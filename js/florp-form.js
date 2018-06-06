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
      florpGenerateYearlyMap(oDivDOMElement, divID, oMapOptions);
    }, 0);
  } else {
    florpGenerateYearlyMap(oDivDOMElement, divID, oMapOptions);
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

function florpGenerateYearlyMap( oDivDOMElement, divID, oMapOptions ) {
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
  // For each user show their markers //
  for (iUserID in oMapOptions) {
    if (oMapOptions.hasOwnProperty(iUserID)) {
      var oUserOptions = oMapOptions[iUserID];
      florpSetUserMarker(iUserID, oUserOptions, map, divID, florp.maps.markerShownOnLoad[divID] === iUserID);
    }
  }
}

function florpSetUserMarker(iUserID, oUserOptions, map, divID, show) {
  var k, oInfoWindowData = {};
  for (k in oUserOptions) {
    if (oUserOptions.hasOwnProperty(k)) {
      oInfoWindowData[k] = {
        value: oUserOptions[k]
      };
    }
  }
  var location = oUserOptions.flashmob_address || oUserOptions.school_city || "";
  if (location.length === 0) {
    console.info("No location found for user "+iUserID);
    if ("undefined" !== typeof florp.maps.markers[divID][iUserID]) {
      // Remove any markers, info windows //
      if ("undefined" !== typeof florp.maps.markers[divID][iUserID].object) {
        // remove marker //
        florp.maps.markers[divID][iUserID].object.setMap(null);
      }
      if ("undefined" !== typeof florp.maps.markers[divID][iUserID].info_window_object) {
        // remove infowindow //
        florp.maps.markers[divID][iUserID].info_window_object.setMap(null);
        delete florp.maps.markers[divID][iUserID].info_window_object;
      }
      if ("undefined" !== typeof florp.maps.markers[divID][iUserID]) {
        delete florp.maps.markers[divID][iUserID];
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
          var map = florp.maps.objects[getMarkerInfoHtmlRes.data.divID];

          if ("undefined" !== typeof getMarkerInfoHtmlRes.data && "undefined" !== typeof florp.maps.markers && "undefined" !== typeof florp.maps.markers[getMarkerInfoHtmlRes.data.divID]) {
            if ("undefined" !== typeof getMarkerInfoHtmlRes.data.oUserOptions.latitude && jQuery.isNumeric(getMarkerInfoHtmlRes.data.oUserOptions.latitude)
                && "undefined" !== typeof getMarkerInfoHtmlRes.data.oUserOptions.longitude && jQuery.isNumeric(getMarkerInfoHtmlRes.data.oUserOptions.longitude)) {
              if ("undefined" === typeof florp.maps.markers[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID]) {
                // Creating new marker - by coordinates //
                // console.log("Creating new marker - by coordinates", getMarkerInfoHtmlRes.data.divID, getMarkerInfoHtmlRes.data.iUserID)
                var markerOptions = jQuery.extend({}, florp.general_map_options.markers, {
                  position: new google.maps.LatLng(getMarkerInfoHtmlRes.data.oUserOptions.latitude, getMarkerInfoHtmlRes.data.oUserOptions.longitude),
                  map: map,
                  title: getMarkerInfoHtmlRes.data.location
                });
                var marker = new google.maps.Marker(markerOptions);
                var infowindow = new google.maps.InfoWindow({
                  content: markerContentHtml
                });
                marker.addListener('click', function() {
                  florpOpenInfoWindow(map, marker, infowindow, getMarkerInfoHtmlRes.data.divID);
                });
                florp.maps.markers[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID] = {
                  object: marker,
                  data: getMarkerInfoHtmlRes.data,
                  html: markerContentHtml,
                  info_window_object: infowindow
                }
              } else {
                // Updating marker - by coordinates //
                // console.log("Updating marker - by coordinates", getMarkerInfoHtmlRes.data.divID, getMarkerInfoHtmlRes.data.iUserID)
                var marker = florp.maps.markers[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID].object;
                var infowindow = florp.maps.markers[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID].info_window_object;
                marker.setPosition(new google.maps.LatLng(getMarkerInfoHtmlRes.data.oUserOptions.latitude, getMarkerInfoHtmlRes.data.oUserOptions.longitude));
                marker.setTitle(getMarkerInfoHtmlRes.data.location);
                infowindow.setContent(markerContentHtml);
                florp_map_options_object[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID] = getMarkerInfoHtmlRes.data.oUserOptions;
                florp.maps.markers[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID].data = getMarkerInfoHtmlRes.data;
                florp.maps.markers[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID].html = markerContentHtml;
              }
              if (show) {
                florpOpenInfoWindow(map, marker, infowindow, getMarkerInfoHtmlRes.data.divID);
              }
            } else {
              // console.log(getMarkerInfoHtmlRes.data.location);
              geocoder = new google.maps.Geocoder();
              geocoder.geocode({
                'address': getMarkerInfoHtmlRes.data.location
              }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
  //                     console.log(results);
  //                     console.log(status);
                  var addressLocation = results[0].geometry.location;
                  
                  if ("undefined" === typeof florp.maps.markers[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID]) {
                    // Creating new marker - no coordinates //
                    // console.log("Creating new marker - no coordinates", getMarkerInfoHtmlRes.data.divID, getMarkerInfoHtmlRes.data.iUserID)
                    var markerOptions = jQuery.extend({}, florp.general_map_options.markers, {
                      position: addressLocation,
                      map: map,
                      title: getMarkerInfoHtmlRes.data.location
                    });
                    var marker = new google.maps.Marker(markerOptions);
                    var infowindow = new google.maps.InfoWindow({
                      content: markerContentHtml
                    });
                    marker.addListener('click', function() {
                      florpOpenInfoWindow(map, marker, infowindow, getMarkerInfoHtmlRes.data.divID);
                    });
                    florp.maps.markers[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID] = {
                      object: marker,
                      data: getMarkerInfoHtmlRes.data,
                      html: markerContentHtml,
                      info_window_object: infowindow
                    }
                  } else {
                    // Updating marker - no coordinates //
                    // console.log("Updating marker - no coordinates", getMarkerInfoHtmlRes.data.divID, getMarkerInfoHtmlRes.data.iUserID)
                    var marker = florp.maps.markers[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID].object;
                    var infowindow = florp.maps.markers[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID].info_window_object;
                    marker.setPosition(addressLocation);
                    marker.setTitle(getMarkerInfoHtmlRes.data.location);
                    infowindow.setContent(markerContentHtml);
                    florp_map_options_object[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID] = getMarkerInfoHtmlRes.data.oUserOptions;
                    florp.maps.markers[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID].data = getMarkerInfoHtmlRes.data;
                    florp.maps.markers[getMarkerInfoHtmlRes.data.divID][getMarkerInfoHtmlRes.data.iUserID].html = markerContentHtml;
                  }
                  if (show) {
                    florpOpenInfoWindow(map, marker, infowindow, getMarkerInfoHtmlRes.data.divID);
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
          console.log(getMarkerInfoHtmlRes);
          if (getMarkerInfoHtmlRes.new_map_options !== false) {
            var map = florp.maps.objects[getMarkerInfoHtmlRes.data.divID];
            florpSetUserMarker(florp.user_id, getMarkerInfoHtmlRes.new_map_options, map, getMarkerInfoHtmlRes.data.divID, true);
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

var aFlorpSubscriberTypes = [];
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

  var fnToggleFlashmobOrganizerWarnings = function( strSubscriberType, bChecked, animate = true ) {
    if (strSubscriberType === 'flashmob_organizer') {
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

  var $flashmobOrganizerCheckbox = jQuery(".florp_subscriber_type_container input[type=checkbox][value=flashmob_organizer]");
  fnToggleFlashmobOrganizerWarnings( 'flashmob_organizer', $flashmobOrganizerCheckbox.is(':checked'), false )
//   jQuery(".lwa-register").bind('afterShow', function() {
//     // console.log($flashmobOrganizerCheckbox, $flashmobOrganizerCheckbox.is(':checked'))
//     fnToggleFlashmobOrganizerWarnings( 'flashmob_organizer', $flashmobOrganizerCheckbox.is(':checked'), false )
//   })

  // When logged in, hide/unhide parts of the profile form based on which subscriber types the user has //
  if ("undefined" === typeof florp.user_id ) {
    // Not logged in => registration form - only toggle warnings //
    var $aSubscriberTypes = jQuery(".florp_subscriber_type_container input[type=checkbox]");
    // console.log($aSubscriberTypes);
    $aSubscriberTypes.change(function () {
      var $this = jQuery(this);
      var strSubscriberType = $this.val()
      var bChecked = $this.is(':checked')
      // console.log(strSubscriberType, bChecked)

      fnToggleFlashmobOrganizerWarnings(strSubscriberType, bChecked)
    })
  } else {
    // Logged in => profile form - do the magic //

    // Get the checkboxes //
    var $aSubscriberTypes = jQuery(".florp_subscriber_type_container input[type=checkbox]");
    // Get create and populate the subscriber types into an array //
    $aSubscriberTypes.each(function () {
      aFlorpSubscriberTypes.push(jQuery(this).val())
    });
    // Onchange event for the checkboxes //
    $aSubscriberTypes.change(function () {
      var $this = jQuery(this);
      var strSubscriberType = $this.val()
      var bChecked = $this.is(':checked')
      var $aFieldsToToggle = jQuery(".florp-subscriber-type-field_"+strSubscriberType+":not(.florp-subscriber-type-field_all,.florp-registration-field) .nf-field-container")
      // console.log($aFieldsToToggle)

      fnToggleFlashmobOrganizerWarnings(strSubscriberType, bChecked)

      var fnGetFieldsAnyToToggle = function() {
        // Get the number of unhidden fields - if there are any, fields with class 'florp-subscriber-type-field_any' are unhidden as well //
        var iCheckedCount = jQuery(".florp_subscriber_type_container input[type=checkbox]").filter(function (index) {
          return jQuery(this).is(':checked');
        }).length;
        var iUnhiddenCount = 0
        aFlorpSubscriberTypes.forEach(function (strType) {
          var $aUnhiddenThisType = jQuery(".florp-subscriber-type-field_"+strType+":not(.florp-subscriber-type-field_all,.florp-registration-field) .nf-field-container:not(.hidden)")
          iUnhiddenCount += $aUnhiddenThisType.length
          if ($aUnhiddenThisType.length > 0) {
            // console.log($aUnhiddenThisType[0])
          }
        })
        var $aFieldsAnyToToggle = jQuery('.florp-subscriber-type-field_any .nf-field-container')
        return {
          fields: $aFieldsAnyToToggle,
          show: (iCheckedCount * iUnhiddenCount) > 0
        }
      }
      var fnCheckFieldsAnyToToggle = function() {
        var checkFieldsAnyToToggleRes = fnGetFieldsAnyToToggle()
        if ( checkFieldsAnyToToggleRes.show ) {
          florpAnimateShow(checkFieldsAnyToToggleRes.fields)
//           checkFieldsAnyToToggleRes.fields.removeClass('hidden')
        } else {
          florpAnimateHide(checkFieldsAnyToToggleRes.fields)
//           checkFieldsAnyToToggleRes.fields.addClass('hidden')
        }
      }

      if ($aFieldsToToggle.length === 0) {
        // No fields to toggle, so nothing will change for fields shown when any subscriber type is matched //
        // fnCheckFieldsAnyToToggle()
      } else if (bChecked) {
        florpAnimateShow($aFieldsToToggle, function() { fnCheckFieldsAnyToToggle(); })
      } else {
        florpAnimateHide($aFieldsToToggle, function() { fnCheckFieldsAnyToToggle(); })
      }

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
    var thisButtonObj = jQuery(this);
    if (!thisButtonObj.hasClass("button")) {
      thisButtonObj.addClass("button");
    }
    if (!thisButtonObj.hasClass("florp-button")) {
      thisButtonObj.addClass("florp-button");
    }
  });
  var findLocationButton = jQuery("span.florp-button");
  findLocationButton.each(function () {
    var thisButtonObj = jQuery(this);
    if (thisButtonObj.text() === "Nájdi" && !thisButtonObj.hasClass("florp-button-find-location")) {
      thisButtonObj.addClass("florp-button-find-location");
    }
  });
  findLocationButton = jQuery(".florp-button-find-location");

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
    var infoWindowData = {};
    for (var i in inputIDs) {
      var id = inputIDs[i].trim();
      var inputSelector = ".ninja-forms-field.nf-element.florp_"+id;
      infoWindowData[id] = {
        selector: inputSelector,
        value: jQuery(inputSelector).first().val()
      };
    }

    var data = {
      action: florp.map_ajax_action,
      security : florp.security,
      location: location,
      infoWindowData: infoWindowData,
    };
    jQuery.ajax({
      type: "POST",
      url: florp.ajaxurl,
      data: data,
      success: function(response) {
        // console.log(response);
        try {
          var mapHtml = JSON.parse(response);
          // console.log(mapHtml);
          generateMapHtml(mapHtml, ".florp-map-preview-wrapper", ".florp-map-preview", ".florp-flashmob-address", bUsingFlashmobAddress);
        } catch(e) {
          console.log(e);
        }
      },
      error: function(errorThrown){
        console.warn(errorThrown);
      }
    });
  }

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
}

function fnFlorpVideoTypeSelect() {
  var selected_option = jQuery(".florp-video-type-select option:selected").attr("value");
  jQuery(".florp-video").hide();
  jQuery(".florp-video-"+selected_option).show();
}

function generateMapHtml(mapHtml, wrapperSelector, mapContainerSelector, locationInputSelector, bUsingFlashmobAddress = true) {
  var $container = jQuery(mapHtml);
  var $jsonContainer = $container.find('.w-map-json'),
      jsonOptions = $jsonContainer[0].onclick() || {},
      $jsonStyleContainer = $container.find('.w-map-style-json'),
      jsonStyleOptions,
      markerOptions,
      shouldRunGeoCode = !1;
      
  if ($jsonStyleContainer.length) {
      jsonStyleOptions = $jsonStyleContainer[0].onclick() || {};
      //$jsonStyleContainer.remove()
  }
  var defaults = {};
  mapOptions = jQuery.extend({}, defaults, jsonOptions);
  // console.log(mapOptions);
  
  jQuery( wrapperSelector ).show();
  var container = jQuery(mapContainerSelector);
  container.height(mapOptions.height).width('90%').css( { marginLeft : "auto", marginRight : "auto" } );
  
  geocoder = new google.maps.Geocoder();
  geocoder.geocode({
    'address': mapOptions.address
  }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      var addressLocation = results[0].geometry.location;
      florp.markerLocation = addressLocation;
      if (bUsingFlashmobAddress) {
        jQuery(".florp_longitude").first().val(addressLocation.lng);
        jQuery(".florp_latitude").first().val(addressLocation.lat);
      }
      var formattedAddress = results[0].formatted_address;
      var gMapOptions = {
          zoom: mapOptions.zoom,
          center: addressLocation,
          mapTypeId: google.maps.MapTypeId[mapOptions.maptype],
          scrollwheel: !mapOptions.disableZoom
      }
      if (typeof florp.map === "undefined" || florp.map === null) {
        florp.map = new google.maps.Map(container[0], gMapOptions);
      } else {
        florp.map.setZoom(mapOptions.zoom);
        florp.map.setCenter(addressLocation);
      }
      
      if (typeof florp.info_window === "undefined" || florp.info_window === null) {
        florp.info_window = new google.maps.InfoWindow({
          content: mapOptions.markers[0].html
        });
      } else {
        florp.info_window.setContent(mapOptions.markers[0].html);
      }
      
      if (typeof florp.marker === "undefined" || florp.marker === null) {
        florp.marker = new google.maps.Marker({
            map: florp.map,
            position: addressLocation,
            icon: mapOptions.icon.url,
            title: formattedAddress,
            draggable: bUsingFlashmobAddress
        });
        if (bUsingFlashmobAddress) {
          // Add drag event to marker - update the marker title, text and the location input; also save the position //
          florp.marker.addListener('dragend', function(event) {
            //console.log(event);
            var newLocation = {
              lat: event.latLng.lat(),
              lng: event.latLng.lng()
            };
            geocoder.geocode({'location': newLocation}, function(results, status) {
              if (status === 'OK') {
                console.log(results);
                if (results[1]) { // city
                  florp.markerLocation = newLocation;
                  jQuery(".florp_longitude").first().val(newLocation.lng);
                  jQuery(".florp_latitude").first().val(newLocation.lat);
                  var newAddress = results[1].formatted_address;
                  florp.marker.setTitle(newAddress);
                  jQuery(locationInputSelector).first().val(newAddress);
                  if (typeof florp.info_window === "object" && florp.info_window !== null) {
                    var content = jQuery(florp.info_window.getContent());
                    var locationElement = content.find(".flashmob-location");
                    if (locationElement.length > 0) {
                      locationElement.html(newAddress);
                      florp.info_window.setContent(content[0].outerHTML);
                    }
                  }
                } else {
                  console.log('No results found');
                }
              } else {
                console.log('Geocoder failed due to: ' + status);
              }
            });
          });
        }
      } else {
        florp.marker.setPosition(addressLocation);
        florp.marker.setTitle(formattedAddress);
        florp.marker.setDraggable(bUsingFlashmobAddress)
      }
      if (typeof florp.info_window === "object" && florp.info_window !== null) {
        florp.marker.addListener('click', function() {
          florp.info_window.open(florp.map, florp.marker);
        });
        if (mapOptions.markers[0].infowindow === "1") {
          florp.info_window.open(florp.map, florp.marker);
        }
      }
    }
  });
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
