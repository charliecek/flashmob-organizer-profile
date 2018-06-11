if ("undefined" === typeof florp_map_options_object) {
  var florp_map_options_object = {};
}

jQuery(function($) {

  var _oldShow = $.fn.show;

  $.fn.show = function(speed, oldCallback) {
    return $(this).each(function() {
      var obj         = $(this),
          newCallback = function() {
            if ($.isFunction(oldCallback)) {
              oldCallback.apply(obj);
            }
            obj.trigger('afterShow');
          };

      // you can trigger a before show if you want
      obj.trigger('beforeShow');

      // now use the old function to show the element passing the new callback
      _oldShow.apply(obj, [speed, newCallback]);
    });
  }
});

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
};
function florpRandomObjectProperty(obj) {
    var keys = Object.keys(obj)
    return obj[keys[ keys.length * Math.random() << 0]];
};
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
    if ($this.is(':hidden')) {
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
    if (!$this.is(':hidden')) {
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

jQuery(document).on('lwa_login', function(event, data, form) {
  if ("undefined" === typeof florp.doNotSetCookie || florp.doNotSetCookie !== true) {
    florpSetCookie("florp-popup", "1");
    console.info("cookie was set");
  } else {
    console.info("cookie was NOT set");
  }
});

function florpScrollToAnchor() {
  console.log("firing event before close");
  var el = jQuery("#florp-popup-scroll");
  if (el.length > 0) {
    jQuery('html, body').scrollTop(el.first().offset().top - 100);
  }
}

function florpUnescapeRegexp(strRegex) {
  return strRegex.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
}

function florpRescrapeFbOgMapImage() {
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
    florpReloadYearlyMap();
    return;
  }
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

function florpGenerateMap( oDivDOMElement, divID, oMapOptions, oAdditionalMarkerOptions = {}, strMapType = 'flashmob_organizer' ) {
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
    oDivDOMElement.height(florp.general_map_options.custom.height).width('100%').css( { marginLeft : "auto", marginRight : "auto" } );
    var gMapOptions = florp.general_map_options.map_init_raw;
    var mapCenterArr = florp.general_map_options.map_init_aux.center;
    gMapOptions.center = new google.maps.LatLng(mapCenterArr.lat, mapCenterArr.lng)
    var map = new google.maps.Map(document.getElementById(divID), gMapOptions);
    
    florp.maps.objects[divID] = map;
  } else {
    map = florp.maps.objects[divID];
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

  if ("undefined" !== typeof oAdditionalMarkerOptions) {
    florp.maps.additionalMarkerOptions[divID] = jQuery.extend(true, {}, florp.maps.additionalMarkerOptions[divID], oAdditionalMarkerOptions)
  }

  // For each user show their markers //
  for (iUserID in oMapOptions) {
    if (oMapOptions.hasOwnProperty(iUserID)) {
      var oUserOptions = oMapOptions[iUserID];
      var strLocation = ""
      if (strMapType === "flashmob_organizer") {
        strLocation = oUserOptions.flashmob_address || oUserOptions.school_city || ""
        florpSetUserMarker( iUserID, oUserOptions, map, divID, florp.maps.markerShownOnLoad[divID] === iUserID, strLocation, 0, strMapType );
      } else if (strMapType === "teacher") {
        var bShowOnLoad = true, bDontShow = false
        var aProperties = ["school_city", "courses_city", "courses_city_2", "courses_city_3"]
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
      }
    }
  }
}

function florpSetUserMarker(iUserID, oUserOptions, map, divID, show, strLocation, mixMarkerKey = 0, strMapType = "flashmob_organizer" ) {
  var k, oInfoWindowData = {};
  for (k in oUserOptions) {
    if (oUserOptions.hasOwnProperty(k)) {
      oInfoWindowData[k] = {
        value: oUserOptions[k]
      };
    }
  }
  // console.log(oInfoWindowData)

  var location = strLocation;
  if (location.length === 0) {
    console.info("No location found for user "+iUserID);
    // console.log(oUserOptions)
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
    };
    jQuery.ajax({
      type: "POST",
      url: florp.ajaxurl,
      data: data,
      success: function(response) {
        // console.log(response);
        try {
          var getMarkerInfoHtmlRes = JSON.parse(response);
//               console.log(getMarkerInfoHtmlRes);
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
        } catch(e) {
          console.log(e);
        }
      },
      error: function(errorThrown){
        console.warn(errorThrown);
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

function florpReloadYearlyMap( iYear = 0 ) {
  /*
   * We look for the map div(s) by data-is-current-year="1" and iterate through these
   * we ask for all the info by ajax 
   */
  
  if ("undefined" === typeof florp.user_id || "undefined" === typeof florp_map_options_object || florpObjectLength(florp_map_options_object) === 0) {
    return;
  }
  
  var currentYearMaps = jQuery(".florp-map[data-is-current-year='1']");
  currentYearMaps.each(function () {
    var thisObj = jQuery(this);
    var id = thisObj.attr('id');
    var old_map_options = florp_map_options_object[id][florp.user_id];
    
    var data = {
      action: florp.get_mapUserInfo_action,
      security : florp.security,
      old_map_options: old_map_options,
      user_id: florp.user_id,
      divID: id,
    };
    jQuery.ajax({
      type: "POST",
      url: florp.ajaxurl,
      data: data,
      success: function(response) {
        // console.log(response);
        try {
          var getMarkerInfoHtmlRes = JSON.parse(response);
          // console.log(getMarkerInfoHtmlRes);
          if (getMarkerInfoHtmlRes.new_map_options !== false) {
            var map = florp.maps.objects[getMarkerInfoHtmlRes.data.divID];
            // TODO check - using location for flashmob_organizer map type //
            var strLocation = getMarkerInfoHtmlRes.new_map_options.flashmob_address || getMarkerInfoHtmlRes.new_map_options.school_city || ""
            florpSetUserMarker(florp.user_id, getMarkerInfoHtmlRes.new_map_options, map, getMarkerInfoHtmlRes.data.divID, true, strLocation);
            florpRescrapeFbOgMapImage();
          }
        } catch(e) {
          console.log(e);
        }
      },
      error: function(errorThrown){
        console.warn(errorThrown);
      }
    });
  });
}

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
jQuery(document).on( 'pumBeforeClose', '#pum-'+florp.popup_id, florpScrollToAnchor );
// jQuery(document).on( 'pumAfterClose', '#pum-'+florp.popup_id, florpScrollToAnchor );
jQuery(document).on( 'pumAfterClose', '#pum-'+florp.popup_id, florp_reload_on_successful_submission );

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
  jQuery(document).on('input', '.ninja-forms-field.florp_webpage, .ninja-forms-field.florp_school_webpage, .ninja-forms-field.florp_facebook_link, .ninja-forms-field.florp_vimeo_link, .ninja-forms-field.florp_youtube_link', function(event) {
    fixWebPages(event, this);
  });
  jQuery(document).on('propertychange', '.ninja-forms-field.florp_webpage, .ninja-forms-field.florp_school_webpage, .ninja-forms-field.florp_facebook_link, .ninja-forms-field.florp_vimeo_link, .ninja-forms-field.florp_youtube_link', function(event) {//IE8
    fixWebPages(event, this);
  });
});

var $aTogglableCheckboxes = [];
var aFlorpTogglableValues = [];
var $aTogglablePreferenceCheckboxes = [];
var aFlorpTogglablePreferenceValues = [];
var $aTogglableSingleCheckboxCheckboxes = [];
var aFlorpTogglableSingleCheckboxValues = [];
function florpFixFormClasses() {
  // console.info("Fixing FLORP classes")

  // Fix classes //
  jQuery( ".florp-class" ).each(function (){
    var thisObj = jQuery(this);
    var strClass = thisObj.attr("class"); 
    var aClasses = strClass.replace("  ", " ").trim().split(" ");
    var aFilteredClasses = jQuery.grep(aClasses, function( n, i ) {
      return ( n.match("^florp-") && n !== "florp-class" );
    });
    var strFilteredClasses = aFilteredClasses.join(" ");
    thisObj.removeClass("florp-class").removeClass(strFilteredClasses);
    thisObj.closest("nf-field").addClass(strFilteredClasses);
  });
  
  jQuery(".nf-help").removeClass("nf-help");

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

  var fnSetCityLabel = function() {
    var bIsTeacher = jQuery(".florp_subscriber_type_container input[value=teacher]").is(":checked"),
    bIsFlashmobOrganizer = jQuery(".florp_subscriber_type_container input[value=flashmob_organizer]").is(":checked"),
    bCoursesInDifferentCity = jQuery(".florp_preferences_container input[value=courses_in_different_city]").is(":checked"),
    $cityLabel = jQuery(".florp_school_city").parents("nf-field").find(".nf-field-label label"),
    strCityLabelNone = "Mesto",
    strCityLabelBoth = "Mesto flashmobu a kurzov",
    strCityLabelCourses = jQuery(".florp_courses_city").parents("nf-field").find(".nf-field-label label").html(),
    strCityLabelFlashmob = "Mesto flashmobu"
    console.log(bIsTeacher, bIsFlashmobOrganizer, bCoursesInDifferentCity, $cityLabel)

    if (bIsTeacher && bIsFlashmobOrganizer) {
      if (bCoursesInDifferentCity) {
        $cityLabel.html(strCityLabelFlashmob)
      } else {
        $cityLabel.html(strCityLabelBoth)
      }
    } else if (bIsTeacher) {
      $cityLabel.html(strCityLabelCourses)
    } else if (bIsFlashmobOrganizer) {
      $cityLabel.html(strCityLabelFlashmob)
    } else {
      $cityLabel.html(strCityLabelNone)
    }
  }

  var fnToggleFields = function($changeEl, $aTogglableCheckboxesLoc, aFlorpTogglableValuesLoc, strToggleType = "togglable") {
    var strSelectorPreventToggling = ""
    var strTogglableFieldSelector = ""
    if (strToggleType === "togglable") {
      // Add, set specific selectors //
      strSelectorPreventToggling = ":not(.florp-registration-field)"
      strTogglableFieldSelector = ".florp-"+strToggleType+"-field_all"+strSelectorPreventToggling+" .nf-field-container,.florp-"+strToggleType+"-field_any"+strSelectorPreventToggling+" .nf-field-container, .florp-"+strToggleType+"-element_all"
    }
    aFlorpTogglableValuesLoc.forEach(function (strType) {
      if (strTogglableFieldSelector.length > 0) {
        strTogglableFieldSelector += ","
      }
      strTogglableFieldSelector += ".florp-"+strToggleType+"-field_"+strType+strSelectorPreventToggling+" .nf-field-container,.florp-"+strToggleType+"-element_"+strType
    })
    var $aTogglableFieldsAll = jQuery(strTogglableFieldSelector)

    // Count checkboxes //
    var iNumberOfChecked = 0
    var iNumberOfCheckboxes = $aTogglableCheckboxesLoc.length
    var oCheckboxesChecked = {}
    $aTogglableCheckboxesLoc.each(function () {
      var $this = jQuery(this);
      var val;
      if (strToggleType === "checkbox") {
        if ($this.hasClass('courses_in_city_2')) {
          val = 'courses2'
        } else if ($this.hasClass('courses_in_city_3')) {
          val = 'courses3'
        } else {
          return
        }
      } else {
        val = $this.val()
      }
      var bChecked = $this.is(':checked')
      oCheckboxesChecked[val] = bChecked
      if (bChecked) {
        iNumberOfChecked++;
      }
    });

    // Do the hiding / showing magic //
    switch (iNumberOfChecked) {
      case 0:
        // hide everything //
        if ($aTogglableFieldsAll.length === 0) {
          // No fields to toggle //
        } else {
          $aTogglableFieldsAll.each(function () {
            jQuery(this).find("input[type=checkbox]").each(function () {
              $this = jQuery(this)
              if ($this.is(":checked")) {
                $this.prop('checked', false).trigger( 'change' )
              }
            })
          })
          florpAnimateHide($aTogglableFieldsAll)
        }
        break;
      case iNumberOfCheckboxes:
        // show everything //
        if ($aTogglableFieldsAll.length === 0) {
          // No fields to toggle //
        } else {
          florpAnimateShow($aTogglableFieldsAll)
        }
        break;
      default:
        // Show those that are checked and hide those unchecked + show 'any', hide 'all' //
        var strSelectorShow = ""
        var strSelectorHide = ""

        var i;
        for (i in oCheckboxesChecked) {
          if (oCheckboxesChecked.hasOwnProperty(i)) {
            if (oCheckboxesChecked[i]) {
              if (strSelectorShow.length > 0) {
                strSelectorShow += ","
              }
              strSelectorShow += ".florp-"+strToggleType+"-field_"+i+strSelectorPreventToggling+" .nf-field-container,.florp-"+strToggleType+"-element_"+i
            } else {
              if (strSelectorHide.length > 0) {
                strSelectorHide += ","
              }
              strSelectorHide += ".florp-"+strToggleType+"-field_"+i+strSelectorPreventToggling+" .nf-field-container%%not%%,.florp-"+strToggleType+"-element_"+i+"%%not%%"
            }
          }
        }

        // Also hide 'all' //
        if (strSelectorHide.length > 0) {
          strSelectorHide += ","
        }
        strSelectorHide += ".florp-"+strToggleType+"-field_all"+strSelectorPreventToggling+" .nf-field-container%%not%%,.florp-"+strToggleType+"-element_all%%not%%"

        var strShownIDs = "";
        if (strSelectorShow.length > 0) {
          // Also show 'any' //
          strSelectorShow += ",.florp-"+strToggleType+"-field_any"+strSelectorPreventToggling+" .nf-field-container"
          var $show = jQuery(strSelectorShow)

          // Get ID selectors of elements to be shown //
          var iID = 0
          $show.each(function() {
            var $this = jQuery(this);
            var id = $this.attr("id")
            if ("undefined" === typeof id) {
              id = "florp-"+strToggleType+"-el-"+iID
              $this.attr("id", id)
            }
            if (strShownIDs.length > 0) {
              strShownIDs += ","
            }
            strShownIDs += "#"+id
            iID++
          })
          // Show elements to be shown //
          florpAnimateShow($show)
        }
        if (strSelectorHide.length > 0) {
          // Replace selector of elements to be shown into selector of elements to be hidden //
          var not = ""
          if (strShownIDs.length > 0) {
            not = ":not("+strShownIDs+")"
          }
          strSelectorHide = strSelectorHide.replace(/%%not%%/g, not)
          var $hide = jQuery(strSelectorHide)
          $hide.each(function () {
            jQuery(this).find("input[type=checkbox]").each(function () {
              $this = jQuery(this)
              if ($this.is(":checked")) {
                $this.prop('checked', false).trigger( 'change' )
              }
            })
          })
          // Hide elements to be hidden //
          florpAnimateHide($hide)
        }
    }
  }

  var $flashmobOrganizerCheckbox = jQuery(".florp_subscriber_type_container input[type=checkbox][value=flashmob_organizer]");
  fnToggleFlashmobOrganizerWarnings( 'flashmob_organizer', $flashmobOrganizerCheckbox.is(':checked'), false )
//   jQuery(".lwa-register").bind('afterShow', function() {
//     // console.log($flashmobOrganizerCheckbox, $flashmobOrganizerCheckbox.is(':checked'))
//     fnToggleFlashmobOrganizerWarnings( 'flashmob_organizer', $flashmobOrganizerCheckbox.is(':checked'), false )
//   })

  // Get the checkboxes //
  $aTogglableCheckboxes = jQuery(".florp_subscriber_type_container input[type=checkbox]");
  $aTogglablePreferenceCheckboxes = jQuery(".florp_preferences_container input[type=checkbox]");
  $aTogglableSingleCheckboxCheckboxes = jQuery(".florp-single-checkbox-toggler input[type=checkbox]");

  // Make some more elements togglable //
  jQuery(".florp_preferences_container input[value=flashmob_leader_tshirt]").parent().addClass("florp-togglable-element_flashmob_organizer")
  jQuery(".florp_preferences_container input[value=courses_in_different_city]").parent().addClass("florp-togglable-element_all")

  // When logged in, hide/unhide parts of the profile form based on which togglable checkbox values the user has //
  if ("undefined" === typeof florp.user_id ) {
    // Not logged in => registration form - only toggle warnings //
    $aTogglableCheckboxes.change(function () {
      var $this = jQuery(this);
      var strTogglableValue = $this.val()
      var bChecked = $this.is(':checked')

      fnToggleFlashmobOrganizerWarnings(strTogglableValue, bChecked)
    })
  } else {
    // Logged in => profile form - do the magic //

    // Get create and populate the togglable checkbox values into an array //
    $aTogglableCheckboxes.each(function () {
      aFlorpTogglableValues.push(jQuery(this).val())
    });
    $aTogglablePreferenceCheckboxes.each(function () {
      aFlorpTogglablePreferenceValues.push(jQuery(this).val())
    });
    $aTogglableSingleCheckboxCheckboxes.each(function () {
      var $this = jQuery(this)
      if ($this.hasClass('courses_in_city_2')) {
        aFlorpTogglableSingleCheckboxValues.push('courses2')
      } else if ($this.hasClass('courses_in_city_3')) {
        aFlorpTogglableSingleCheckboxValues.push('courses3')
      }
    });

    // Toggle fields based on checkboxes //
    fnToggleFields(undefined, $aTogglableCheckboxes, aFlorpTogglableValues, "togglable");
    fnToggleFields(undefined, $aTogglablePreferenceCheckboxes, aFlorpTogglablePreferenceValues, "preference");
    fnToggleFields(undefined, $aTogglableSingleCheckboxCheckboxes, aFlorpTogglableSingleCheckboxValues, "checkbox");
    fnSetCityLabel()

    // Onchange events for the checkboxes //
    $aTogglableCheckboxes.change(function () {
      var $this = jQuery(this);

      fnToggleFields($this, $aTogglableCheckboxes, aFlorpTogglableValues, "togglable");
      fnSetCityLabel()

      var strTogglableValue = $this.val()
      var bChecked = $this.is(':checked')
      fnToggleFlashmobOrganizerWarnings(strTogglableValue, bChecked)
    });
    $aTogglablePreferenceCheckboxes.change(function () {
      var $this = jQuery(this);

      fnToggleFields($this, $aTogglablePreferenceCheckboxes, aFlorpTogglablePreferenceValues, "preference");
      fnSetCityLabel()
    });
    $aTogglableSingleCheckboxCheckboxes.change(function () {
      var $this = jQuery(this);

      fnToggleFields($this, $aTogglableSingleCheckboxCheckboxes, aFlorpTogglableSingleCheckboxValues, "checkbox");
      fnSetCityLabel()
    });
  }

  var florpSchoolCitySelect = jQuery(".florp_school_city");
  if (typeof florp.school_city !== "undefined" && florp.school_city.length > 0) {
    jQuery(".florp_school_city option").removeAttr("selected");
//     jQuery(".florp_school_city option[value="+florp.school_city+"]").attr("selected", "selected");
    florpSchoolCitySelect.val(florp.school_city);
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
  var findFlorpButtons = jQuery("span.florp-button");
  findFlorpButtons.each(function () {
    var $this = jQuery(this);
    if ($this.text() === "Nájdi" && !$this.hasClass("florp-button-find-location")) {
      $this.addClass("florp-button-find-location");
    }
    if ($this.text() === "Obnov náhľad" && !$this.hasClass("florp-button-reload-courses-map")) {
      $this.addClass("florp-button-reload-courses-map");
    }
  });
  var findLocationButton = jQuery(".florp-button-find-location");
  var reloadCoursesButton = jQuery(".florp-button-reload-courses-map")

  // BEGIN find location //
  // Function to show map with location either based on city or flashmob location //
  var fnFindLocation = function() {
    var location, locationSelector = ".florp-flashmob-address", bUsingFlashmobAddress = true;
    location = jQuery.trim(jQuery(locationSelector).first().val());
    jQuery(".florp-map-preview-wrapper .nf-field-description").removeAttr("style")
    if (location === "") {
      locationSelector = ".florp_school_city";
      bUsingFlashmobAddress = false
      location = jQuery.trim(jQuery(locationSelector).first().val());
      jQuery(".florp-map-preview-wrapper .nf-field-description").hide()
      jQuery(".ninja-forms-field.nf-element.florp_longitude").val("");
      jQuery(".ninja-forms-field.nf-element.florp_latitude").val("");
    }
    if (location === "" || location === "null") {
      // issue an error about empty location //
      console.warn("Location is empty!");
      jQuery(".ninja-forms-field.nf-element.florp_longitude").val("");
      jQuery(".ninja-forms-field.nf-element.florp_latitude").val("");
      jQuery(".florp-map-preview-wrapper").hide();
      return;
    }

    // generate the list by: var arr = []; for (var i in form.fields) {arr.push(form.fields[i].key)}; console.log(arr.join("',"+"\n"+"'")) //
    var inputIDs = [
//           'user_email',
        'first_name',
        'last_name',
//           'user_pass',
//           'passwordconfirm',
      'webpage',
      'school_name',
      'school_webpage',
      'school_city',
      'flashmob_number_of_dancers',
      'video_link_type',
      'youtube_link',
      'facebook_link',
      'vimeo_link',
      'embed_code',
      'flashmob_address',
      'longitude',
      'latitude'
    ];
    if ("undefined" !== typeof florp.user_id ) {
      var oMapOptions = {};
      oMapOptions[florp.user_id] = {}
      for (var i in inputIDs) {
        var id = inputIDs[i].trim();
        var inputSelector = ".ninja-forms-field.nf-element.florp_"+id;
        oMapOptions[florp.user_id][id] = jQuery(inputSelector).first().val()
      }

      var $previewContainer = jQuery(".florp-map-preview")
      var divID = "flashmob_organizer_preview"
      $previewContainer.attr("id", divID)
      florp_map_options_object[divID] = oMapOptions;
      jQuery( ".florp-map-preview-wrapper" ).show();
      $previewContainer.height(florp.general_map_options.custom.height).width('90%').css( { marginLeft : "auto", marginRight : "auto" } );

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
                console.log('No results found');
              }
            } else {
              console.warn('Geocoder failed due to: ' + status);
            }
          });
        });
      }

      var oAdditionalMarkerOptions = {}
      oAdditionalMarkerOptions[florp.user_id] = {
        "bDraggable" : bUsingFlashmobAddress,
        "draggableCallback" : fnDraggableCallback
      }
      florpGenerateMap( $previewContainer, divID, oMapOptions, oAdditionalMarkerOptions)
    }
  }
  // END find location //

  if (florp.hide_flashmob_fields == 1) {
    // Disable after-flashmob fields //
    jQuery(".florp-flashmob input, .florp-flashmob select, .florp-flashmob text, .florp-flashmob .florp-button-find-location").attr("disabled", "disabled");
    fnFlorpVideoTypeSelect();

    var $flashmobOrganizerCheckbox = jQuery(".florp_subscriber_type_container input[type=checkbox][value=flashmob_organizer]");
    var fnToggleLocationFinding = function($checkbox, animate = true) {
      $florpMapWrapperDiv = jQuery('.florp-map-wrapper-div')
      if ($checkbox.is(":checked")) {
        if (animate) {
          florpAnimateShow($florpMapWrapperDiv)
        } else {
          $florpMapWrapperDiv.show()
        }
        // Show map with location on form load //
        fnFindLocation()
        // Onchange event when school_city is changed //
        florpSchoolCitySelect.change(function() {
          if (jQuery.trim(jQuery(".florp-flashmob-address").first().val()) === "") {
            fnFindLocation()
          }
        })
      } else {
        if (animate) {
          florpAnimateHide($florpMapWrapperDiv)
        } else {
          $florpMapWrapperDiv.hide()
        }
      }
    }
    fnToggleLocationFinding($flashmobOrganizerCheckbox, false)
    $flashmobOrganizerCheckbox.change(function() {
      $this = jQuery(this)
      fnToggleLocationFinding($this, true)
    })
  } else {
    // Hide before-flashmob fields //
    jQuery(".florp-before-flashmob").hide();
    jQuery(".school_city_warning").hide();

    // Add video link select events //
    var florpVideoTypeSelect = jQuery(".florp-video-type-select");
    if (florp.video_link_type.length > 0 && (florp.video_link_type === 'youtube' || florp.video_link_type === 'facebook' || florp.video_link_type === 'vimeo' || florp.video_link_type === 'other')) {
      jQuery(".florp-video-type-select option").removeAttr("selected");
      jQuery(".florp-video-type-select option[value="+florp.video_link_type+"]").attr("selected", "selected");
//         florpVideoTypeSelect.val(florp.video_link_type);
    }
    fnFlorpVideoTypeSelect();
    florpVideoTypeSelect.change(function() {
      fnFlorpVideoTypeSelect();
    });

    // Show map with location on form load //
    fnFindLocation()
    // Onchange event when school_city is changed //
    florpSchoolCitySelect.change(function() {
      if (jQuery.trim(jQuery(".florp-flashmob-address").first().val()) === "") {
        fnFindLocation()
      }
    })
    // Onclick event when location finder button is clicked //
    findLocationButton.on('click', fnFindLocation);
  }

  // BEGIN reload courses //
  var fnBindReloadCoursesMapEvents = function( $checkbox ) {
    var bIsTeacher = jQuery(".florp_subscriber_type_container input[value=teacher]").is(":checked"),
    bCoursesInDifferentCity = jQuery(".florp_preferences_container input[value=courses_in_different_city]").is(":checked"),
    bCoursesInCity2 = jQuery("input.courses_in_city_2").is(":checked"),
    bCoursesInCity3 = jQuery("input.courses_in_city_3").is(":checked");

    jQuery(".florp_school_city,.florp_courses_city,.florp_courses_city_2,.florp_courses_city_3").off('change', fnReloadCoursesMap)
    reloadCoursesButton.off('click', fnReloadCoursesMap)
    if (!bIsTeacher) {
      return
    }
    fnReloadCoursesMap()
//     if ($checkbox.val() === 'teacher') {
//     }
    reloadCoursesButton.on('click', fnReloadCoursesMap)
    if (bCoursesInDifferentCity) {
      var strSelector = ".florp_courses_city"
      var $select = jQuery(strSelector)
      $select.on('change', fnReloadCoursesMap)
      if (bCoursesInCity2) {
        strSelector = ".florp_courses_city_2"
        $select = jQuery(strSelector)
        $select.on('change', fnReloadCoursesMap)
      }
      if (bCoursesInCity3) {
        strSelector = ".florp_courses_city_3"
        $select = jQuery(strSelector)
        $select.on('change', fnReloadCoursesMap)
      }
    } else {
      var strSelector = ".florp_school_city"
      var $select = jQuery(strSelector)
      $select.on('change', fnReloadCoursesMap)
    }
  }
  var strCoursesMapCheckboxSelectors = ".florp_subscriber_type_container input[value=teacher], .florp_preferences_container input[value=courses_in_different_city], input.courses_in_city_2, input.courses_in_city_3"
  jQuery(strCoursesMapCheckboxSelectors).change(function () {
    var $this = jQuery(this)
    fnBindReloadCoursesMapEvents($this)
  })

  // Function to show map with location either based on city or flashmob location //
  var fnReloadCoursesMap = function() {
    var location, bIsTeacher = jQuery(".florp_subscriber_type_container input[value=teacher]").is(":checked"),
    bCoursesInDifferentCity = jQuery(".florp_preferences_container input[value=courses_in_different_city]").is(":checked"),
    bCoursesInCity2 = jQuery("input.courses_in_city_2").is(":checked"),
    bCoursesInCity3 = jQuery("input.courses_in_city_3").is(":checked");

    if (!bIsTeacher) {
      return
    }

    var inputIDs = [
      'first_name',
      'last_name',
      'webpage',
      'school_name',
      'school_webpage'
    ];
    if (bCoursesInDifferentCity) {
      var strSelector = ".florp_courses_city"
      var strCity = jQuery(strSelector).val()
      if (strCity !== "null") {
        inputIDs.push("courses_city")
        inputIDs.push("courses_info")
      }
      if (bCoursesInCity2) {
        strSelector = ".florp_courses_city_2"
        strCity = jQuery(strSelector).val()
        if (strCity !== "null") {
          inputIDs.push("courses_city_2")
          inputIDs.push("courses_info_2")
        }
      }
      if (bCoursesInCity3) {
        strSelector = ".florp_courses_city_3"
        strCity = jQuery(strSelector).val()
        if (strCity !== "null") {
          inputIDs.push("courses_city_3")
          inputIDs.push("courses_info_3")
        }
      }
    } else {
      var strSelector = ".florp_school_city"
      var strCity = jQuery(strSelector).val()
      if (strCity !== "null") {
        inputIDs.push("school_city")
        inputIDs.push("courses_info")
      }
    }
    // console.log(inputIDs)

    if ("undefined" !== typeof florp.user_id ) {
      var oMapOptions = {};
      oMapOptions[florp.user_id] = {}
      for (var i in inputIDs) {
        var id = inputIDs[i].trim();
        var inputSelector = ".ninja-forms-field.nf-element.florp_"+id;
        oMapOptions[florp.user_id][id] = jQuery(inputSelector).first().val()
      }

      var $previewContainer = jQuery(".florp-map-courses-preview")
      var divID = "teacher_map_preview"
      $previewContainer.attr("id", divID)
      florp_map_options_object[divID] = oMapOptions;
      //jQuery( ".florp-map-courses-preview-wrapper" ).show();
      //$previewContainer.height(florp.general_map_options.custom.height).width('90%').css( { marginLeft : "auto", marginRight : "auto" } );

      florpGenerateMap( $previewContainer, divID, oMapOptions, {}, "teacher" )
    }
  }

  fnReloadCoursesMap()
  fnBindReloadCoursesMapEvents()
  // END reload courses //
}

function fnFlorpVideoTypeSelect() {
  var selected_option = jQuery(".florp-video-type-select option:selected").attr("value");
  jQuery(".florp-video").hide();
  jQuery(".florp-video-"+selected_option).show();
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

  if ("undefined" === typeof florp.user_id ) {
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
  var divID = objTab.attr("href");
  if ("undefined" === typeof divID) {
    console.warn("Couldn't find div ID for clicked tab:")
    console.log(objTarget, objTab);
    console.info("Loading EVERY non-hidden map and video");
    florpReloadVisibleMaps();
    florpLoadVisibleVideos();
    return;
  }
  var objContent = jQuery( divID )
  
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
