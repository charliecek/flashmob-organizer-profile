// BEGIN Globals //
  // Define the main florp map options object if not defined //
  if ("undefined" === typeof florp_map_options_object) {
    var florp_map_options_object = {}
  }

  var $aTogglableSingleCheckboxCheckboxes = [],
      $aPreferenceTogglerCheckboxes = [],
      $aTogglablePreferenceFields

  if (florp.courses_info_disabled == 1) {
    var aSectionTogglerSelectors = ['.florp-section-base', '.florp-section-flashmob']
    var aSectionTogglerSelectorSuccessors = {
      '.florp-section-base': '.florp-section-flashmob',
      '.florp-section-flashmob': undefined
    }
  } else {
    var aSectionTogglerSelectors = ['.florp-section-base', '.florp-section-courses', '.florp-section-flashmob']
    var aSectionTogglerSelectorSuccessors = {
      '.florp-section-base': '.florp-section-courses',
      '.florp-section-courses': '.florp-section-flashmob',
      '.florp-section-flashmob': undefined
    }
  }
// END Globals //

// BEGIN Auxiliary functions //
  // Extend jQuery show() to trigger afterShow and beforeShow events //
//   jQuery(function($) {
//
//     var _oldShow = $.fn.show;
//
//     $.fn.show = function(speed, oldCallback) {
//       return $(this).each(function() {
//         var obj         = $(this),
//             newCallback = function() {
//               if ($.isFunction(oldCallback)) {
//                 oldCallback.apply(obj);
//               }
//               obj.trigger('afterShow');
//             };
//
//         // you can trigger a before show if you want
//         obj.trigger('beforeShow');
//
//         // now use the old function to show the element passing the new callback
//         _oldShow.apply(obj, [speed, newCallback]);
//       });
//     }
//   });

  function florpObjectLength(a) {
    var count = 0;
    var i;

    for (i in a) {
      if (a.hasOwnProperty(i)) {
        count++;
      }
    }
    return count;
  }
  function florpRandomObjectKey(obj) {
      var keys = Object.keys(obj)
      return keys[ keys.length * Math.random() << 0];
  }
  function florpRandomObjectProperty(obj) {
      var keys = Object.keys(obj)
      return obj[keys[ keys.length * Math.random() << 0]];
  }

  function florpSetCookie(key, value) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';path=/;expires=' + expires.toUTCString();
  }
  function florpGetCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
  }

  function florpAnimateHide($elements, callback) {
    $elements.each(function () {
      var $this = jQuery(this)
      if ($this.hasClass('hidden')) {
        // don't re-hide //
        return
      }
      $this.show().hide(500,
        function () {
          // Clean up //
          $this.addClass('hidden').removeAttr("style")
          if ("undefined" !== typeof callback) {
            callback()
          }
      })
    });
  }
  function florpAnimateShow($elements, callback) {
    $elements.each(function () {
      var $this = jQuery(this)
      if (!$this.hasClass('hidden')) {
        // don't re-show //
        return
      }
      $this.hide().removeClass('hidden').show(500,
        function () {
          // Clean up //
          $this.removeAttr("style")
          if ("undefined" !== typeof callback) {
            callback()
          }
      })
    });
  }

  function florpUnescapeRegexp(strRegex) {
    return strRegex.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
  }
// END Auxiliary functions //

// BEGIN Florp specific functions //
  function florpScrollToAnchor() {
    console.log("firing event before close");
    var el = jQuery("#florp-popup-scroll");
    if (el.length > 0) {
      jQuery('html, body').scrollTop(el.first().offset().top - 100);
    }
  }

  function florpRescrapeFbOgMapImage() {
    if (florp.blog_type != 'main' || florp.using_og_map_image != 1) {
      return
    }
    jQuery.post(
      'https://graph.facebook.com',
      {
          id: 'http://flashmob.salsarueda.dance/',
          scrape: true
      },
      function(response){
          console.log(response);
      }
    );
  }
  function florp_reload_on_successful_submission() {
    if (florp.reload_ok_submission != 1) {
      florpReloadMaps();
      return;
    }

    // Rescrape the FB OG map image //
    florpRescrapeFbOgMapImage();

    var strCookieName = florp.reload_ok_cookie;
    var strCookieValue = florpGetCookie(strCookieName);
    if (strCookieValue !== '1') {
      return;
    }
    florpSetCookie(florp.reload_ok_cookie, "0");
    if (window.location.href.match(new RegExp( florpUnescapeRegexp("#"+florp.florp_trigger_anchor), 'gi'))) {
      window.location.reload();
    } else if (window.location.href.match(new RegExp( florpUnescapeRegexp("#"), 'gi'))) {
      window.location.href = window.location.href.replace(/#.*/g, '#'+florp.florp_trigger_anchor);
    } else {
      window.location.href = window.location.href + '#'+florp.florp_trigger_anchor;
    }
  }

  function florpGenerateYearlyMaps() {
    /*
    * Iterate through divs with a given class
    * and call florpGenerateYearlyMap for each one
    */
    if ("undefined" === typeof florp_map_options_object || florpObjectLength(florp_map_options_object) === 0) {
      return;
    }

    var divID;
    for (divID in florp_map_options_object) {
      if (florp_map_options_object.hasOwnProperty(divID)) {
        var oElement = jQuery("#"+divID);
        if (oElement.length > 0) {
          if (florp.load_maps_lazy === '1') {
            var isVisible = oElement.is(":not(:hidden)");
            if (isVisible) {
              console.info("Loading map in div id=" + divID + ".");
              florpGenerateYearlyMapSyncOrAsync(oElement, divID, florp_map_options_object[divID]);
            } else {
              console.info("Not loading map in div with id=" + divID + " - it is not visible");
            }
          } else {
            florpGenerateYearlyMapSyncOrAsync(oElement, divID, florp_map_options_object[divID]);
          }
        } else {
          console.warn("There is no div with id=" + divID + "!");
        }
      }
    }

  }

  function florpGenerateYearlyMapSyncOrAsync(oDivDOMElement, divID, oMapOptions) {
    if (florp.load_maps_async === '1') {
      setTimeout(function() {
        florpGenerateMap(oDivDOMElement, divID, oMapOptions);
      }, 0);
    } else {
      florpGenerateMap(oDivDOMElement, divID, oMapOptions);
    }
  }

  function florpReloadVisibleMaps() {
    if ("undefined" === typeof florp.maps) {
      florpGenerateYearlyMaps();
    }

    if ("undefined" === typeof florp.maps) {
      console.warn("florp.maps object does not exist!");
      return;
    }
    var divID;
    for (divID in florp_map_options_object) {
      if (florp_map_options_object.hasOwnProperty(divID)) {
        var oElement = jQuery("#"+divID);
        if (oElement.length > 0) {
          if ("undefined" === typeof florp.maps.positionFixed[divID]) {
            florp.maps.positionFixed[divID] = false;
          }
          if ("undefined" === typeof florp.maps.visibility[divID]) {
            florp.maps.visibility[divID] = false;
          }
          var isVisibleOld = florp.maps.visibility[divID];
          var isVisible = oElement.is(":not(:hidden)");
          florp.maps.visibility[divID] = isVisible;

          if (florp.load_maps_lazy !== '1') {
            if ("undefined" === typeof florp.maps.objects || "undefined" === typeof florp.maps.objects[divID]) {
              console.warn("florp.maps.objects or florp.maps.objects["+divID+"] is undefined!");
              continue;
            }
          }
          if (isVisible && isVisibleOld !== isVisible ) {
            if (florp.maps.positionFixed[divID]) {
              // console.info("Position was already fixed for div "+divID);
              continue;
            }

            if (florp.load_maps_lazy === '1') {
              if ("undefined" === typeof florp.maps.objects || "undefined" === typeof florp.maps.objects[divID]) {
                console.info("Lazy loading map in div id=" + divID + ".");
                florpGenerateYearlyMapSyncOrAsync(oElement, divID, florp_map_options_object[divID]);
                return;
              } else {
                // console.info("Fixing position for map in div id=" + divID + ".");
                console.info("NOT fixing position for map in div id=" + divID + ".");
                return;
              }
            }

            var gmap = florp.maps.objects[divID];
            google.maps.event.trigger(gmap, "resize");
            var mapCenterArr = florp.general_map_options.map_init_aux.center;
            gmap.setCenter(mapCenterArr);

            if ("undefined" === typeof florp.maps.open_marker || "undefined" === typeof florp.maps.open_marker[divID] || "undefined" === typeof florp.maps.open_infowindow || "undefined" === typeof florp.maps.open_infowindow[divID]) {
              // console.info("No open marker or infoWindow for div "+divID);
              continue;
            }
            var marker = florp.maps.open_marker[divID];
            var infowindow = florp.maps.open_infowindow[divID];
            florpOpenInfoWindow(gmap, marker, infowindow, divID);
            florp.maps.positionFixed[divID] = true;
            console.info("Position of map in div "+divID+" was reloaded");
          } else {
            // console.info("Div "+divID+" is not visible or its visibility didn't change");
          }
        } else {
          console.warn("There is no div with id=" + divID + "!");
        }
      }
    }
  }

  function initFlorpMapsObject() {
    florp.maps = {
      objects: {},
      markers: {},
      markerShownOnLoad: {},
      visibility: {},
      positionFixed: {},
    };
  }

  function florpGenerateMap( oDivDOMElement, divID, oMapOptions, oAdditionalMarkerOptions = {}, strMapType = '', bIsPreview = false, noMarker = false ) {
    /*
    * we get the year from the element: data-year=201*, data-is-current-year="0|1"
    * By Ajax, ask for an array of info for each map by year (location[address and/or coord], marker icon, marker HTML,
    * center of map, rule on which marker info should be open by default, text for missing video, map width and height)
    *  Default open marker: either we center the map at the middle marker, then it's the one OR we have a predefined center, then middle marker or random?
    * From the array we create the map.
    * We save the array of info for future reference. All maps and all markers should have an id and a saved reference, too.
    */

    // console.log(oMapOptions);
    // initialize map //

    if (strMapType.length === 0) {
      strMapType = jQuery('#'+divID).data('mapType')
    }

    if ("undefined" === typeof florp.maps) {
      initFlorpMapsObject();
    }
    florp.maps.visibility[divID] = oDivDOMElement.is(":not(:hidden)");
    if ("undefined" === typeof florp.maps.markers[divID]) {
      florp.maps.markers[divID] = {};
    }
    if ("undefined" === typeof florp.maps.additionalMarkerOptions) {
      florp.maps.additionalMarkerOptions = {};
    }
    if ("undefined" === typeof florp.maps.markerShownOnLoad[divID]) {
      florp.maps.markerShownOnLoad[divID] = false;
    }

    if ("undefined" === typeof florp.maps.objects[divID]) {
      if (bIsPreview) {
        var height = florp.general_map_options.custom.height_preview
      } else {
        var height = florp.general_map_options.custom.height
      }
      oDivDOMElement.height(height).width('100%').css( { marginLeft : "auto", marginRight : "auto" } );
      var gMapOptions = florp.general_map_options.map_init_raw;
      if (bIsPreview) {
        gMapOptions.zoom = florp.general_map_options.custom.zoom_preview
      }
      var mapCenterArr = florp.general_map_options.map_init_aux.center;
      gMapOptions.center = new google.maps.LatLng(mapCenterArr.lat, mapCenterArr.lng)
      var map = new google.maps.Map(document.getElementById(divID), gMapOptions);

      florp.maps.objects[divID] = map;
    } else {
      map = florp.maps.objects[divID];
    }

    if ("undefined" !== typeof oAdditionalMarkerOptions) {
      // NOTE: oAdditionalMarkerOptions is NOT per-marker! //
      florp.maps.additionalMarkerOptions[divID] = jQuery.extend(true, {}, florp.maps.additionalMarkerOptions[divID], oAdditionalMarkerOptions)
    }

    if (noMarker) {
      if ("undefined" !== typeof florp.user_id) {
        if (strMapType === "flashmob_organizer") {
          console.info("Removing user's marker")
          var mixMarkerKey = 0
          florpRemoveUserMarker(florp.user_id, map, divID, mixMarkerKey)
        } else if (strMapType === "teacher") {
          aProperties = ["courses_city", "courses_city_2", "courses_city_3"]
          aProperties.forEach(function(prop) {
            florpRemoveUserMarker(florp.user_id, map, divID, prop)
          })
        } else {
          console.warn("Unknown map type")
        }
      }
      return
    }
    // First select the marker shown on load randomly //
    florp.maps.markerShownOnLoad[divID] = florpRandomObjectKey(oMapOptions);
    var bUserIdMatched = false
    var iUserID;
    if ("undefined" !== typeof florp.user_id) {
      // User is logged in => try to find a marker that belongs to them //
      for (iUserID in oMapOptions) {
        if (oMapOptions.hasOwnProperty(iUserID)) {
          if (iUserID == florp.user_id) {
            florp.maps.markerShownOnLoad[divID] = florp.user_id;
            bUserIdMatched = true;
            break;
          }
        }
      }
    }
    if (!bUserIdMatched) {
      // User is not logged in or has no marker => let's find the marker that was specified by shortcode //
      for (iUserID in oMapOptions) {
        if (oMapOptions.hasOwnProperty(iUserID)) {
          var oUserOptions = oMapOptions[iUserID];
          if ("undefined" !== typeof oUserOptions["showOnLoad"] && oUserOptions["showOnLoad"] === true) {
            florp.maps.markerShownOnLoad[divID] = iUserID;
            break;
          }
        }
      }
    }

    // For each user show their markers //
    for (iUserID in oMapOptions) {
      if (oMapOptions.hasOwnProperty(iUserID)) {
        var oUserOptions = oMapOptions[iUserID];
        var strLocation = ""
        if (strMapType === "flashmob_organizer") {
          strLocation = oUserOptions.flashmob_address || oUserOptions.flashmob_city || ""
          florpSetUserMarker( iUserID, oUserOptions, map, divID, florp.maps.markerShownOnLoad[divID] === iUserID, strLocation, 0, strMapType, bIsPreview );
        } else if (strMapType === "teacher") {
          var bShowOnLoad = true, bDontShow = false, aProperties = ["courses_city", "courses_city_2", "courses_city_3"]
          if (divID !== 'teacher_map_preview') {
            bShowOnLoad = false
          }
          aProperties.forEach(function(prop) {
            if ("undefined" === typeof oUserOptions[prop]) {
              strLocation = ""
            } else {
              strLocation = oUserOptions[prop]
              if (bShowOnLoad) {
                bDontShow = true
              }
            }
            florpSetUserMarker( iUserID, oUserOptions, map, divID, bShowOnLoad, strLocation, prop, strMapType, bIsPreview );
            if (bDontShow) {
              bDontShow = false
              bShowOnLoad = false
            }
          })
        }
      }
    }
  }

  function florpRemoveUserMarker(iUserID, map, divID, mixMarkerKey = 0) {
    if ("undefined" !== typeof florp.maps.markers[divID][iUserID]) {
      if ("undefined" !== typeof florp.maps.markers[divID][iUserID][mixMarkerKey]) {
        // Remove any markers, info windows //
        if ("undefined" !== typeof florp.maps.markers[divID][iUserID][mixMarkerKey].object) {
          // remove marker //
          florp.maps.markers[divID][iUserID][mixMarkerKey].object.setMap(null);
        }
        if ("undefined" !== typeof florp.maps.markers[divID][iUserID][mixMarkerKey].info_window_object) {
          // remove infowindow //
          florp.maps.markers[divID][iUserID][mixMarkerKey].info_window_object.setMap(null);
          delete florp.maps.markers[divID][iUserID][mixMarkerKey].info_window_object;
        }
        if ("undefined" !== typeof florp.maps.markers[divID][iUserID][mixMarkerKey]) {
          delete florp.maps.markers[divID][iUserID][mixMarkerKey];
        }
        if ("undefined" !== typeof florp.maps.markers[divID][iUserID]) {
          // If there are other markers left, reopen the first one's info window //
          var k;
          for (k in florp.maps.markers[divID][iUserID]) {
            if (florp.maps.markers[divID][iUserID].hasOwnProperty(k)) {
              var oMarkerOptions = florp.maps.markers[divID][iUserID][k]
              florpOpenInfoWindow(map, oMarkerOptions.object, oMarkerOptions.info_window_object, divID);
              break
            }
          }
        }
      }
    }
  }

  function florpSetUserMarker(iUserID, oUserOptions, map, divID, show, strLocation, mixMarkerKey = 0, strMapType = "flashmob_organizer", bIsPreview ) {
    var k, oInfoWindowData = {};
    for (k in oUserOptions) {
      if (oUserOptions.hasOwnProperty(k)) {
        oInfoWindowData[k] = {
          value: oUserOptions[k]
        };
      }
    }
    // console.log(oInfoWindowData)

    var location = strLocation || "";
    if (location.length === 0) {
      console.info("No location found for user "+iUserID+" (marker key: "+mixMarkerKey+")");
      // console.log(oUserOptions)
      florpRemoveUserMarker(iUserID, map, divID, mixMarkerKey)
    } else {
      // Get the marker HTML //
      var data = {
        action: florp.get_markerInfoHTML_action,
        security : florp.security,
        location: location,
        infoWindowData: oInfoWindowData,
        oUserOptions: oUserOptions,
        divID: divID,
        iUserID: iUserID,
        mixMarkerKey: mixMarkerKey,
        strMapType: strMapType,
        iCurrentYear: jQuery("#"+divID).data('isCurrentYear'),
        iBeforeFlashmob: florp.hide_flashmob_fields,
        iIsPreview: bIsPreview ? 1 : 0,
      };
      window["florpSetUserMarkerAjaxRunning"] = true
      jQuery.ajax({
        type: "POST",
        url: florp.ajaxurl,
        data: data,
        success: function(response) {
          // console.log(response);
          try {
            var getMarkerInfoHtmlRes = JSON.parse(response);
            // console.log(getMarkerInfoHtmlRes);
            var markerContentHtml = getMarkerInfoHtmlRes.contentHtml;
            var map, divID, iUserID, mixMarkerKey, oUserOptions, location;
            if ("undefined" !== typeof getMarkerInfoHtmlRes.data) {
              divID = getMarkerInfoHtmlRes.data.divID
              iUserID = getMarkerInfoHtmlRes.data.iUserID
              mixMarkerKey = getMarkerInfoHtmlRes.data.mixMarkerKey
              oUserOptions = getMarkerInfoHtmlRes.data.oUserOptions
              location = getMarkerInfoHtmlRes.data.location
              map = florp.maps.objects[divID]
            }

            if ("undefined" !== typeof getMarkerInfoHtmlRes.data && "undefined" !== typeof florp.maps.markers && "undefined" !== typeof florp.maps.markers[divID]) {
              if ("undefined" !== typeof oUserOptions.latitude && jQuery.isNumeric(oUserOptions.latitude)
                  && "undefined" !== typeof oUserOptions.longitude && jQuery.isNumeric(oUserOptions.longitude)) {
                if ("undefined" === typeof florp.maps.markers[divID][iUserID] || "undefined" === typeof florp.maps.markers[divID][iUserID][mixMarkerKey]) {
                  // Creating new marker - by coordinates //
                  // console.log("Creating new marker - by coordinates", divID, iUserID)
                  if ("undefined" === typeof florp.maps.markers[divID][iUserID]) {
                    florp.maps.markers[divID][iUserID] = {}
                  }
                  var markerOptions = jQuery.extend({}, florp.general_map_options.markers, {
                    position: new google.maps.LatLng(oUserOptions.latitude, oUserOptions.longitude),
                    map: map,
                    title: location
                  });

                  var bDraggable = false
                  if ("undefined" !== typeof florp.maps.additionalMarkerOptions[divID] && "undefined" !== typeof florp.maps.additionalMarkerOptions[divID][iUserID] && "undefined" !== typeof florp.maps.additionalMarkerOptions[divID][iUserID]["bDraggable"] && "undefined" !== typeof florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallback"]) {
                    bDraggable = florp.maps.additionalMarkerOptions[divID][iUserID]["bDraggable"]
                    markerOptions["draggable"] = bDraggable
                  }

                  var marker = new google.maps.Marker(markerOptions);
                  if (bDraggable && ("undefined" === typeof florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallbackWasRun"] || false === florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallbackWasRun"])) {
                    florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallback"](marker, divID, iUserID)
                    florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallbackWasRun"] = true
                  }

                  var infowindow = new google.maps.InfoWindow({
                    content: markerContentHtml
                  });
                  marker.addListener('click', function() {
                    florpOpenInfoWindow(map, marker, infowindow, divID);
                  });
                  florp.maps.markers[divID][iUserID][mixMarkerKey] = {
                    object: marker,
                    data: getMarkerInfoHtmlRes.data,
                    html: markerContentHtml,
                    info_window_object: infowindow
                  }
                } else {
                  // Updating marker - by coordinates //
                  // console.log("Updating marker - by coordinates", divID, iUserID)
                  var marker = florp.maps.markers[divID][iUserID][mixMarkerKey].object;
                  var infowindow = florp.maps.markers[divID][iUserID][mixMarkerKey].info_window_object;
                  marker.setPosition(new google.maps.LatLng(oUserOptions.latitude, oUserOptions.longitude));
                  marker.setTitle(location);
                  infowindow.setContent(markerContentHtml);
                  florp_map_options_object[divID][iUserID] = oUserOptions;
                  florp.maps.markers[divID][iUserID][mixMarkerKey].data = getMarkerInfoHtmlRes.data;
                  florp.maps.markers[divID][iUserID][mixMarkerKey].html = markerContentHtml;

                  var bDraggable = false
                  if ("undefined" !== typeof florp.maps.additionalMarkerOptions[divID] && "undefined" !== typeof florp.maps.additionalMarkerOptions[divID][iUserID] && "undefined" !== typeof florp.maps.additionalMarkerOptions[divID][iUserID]["bDraggable"] && "undefined" !== typeof florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallback"]) {
                    bDraggable = florp.maps.additionalMarkerOptions[divID][iUserID]["bDraggable"]
                    marker.setDraggable(bDraggable)

                    if (bDraggable && ("undefined" === typeof florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallbackWasRun"] || false === florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallbackWasRun"])) {
                      florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallback"](marker, divID, iUserID)
                      florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallbackWasRun"] = true
                    }
                  }
                }
                if (show) {
                  florpOpenInfoWindow(map, marker, infowindow, divID);
                }
              } else {
                // console.log(location);
                if ("undefined" === typeof florp.geocoder) {
                  florp.geocoder = new google.maps.Geocoder();
                }
                window["florpSetUserMarkerGeocoderRunning"] = true
                florp.geocoder.geocode({
                  'address': location
                }, function(results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
    //                     console.log(results);
    //                     console.log(status);
                    var addressLocation = results[0].geometry.location;

                    if ("undefined" === typeof florp.maps.markers[divID][iUserID] || "undefined" === typeof florp.maps.markers[divID][iUserID][mixMarkerKey]) {
                      // Creating new marker - no coordinates //
                      // console.log("Creating new marker - no coordinates", divID, iUserID)
                      if ("undefined" === typeof florp.maps.markers[divID][iUserID]) {
                        florp.maps.markers[divID][iUserID] = {}
                      }
                      var markerOptions = jQuery.extend({}, florp.general_map_options.markers, {
                        position: addressLocation,
                        map: map,
                        title: location
                      });

                      var bDraggable = false
                      if ("undefined" !== typeof florp.maps.additionalMarkerOptions[divID] && "undefined" !== typeof florp.maps.additionalMarkerOptions[divID][iUserID] && "undefined" !== typeof florp.maps.additionalMarkerOptions[divID][iUserID]["bDraggable"] && "undefined" !== typeof florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallback"]) {
                        bDraggable = florp.maps.additionalMarkerOptions[divID][iUserID]["bDraggable"]
                        markerOptions["draggable"] = bDraggable
                      }

                      var marker = new google.maps.Marker(markerOptions);
                      if (bDraggable && ("undefined" === typeof florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallbackWasRun"] || false === florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallbackWasRun"])) {
                        florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallback"](marker, divID, iUserID)
                        florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallbackWasRun"] = true
                      }

                      var infowindow = new google.maps.InfoWindow({
                        content: markerContentHtml
                      });
                      marker.addListener('click', function() {
                        florpOpenInfoWindow(map, marker, infowindow, divID);
                      });
                      florp.maps.markers[divID][iUserID][mixMarkerKey] = {
                        object: marker,
                        data: getMarkerInfoHtmlRes.data,
                        html: markerContentHtml,
                        info_window_object: infowindow
                      }
                    } else {
                      // Updating marker - no coordinates //
                      var marker = florp.maps.markers[divID][iUserID][mixMarkerKey].object;
                      var infowindow = florp.maps.markers[divID][iUserID][mixMarkerKey].info_window_object;
                      marker.setPosition(addressLocation);
                      marker.setTitle(location);
                      infowindow.setContent(markerContentHtml);
                      florp_map_options_object[divID][iUserID] = oUserOptions;
                      florp.maps.markers[divID][iUserID][mixMarkerKey].data = getMarkerInfoHtmlRes.data;
                      florp.maps.markers[divID][iUserID][mixMarkerKey].html = markerContentHtml;

                      var bDraggable = false
                      if ("undefined" !== typeof florp.maps.additionalMarkerOptions[divID] && "undefined" !== typeof florp.maps.additionalMarkerOptions[divID][iUserID] && "undefined" !== typeof florp.maps.additionalMarkerOptions[divID][iUserID]["bDraggable"] && "undefined" !== typeof florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallback"]) {
                        bDraggable = florp.maps.additionalMarkerOptions[divID][iUserID]["bDraggable"]
                        marker.setDraggable(bDraggable)

                        if (bDraggable && ("undefined" === typeof florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallbackWasRun"] || false === florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallbackWasRun"])) {
                          florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallback"](marker, divID, iUserID)
                          florp.maps.additionalMarkerOptions[divID][iUserID]["draggableCallbackWasRun"] = true
                        }
                      }
                    }
                    if (show) {
                      florpOpenInfoWindow(map, marker, infowindow, divID);
                    }
                  } else {
                    console.warn(status);
                  }
                  window["florpSetUserMarkerGeocoderRunning"] = false
                });
              }
            } else {
              // DEBUG INFO: //
              if ("undefined" === typeof getMarkerInfoHtmlRes.data) {
                console.warn(getMarkerInfoHtmlRes);
              } else if ("undefined" === typeof getMarkerInfoHtmlRes.data.divID) {
                console.warn(getMarkerInfoHtmlRes.data);
              }
              if ("undefined" === typeof florp.maps.markers) {
                console.warn("flowp.maps.markers is undefined");
              } else if ("undefined" !== typeof getMarkerInfoHtmlRes.data.divID && "undefined" !== typeof florp.maps.markers[getMarkerInfoHtmlRes.data.divID]) {
                console.warn(florp.maps.markers[getMarkerInfoHtmlRes.data.divID]);
              } else if ("undefined" !== typeof getMarkerInfoHtmlRes.data.divID) {
                console.warn("no markers for div ID: " + getMarkerInfoHtmlRes.data.divID);
              } else {
                console.log(florp.maps.markers);
              }
            }
            window["florpSetUserMarkerAjaxRunning"] = false
          } catch(e) {
            console.warn(e);
            window["florpSetUserMarkerAjaxRunning"] = false
          }
        },
        error: function(errorThrown){
          console.warn(errorThrown);
          window["florpSetUserMarkerAjaxRunning"] = false
        }
      });
    }
    return;
  }

  function florpOpenInfoWindow(map, marker, infowindow, divID) {
    if ("undefined" === typeof florp.maps.open_infowindow) {
      florp.maps.open_infowindow = {};
    }
    if ("undefined" === typeof florp.maps.open_marker) {
      florp.maps.open_marker = {};
    }
    if ("undefined" !== typeof florp.maps.open_infowindow[divID]) {
      florp.maps.open_infowindow[divID].close();
    }
    infowindow.open(map, marker);
    florp.maps.open_marker[divID] = marker;
    florp.maps.open_infowindow[divID] = infowindow;
  }

  function florpReloadMaps( iYear = 0 ) {
    /*
    * We look for the map div(s) by data-is-current-year="1" and iterate through these
    * we ask for all the info by ajax, reloading the MARKER that belongs to the edited user
    */

    if (sessionStorage.getItem("florpFormSubmitSuccessful") !== "1") {
      return;
    }

    console.info("Reloading maps")
    if ("undefined" === typeof florp_map_options_object || florpObjectLength(florp_map_options_object) === 0) {
      return;
    }

    // Rescrape the FB OG map image //
    florpRescrapeFbOgMapImage();

    if (florp.blog_type === "main") {
      var reloadMaps = jQuery(".florp-map[data-is-current-year='1'], .florp-map[data-map-type=teacher]");
    } else if (florp.blog_type === "flashmob") {
      var reloadMaps = jQuery(".florp-map[data-is-current-year='1']");
      var $popup = PUM.getPopup(florp.popup_id)
      var iUserID = $popup.data("userId")
      var divID = $popup.data("divId")
      if ("undefined" !== typeof iUserID && "undefined" !== typeof divID) {
        florp.maps.markerShownOnLoad[divID] = iUserID
      }
    } else {
      return
    }
    var fnReloadMarker = function (response) {
      try {
        var getMarkerInfoHtmlRes = JSON.parse(response);
        // console.log(getMarkerInfoHtmlRes);
        if (getMarkerInfoHtmlRes.new_map_options !== false) {
          var divID = getMarkerInfoHtmlRes.data.divID
          var iUserID = getMarkerInfoHtmlRes.data.user_id
          var map = florp.maps.objects[divID];
          var oUserOptions = getMarkerInfoHtmlRes.new_map_options
          var strMapType = jQuery('#'+divID).data('mapType')
          var strLocation = ""
          if (strMapType === "flashmob_organizer") {
            strLocation = oUserOptions.flashmob_address || oUserOptions.flashmob_city || ""
            florpSetUserMarker( iUserID, oUserOptions, map, divID, florp.maps.markerShownOnLoad[divID] === iUserID, strLocation, 0, strMapType );
          } else if (strMapType === "teacher") {
            var bShowOnLoad = true, bDontShow = false, aProperties = ["courses_city", "courses_city_2", "courses_city_3"]
            if (divID !== 'teacher_map_preview') {
              bShowOnLoad = false
            }
            aProperties.forEach(function(prop) {
              if ("undefined" === typeof oUserOptions[prop]) {
                strLocation = ""
              } else {
                strLocation = oUserOptions[prop]
                if (bShowOnLoad) {
                  bDontShow = true
                }
              }
              florpSetUserMarker( iUserID, oUserOptions, map, divID, bShowOnLoad, strLocation, prop, strMapType );
              if (bDontShow) {
                bDontShow = false
                bShowOnLoad = false
              }
            })
          } else {
            return
          }
        }
      } catch(e) {
        console.warn(e);
      }
    }
    reloadMaps.each(function () {
      var $this = jQuery(this);
      var id = $this.prop('id');
      var $popup = PUM.getPopup(florp.popup_id)
      var popupUserID = $popup.data("userId")
      if (("undefined" === typeof florp.user_id || florp.blog_type !== "main") && !(florp.blog_type === "flashmob" && "undefined" !== typeof popupUserID)) {
        // reload all markers //
        console.info("Reloading all markers in map "+id)
        for (user_id in florp_map_options_object[id]) {
          if (florp_map_options_object[id].hasOwnProperty(user_id)) {
            console.info("Reloading marker "+user_id+" in map "+id)
            var old_map_options = florp_map_options_object[id][user_id];

            var data = {
              action: florp.get_mapUserInfo_action,
              security : florp.security,
              old_map_options: old_map_options,
              user_id: user_id,
              divID: id,
              strMapType: $this.data('mapType'),
            };
            jQuery.ajax({
              type: "POST",
              url: florp.ajaxurl,
              data: data,
              success: function(response) {
                // console.log(response);
                fnReloadMarker(response)
              },
              error: function(errorThrown){
                console.warn(errorThrown);
              }
            });
          }
        }
      } else {
        // reload only the marker of the logged in user //
        var iUserIDToReload = florp.user_id
        if (florp.blog_type === "flashmob" && "undefined" !== typeof popupUserID) {
          iUserIDToReload = popupUserID
        }
        console.info("Reloading marker "+iUserIDToReload+" in map "+id)
        var old_map_options = florp_map_options_object[id][iUserIDToReload];

        var data = {
          action: florp.get_mapUserInfo_action,
          security : florp.security,
          old_map_options: old_map_options,
          user_id: iUserIDToReload,
          divID: id,
          strMapType: $this.data('mapType'),
        };
        jQuery.ajax({
          type: "POST",
          url: florp.ajaxurl,
          data: data,
          success: function(response) {
            // console.log(response);
            fnReloadMarker(response)
          },
          error: function(errorThrown){
            console.warn(errorThrown);
          }
        });
      }
    });
  }

  var fnGetTshirtImgPath = function( strImgCitySlug, color ) {
    var strImgCitySlugLoc = "default"
    if ("undefined" !== typeof florp.tshirt_imgs_couples && "undefined" !== typeof florp.tshirt_imgs_couples[strImgCitySlug] && florp.tshirt_imgs_couples[strImgCitySlug]) {
      strImgCitySlugLoc = strImgCitySlug
    }
    return florp.img_path+"t-shirt-chest-"+color+"-"+strImgCitySlugLoc+".png"
  }
  var fnGetTshirtPreviewImgPath = function( strImgCitySlug, color ) {
    if ("undefined" === typeof florp.tshirt_imgs_full || "undefined" === typeof florp.tshirt_imgs_full[color]) {
      return fnGetTshirtImgPath( strImgCitySlug, color )
    }

    var strImgCitySlugLoc = "default"
    if ("undefined" !== typeof florp.tshirt_imgs_full[color][strImgCitySlug] && florp.tshirt_imgs_full[color][strImgCitySlug]) {
      strImgCitySlugLoc = strImgCitySlug
    } else if ("undefined" !== typeof florp.tshirt_imgs_full[color]["default"] && florp.tshirt_imgs_full[color]["default"]) {
      // ok //
    } else {
      return fnGetTshirtImgPath( strImgCitySlug, color )
    }
    return florp.img_path+"t-shirt-"+color+"-"+strImgCitySlugLoc+".png"
  }

  function florpFixFormClasses() {
    // console.info("Fixing FLORP classes")

    // Move florp-* classes from .nf-field-container to nf-field //
    jQuery( ".florp-class" ).each(function () {
      var thisObj = jQuery(this);
      var strClass = thisObj.prop("class");
      var aClasses = strClass.replace("  ", " ").trim().split(" ");
      var aFilteredClasses = jQuery.grep(aClasses, function( n, i ) {
        return ( n.match("^florp-") && n !== "florp-class" );
      });
      var strFilteredClasses = aFilteredClasses.join(" ");
      thisObj.removeClass("florp-class").removeClass(strFilteredClasses);
      thisObj.closest("nf-field").addClass(strFilteredClasses);
    });

    jQuery(".nf-help").removeClass("nf-help");

    // Hide all course related fields if not allowed //
    if (florp.courses_info_disabled == 1) {
      jQuery('.florp-section-courses').hide()
    }

    // Fix jBox info text style //
    if (florp.popup_id > 0) {
      jQuery('body').on('DOMNodeInserted', '.jBox-wrapper', function () {
        // console.log("jBox-wrapper div was created")
        jQuery( this ).addClass("z-index-1999999999")
      });
    }

    // Replace tshirt color radio buttons with images //
    var $tshirtColorRadioButtons = jQuery(".florp-participant-tshirt-color .nf-field-element ul>li input, .florp-leader-tshirt-color .nf-field-element ul>li input")
    if ($tshirtColorRadioButtons.length > 0) {
      $tshirtColorRadioButtons.each(function( index ) {
        var $this = jQuery(this)
        var color = $this.val()
        var imgCitySlug = "default"
        var tshirtImgPath = fnGetTshirtImgPath( imgCitySlug, color )
        var tshirtImgPreviewPath = fnGetTshirtPreviewImgPath( imgCitySlug, color )
        var $label = $this.parent().find("label")
        $label.html(jQuery('<img id="florp-tshirt-color-label-img-'+index+'" data-color="'+color+'" data-preview-path="'+tshirtImgPreviewPath+'" class="florp-tshirt-color-label-img" src="'+tshirtImgPath+'"/>'))
      })
    }

    // Turn .florp_disabled fields into disabled fields //
    jQuery(".florp_disabled select,.florp_disabled input").prop("disabled", true);
    if (florp.blog_type === "main" && florp.has_participants == 1) {
      jQuery("input.flashmob_organizer").prop("disabled", true)
      jQuery(".florp_flashmob_city").prop("disabled", true)
    }

    // Fix the info circle's position for the newsletter checkbox //
    var $preferenceInfo = jQuery(".florp_newsletter_container .nf-field-label label span.fa-info-circle")
    if ($preferenceInfo.length > 0) {
      $newsletterSubscribeLabel = jQuery(".florp_newsletter_container input[value=newsletter_subscribe]").parent().find("label")
      if ($newsletterSubscribeLabel.length > 0) {
        $newsletterSubscribeLabel.html($newsletterSubscribeLabel.html()+" ").append($preferenceInfo)
      }
    }
    var $preferenceInfo = jQuery(".florp_preferences_container .nf-field-label label span.fa-info-circle")
    if ($preferenceInfo.length > 0) {
      $newsletterSubscribeLabel = jQuery(".florp_preferences_container input[value=newsletter_subscribe]").parent().find("label")
      if ($newsletterSubscribeLabel.length > 0) {
        $newsletterSubscribeLabel.html($newsletterSubscribeLabel.html()+" ").append($preferenceInfo)
      }
    }

    // FN to get selected school webpage radiolist value //
    var fnGetSchoolWebpageRadiolistValue = function() {
      return jQuery(".florp_webpage_radiolist input[type=radio]:checked").val()
    }

    // FN to Toggle organizer warnings depending on whether the user will organize a flashmob //
    var fnToggleFlashmobOrganizerWarnings = function( strTogglableValue, bChecked, animate = true ) {
      if (strTogglableValue === 'flashmob_organizer') {
        var fnToggle = function(oThis, bChecked, animate) {
          $this = jQuery(oThis)
          if (bChecked && (!animate || $this.is(":hidden"))) {
            if (animate) {
              florpAnimateShow($this)
            } else {
              $this.show()
            }
          } else if (!bChecked && (!animate || !$this.is(":hidden"))) {
            if (animate) {
              florpAnimateHide($this)
            } else {
              $this.hide()
            }
          }
        }

        // Toggling independently from florp.hide_flashmob_fields //
        var $flashmobOrganizerWarningsAlways = jQuery('.flashmob_organizer_warning')
        $flashmobOrganizerWarningsAlways.each(function() {
          fnToggle(this, bChecked, animate)
        })
        if (florp.hide_flashmob_fields == 1) {
          // Toggling warnings before flashmob //
          var $flashmobOrganizerWarningsBeforeFlashmob = jQuery('.school_city_warning')
          $flashmobOrganizerWarningsBeforeFlashmob.each(function() {
            fnToggle(this, bChecked, animate)
          })
        }
      }
    }

    // FN to Toggle fields based on checked checkboxes //
    var fnToggleFields = function($aTogglableCheckboxesLoc, strToggleType = "") {
//       console.log($aTogglableCheckboxesLoc)
      // Count checkboxes //
      $aTogglableCheckboxesLoc.each(function() {
        var $this = jQuery(this),
            $checkbox = $this,
            val
        if (strToggleType === "checkbox") {
          if ($this.hasClass('florp_teacher')) {
            val = 'teacher'
          } else if ($this.hasClass('courses_in_city_2')) {
            val = 'courses2'
          } else if ($this.hasClass('courses_in_city_3')) {
            val = 'courses3'
          } else if ($this.parents(".florp_webpage_radiolist").length > 0) {
            val = 'webpage_own'
            $checkbox = jQuery(".florp_webpage_radiolist input[type=radio][value=vlastna]")
          } else {
            console.warn("fnToggleFields called with type 'checkbox' on invalid item:")
            console.log($aTogglableCheckboxesLoc)
            return
          }
        } else {
          val = $this.val()
        }
        var strTogglableFieldSelector = ".florp-"+strToggleType+"-field_"+val+" .nf-field-container"
        var $aTogglableFieldsAll = jQuery(strTogglableFieldSelector)

        var bChecked = $checkbox.is(':checked')
        if (bChecked) {
          florpAnimateShow($aTogglableFieldsAll)
        } else {
          florpAnimateHide($aTogglableFieldsAll)
          var $checkboxes = $aTogglableFieldsAll.find("input[type=checkbox]")
          if ($checkboxes.length > 0) {
            $checkboxes.each(function() {
              $this = jQuery(this)
              if ($this.is(":checked")) {
                $this.removeAttr("checked").trigger("change")
              }
            })
          }
        }
      });
    }

    // FN to Toggle sections (accordeons) //
    var fnToggleSection = function($sectionToggler, $sectionItems, sectionTypeSelector) {
      // Close the other sections //
      aSectionTogglerSelectors.forEach(function(strSelector) {
        if (strSelector !== sectionTypeSelector) {
          var $toggler = jQuery(strSelector+".florp-section-toggler")
          var $togglees = jQuery(strSelector+":not(.florp-section-toggler)")
          $toggler.data("open", 0).removeClass("active")
//           $togglees.addClass("hidden")
          florpAnimateHide($togglees)
        }
      })
      var open = $sectionToggler.data("open"),
          animate = true
      if ("undefined" === typeof open) {
        animate = false
        open = 1;
        $sectionToggler.data("open", open)
      }
      if (open) {
        // Closing //
        $sectionToggler.data("open", 0)
        $sectionToggler.removeClass("active")
        // $sectionItems.addClass("hidden")
        if (animate) {
          florpAnimateHide($sectionItems)
        } else {
          $sectionItems.addClass("hidden")
        }

        // Open next if any //
        if ("undefined" !== typeof aSectionTogglerSelectorSuccessors && "undefined" !== typeof aSectionTogglerSelectorSuccessors[sectionTypeSelector]) {
          var strSelectorNext = aSectionTogglerSelectorSuccessors[sectionTypeSelector]
          var $togglerNext = jQuery(strSelectorNext+".florp-section-toggler")
          var $toggleesNext = jQuery(strSelectorNext+":not(.florp-section-toggler)")
          fnToggleSection($togglerNext, $toggleesNext, strSelectorNext)
        }
      } else {
        // Opening //
        $sectionToggler.data("open", 1)
        $sectionToggler.addClass("active")
        // $sectionItems.removeClass("hidden")
        florpAnimateShow($sectionItems)

        // Scroll to toggler //
        var offset = 0
        if (jQuery("body").hasClass("logged-in") && jQuery("body").hasClass("admin-bar")) {
          offset = 32;
        }
        if (jQuery("body header").length > 0) {
          offset += jQuery("body header").first().height()
        }
        jQuery('html, body').animate({
          scrollTop: $sectionToggler.offset().top - offset
        }, 400);
      }
    }

    // Get the flashmob organizer checkbox //
    var $flashmobOrganizerCheckbox = jQuery("input.florp_flashmob_organizer[type=checkbox]")

    $aTogglableSingleCheckboxCheckboxes = jQuery(".florp-single-checkbox-toggler input[type=checkbox], .florp_webpage_radiolist input[type=radio]");

    // Toggle warnings for flashmob organizers //
    fnToggleFlashmobOrganizerWarnings( 'flashmob_organizer', $flashmobOrganizerCheckbox.is(':checked'), false )

    // Get and Toggle sections (accordeons) //
    var $togglerOpenOnLoad, $toggleesOpenOnLoad, togglerSelectorOpenOnLoad
    aSectionTogglerSelectors.forEach(function(strSelector) {
      var $toggler = jQuery(strSelector+".florp-section-toggler")
      var $togglees = jQuery(strSelector+":not(.florp-section-toggler)")
      if ($toggler.hasClass("florp-section-toggler-open")) {
        $togglerOpenOnLoad = $toggler
        $toggleesOpenOnLoad = $togglees
        togglerSelectorOpenOnLoad = strSelector
      }
      fnToggleSection( $toggler, $togglees, strSelector )
      $toggler.click(function() {
        fnToggleSection( $toggler, $togglees, strSelector )
      })
    })
    // Open the section that should be open on load //
    if ("undefined" !== typeof $togglerOpenOnLoad && "undefined" !== typeof $toggleesOpenOnLoad && "undefined" !== typeof togglerSelectorOpenOnLoad) {
      fnToggleSection( $togglerOpenOnLoad, $toggleesOpenOnLoad, togglerSelectorOpenOnLoad )
    }

    // Add correct classes to buttons //
    var buttons = jQuery(".florp-button,florp-profile-form-wrapper-div input[type=button]");
    buttons.each(function () {
      var $this = jQuery(this);
      if (!$this.hasClass("button")) {
        $this.addClass("button");
      }
      if (!$this.hasClass("florp-button")) {
        $this.addClass("florp-button");
      }
    });

    // Add preview on hover to t-shirt images //
    jQuery(document).on('mouseover', 'img.florp-tshirt-color-label-img', function (e) {
      var vOffset = -20,
          hOffset = 20,
          $img = jQuery(this),
          posV = {"left": (e.pageX + hOffset) + "px"},
          posH = {"top": (e.pageY - vOffset) + "px"},
          w = jQuery(window).width(),
          h = jQuery(window).height(),
          strPreviewImgPath = $img.data( "previewPath" ) || $img.attr('src')
      jQuery("body").append("<p id='t-shirt-preview'><img src='" + strPreviewImgPath + "' alt='Image preview' /></p>");

      $preview = jQuery("#t-shirt-preview")
      $preview.css({
        'display': 'block',
      });
      if (e.clientY > (h / 2)) {
        var top = (e.pageY + vOffset - $preview.height())
        if (top < 0) {
          console.log($preview.height())
          top = 0
        }
        posH = {"top": top + "px"}
      }
      var zIndex = {}
      if (jQuery(".pum-container").length > 0) {
        var zi = jQuery(".pum-container").css("z-index")
        zIndex = {"z-index": 1999999999}
        if ("undefined" !== typeof zi) {
          zIndex = {"z-index": zi + "9"}
        }
      }
//       if (e.clientX > (w / 2)) {
//         posV = {"left": (e.pageX - hOffset - $preview.width()) + "px"}
//       }
      $preview.css(jQuery.extend({}, posV, posH, zIndex ));
    }).on('mouseleave', '.florp-tshirt-color-label-img', function (e) {
      jQuery('#t-shirt-preview').remove();
    })

    if (florp.blog_type === "main") {
      // Toggle fields based on checkboxes //
      fnToggleFields($aTogglableSingleCheckboxCheckboxes, "checkbox");
      $aTogglableSingleCheckboxCheckboxes.change(function () {
        fnToggleFields(jQuery(this), "checkbox");
      });

      if ("undefined" === typeof florp.user_id ) {
        // Not logged in => registration form - toggle warnings //
//         TODO  fnToggleFlashmobOrganizerWarnings(strTogglableValue, bChecked)
        return
      }

      var $florpUserCitySelect = jQuery(".florp_user_city");
      var $florpFlashmobCitySelect = jQuery(".florp_flashmob_city");
      var $florpCoursesCitySelect = jQuery(".florp_courses_city");
      var $florpNonUserCitySelects = jQuery(".florp_flashmob_city,.florp_courses_city")
      $florpNonUserCitySelects.each(function () {
        var $this = jQuery(this)
        if ($this.val() === "null") {
          $this.data("setByUser", "0")
        } else {
          $this.data("setByUser", "1")
        }
      }).change(function() {
        var $this = jQuery(this)
        if ($this.val() === "null") {
          $this.data("setByUser", "0")
        } else {
          $this.data("setByUser", "1")
        }
      })

      var fnSetCitiesToUserCity = function($u, $fc, bOnChange = false) {
        if ($u.val() !== "null") {
          $fc.each(function(index) {
            var $this = jQuery(this)
            if ($this.val() === "null" || (bOnChange && $this.data("setByUser") === "0")) {
              $this.val($u.val()).data("setByUser", "0")
            }
          })
        }
      }
      fnSetCitiesToUserCity($florpUserCitySelect, $florpNonUserCitySelects)
      $florpUserCitySelect.change(function() {
        fnSetCitiesToUserCity($florpUserCitySelect, $florpNonUserCitySelects, true)
      })

      // Replace tshirt color radio buttons with images //
      var fnChangeProfileTshirtImgs = function($city) {
        var strImgCitySlug = $city.val().toLowerCase().replace(/\s+/g, "-").replace(/[^a-zA-Z0-9_-]/g, "_")
//         console.log(strImgCitySlug)
        if ("undefined" === typeof nfForms || "undefined" === typeof florp || "undefined" === typeof florp.form_id) {
          return;
        }
        var $form = jQuery("#florp-profile-form-wrapper-div #nf-form-"+florp.form_id+"-cont")
        var $tshirtImgs = $form.find(".florp-tshirt-color-label-img")
        $tshirtImgs.each(function(index) {
          var $this = jQuery(this)
          var color = $this.data("color")
          var tshirtImgPath = fnGetTshirtImgPath( strImgCitySlug, color )
          var tshirtImgPreviewPath = fnGetTshirtPreviewImgPath( strImgCitySlug, color )
          $this.prop("src", tshirtImgPath).data( "previewPath", tshirtImgPreviewPath )
        })
      }
      $florpUserCitySelect.each(function(index) {
        fnChangeProfileTshirtImgs(jQuery(this))
      })
      $florpUserCitySelect.change(function() {
        fnChangeProfileTshirtImgs(jQuery(this))
      })

      // Add correct classes to map refresh buttons //
      var findFlorpButtons = jQuery("span.florp-button");
      findFlorpButtons.each(function () {
        var $this = jQuery(this);
        if ($this.text() === "Obnov" && $this.parents(".florp-map-wrapper-div").length > 0 && !$this.hasClass("florp-button-find-location")) {
          $this.addClass("florp-button-find-location");
        }
        if ($this.text() === "Obnov" && $this.parents(".florp-map-courses-wrapper-div").length > 0 && !$this.hasClass("florp-button-reload-courses-map")) {
          $this.addClass("florp-button-reload-courses-map");
        }
      });
      // Get the correct map refresh buttons //
      var $findLocationButton = jQuery(".florp-button-find-location");
      var $reloadCoursesButton = jQuery(".florp-button-reload-courses-map")

      // BEGIN find location function //
        // Function to show map with location either based on city or flashmob location //
        var fnFindLocation = function() {
          var location, locationSelector = ".florp-flashmob-address", bUsingFlashmobAddress = true;
          location = jQuery.trim(jQuery(locationSelector).first().val());
          var $flashmobOrganizerCheckbox = jQuery("input.florp_flashmob_organizer[type=checkbox]")
          var bIsFlashmobOrganizer = $flashmobOrganizerCheckbox.is(':checked')
          jQuery(".florp-map-preview-wrapper .nf-field-description").removeAttr("style")
          if (location === "") {
            locationSelector = ".florp_flashmob_city";
            bUsingFlashmobAddress = false
            location = jQuery.trim(jQuery(locationSelector).first().val());
            jQuery(".florp-map-preview-wrapper .nf-field-description").hide()
            jQuery(".ninja-forms-field.nf-element.florp_longitude").val("");
            jQuery(".ninja-forms-field.nf-element.florp_latitude").val("");
          }
          var bLocationEmpty = false
          if (location === "" || location === "null") {
            // issue an error about empty location //
            console.warn("Location is empty!");
            jQuery(".ninja-forms-field.nf-element.florp_longitude").val("");
            jQuery(".ninja-forms-field.nf-element.florp_latitude").val("");
//             jQuery(".florp-map-preview-wrapper").hide();
            bLocationEmpty = true
          }

          // generate the list by: var arr = []; for (var i in form.fields) {arr.push(form.fields[i].key)}; console.log(arr.join("',"+"\n"+"'")) //
          var inputIDs = [
      //           'user_email',
              'first_name',
              'last_name',
      //           'user_pass',
      //           'passwordconfirm',
            'school_name',
            'facebook',
            'webpage',
            'custom_webpage',
            'user_city',
            'flashmob_number_of_dancers',
            'video_link',
            'flashmob_city',
            'flashmob_address',
            'longitude',
            'latitude',
          ], inputCheckboxIDs = [
            'hide_leader_info',
            'flashmob_organizer',
          ]
          if ("undefined" !== typeof florp.user_id ) {
            var oMapOptions = {};
            oMapOptions[florp.user_id] = {}
            for (var i in inputIDs) {
              var id = inputIDs[i].trim(),
                  val
              if (id === "webpage") {
                val = fnGetSchoolWebpageRadiolistValue()
              } else {
                var inputSelector = ".ninja-forms-field.nf-element.florp_"+id
                val = jQuery(inputSelector).first().val()
              }
              if ("undefined" !== typeof val) {
                oMapOptions[florp.user_id][id] = val
              }
            }
            for (var i in inputCheckboxIDs) {
              var id = inputCheckboxIDs[i].trim();
              var inputSelector = ".ninja-forms-field.nf-element.florp_"+id
              oMapOptions[florp.user_id][id] = jQuery(inputSelector).first().is(":checked") ? 1 : 0
            }

            var $previewContainer = jQuery(".florp-map-preview")
            var divID = "flashmob_organizer_preview"
            $previewContainer.prop("id", divID)
            florp_map_options_object[divID] = oMapOptions;
            var oAdditionalMarkerOptions = {}
            oAdditionalMarkerOptions[florp.user_id] = {
              "bDraggable" : bUsingFlashmobAddress
            }
            // console.log(oMapOptions)
            if (bLocationEmpty || !bIsFlashmobOrganizer) {
              florpGenerateMap( $previewContainer, divID, oMapOptions, oAdditionalMarkerOptions, 'flashmob_organizer', true, true )
              return
            }
//             jQuery( ".florp-map-preview-wrapper" ).show();
//             $previewContainer.height(florp.general_map_options.custom.height_preview).width('90%').css( { marginLeft : "auto", marginRight : "auto" } );

            var fnDraggableCallback = function(marker, divID, iUserID) {
              // console.log("Adding dragend listener")
              marker.addListener('dragend', function(event) {
                // console.log(event);
                var newLocation = {
                  lat: event.latLng.lat(),
                  lng: event.latLng.lng()
                };
                if ("undefined" === typeof florp.geocoder) {
                  florp.geocoder = new google.maps.Geocoder();
                }
                florp.geocoder.geocode({
                  'location': newLocation
                }, function(results, status) {
                  if (status === 'OK') {
                    // console.log(results);
                    if (results[1]) { // city
                      // florp.markerLocation = newLocation;
                      jQuery(".florp_longitude").first().val(newLocation.lng);
                      jQuery(".florp_latitude").first().val(newLocation.lat);
                      var newAddress = results[1].formatted_address;
                      marker.setTitle(newAddress);
                      jQuery(".florp-flashmob-address").first().val(newAddress);
                      var infoWindow = florp.maps.markers[divID][iUserID][0].info_window_object
                      if (typeof infoWindow === "object" && florp.info_window !== null) {
                        var content = jQuery(infoWindow.getContent());
                        var locationElement = content.find(".florp-flashmob-location");
                        if (locationElement.length > 0) {
                          locationElement.html(newAddress);
                          infoWindow.setContent(content[0].outerHTML);
                        }
                      }
                    } else {
                      console.warn('No results found');
                    }
                  } else {
                    console.warn('Geocoder failed due to: ' + status);
                  }
                });
              });
            }
            oAdditionalMarkerOptions["draggableCallback"] = fnDraggableCallback

            florpGenerateMap( $previewContainer, divID, oMapOptions, oAdditionalMarkerOptions, 'flashmob_organizer', true )
          }
        }
      // END find location function //

      // Show map with location on form load //
      fnFindLocation()

      fnToggleFlashmobFieldsIfOrganizer = function() {
        var $elementsToDisable = jQuery("input.florp_hide_leader_info, select.florp_flashmob_city, .florp-button-find-location")
        if ($flashmobOrganizerCheckbox.is(":checked")) {
          $elementsToDisable.removeAttr("disabled")
        } else {
          $elementsToDisable.attr("disabled", "disabled")
        }
      }
      fnToggleFlashmobFieldsIfOrganizer()

      // Onchange event when flashmob_city is changed //
      $florpFlashmobCitySelect.change(function() {
        if (jQuery.trim(jQuery(".florp-flashmob-address").first().val()) === "") {
          if (jQuery(this).val() === "null" && florp.has_participants != 1) {
            if ($flashmobOrganizerCheckbox.is(":checked")) {
              $flashmobOrganizerCheckbox.removeAttr("checked").trigger("change")
            }
//             jQuery(this).val($florpUserCitySelect.val())
          }
          fnFindLocation()
        }
      })
      $flashmobOrganizerCheckbox.change(function() {
        if (jQuery.trim(jQuery(".florp-flashmob-address").first().val()) === "") {
          fnFindLocation()
        }
        fnToggleFlashmobFieldsIfOrganizer()
      })
      jQuery("input.florp_hide_leader_info").change(function() {
        if (jQuery.trim(jQuery(".florp-flashmob-address").first().val()) === "") {
          fnFindLocation()
        }
      })

      if (florp.hide_flashmob_fields == 1) {
        // Disable after-flashmob fields //
        jQuery(".florp-flashmob input, .florp-flashmob select, .florp-flashmob text").attr("disabled", "disabled");
      } else {
        // Hide before-flashmob fields //
        jQuery(".florp-before-flashmob").hide();
        jQuery(".school_city_warning").hide();

        // Onclick event when location finder button is clicked //
      }
      $findLocationButton.on('click', function() {
        if (typeof $findLocationButton.attr("disabled") === "undefined") {
          fnFindLocation()
        }
      });

      // BEGIN reload courses //
      var fnBindReloadCoursesMapEvents = function( $checkbox ) {
        var bIsTeacher = jQuery("input.florp_teacher").is(":checked"),
            bCoursesInCity2 = jQuery("input.courses_in_city_2").is(":checked"),
            bCoursesInCity3 = jQuery("input.courses_in_city_3").is(":checked");

        jQuery(".florp_courses_city,.florp_courses_city_2,.florp_courses_city_3").off('change', fnReloadCoursesMap)
        $reloadCoursesButton.off('click', fnReloadCoursesMap)
        fnReloadCoursesMap()
        if (!bIsTeacher) {
          $reloadCoursesButton.attr("disabled", "disabled")
          return
        }
        $reloadCoursesButton.removeAttr("disabled")
    //     if ($checkbox.val() === 'teacher') {
    //     }
        $reloadCoursesButton.on('click', fnReloadCoursesMap)
        var strSelector = ".florp_courses_city",
            $select = jQuery(strSelector)
        $select.on('change', fnReloadCoursesMap)
        if (bCoursesInCity2) {
          strSelector = ".florp_courses_city_2"
          $select = jQuery(strSelector)
          $select.on('change', fnReloadCoursesMap)
          if (bCoursesInCity3) {
            strSelector = ".florp_courses_city_3"
            $select = jQuery(strSelector)
            $select.on('change', fnReloadCoursesMap)
          }
        }
      }
      var strCoursesMapCheckboxSelectors = "input.florp_teacher, input.courses_in_city_2, input.courses_in_city_3"
      jQuery(strCoursesMapCheckboxSelectors).change(function () {
        var $this = jQuery(this)
        fnBindReloadCoursesMapEvents($this)
      })

      // Function to show map with location either based on city or flashmob location //
      var fnReloadCoursesMap = function() {
        var timeout = 250
        var aShowStoppersActive = []
        var aShowStoppers = ["florpSetUserMarkerGeocoderRunning", "florpSetUserMarkerAjaxRunning", "fnReloadCoursesMapRunning"]
        aShowStoppers.forEach(function(key) {
          if (window[key]) {
            aShowStoppersActive.push(key)
          }
        })
        if (aShowStoppersActive.length > 0) {
          var sShowStoppersActive = aShowStoppersActive.join(", ")
          if (window["reloadCoursesMapTimeout"]) {
            console.info("fnReloadCoursesMap: there is a blocking operation ("+sShowStoppersActive+") running && another call of fnReloadCoursesMap scheduled; rescheduling")
            clearTimeout(window["reloadCoursesMapTimeout"])
            window["reloadCoursesMapTimeout"] = false
          } else {
            console.info("fnReloadCoursesMap: there is a blocking operation ("+sShowStoppersActive+") running; scheduling a new call")
          }
          window["reloadCoursesMapTimeout"] = setTimeout(function () {
            fnReloadCoursesMap()
          }, timeout);
          return
        }
        window["fnReloadCoursesMapRunning"] = true
        console.info("fnReloadCoursesMap: running")
        var location,
            bIsTeacher = jQuery("input.florp_teacher").is(":checked"),
            $coursesInCity2 = jQuery("input.courses_in_city_2"),
            bCoursesInCity2 = $coursesInCity2.is(":checked"),
            $coursesInCity3 = jQuery("input.courses_in_city_3"),
            bCoursesInCity3 = $coursesInCity3.is(":checked"),
            locationEmpty = true,
            inputIDs = [
              'first_name',
              'last_name',
              'school_name',
              'facebook',
              'webpage',
              'custom_webpage',
            ],
            aTriggerChange = []
        if (bIsTeacher) {
          var strSelector = ".florp_courses_city",
              strCity = jQuery(strSelector).val()
          if (strCity === "null") {
            if ($coursesInCity2.is(":checked")) {
              $coursesInCity2.removeAttr("checked")
              aTriggerChange.push($coursesInCity2)
            }
            $coursesInCity2.attr("disabled", "disabled")
          } else {
            locationEmpty = false
            $coursesInCity2.removeAttr("disabled")
            inputIDs.push("courses_city")
            inputIDs.push("courses_info")
          }
          if (bCoursesInCity2) {
            strSelector = ".florp_courses_city_2"
            strCity = jQuery(strSelector).val()
            if (strCity === "null") {
              if ($coursesInCity3.is(":checked")) {
                $coursesInCity3.removeAttr("checked")
                aTriggerChange.push($coursesInCity3)
              }
              $coursesInCity3.attr("disabled", "disabled")
            } else {
              $coursesInCity3.removeAttr("disabled")
              inputIDs.push("courses_city_2")
              inputIDs.push("courses_info_2")
            }
            if (bCoursesInCity3) {
              strSelector = ".florp_courses_city_3"
              strCity = jQuery(strSelector).val()
              if (strCity !== "null") {
                inputIDs.push("courses_city_3")
                inputIDs.push("courses_info_3")
              }
            }
          }
        }
        // console.log(inputIDs)

        if ("undefined" !== typeof florp.user_id ) {
          var oMapOptions = {};
          oMapOptions[florp.user_id] = {}
          for (var i in inputIDs) {
            var id = inputIDs[i].trim(),
                val
            if (id === "webpage") {
              val = fnGetSchoolWebpageRadiolistValue()
            } else {
              var inputSelector = ".ninja-forms-field.nf-element.florp_"+id
              val = jQuery(inputSelector).first().val()
            }
            if ("undefined" !== typeof val) {
              oMapOptions[florp.user_id][id] = val
            }
          }

          var $previewContainer = jQuery(".florp-map-courses-preview")
          var divID = "teacher_map_preview"
          $previewContainer.prop("id", divID)
          florp_map_options_object[divID] = oMapOptions;
          //jQuery( ".florp-map-courses-preview-wrapper" ).show();
          //$previewContainer.height(florp.general_map_options.custom.height).width('90%').css( { marginLeft : "auto", marginRight : "auto" } );

          florpGenerateMap( $previewContainer, divID, oMapOptions, {}, "teacher", true, locationEmpty )
        }
        if (aTriggerChange.length > 0) {
          aTriggerChange.forEach(function($checkbox) {
            $checkbox.trigger("change")
          })
        }
        window["fnReloadCoursesMapRunning"] = false
      }

      fnReloadCoursesMap()
      fnBindReloadCoursesMapEvents()
      // END reload courses //
    } else if (florp.blog_type === "flashmob") {
      // Get create and populate the togglable checkbox values into an array //
      $aPreferenceTogglerCheckboxes = jQuery(".florp_preferences_container input[type=checkbox]")
      fnToggleFields($aPreferenceTogglerCheckboxes, "preference");
      $aPreferenceTogglerCheckboxes.change(function() {
        var $this = jQuery(this)
        fnToggleFields($this, "preference");
      })
    }
  }

  function florpFlashAnchors() {
    var regexes = [{
      name: "florpAnchorFlash",
      regex: new RegExp( "#flash\-201[3-7]$" ),
      base: "#flash-",
      elementSelector: "#flash",
      offset: 0,
    }, {
      name: "florpAnchorMap",
      regex: new RegExp( "#map\-2014$" ),
      base: "#map-",
      elementSelector: "#us_map_3",
      offset: 100,
    }];

    for (var i = 0; i < regexes.length; i++) {
      var regexObj = regexes[i];
      var matches = window.location.hash.match( regexObj.regex );
      if (window.location.hash.match( regexObj.regex )) {
        if ("undefined" === typeof window[regexObj.name]) {
          window[regexObj.name] = setInterval(function (i) {
            if (document.readyState == "complete") {
              var regexObjLocal = regexes[i];
              var el = jQuery(regexObjLocal.elementSelector);
              clearInterval(window[regexObjLocal.name]);
              window[regexObjLocal.name] = undefined;
              var tab = jQuery(".w-tabs-item-title").filter(function() {
                var year = window.location.hash.match( regexObjLocal.regex )[0].replace(regexObjLocal.base, "");
                return jQuery(this).html().trim() === year;
              });
              tab.click();
              jQuery('html, body').scrollTop(el.first().offset().top - regexObjLocal.offset);
            }
          }, 200, i);
        }
      }
    }
  }

  function florpLoadVisibleVideos() {
    if (florp.load_videos_lazy !== '1') {
      return;
    }
    jQuery('.w-video.removedEmbed').each(function() {
      $div = jQuery(this);
      if ($div.is(":not(:hidden)")) {
        var iEmbedID = $div.data("embedId");
        if ("undefined" === typeof iEmbedID || "undefined" === typeof florp.embeds[iEmbedID]) {
          console.warn("Couldn't find embed to replace back");
        } else {
          $div.removeClass("removedEmbed").append(florp.embeds[iEmbedID].children());
          console.info("Lazy loaded video ("+iEmbedID+")");
        }
      }
    });
  }
// END Florp specific functions //

// BEGIN Florp events //
  // Set florp-popup=1 cookie on lwa_login event if permitted //
  jQuery(document).on('lwa_login', function(event, data, form) {
    if ("undefined" === typeof florp.doNotSetCookie || florp.doNotSetCookie !== true) {
      florpSetCookie("florp-popup", "1");
      console.info("cookie was set");
    } else {
      console.info("cookie was NOT set");
    }
  });

  jQuery(document).on( 'pumAfterOpen', '#pum-'+florp.popup_id, function () {
    var $popup = PUM.getPopup(this);
    if (!$popup.length || !$popup.hasClass('pum')) { $popup = jQuery(this); console.warn("Trying to get the popup object by jQuery from 'this'"); }
    if (!$popup.length || !$popup.hasClass('pum')) { $popup = jQuery('#pum-'+florp.popup_id); console.warn("Trying to get the popup object by jQuery from ID"); }
    if (!$popup.length || !$popup.hasClass('pum')) { console.warn("Couldn't get the popup object!"); return; }
    var settings = $popup.popmake('getSettings');
    if (settings.close_on_overlay_click) {
      setTimeout(function () {
        // Remove the original close overlay event //
        jQuery(document).off('click.pumCloseOverlay');

        // Add the overlay event with a check whether the click was on the submit button //
        jQuery(document).on('click.pumCloseOverlay', function (e) {
          var $target = jQuery(e.target);
          if(!$target.closest('.pum-container').length && !$target.hasClass("florp_uloz_profil")) {
            var $popup = PUM.getPopup(e.target);
            if (!$popup.length || !$popup.hasClass('pum')) { console.warn("Couldn't get the popup object!"); return; }
            jQuery.fn.popmake.last_close_trigger = 'Overlay Click';
            $popup.popmake('close');
          }
        });
      }, 500);
    }
  });

  jQuery(document).on( 'click', '.florp-click-participant-trigger', function () {
    if (florp.popup_id > 0) {
      var $this = jQuery(this),
          iUserID = $this.data("userId"),
          strDivID = $this.data("divId"),
          strFlashmobCity = $this.data("flashmobCity"),
          strImgCitySlug = strFlashmobCity.toLowerCase().replace(/\s+/g, "-").replace(/[^a-zA-Z0-9_-]/g, "_")
      // console.log($this)
      var $form = jQuery("#florp-profile-form-wrapper-div #nf-form-"+florp.form_id+"-cont")
      if ("undefined" === typeof nfForms) {
        return;
      }
      nfForms.forEach(function (oForm) {
        if (oForm.id == florp.form_id) {
          oForm.fields.forEach(function (oField) {
            if (oField.key === 'leader_user_id') {
              jQuery( '#nf-field-' + oField.id ).val( iUserID ).trigger('change')
            } else if (oField.key === 'flashmob_city') {
              jQuery( '#nf-field-' + oField.id ).val( strFlashmobCity ).trigger('change')
            }
          })
        }
      })
      var $tshirtImgs = $form.find(".florp-tshirt-color-label-img")
      $tshirtImgs.each(function(index) {
        var $this = jQuery(this)
        var color = $this.data("color")
        var tshirtImgPath = fnGetTshirtImgPath( strImgCitySlug, color )
        var tshirtImgPreviewPath = fnGetTshirtPreviewImgPath( strImgCitySlug, color )
        $this.prop("src", tshirtImgPath).data( "previewPath", tshirtImgPreviewPath )
      })
      PUM.getPopup(florp.popup_id).data("markerKey", $this.data("markerKey")).data("userId", iUserID).data("divId", strDivID)
      PUM.open(florp.popup_id);
    }
  })

  jQuery(document).on( 'pumAfterOpen', '#pum-'+florp.popup_id, function () {
    sessionStorage.setItem("florpFormSubmitSuccessful", "0");
  });

  // jQuery(document).on( 'pumBeforeOpen', '#pum-'+florp.popup_id, function () {
  //   console.log(jQuery(".jBox-wrapper"))
  //   jQuery(".jBox-wrapper").addClass("z-index-1999999999")
  // });

  jQuery(document).on( 'pumBeforeClose', '#pum-'+florp.popup_id, florpScrollToAnchor );
  // jQuery(document).on( 'pumAfterClose', '#pum-'+florp.popup_id, florpScrollToAnchor );
  jQuery(document).on( 'pumBeforeClose', '#pum-'+florp.popup_id, florp_reload_on_successful_submission );

  jQuery( document ).on( 'nfFormReady', function() {
    florpFixFormClasses();

    // Trigger the popup //
    if (florp.do_trigger_popup_click) {
      jQuery("."+florp.click_trigger_class).first().trigger( "click" );
      console.log("click triggered");
    }

    jQuery(document).on('input', '.ninja-forms-field.florp_first_name', function(event) {
  //     event.preventDefault();
      var newValue = jQuery(this).val();
      jQuery('.florp_onchange.florp_first_name').html(newValue);
    });
    jQuery(document).on('propertychange', '.ninja-forms-field.florp_first_name', function(event) {//IE8
  //     event.preventDefault();
      var newValue = jQuery(this).val();
      jQuery('.florp_onchange.florp_first_name').html(newValue);
    });
    jQuery(document).on('input', '.ninja-forms-field.florp_last_name', function(event) {
  //     event.preventDefault();
      var newValue = jQuery(this).val();
      jQuery('.florp_onchange.florp_last_name').html(newValue);
    });
    jQuery(document).on('propertychange', '.ninja-forms-field.florp_last_name', function(event) {//IE8
  //     event.preventDefault();
      var newValue = jQuery(this).val();
      jQuery('.florp_onchange.florp_last_name').html(newValue);
    });

    // Fix webpages //
    var fixWebPages = function(event, _this) {
  //     event.preventDefault();
      var newValue = jQuery(_this).val().trim();

      // If trimmed, set the input to trimmed value //
      if (jQuery(_this).val().length > newValue.length) {
        jQuery(_this).val(newValue);
      }

      if (newValue.length > 0) {
        // Remove any white spaces //
        if (newValue.match(/\s/)) {
          newValue = newValue.replace(/\s/g, "");
          jQuery(_this).val(newValue);
        }

        // Add https?:// to the beginning if it's missing //
        var strHttpsParts = "(h|ht|htt|https?|https?:|https?:\/|https?:\/\/)";
        if (
          !newValue.match(new RegExp( "^"+strHttpsParts+"$|^https?:\/\/.+", 'gi'))
        ) {
          jQuery(_this).val("http://"+newValue);
        } else {
          // Remove duplicate https?:// //
          var strRegExp = "^https?:\/\/"+strHttpsParts+"$|^https?:\/\/https?:\/\/.+$";
          while (
            newValue.match(new RegExp( strRegExp, 'gi'))
          ) {
            newValue = newValue.replace(new RegExp("^https?:\/\/"), "");
            jQuery(_this).val(newValue);
          }
        }
      }
    }
    jQuery(document).on('input', '.ninja-forms-field.florp_facebook, .ninja-forms-field.florp_custom_webpage, .ninja-forms-field.florp_video_link', function(event) {
      fixWebPages(event, this);
    });
    jQuery(document).on('propertychange', '.ninja-forms-field.florp_facebook, .ninja-forms-field.florp_custom_webpage, .ninja-forms-field.florp_video_link', function(event) {//IE8
      fixWebPages(event, this);
    });
  });

  jQuery( document ).ready(function() {
    if (florp.load_videos_lazy === '1') {
      var iEmbedID = 0;
      florp.embeds = {};
      jQuery('.w-video').each(function() {
        $div = jQuery(this);
        if ($div.is(":hidden") && $div.find("script").length === 0) {
          florp.embeds[iEmbedID] = $div.clone();
          $div.addClass("removedEmbed").data("embedId", iEmbedID).children().remove();
          console.info("Removed video ("+iEmbedID+") and saved it for lazy loading");
          iEmbedID++;
        }
      });
    }

    if (florp.blog_type === "main" && "undefined" === typeof florp.user_id ) {
      jQuery("#pum_popup_title_"+florp.popup_id).html("Registrácia");
      // console.log(jQuery("#pum_popup_title_"+florp.popup_id))
    }

    florpGenerateYearlyMaps();

    florpFlashAnchors();
  });


  jQuery(window).on('hashchange', function(e){
    florpFlashAnchors();
  });

  // Bind click event on all tab title elements //
  jQuery(document).on('click', ".w-tabs-item, .w-tabs-section-header", function (event) {
    var objTarget = jQuery(event.target);
    // The selectors of tab and tab title shown before all the contents - in non-mobile view //
    var strTabClass = "w-tabs-item-h";
    var strTabItemClass = "w-tabs-item";
    // The selector of tab title shown right before the content - in mobile view //
    var strTabItemClassMobile = "w-tabs-section-header";
    if (objTarget.hasClass(strTabItemClass)) {
      // Clicked on the tab (non-mobile) item => find the ANCHOR item //
      var objTab = objTarget.find("."+strTabClass);
      var objTabItem = objTarget;
    } else if (objTarget.hasClass(strTabItemClassMobile)) {
      // Clicked on the tab title (mobile) ANCHOR itself - the one we want //
      var objTab = objTarget;
      var objTabItem = objTarget;
    } else if (objTarget.hasClass(strTabClass)) {
      // Clicked on the tab title (non-mobile) ANCHOR itself => find the tab item parent //
      var objTab = objTarget;
      var objTabItem = objTarget.parents("."+strTabItemClass);
    } else {
      // Didn't click on either tab item or tab anchor //
      //   => try to find the tab anchor downwards (non-mobile) and tab item upwards //
      var objTab = objTarget.find("."+strTabClass);
      var objTabItem = objTarget.parents("."+strTabItemClass);
      if (objTab.length === 0) {
        // Try to find the tab anchor upwards (non-mobile) //
        objTab = objTarget.parents("."+strTabClass);
      }
      if (objTab.length === 0) {
        // Try to find the tab anchor upwards (mobile) //
        //   - no searching downwards as the tab title is the item //
        objTab = objTarget.parents("."+strTabItemClassMobile);
        objTabItem = objTab;
      }
    }
    if (objTab.length === 0) {
      console.warn("Couldn't find '."+strTabClass+"' above/under clicked element:")
      console.log(objTarget);
      console.info("Loading EVERY non-hidden map and video");
      florpReloadVisibleMaps();
      florpLoadVisibleVideos();
      return;
    }
    if (objTabItem.length === 0) {
      console.warn("Couldn't find '."+strTabItemClass+"' above/under clicked element:")
      console.log(objTarget);
      console.info("Loading EVERY non-hidden map and video");
      florpReloadVisibleMaps();
      florpLoadVisibleVideos();
      return;
    }
    var divID = objTab.prop("href")
    if ("undefined" === typeof divID) {
      console.warn("Couldn't find div ID for clicked tab:")
      console.log(objTarget, objTab);
      console.info("Loading EVERY non-hidden map and video");
      florpReloadVisibleMaps();
      florpLoadVisibleVideos();
      return;
    } else {
      divID = "#"+divID.split("#")[1];
    }
    try {
      var objContent = jQuery( divID )
    } catch (e) {
      console.warn(e)
      console.log(divID)
      return
    }

    if (objContent.length === 0) {
      console.warn("Couldn't find content associated with clicked tab:")
      console.log(objTarget, objTab, divID);
      return;
    }
  //   if (objContent.find(".florp-map").length === 0) {
  //     // console.info("There is no florp map under content for tab "+divID);
  //     return;
  //   }

    setTimeout(function () {
      if (objTarget.is(':animated') || objTab.is(':animated') || objContent.is(':animated')) {
        var interval = setInterval(function () {
          if (objTarget.is(':animated') || objTab.is(':animated') || objContent.is(':animated')) {
            // continue
          } else {
            clearInterval(interval)
            if (objContent.find(".florp-map").length > 0) {
              florpReloadVisibleMaps();
            }
            if (objContent.find(".w-video").length > 0) {
              florpLoadVisibleVideos();
            }
            if (objContent.find(".florp-profile-wrapper").length > 0) {
  //             florpFormInit();
            }
          }
        }, 100);
      } else {
        if (objContent.find(".florp-map").length > 0) {
          florpReloadVisibleMaps();
        }
        if (objContent.find(".w-video").length > 0) {
          florpLoadVisibleVideos();
        }
        if (objContent.find(".florp-profile-wrapper").length > 0) {
  //         florpFormInit();
        }
      }
    }, 500);
  });

  // Login with Ajax events //
  jQuery(document).on('click', '.lwa-links-remember', function(event){
    var remember_form = jQuery(this).parents('.lwa').find('.lwa-remember');
    if( remember_form.length > 0 ){
      event.preventDefault();
      jQuery(this).hide('slow');
      jQuery(this).parents('.lwa').find('.lwa-links-register-inline').show('slow');
    }
  });
  jQuery(document).on('click', '.lwa-links-remember-cancel', function(event){
    event.preventDefault();
    jQuery(this).parents('.lwa').find('.lwa-links-remember').show('slow');
  });

  jQuery(document).on('click', '.lwa-links-register-inline', function(event){
    var remember_form = jQuery(this).parents('.lwa').find('.lwa-remember');
    if( remember_form.length > 0 ){
      event.preventDefault();
      jQuery(this).parents('.lwa').find('.lwa-form').hide('slow');
    }
  });
  jQuery(document).on('click', '.lwa-links-register-inline-cancel', function(event){
    event.preventDefault();
    jQuery(this).parents('.lwa').find('.lwa-form').show('slow');
  });
// END Florp events //
