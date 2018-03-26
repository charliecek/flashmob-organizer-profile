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

jQuery(document).on('lwa_login', function(event, data, form) {
  florpSetCookie("florp-popup", "1");
  console.log("cookie was set");
});

function florpScrollToAnchor() {
  console.log("firing event before close");
  var el = jQuery("a[name=popup-florp]");
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
  if (!florp.reload_ok_submission) {
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
        florpGenerateYearlyMap(oElement, divID, florp_map_options_object[divID]);
      } else {
        console.warn("There is no div with id=" + divID + "!");
      }
    }
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
        
        if ("undefined" === typeof florp.maps.objects || "undefined" === typeof florp.maps.objects[divID]) {
          console.warn("florp.maps.objects or florp.maps.objects["+divID+"] is undefined!");
          continue;
        }
        if (isVisible && isVisibleOld !== isVisible ) {
          if (florp.maps.positionFixed[divID]) {
            // console.info("Position was already fixed for div "+divID);
            continue;
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
  
  var iUserID;
  florp.maps.markerShownOnLoad[divID] = florpRandomObjectKey(oMapOptions);
  for (iUserID in oMapOptions) {
    if (oMapOptions.hasOwnProperty(iUserID)) {
      var oUserOptions = oMapOptions[iUserID];
      if ("undefined" !== typeof oUserOptions["showOnLoad"] && oUserOptions["showOnLoad"] === true) {
        florp.maps.markerShownOnLoad[divID] = iUserID;
        break;
      }
    }
  }
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
          var res = JSON.parse(response);
//               console.log(res);
          var markerContentHtml = res.contentHtml;
          var map = florp.maps.objects[res.data.divID];
          
          if ("undefined" !== typeof res.data && "undefined" !== typeof florp.maps.markers && "undefined" !== typeof florp.maps.markers[res.data.divID]) {
            if ("undefined" !== typeof res.data.oUserOptions.latitude && jQuery.isNumeric(res.data.oUserOptions.latitude)
                && "undefined" !== typeof res.data.oUserOptions.longitude && jQuery.isNumeric(res.data.oUserOptions.longitude)) {
              if ("undefined" === typeof florp.maps.markers[res.data.divID][res.data.iUserID]) {
                // place the marker directly //
                var markerOptions = jQuery.extend({}, florp.general_map_options.markers, {
                  position: new google.maps.LatLng(res.data.oUserOptions.latitude, res.data.oUserOptions.longitude),
                  map: map,
                  title: res.data.location
                });
                var marker = new google.maps.Marker(markerOptions);
                var infowindow = new google.maps.InfoWindow({
                  content: markerContentHtml
                });
                marker.addListener('click', function() {
                  florpOpenInfoWindow(map, marker, infowindow, res.data.divID);
                });
                florp.maps.markers[res.data.divID][res.data.iUserID] = {
                  object: marker,
                  data: res.data,
                  html: markerContentHtml,
                  info_window_object: infowindow
                }
              } else {
                var marker = florp.maps.markers[res.data.divID][res.data.iUserID].object;
                var infowindow = florp.maps.markers[res.data.divID][res.data.iUserID].info_window_object;
                marker.setPosition(new google.maps.LatLng(res.data.oUserOptions.latitude, res.data.oUserOptions.longitude));
                marker.setTitle(res.data.location);
                infowindow.setContent(markerContentHtml);
                florp_map_options_object[res.data.divID][res.data.iUserID] = res.data.oUserOptions;
                florp.maps.markers[res.data.divID][res.data.iUserID].data = res.data;
                florp.maps.markers[res.data.divID][res.data.iUserID].html = markerContentHtml;
              }
              if (show) {
                florpOpenInfoWindow(map, marker, infowindow, res.data.divID);
              }
            } else {
  //                 console.log(res.data.location);
              
              geocoder = new google.maps.Geocoder();
              geocoder.geocode({
                'address': res.data.location
              }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
  //                     console.log(results);
  //                     console.log(status);
                  var addressLocation = results[0].geometry.location;
                  
                  if ("undefined" === typeof florp.maps.markers[res.data.divID][res.data.iUserID]) {
                    var markerOptions = jQuery.extend({}, florp.general_map_options.markers, {
                      position: addressLocation,
                      map: map,
                      title: res.data.location
                    });
                    var marker = new google.maps.Marker(markerOptions);
                    var infowindow = new google.maps.InfoWindow({
                      content: markerContentHtml
                    });
                    marker.addListener('click', function() {
                      florpOpenInfoWindow(map, marker, infowindow, res.data.divID);
                    });
                    florp.maps.markers[res.data.divID][res.data.iUserID] = {
                      object: marker,
                      data: res.data,
                      html: markerContentHtml,
                      info_window_object: infowindow
                    }
                  } else {
                    var marker = florp.maps.markers[res.data.divID][res.data.iUserID].object;
                    var infowindow = florp.maps.markers[res.data.divID][res.data.iUserID].info_window_object;
                    marker.setPosition(new google.maps.LatLng(res.data.oUserOptions.latitude, res.data.oUserOptions.longitude));
                    marker.setTitle(res.data.location);
                    infowindow.setContent(markerContentHtml);
                    florp_map_options_object[res.data.divID][res.data.iUserID] = res.data.oUserOptions;
                    florp.maps.markers[res.data.divID][res.data.iUserID].data = res.data;
                    florp.maps.markers[res.data.divID][res.data.iUserID].html = markerContentHtml;
                  }
                  if (show) {
                    florpOpenInfoWindow(map, marker, infowindow, res.data.divID);
                  }
                } else {
                  console.warn(status);
                }
              });
            }
          } else {
            // DEBUG INFO: //
            if ("undefined" === typeof res.data) {
              console.warn(res);
            } else if ("undefined" === typeof res.data.divID) {
              console.warn(res.data);
            }
            if ("undefined" === typeof florp.maps.markers) {
              console.warn("flowp.maps.markers is undefined");
            } else if ("undefined" !== typeof res.data.divID && "undefined" !== typeof florp.maps.markers[res.data.divID]) {
              console.warn(florp.maps.markers[res.data.divID]);
            } else if ("undefined" !== typeof res.data.divID) {
              console.warn("no markers for div ID: " + res.data.divID);
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
  currentYearMaps.each(function (){
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
          var res = JSON.parse(response);
          console.log(res);
          if (res.new_map_options !== false) {
            var map = florp.maps.objects[res.data.divID];
            florpSetUserMarker(florp.user_id, res.new_map_options, map, res.data.divID, true);
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

jQuery(document).on( 'pumBeforeClose', '#pum-5347', florpScrollToAnchor );
// jQuery(document).on( 'pumAfterClose', '#pum-5347', florpScrollToAnchor );
jQuery(document).on( 'pumAfterClose', '#pum-5347', florp_reload_on_successful_submission );

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

function florpFixFormClasses() {
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
  
  var select = jQuery(".florp_school_city");
  if (typeof florp.school_city !== "undefined" && florp.school_city.length > 0) {
    jQuery(".florp_school_city option").removeAttr("selected");
//     jQuery(".florp_school_city option[value="+florp.school_city+"]").attr("selected", "selected");
    select.val(florp.school_city);
  }
  
  // Add location find button class //
  var findLocationbutton = jQuery(".florp-button");
  if (!findLocationbutton.hasClass("button")) {
    findLocationbutton.addClass("button");
  }
  if (florp.hide_flashmob_fields) {
    // jQuery(".florp-flashmob").hide();
    jQuery(".florp-flashmob input, .florp-flashmob select, .florp-flashmob text, .florp-flashmob .florp-button").attr("disabled", "disabled");
    florpVideoTypeSelect();
  } else {
    jQuery(".florp-before-flashmob").hide();
    jQuery(".school_city_warning").hide();
    
    // Add video link select events //
    var select = jQuery(".florp-video-type-select");
    if (florp.video_link_type.length > 0 && (florp.video_link_type === 'youtube' || florp.video_link_type === 'facebook' || florp.video_link_type === 'vimeo' || florp.video_link_type === 'other')) {
      jQuery(".florp-video-type-select option").removeAttr("selected");
      jQuery(".florp-video-type-select option[value="+florp.video_link_type+"]").attr("selected", "selected");
//         select.val(florp.video_link_type);
    }
    florpVideoTypeSelect();
    select.change(function() {
      florpVideoTypeSelect();
    });
    
    // Add location find button click event //
    findLocationbutton.on('click', function() {
      var location = jQuery(".florp-flashmob-address").first().val();
      if (location === "") {
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
            generateMapHtml(mapHtml, ".florp-map-preview-wrapper", ".florp-map-preview", ".florp-flashmob-address");
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
}
  
function florpVideoTypeSelect() {
  var selected_option = jQuery(".florp-video-type-select option:selected").attr("value");
  jQuery(".florp-video").hide();
  jQuery(".florp-video-"+selected_option).show();
}

function generateMapHtml(mapHtml, wrapperSelector, mapContainerSelector, locationInputSelector) {
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
      jQuery(".florp_longitude").first().val(addressLocation.lng);
      jQuery(".florp_latitude").first().val(addressLocation.lat);
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
            draggable: true
        });
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
      } else {
        florp.marker.setPosition(addressLocation);
        florp.marker.setTitle(formattedAddress);
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

jQuery( document ).ready(function() {
  if ("undefined" === typeof florp.user_id ) {
    jQuery("#pum_popup_title_5347").html("Registrácia organizátora flashmobu");
    console.log(jQuery("#pum_popup_title_5347"))
  }

  florpGenerateYearlyMaps();

  florpFlashAnchors();
});

jQuery(window).on('hashchange', function(e){
  florpFlashAnchors();
});

// Bind click event on all tab title elements //
jQuery(document).on('click', ".w-tabs-item", function (event) {
  var strTabClass = "w-tabs-item-h";
  var strTabItemClass = "w-tabs-item";
  var objTarget = jQuery(event.target);
  if (objTarget.hasClass(strTabItemClass)) {
    var objTab = objTarget.find("."+strTabClass);
    var objTabItem = objTarget;
  } else if (objTarget.hasClass(strTabClass)) {
    var objTab = objTarget;
    var objTabItem = objTarget.parents("."+strTabItemClass);
  } else {
    var objTab = objTarget.find("."+strTabClass);
    var objTabItem = objTarget.parents("."+strTabItemClass);
    if (objTab.length === 0) {
      objTab = objTarget.parents("."+strTabClass);
    }
  }
  if (objTab.length === 0) {
    console.warn("Couldn't find '."+strTabClass+"' above/under clicked element:")
    console.log(objTarget);
    return;
  }
  if (objTabItem.length === 0) {
    console.warn("Couldn't find '."+strTabItemClass+"' above/under clicked element:")
    console.log(objTarget);
    return;
  }
  var divID = objTab.attr("href");
  if ("undefined" === typeof divID) {
    console.warn("Couldn't find div ID for clicked tab:")
    console.log(objTarget, objTab);
    return;
  }
  var objContent = jQuery( divID )
  
  if (objContent.length === 0) {
    console.warn("Couldn't find content associated with clicked tab:")
    console.log(objTarget, objTab, divID);
    return;
  }
  if (objContent.find(".florp-map").length === 0) {
    // console.info("There is no florp map under content for tab "+divID);
    return;
  }
  
  setTimeout(function () {
    if (objTarget.is(':animated') || objTab.is(':animated') || objContent.is(':animated')) {
      var interval = setInterval(function () {
        if (objTarget.is(':animated') || objTab.is(':animated') || objContent.is(':animated')) {
          // continue
        } else {
          clearInterval(interval)
          florpReloadVisibleMaps();
        }
      }, 100);
    } else {
      florpReloadVisibleMaps();
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