<?php
/**
 * Plugin Name: Flashmob Organizer Profile (with login/registration page)
 * Description: Creates shortcodes for flashmob organizer login / registration / profile editing form and for maps showing cities with videos of flashmobs for each year
 * Author: charliecek
 * Author URI: http://charliecek.eu/
 * Version: 2.3.2
 */

class FLORP{

  private $strVersion = '2.3.2';
  private $iFlashmobBlogID = 6;
  private $strOptionsPageSlug = 'florp-options';
  private $strOptionKey = 'florp-options';
  private $aOptionDefaults = array();
  private $aOptionFormKeys = array();
  private $aBooleanOptions = array();
  private $strProfileFormWrapperID = 'florp-profile-form-wrapper-div';
  private $strClickTriggerClass = 'florp-click-register-trigger';
  private $strClickTriggerGetParam = 'popup-florp';
  private $strClickTriggerAnchor = 'popup-florp';
  private $strClickTriggerCookieKey = 'florp-popup';
  private $aOptions;
  private $aRegisteredUserCount;
  private $aFlashmobSubscribers;
  
  public function __construct() {
    $this->aOptions = get_site_option( $this->strOptionKey, array() );
    $this->aOptionDefaults = array(
      'bReloadAfterSuccessfulSubmission'  => false,
      'aYearlyMapOptions'                 => array(),
      'iFlashmobYear'                     => isset($this->aOptions['iCurrentFlashmobYear']) ? $this->aOptions['iCurrentFlashmobYear'] : intval(date( 'Y' )),
      'iFlashmobMonth'                    => 1,
      'iFlashmobDay'                      => 1,
      'iFlashmobHour'                     => 0,
      'iFlashmobMinute'                   => 0,
    );
    $this->aOptionFormKeys = array(
      'florp_reload_after_ok_submission'  => 'bReloadAfterSuccessfulSubmission',
      'florp_flashmob_year'               => 'iFlashmobYear',
      'florp_flashmob_month'              => 'iFlashmobMonth',
      'florp_flashmob_day'                => 'iFlashmobDay',
      'florp_flashmob_hour'               => 'iFlashmobHour',
      'florp_flashmob_minute'             => 'iFlashmobMinute',
    );
    $aDeprecatedKeys = array( 'iCurrentFlashmobYear', 'bHideFlashmobFields' );
    $this->aBooleanOptions = array( 'bReloadAfterSuccessfulSubmission' );
    
    // Get options and set defaults //
    if (empty($this->aOptions)) {
      $this->aOptions = $this->aOptionDefaults;
      update_site_option( $this->strOptionKey, $this->aOptions, true );
    } else {
      $bUpdate = false;
      foreach ($this->aOptionDefaults as $key => $val) {
        if (!isset($this->aOptions[$key])) {
          $this->aOptions[$key] = $val;
          $bUpdate = true;
        }
      }
      foreach ($aDeprecatedKeys as $strKey) {
        if (isset($this->aOptions[$strKey])) {
          unset($this->aOptions[$strKey]);
          $bUpdate = true;
        }
      }
      if ($bUpdate) {
        update_site_option( $this->strOptionKey, $this->aOptions, true );
      }
    }
    
    $iTimeZoneOffset = get_option( 'gmt_offset', 0 );
    $iFlashmobTime = intval(mktime( $this->aOptions['iFlashmobHour'] - $iTimeZoneOffset, $this->aOptions['iFlashmobMinute'], 0, $this->aOptions['iFlashmobMonth'], $this->aOptions['iFlashmobDay'], $this->aOptions['iFlashmobYear'] ));
    $iNow = time();
    if ($iFlashmobTime < $iNow) {
      $this->aOptions['bHideFlashmobFields'] = false;
    } else {
      $this->aOptions['bHideFlashmobFields'] = true;
    }
    
    $this->aRegisteredUserCount = array(
      'on-map-only' => -1,
      'all'         => -1
    );
    $this->aFlashmobSubscribers = array();
    krsort($this->aOptions["aYearlyMapOptions"]);

    if (empty($this->aOptions['aYearlyMapOptions'])) {
      $this->aOptions['aYearlyMapOptions'] = array(
        2016 =>
        array(
          22 => 
          array (
            'first_name' => 'Jaroslav',
            'last_name' => 'Hluch',
            'webpage' => 'https://www.facebook.com/jaroslav.hluch',
            'school_city' => 'Bratislava',
            'video_link_type' => 'vimeo',
            'vimeo_link' => 'http://vimeo.com/191247547',
            // 'embed_code' => '<iframe src="https://player.vimeo.com/video/191247547" width="340" height="200" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>',
            'flashmob_address' => 'Nákupné centrum Centrál, Bratislava',
            'longitude' => '17.129393',
            'latitude' => '48.157427',
          ),
          1000 => 
          array (
            'first_name' => 'Jana',
            'last_name' => 'Kvantová',
            'webpage' => 'https://www.facebook.com/jana.kvantova',
            'school_city' => 'Piešťany',
            'video_link_type' => 'facebook',
            'facebook_link' => 'https://www.facebook.com/tvkarpaty/videos/1275355985822296/',
            'flashmob_address' => 'Winterova ulica, Piešťany',
            'longitude' => '17.835444',
            'latitude' => '48.590201',
            'note' => 'pôvodné video <a href="https://www.facebook.com/tvkarpaty/videos/1275355985822296/" target="_blank">tu</a>.',
          ),
          1001 => 
          array (
            'first_name' => 'Rišo (Iko)',
            'last_name' => 'Križan',
            'webpage' => 'https://www.facebook.com/riso.krizaniko',
            'school_city' => 'Bojnice',
            'video_link_type' => 'youtube',
            'youtube_link' => 'https://www.youtube.com/watch?v=CCCMo8Jdf9c',
            'flashmob_address' => 'Bojnice',
            'longitude' => '18.582687',
            'latitude' => '48.778839',
            'note' => 'pôvodné video <a href="http://www.rtvprievidza.sk/home/region/3953-tanec-spaja-kultury" target="_blank">tu</a>.',
          ),
        ),
        2015 =>
        array(
          32 => 
          array (
            'first_name' => 'Barbora',
            'last_name' => 'Boboková',
            'school_city' => 'Prievidza',
            'video_link_type' => 'youtube',
            'youtube_link' => 'https://www.youtube.com/watch?v=8LHBuWI5Hc4',
            'flashmob_address' => 'Prievidza',
            'longitude' => '18.624538',
            'latitude' => '48.774521',
          ),
          1002 => 
          array (
            'first_name' => 'Zuzana',
            'last_name' => 'Žilinská',
            'webpage' => 'https://www.facebook.com/zzilinska',
            'school_city' => 'Levice',
            'video_link_type' => 'youtube',
            'youtube_link' => 'https://www.youtube.com/watch?v=_uVA-dEF8BM',
            'flashmob_address' => 'Levice',
            'longitude' => '18.598438',
            'latitude' => '48.217424',
          ),
          1003 => 
          array (
            'first_name' => 'Michal',
            'last_name' => 'Mravec',
            'webpage' => 'https://www.facebook.com/michal.mravec.7',
            'school_city' => 'Žilina',
            'video_link_type' => 'youtube',
            'youtube_link' => 'https://www.youtube.com/watch?v=5gvAasxL8mQ',
            'flashmob_address' => 'OC Mirage, Žilina',
            'longitude' => '18.7408',
            'latitude' => '49.21945',
          ),
          1004 => 
          array (
            'first_name' => 'Vladimír',
            'last_name' => 'Svorad',
            'webpage' => 'https://www.facebook.com/vladimir.svorad.9',
            'school_city' => 'Topolčany',
            'video_link_type' => 'youtube',
            'flashmob_address' => 'Topolčany',
            'longitude' => '18.170007',
            'latitude' => '48.558945',
            'note' => 'video z tohoto mesta nie je k dispozícii',
          ),
          22 => 
          array (
            'first_name' => 'Jaroslav',
            'last_name' => 'Hluch',
            'webpage' => 'https://www.facebook.com/jaroslav.hluch',
            'school_city' => 'Bratislava',
            'video_link_type' => 'youtube',
            'youtube_link' => 'https://www.youtube.com/watch?v=Xqo7MhkatQU',
            'flashmob_address' => 'Avion Shopping Park, Bratislava',
            'longitude' => '17.18008',
            'latitude' => '48.166776',
          ),
        ),
        2014 =>
        array(
          22 => 
          array (
            'first_name' => 'Jaroslav',
            'last_name' => 'Hluch',
            'webpage' => 'https://www.facebook.com/jaroslav.hluch',
            'school_city' => 'Bratislava',
            'video_link_type' => 'youtube',
            'youtube_link' => 'https://www.youtube.com/watch?v=lIcB_YlAMqU',
            'flashmob_address' => 'Eurovea, Bratislava',
            'longitude' => '17.121326',
            'latitude' => '48.140501',
          ),
          1005 => 
          array (
            'first_name' => 'Ivana',
            'last_name' => 'Kubišová',
            'webpage' => 'https://www.facebook.com/ivana.kubisova',
            'school_city' => 'Banská Bystrica',
            'video_link_type' => 'youtube',
            'youtube_link' => 'https://www.youtube.com/watch?v=omPI_p1mBJE',
            'flashmob_address' => 'Banská Bystrica',
            'longitude' => '19.146192',
            'latitude' => '48.736277',
            'note' => 'zapojili sa tanečníci z Banskej Bystrice, Zvolena a Žiliny.',
          ),
          1000 => 
          array (
            'first_name' => 'Jana',
            'last_name' => 'Kvantová',
            'webpage' => 'https://www.facebook.com/jana.kvantova',
            'school_city' => 'Hlohovec',
            'video_link_type' => 'youtube',
            'youtube_link' => 'https://www.youtube.com/watch?v=Dmgn-MEODgI',
            'flashmob_address' => 'Hlohovec',
            'longitude' => '17.803329',
            'latitude' => '48.425158',
          ),
          1006 => 
          array (
            'first_name' => 'José',
            'last_name' => 'Garcia',
            'webpage' => 'https://www.facebook.com/josegarciask',
            'school_city' => 'Košice',
            'video_link_type' => 'youtube',
            'youtube_link' => 'https://www.youtube.com/watch?v=Ub0vgUypxGs',
            'flashmob_address' => 'Košice',
            'longitude' => '21.261075',
            'latitude' => '48.716386',
          ),
          1007 => 
          array (
            'first_name' => 'Eva',
            'last_name' => 'Macháčková',
            'webpage' => 'https://www.facebook.com/evinamachackova',
            'school_city' => 'Piešťany',
            'video_link_type' => 'youtube',
            'youtube_link' => 'https://www.youtube.com/watch?v=rJSCefB6qJw',
            'flashmob_address' => 'Piešťany',
            'longitude' => '17.827155',
            'latitude' => '48.591797',
          ),
          32 => 
          array (
            'first_name' => 'Barbora',
            'last_name' => 'Boboková',
            'school_city' => 'Prievidza',
            'video_link_type' => 'youtube',
            'youtube_link' => 'https://www.youtube.com/watch?v=Bz7-QD8TO9Y',
            'flashmob_address' => 'Prievidza',
            'longitude' => '18.624538',
            'latitude' => '48.774521',
          ),
          1004 => 
          array (
            'first_name' => 'Vladimír',
            'last_name' => 'Svorad',
            'webpage' => 'https://www.facebook.com/vladimir.svorad.9',
            'school_city' => 'Topolčany',
            'video_link_type' => 'youtube',
            'youtube_link' => 'https://www.youtube.com/watch?v=wAX6EjZOJH4',
            'flashmob_address' => 'Topolčany',
            'longitude' => '18.170007',
            'latitude' => '48.558945',
          ),
        ),
        2013 =>
        array(
          22 => 
          array (
            'first_name' => 'Jaroslav',
            'last_name' => 'Hluch a team',
            'school_city' => 'Bratislava',
            'flashmob_number_of_dancers' => '16',
            'video_link_type' => 'youtube',
            'youtube_link' => 'https://www.youtube.com/watch?v=y_aSUdDk3Cw',
            'flashmob_address' => 'Nákupné centrum Polus, Bratislava',
            'longitude' => '17.138409',
            'latitude' => '48.168235',
            'note' => 'za video ďakujeme Michalovi Hrabovcovi (a teamu).',
          ),
        ),
      );
      update_site_option( $this->strOptionKey, $this->aOptions, true );
    }
    
    add_shortcode( 'florp-form', array( $this, 'profile_form' ));
    // add_shortcode( 'florp-form-loader', array( $this, 'profile_form_loader' ));
    add_shortcode( 'florp-popup-anchor', array( $this, 'popup_anchor' ));
    add_shortcode( 'florp-map', array( $this, 'map' ));
    add_shortcode( 'florp-registered-count', array( $this, 'getRegisteredUserCount' ));
    add_shortcode( 'florp-registered-counter-impreza', array( $this, 'registeredUserImprezaCounter' ));
    add_shortcode( 'florp-popup-links', array( $this, 'popupLinks' ));
    
    // add_filter( 'ninja_forms_render_default_value', array( $this, 'filter__set_nf_default_values'), 10, 3 );
    add_filter( 'us_meta_tags', array( $this, 'filter__us_meta_tags' ));
    // add_filter( 'us_meta_tags', array( $this, 'filter__us_meta_tags_before_echo' ));
    
    add_action( 'ninja_forms_register_actions', array( $this, 'action__register_nf_florp_action' ));
    add_action( 'ninja_forms_after_submission', array( $this, 'action__update_user_profile' ));
    add_action( 'after_setup_theme', array( $this, 'action__remove_admin_bar' ));
    add_action( 'wp_ajax_florp_map_ajax', array( $this, 'action__map_ajax_callback' ));
    add_action( 'wp_ajax_nopriv_florp_map_ajax', array( $this, 'action__map_ajax_callback' ) );
    add_action( 'wp_ajax_get_markerInfoHTML', array( $this, 'action__get_markerInfoHTML_callback' ));
    add_action( 'wp_ajax_nopriv_get_markerInfoHTML', array( $this, 'action__get_markerInfoHTML_callback' ) );
    add_action( 'wp_ajax_get_mapUserInfo', array( $this, 'action__get_mapUserInfo_callback' ));
    add_action( 'wp_ajax_nopriv_get_mapUserInfo', array( $this, 'action__get_mapUserInfo_callback' ) );
    add_action( 'admin_menu', array( $this, "action__add_options_page" ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'action__wp_enqueue_scripts' ), 9999 );
    add_action( 'ninja_forms_loaded', array( $this, 'action__register_merge_tags' ));
    add_action( 'login_head', array( $this, 'action__reset_password_redirect' ));

    $this->map_shortcode_template = '
      [us_gmaps
        marker_address="%%marker_address%%"
        marker_text="%%base_64_encoded_url_encoded_text%%"
        show_infowindow="%%show_infowindow%%"
        height="590"
        zoom="8"
        custom_marker_img="5236"
        custom_marker_size="40"
        disable_zoom="1"
        el_class="slovensky-flashmob-mapa"
        markers="%5B%7B%7D%5D"
      ]';
    $this->markerInfoWindowTemplate = '
      <div style="width: 285px; margin-left: 28px;">
        <h5 class="flashmob-location" style="padding:0!important">%%flashmob_city%%</h5>
        <p style="padding-left:0!important">
          <strong>Organizátor</strong>: %%organizer%%
          %%year%%
          %%school%%
          %%dancers%%
          %%note%%
        </p>
        %%embed_code%%
      </div>
    ';
    $this->aUserFields = array( 'user_email', 'first_name', 'last_name', 'user_pass' );
    $this->aUserFieldsMap = array( 'first_name', 'last_name' );
    $this->aMetaFields = array( 'webpage', 'school_name', 'school_webpage', 'school_city',
                          'flashmob_number_of_dancers', 'video_link_type', 'youtube_link', 'facebook_link', 'vimeo_link', 'embed_code', 'flashmob_address', 'longitude', 'latitude' );
    $this->aMetaFieldsToClean = array( 'school_city', // TODO: really?
                          'flashmob_number_of_dancers', 'video_link_type', 'youtube_link', 'facebook_link', 'vimeo_link', 'embed_code', 'flashmob_address', 'longitude', 'latitude' );
    $this->aGeneralMapOptions = array(
      'map_init_raw'  => array(
        'zoom'        => 8,
        'mapTypeId'   => 'roadmap',
        'scrollwheel' => false,
      ),
      'map_init_aux'  => array(
        'center'      => array( 'lat' => 48.669026, 'lng' => 19.699024 ),
      ),
      'markers'   => array(
        'icon'        => "http://flashmob.salsarueda.dance/wp-content/uploads/sites/6/2013/05/marker40.png",
      ),
      'custom'    => array(
        'height'       => 590,
        'disable_zoom' => 1,
      ),
      'og_map'    => array(
        'zoom'      => 7,
        'maptype'   => 'roadmap',
        'center'    => '48.72,19.7',
        'size'      => '640x320',
        'key'       => 'AIzaSyC_g9bY9qgW7mA0L1EupZ4SDYrBQWWi-V0',
      ),
      'og_map_image_alt'  => "Mapka registrovaných organizátorov rueda flashmobu na Slovensku",
      'fb_app_id'         => '768253436664320',
    );
  }

  public function profile_form( $aAttributes ) {
    $strShortcodeOutput = do_shortcode( '[ninja_form id=2]' );
    return '<div id="'.$this->strProfileFormWrapperID.'">' . $strShortcodeOutput.'</div>';
  }
  
  public function profile_form_loader( $aAttributes ) {
    $strDivID = 'florp-profile-form-placeholder-div';
    return '
      <div id="'.$strDivID.'"></div>
      <script type="text/javascript">
        var sourceForm = jQuery("#'.$strDivID.'");
        var replacementForm = jQuery("#'.$this->strProfileFormWrapperID.'");
        if (replacementForm.length > 0) {
          sourceForm.prepend(replacementForm);
          replacementForm.show();
        } else {
          console.log("No form to replace with!");
          sourceForm.hide();
        }
      </script>
    ';
  }
  
  public function popup_anchor( $aAttributes ) {
    return '<a name="'.$this->strClickTriggerAnchor.'"></a>';
  }
  
  private function getFlashmobSubscribers() {
    if (empty($this->aFlashmobSubscribers)) {
      $aArgs = array(
        'blog_id' => $this->iFlashmobBlogID,
        'role'    => 'subscriber'
      );
      $aUsers = get_users( $aArgs );
      $this->aFlashmobSubscribers = $aUsers;
      return $aUsers;
    } else {
      return $this->aFlashmobSubscribers;
    }
  }
  
  public function getRegisteredUserCount( $aAttributes ) {
    $bOnMapOnly = isset($aAttributes['on-map-only']) || (is_array($aAttributes) && in_array('on-map-only', $aAttributes));
    if ($bOnMapOnly && -1 != $this->aRegisteredUserCount['on-map-only']) {
      return $this->aRegisteredUserCount['on-map-only'];
    } elseif (!$bOnMapOnly && -1 != $this->aRegisteredUserCount['all']) {
      return $this->aRegisteredUserCount['all'];
    }
    $aUsers = $this->getFlashmobSubscribers();
    if ($bOnMapOnly) {
      $iCnt = 0;
      foreach ($aUsers as $key => $oUser) {
        $aAllMeta = array_map(
          function( $a ){
            if (is_array($a) && count($a) === 1) {
              return $a[0];
            } else {
              return $a;
            }
          },
          get_user_meta( $oUser->ID )
        );
        $strSchoolCity = trim($aAllMeta['school_city']);
        $strFlashmobAddress = trim($aAllMeta['flashmob_address']);
        if (empty($strSchoolCity) && empty($strFlashmobAddress)) {
          continue;
        }
        $iCnt++;
      }
      $this->aRegisteredUserCount['on-map-only'] = $iCnt;
      return $iCnt;
    } else {
      $iCnt = count( $aUsers );
      $this->aRegisteredUserCount['all'] = $iCnt;
      return $iCnt;
    }
  }
  
  public function registeredUserImprezaCounter( $aAttributes ) {
    $bOnMapOnly = isset($aAttributes['on-map-only']) || (is_array($aAttributes) && in_array('on-map-only', $aAttributes));
    $aCountAttrs = array();
    if ($bOnMapOnly) {
      $aCountAttrs['on-map-only'] = true;
    }
    $iCount = $this->getRegisteredUserCount( $aCountAttrs );
    $aAttributes['target'] = $iCount;
    
    $aCities = array();
//     $aSubscribers = $this->getFlashmobSubscribers();
//     // $aMetas = array();
//     foreach ($aSubscribers as $oUser) {
//       $aInfoArray = $this->getOneUserMapInfo( $oUser );
//       // $aMetas[$oUser->user_login] = $aInfoArray;
//       $strSchoolCity = $aInfoArray['school_city'];
//       if (isset($strSchoolCity)) {
//         $strSchoolCity = trim($strSchoolCity);
//         if (!empty($strSchoolCity)) {
//           $aCities[] = $strSchoolCity;
//         }
//       }
//     }
    if ($iCount === 0 && empty($aCities)) {
      // OK //
    } elseif ($iCount > 0 && empty($aCities)) {
      // $aAttributes['title'] = var_export($aMetas, true);
    } else {
      // $aAttributes['title'] = __('Registered cities','florp') . ": " . implode(', ', $aCities); // TODO ked sa spravi lokalizacia!
      // $aAttributes['title'] = "Registrované mestá: " . implode(', ', $aCities);
    }
//     if ($iCount === 0 || $iCount >= 5) {
//       $aAttributes['title'] = "registrovaných miest";
//     } elseif ($iCount === 1) {
//       $aAttributes['title'] = "registrované mesto";
//     } else {
//       $aAttributes['title'] = "registrované mestá";
//     }
    if (!isset($aAttributes['title'])) {
      $aAttributes['title'] = "MESTÁ";
    }
    $aShortCodeAttributes = array();
    foreach ($aAttributes as $key => $val) {
      if ($key === 'on-map-only' || $val === 'on-map-only') continue;
      $aShortCodeAttributes[] = $key.'="'.$val.'"';
    }
    $strShortCodeAttributes = implode(' ', $aShortCodeAttributes);
    $strFullShortcode = '[us_counter '.$strShortCodeAttributes.']';
    return do_shortcode($strFullShortcode);
  }
  
  public function popupLinks( $aAttributes = array() ) {
    $aDefaults = array(
      'login' => 'Login',
      'login-trigger' => 'florp-click-login-trigger',
      'register' => 'Register',
      'register-trigger' => 'florp-click-register-trigger',
      'profile' => 'Profile',
      'profile-trigger' => 'florp-click-profile-trigger',
      'separator' => ' | ',
    );
    $aAttributes = array_merge( $aDefaults, $aAttributes );
    $aLoggedInItems = array(
      'profile'
    );
    $aLoggedOutItems = array(
      'login',
      'register',
    );
    $aReturn = array();
    if (is_user_logged_in()) {
      foreach ($aLoggedInItems as $strItem) {
        $aReturn[] = '<span class="florp-click-trigger '.$aAttributes[$strItem.'-trigger'].'">'.$aAttributes[$strItem].'</span>';
      }
    } else {
      foreach ($aLoggedOutItems as $strItem) {
        $aReturn[] = '<span class="florp-click-trigger '.$aAttributes[$strItem.'-trigger'].'">'.$aAttributes[$strItem].'</span>';
      }
    }
    $strReturn = implode($aAttributes['separator'], $aReturn);
    return $strReturn;
  }
  
  public function map( $aAttributes ) {
    $iFlashmobYear = intval($this->aOptions['iFlashmobYear']);
    $iIsCurrentYear = 0;
    $bAllYears = false;
    if (isset($aAttributes['year'])) {
      $mixYear = $aAttributes['year'];
      if ($aAttributes['year'] === 'all') {
        $bAllYears = true;
      } else {
        $mixYear = intval($mixYear);
      }
    } elseif (isset($aAttributes['all-years'])) {
      $bAllYears = true;
    } else {
      $mixYear = $iFlashmobYear;
    }
    if ($bAllYears) {
      $mixYear = 'all';
    } elseif (empty($mixYear)) {
      return '<span class="warning">'.__('Map shortcode called with empty year!','florp').'</span>';
    } else {
      if ($iFlashmobYear === $mixYear) {
        $iIsCurrentYear = 1;
      }
    }
    $iTimestamp = date('U');
    $strRandomString = wp_generate_password( 5, false );
    $strID = $iTimestamp . '_' . $strRandomString;
    
    if ($bAllYears) {
      // Current year: //
      $aSchoolCities = array();
      $aSchoolCitiesNoVideo = array();
      $aMapOptionsNoVideo = array();
      $aMapOptionsArray = array();
      $aCurrentYearOptions = $this->get_map_options_array(true, 0);
      $aVideoFields = array('facebook_link', 'youtube_link', 'vimeo_link', 'embed_code');
      foreach ($aCurrentYearOptions as $iUserID => $aOptions) {
        $strCity = $aOptions['school_city'];
        if (!empty($strCity)) {
          $strCity = strtolower($strCity);
        
          $bVideo = false;
          foreach ($aVideoFields as $strFieldKey) {
            if (isset($aOptions[$strFieldKey]) && !empty($aOptions[$strFieldKey])) {
              $bVideo = true;
              break;
            }
          }
          if ($bVideo) {
            $aSchoolCities[] = $strCity;
            $aMapOptionsArray[$iUserID] = $aOptions;
            $aMapOptionsArray[$iUserID]['year'] = $this->aOptions['iFlashmobYear'];
          } else {
            $aSchoolCitiesNoVideo[$strCity] = $iUserID;
            $aMapOptionsNoVideo[$iUserID] = $aOptions;
            $aMapOptionsNoVideo[$iUserID]['year'] = $this->aOptions['iFlashmobYear'];
          }

        }
      }
      foreach ($this->aOptions["aYearlyMapOptions"] as $iYear => $aMapOptionsForYear) {
        foreach ($aMapOptionsForYear as $iUserID => $aOptions) {
          $strCity = $aOptions['school_city'];
          if (!empty($strCity)) {
            $strCity = strtolower($strCity);
            $bVideo = false;
            foreach ($aVideoFields as $strFieldKey) {
              if (isset($aOptions[$strFieldKey]) && !empty($aOptions[$strFieldKey])) {
                $bVideo = true;
                break;
              }
            }
            if (!in_array($strCity, $aSchoolCities)) {
              if ($bVideo) {
                $aSchoolCities[] = $strCity;
                $aOptions['year'] = $iYear;
                if (isset($aMapOptionsArray[$iUserID])) {
                  $aMapOptionsArray[] = $aOptions;
                } else {
                  $aMapOptionsArray[$iUserID] = $aOptions;
                }
              } elseif (!isset($aSchoolCitiesNoVideo[$strCity])) {
                $aOptions['year'] = $iYear;
                $iKey = $iUserID;
                while (isset($aMapOptionsNoVideo[$iKey])) {
                  $iKey++;
                }
                $aMapOptionsNoVideo[$iKey] = $aOptions;
                $aSchoolCitiesNoVideo[$strCity] = $iKey;
              }
            }
          }
        }
      }
      foreach ($aSchoolCitiesNoVideo as $strCity => $iKey) {
        if (!in_array($strCity, $aSchoolCities)) {
          $aOptions = $aMapOptionsNoVideo[$iKey];
          if (isset($aMapOptionsArray[$iKey])) {
            $aMapOptionsArray[] = $aOptions;
          } else {
            $aMapOptionsArray[$iKey] = $aOptions;
          }
        }
      }
    } else {
      // Get the map options array //
      $aMapOptionsArray = $this->get_map_options_array($iIsCurrentYear === 1, $mixYear);
    }
    
    if (isset($aAttributes['city-shown-on-load'])) {
      $strCity = trim($aAttributes['city-shown-on-load']);
      if (!empty($strCity)) {
        $strCity = strtolower($strCity);
        foreach ($aMapOptionsArray as $iUserID => $aOptions) {
          if (strtolower($aOptions['school_city']) == $strCity || stripos($aOptions['school_city'], $strCity) !== false || stripos($aOptions['flashmob_address'], $strCity) !== false) {
            $aMapOptionsArray[$iUserID]['showOnLoad'] = true;
            break;
          }
        }
      }
    }
    $strMapOptionsArrayJson = json_encode($aMapOptionsArray);
    $strMapJson = '<script type="text/javascript">
      if ("undefined" === typeof florp_map_options_object) {
        var florp_map_options_object = {};
      }
      florp_map_options_object["'.$strID.'"] = '.$strMapOptionsArrayJson.';
    </script>';
      /* '.var_export(array($mixYear, $iFlashmobYear, $aAttributes), true).' */
    $strMapDivHtml = '<div id="'.$strID.'" class="florp-map" data-year="'.$mixYear.'" data-is-current-year="'.$iIsCurrentYear.'"></div>';
    return $strMapJson.PHP_EOL.$strMapDivHtml; //."<!-- ".var_export($aAttributes, true)." ".var_export($this->aOptions["aYearlyMapOptions"], true)." -->";
  }
  
  private function get_map_options_array( $bIsCurrentYear = true, $iYear = 0 ) {
    if ($bIsCurrentYear || $iYear == 0) {
      // Construct the current year's user array //
      $aUsers = $this->getFlashmobSubscribers();
      foreach ($aUsers as $key => $oUser) {
        $aMapOptionsArray[$oUser->ID] = $this->getOneUserMapInfo($oUser);
      }
    } elseif (isset($this->aOptions["aYearlyMapOptions"][$iYear])) {
      $aMapOptionsArray = $this->aOptions["aYearlyMapOptions"][$iYear];
//       $aMapOptionsArray['info'] = "byYear";
    } else {
      $aMapOptionsArray = array();
//       $aMapOptionsArray['info'] = "empty";
    }
    return $aMapOptionsArray;
  }
  
  private function getOneUserMapInfo($oUser) {
    $aMapOptionsArray = array();
    foreach ($this->aUserFieldsMap as $keyVal) {
      $mixVal = $oUser->$keyVal;
      if (isset($mixVal) && !empty($mixVal)) {
        $aMapOptionsArray[$keyVal] = $mixVal;
      }
    }
    $aAllMeta = array_map(
      function( $a ){
        if (is_array($a) && count($a) === 1) {
          return $a[0];
        } else {
          return $a;
        }
      },
      get_user_meta( $oUser->ID )
    );
    foreach ($this->aMetaFields as $keyVal) {
      $mixMeta = $aAllMeta[$keyVal];
      if (isset($mixMeta) && !empty($mixMeta)) {
        $aMapOptionsArray[$keyVal] = $mixMeta;
      }
    }
    return $aMapOptionsArray;
  }

  private function archive_current_year_map_options() {
    $iFlashmobYear = $this->aOptions['iFlashmobYear'];
    $aMapOptions = $this->get_map_options_array(true, $iFlashmobYear);
    $this->aOptions['aYearlyMapOptions'][$iFlashmobYear] = $aMapOptions;
    update_site_option( $this->strOptionKey, $this->aOptions, true );
    
    // clean user meta //
    $aUsers = $this->getFlashmobSubscribers();
    foreach ($aUsers as $key => $oUser) {
      foreach ($this->aMetaFieldsToClean as $keyVal) {
        delete_user_meta( $oUser->ID, $keyVal );
      }
    }
  }
  
  public function filter__set_nf_default_values( $default_value, $field_type, $field_settings ) {
    if (empty($field_settings['default'])) {
      $iUserID = get_current_user_id();
      $default_value = get_user_meta( $iUserID, $field_settings['key'], true );
    }
    return $default_value;
  }
  
  public function getMapImage() {
    $aMapOptions = $this->aGeneralMapOptions;
    $aSizeArr = explode( "x", $aMapOptions['og_map']['size']);
    $aOptionsFromUsers = $this->get_map_options_array();
    $aMarkerOptions = array( 'icon:'.urlencode($aMapOptions['markers']['icon']) );
    
    if (!empty($aOptionsFromUsers)) {
      foreach ($aOptionsFromUsers as $iUserID => $aOptions ) {
        if (isset($aOptions['latitude'],$aOptions['longitude']) && !empty($aOptions['latitude']) && !empty($aOptions['longitude'])) {
          $aMarkerOptions[] = $aOptions['latitude'].",".$aOptions['longitude'];
          continue;
        }
        if (isset($aOptions['school_city'])) {
          $aOptions['school_city'] = trim($aOptions['school_city']);
          if (!empty($aOptions['school_city'])) {
            $aMarkerOptions[] = urlencode($aOptions['school_city']);
          }
        }
      }
    }
    $strMarkerOptions = implode( "|", $aMarkerOptions );
    
    $aMapImageOptions = $aMapOptions['og_map'];
    $aMapImageOptions['markers'] = $strMarkerOptions;
    array_walk($aMapImageOptions, function(&$a, $b) { $a = "$b=$a"; });
    
    $strMapImage = 'https://maps.googleapis.com/maps/api/staticmap?'.implode("&", $aMapImageOptions);
    $aReturn = array(
      'url'       => $strMapImage,
      'alt'       => $aMapOptions['og_map_image_alt'],
      'width'     => $aSizeArr[0],
      'height'    => $aSizeArr[1],
      'fb_app_id' => $aMapOptions['fb_app_id'],
    );
    // echo "<!-- ".var_export($aMapOptions, true) . "\n" . var_export($aOptionsFromUsers, true)."\n".var_export($aMapImageOptions, true)."\n".$strMapImage." -->";
    return $aReturn;
  }
  
  public function filter__us_meta_tags( $aMetaTags ) {
    $iBlogID = get_current_blog_id();
    $sLangSlug = 'sk';
    if (function_exists('pll_current_language')) {
      $sLangSlug = pll_current_language('slug');
    }
    if ($iBlogID == $this->iFlashmobBlogID && $sLangSlug == 'sk') {
      $aMapImage = $this->getMapImage();
      $aMetaTags['og:image'] = $aMapImage['url'];
      $aMetaTags['og:image:width'] = $aMapImage['width'];
      $aMetaTags['og:image:height'] = $aMapImage['height'];
      $aMetaTags['og:image:alt'] = $aMapImage['alt'];
      $aMetaTags['og:updated_time'] = time();
      $aMetaTags['fb:app_id'] = $aMapImage['fb_app_id'];
    }
    return $aMetaTags;
  }
  
  public function filter__us_meta_tags_before_echo( $aMetaTags ) {
    return $aMetaTags;
  }
  
  public function action__wp_enqueue_scripts() {
    $iUserID = get_current_user_id();
    wp_enqueue_script('florp_nf_action_controller', plugins_url('js/florp_nf_action_controller.js', __FILE__), array('jquery'), $this->strVersion, true);
    wp_enqueue_script('florp_form_js', plugins_url('js/florp-form.js', __FILE__), array('jquery'), $this->strVersion, true);
    
    wp_enqueue_script('us-google-maps-with-key', '//maps.googleapis.com/maps/api/js?key=AIzaSyBaPowbVdIBpJqo_yhEfLn1v60EWbow6ZY', array(), '', FALSE );
    $bDoTriggerPopupClick = false;
    if (isset($_GET[$this->strClickTriggerGetParam])) {
      if (isset($_COOKIE[$this->strClickTriggerCookieKey]) && $_COOKIE[$this->strClickTriggerCookieKey] === '1') {
        $bDoTriggerPopupClick = true;
      }
    }
    setcookie($this->strClickTriggerCookieKey, "0", time() + (1 * 24 * 60 * 60), '/');
    $aJS = array(
      'hide_flashmob_fields'      => $this->aOptions['bHideFlashmobFields'] ? 1 : 0,
      'reload_ok_submission'      => $this->aOptions['bReloadAfterSuccessfulSubmission'] ? 1 : 0,
      'reload_ok_cookie'          => 'florp-form-saved',
      'florp_trigger_anchor'      => $this->strClickTriggerAnchor,
      'map_ajax_action'           => 'florp_map_ajax',
      'get_markerInfoHTML_action' => 'get_markerInfoHTML',
      'get_mapUserInfo_action'    => 'get_mapUserInfo',
      'ajaxurl'                   => admin_url( 'admin-ajax.php'),
      'security'                  => wp_create_nonce( 'srd-florp-security-string' ),
      'video_link_type'           => get_user_meta( $iUserID, 'video_link_type', true ),
      'school_city'               => get_user_meta( $iUserID, 'school_city', true ),
      'click_trigger_class'       => $this->strClickTriggerClass,
      'do_trigger_popup_click'    => $bDoTriggerPopupClick,
      'general_map_options'       => $this->aGeneralMapOptions,
    );
    if (is_user_logged_in()) {
      $oCurrentUser = wp_get_current_user();
      $aJS['user_id'] = $oCurrentUser->ID;
    }
    wp_localize_script( 'florp_form_js', 'florp', $aJS );
    
    wp_enqueue_style( 'florp_form_css', plugins_url('css/florp-form.css', __FILE__), false, $this->strVersion, 'all');
  }
  
  public function action__add_options_page() {
    add_options_page(
      "Profil organizátora SVK flashmobu",
      "Profil organizátora SVK flashmobu",
      "manage_options",
      $this->strOptionsPageSlug,
      array( $this, "options_page" )
    );
  }

  public function options_page() {
    // echo "<h1>" . __("Flashmob Organizer Profile Options", "florp" ) . "</h1>";
    echo "<h1>" . "Nastavenia profilu organizátora slovenského flashmobu" . "</h1>";

    if (isset($_POST['save-florp-options'])) {
      $this->save_option_page_options($_POST);
    }
    
    // echo "<pre>" .var_export($this->aOptions, true). "</pre>";
    // $aMapOptions = $this->get_map_options_array(false, 0);
    // echo "<pre>" .var_export($aMapOptions, true). "</pre>";

    if ($this->aOptions['bReloadAfterSuccessfulSubmission'] === true) {
      $strReloadChecked = 'checked="checked"';
    } else {
      $strReloadChecked = '';
    }
    
    $iFlashmobMonth = $this->aOptions["iFlashmobMonth"];
    $optionsMonths = "";
    for ($i = 1; $i <= 12; $i++) {
      if ($iFlashmobMonth == $i) {
        $strSelected = 'selected="selected"';
      } else {
        $strSelected = '';
      }
      $strMonthName = __( date('F', mktime(0, 0, 0, $i, 1, date('Y'))), 'florp' );
      $optionsMonths .= '<option value="'.$i.'" '.$strSelected.'>'.$strMonthName.'</option>';
    }
    
    $iYearNow = intval(date('Y'));
    $aNumOptionSettings = array(
      'optionsYears'    => array( 'start' => $iYearNow - 5, 'end' => $iYearNow + 5, 'leadingZero' => false, 'optionKey' => 'iFlashmobYear' ),
      'optionsDays'     => array( 'start' => 1, 'end' => 31, 'leadingZero' => false, 'optionKey' => 'iFlashmobDay' ),
      'optionsHours'    => array( 'start' => 0, 'end' => 23, 'leadingZero' => true, 'optionKey' => 'iFlashmobHour' ),
      'optionsMinutes'  => array( 'start' => 0, 'end' => 59, 'leadingZero' => true, 'optionKey' => 'iFlashmobMinute' ),
    );
    $aNumOptions = array();
    foreach ($aNumOptionSettings as $strOptionKey => $aSettings) {
      $aNumOptions[$strOptionKey] = '';
      $iOptionValue = isset($this->aOptions[$aSettings['optionKey']]) ? intval($this->aOptions[$aSettings['optionKey']]) : -1;
      for ($i = $aSettings['start']; $i <= $aSettings['end']; $i++) {
        if ($strOptionKey === "optionsYears" && isset($this->aOptions['aYearlyMapOptions'][$i])) {
          continue;
        }
        if ($iOptionValue == $i) {
          $strSelected = 'selected="selected"';
        } else {
          $strSelected = '';
        }
        if ($aSettings['leadingZero'] && $i < 10) {
          $strLabel = "0".$i;
        } else {
          $strLabel = $i;
        }
        $aNumOptions[$strOptionKey] .= '<option value="'.$i.'" '.$strSelected.'>'.$strLabel.'</option>';
      }
    }
    $strOptionsDaysStart = "";
    $strOptionsDaysEnd = "";
    $iSeasonStartDay = $this->aOptions["iSeasonStartDay"];
    $iSeasonEndDay = $this->aOptions["iSeasonEndDay"];
    
    echo str_replace(
      array( '%%reloadChecked%%', '%%optionsYears%%', '%%optionsMonths%%', '%%optionsDays%%', '%%optionsHours%%', '%%optionsMinutes%%' ),
      array( $strReloadChecked, $aNumOptions['optionsYears'], $optionsMonths, $aNumOptions['optionsDays'], $aNumOptions['optionsHours'], $aNumOptions['optionsMinutes'] ),
      '
        <form action="" method="post">
          <table style="width: 100%">
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                <label for="florp_reload_after_ok_submission">Znovu načítať celú stránku po vypnutí popup-u po úspešnom uložení formulára?</label>
              </th>
              <td>
                <input id="florp_reload_after_ok_submission" name="florp_reload_after_ok_submission" type="checkbox" %%reloadChecked%% value="1"/>
              </td>
            </tr>
              <th colspan="2">
                <span style="font-size: smaller;">Znovunačítanie je odporúčané zapnúť iba ak je problém s obnovením mapky / mapiek po uložení formuláru.</span>
              </th>
            <tr>
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_flashmob_year">Dátum a čas slovenského flashmobu</label></th>
              <td>
                <select id="florp_flashmob_year" name="florp_flashmob_year">%%optionsYears%%</select>
                / <select id="florp_flashmob_month" name="florp_flashmob_month">%%optionsMonths%%</select>
                / <select id="florp_flashmob_day" name="florp_flashmob_day">%%optionsDays%%</select>
                <select id="florp_flashmob_hour" name="florp_flashmob_hour">%%optionsHours%%</select>
                : <select id="florp_flashmob_minute" name="florp_flashmob_minute">%%optionsMinutes%%</select>
              </td>
            </tr>
            <tr>
              <th colspan="2">
                <span style="font-size: smaller;">Pozor: Ak zmeníte rok flashmobu, aktuálny rok sa archivuje a položky týkajúce sa presného miesta a videa sa u každého registrovaného účastníka vymažú.</span>
              </th>
            </tr>
          </table>
          
          <span style="">
            <input id="save-florp-options-bottom" class="button button-primary button-large" name="save-florp-options" type="submit" value="Ulož" />
          </span>
        </form>
      '
    );
  }
  
  private function save_option_page_options( $aPostedOptions ) {
    $iFlashmobYearCurrent = intval($this->aOptions['iFlashmobYear']);
    $iFlashmobYearNew = isset($aPostedOptions['florp_flashmob_year']) ? intval($aPostedOptions['florp_flashmob_year']) : $iFlashmobYearCurrent;
    if (isset($this->aOptions['aYearlyMapOptions'][$iFlashmobYearNew])) {
      echo '<span class="warning">Rok flashmobu možno nastaviť len na taký, pre ktorý ešte nie sú archívne dáta v DB!</span>';
      return false;
    } elseif ($iFlashmobYearNew != $iFlashmobYearCurrent) {
      $this->archive_current_year_map_options();
      echo '<span class="info">Dáta flashmobu z roku '.$iFlashmobYearCurrent.' boli archivované.</span>';
    }
  
    foreach ($this->aBooleanOptions as $strOptionKey) {
      $this->aOptions[$strOptionKey] = false;
    }
    foreach ($aPostedOptions as $key => $val) {
      if (isset($this->aOptionFormKeys[$key])) {
        $strOptionKey = $this->aOptionFormKeys[$key];
      } else {
        continue;
      }
      if (in_array( $strOptionKey, $this->aBooleanOptions )) {
        // Boolean //
        $this->aOptions[$strOptionKey] = ($val == '1');
      } else {
        $this->aOptions[$strOptionKey] = $val;
      }
    }
    update_site_option( $this->strOptionKey, $this->aOptions, true );
    
    return true;
  }
  
  public function action__remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
      show_admin_bar( false );
    }
  }
  
  public function action__reset_password_redirect() {
//     var_dump("haloooo");
    // Check if have submitted
    $confirm = ( isset($_GET['action'] ) && $_GET['action'] == resetpass );

    if( $confirm ) {
      setcookie($this->strClickTriggerCookieKey, "1", time() + (1 * 24 * 60 * 60), '/');
      wp_redirect( home_url( '/?popup-florp#popup-florp' ) );
      exit;
    }
  }
  
  public function action__register_merge_tags() {
    require_once __DIR__ . "/class.florp.mergetags.php";
    Ninja_Forms()->merge_tags[ 'florp_merge_tags' ] = new FlorpMergeTags();
  }
  
  public function action__map_ajax_callback() {
    check_ajax_referer( 'srd-florp-security-string', 'security' );
    $strLocation = $_POST['location'];
    $strMarkerText = $this->getMarkerInfoWindowContent($_POST['infoWindowData']);
    $strMarkerTextEncoded = base64_encode( $strMarkerText );
    $aSearch = array( '%%marker_address%%', '%%show_infowindow%%', '%%base_64_encoded_url_encoded_text%%' );
    $aReplace = array( $strLocation, '1', $strMarkerTextEncoded );
    $strShortcode = str_replace( $aSearch, $aReplace, $this->map_shortcode_template);
    $strResponse = do_shortcode($strShortcode);
    echo json_encode($strResponse);
    wp_die();
  }
  
  public function action__get_markerInfoHTML_callback() {
    check_ajax_referer( 'srd-florp-security-string', 'security' );
    $strMarkerText = $this->getMarkerInfoWindowContent($_POST['infoWindowData']);
    $aRes = array(
      'contentHtml' => $strMarkerText,
      'data'        => $_POST
    );
    echo json_encode($aRes);
    wp_die();
  }
  
  public function action__get_mapUserInfo_callback() {
    check_ajax_referer( 'srd-florp-security-string', 'security' );

    $oUser = get_user_by( 'id', $_POST['user_id'] );
    if (in_array("administrator", $oUser->roles)) {
      $aRes = array(
        'new_map_options' => false,
        'data'        => $_POST,
        // 'user' => $oUser
      );
      echo json_encode($aRes);
      wp_die();
    } else {
      $aMapOptionsArray = $this->getOneUserMapInfo($oUser);
          
      $aRes = array(
        'new_map_options' => $aMapOptionsArray,
        'data'        => $_POST,
        // 'user' => $oUser
      );
      echo json_encode($aRes);
      wp_die();
    }
  }
  
  private function getMarkerInfoWindowContent( $aInfoWindowData ) {
    if (empty($aInfoWindowData['webpage']['value'])) {
      $strOrganizer = $aInfoWindowData['first_name']['value'] . " " . $aInfoWindowData['last_name']['value'];
    } else {
      $strOrganizer = '<a href="'.$aInfoWindowData['webpage']['value'].'" target="_blank">'.$aInfoWindowData['first_name']['value'] . " " . $aInfoWindowData['last_name']['value'].'</a>';
    }
    if (empty($aInfoWindowData['school_name']['value'])) {
      $strSchool = '';
    } else {
      $strSchool = $aInfoWindowData['school_name']['value'];
      if (!empty($aInfoWindowData['school_webpage']['value'])) {
        $strSchool = '<a href="'.$aInfoWindowData['school_webpage']['value'].'" target="_blank">'.$strSchool.'</a>';
      }
      $strSchool = '<br>Škola / skupina: ' . $strSchool;
      if (!empty($aInfoWindowData['school_city']['value'])) {
        $strSchool .= " (".$aInfoWindowData['school_city']['value'].")";
      }
    }
    if (empty($aInfoWindowData['video_link_type']['value'])
        || (empty(trim($aInfoWindowData['youtube_link']['value']))
            && empty(trim($aInfoWindowData['embed_code']['value']))
            && empty(trim($aInfoWindowData['facebook_link']['value']))
            && empty(trim($aInfoWindowData['vimeo_link']['value'])) ) ) {
      $strEmbedCode = "";
    } else if ($aInfoWindowData['video_link_type']['value'] === "youtube" && !empty(trim($aInfoWindowData['youtube_link']['value']))) {
      $strYoutubeLink = trim($aInfoWindowData['youtube_link']['value']);
      $strYoutubeLinkRegex = '~^https?://(www\.|m\.)?youtube\.com/watch\?v=(.+)$~i';
      $aMatches = array();
      $mixCheckRes = preg_match( $strYoutubeLinkRegex, $strYoutubeLink, $aMatches );
      if (!$mixCheckRes || !isset($aMatches[2]) || empty($aMatches[2])) {
        $strEmbedCode = "";
      } else {
        $strYoutubeVideoParams = $aMatches[2];
        $aYoutubeVideoParams = explode('&amp;', $strYoutubeVideoParams);
        if (count($aYoutubeVideoParams) === 1) {
          $aYoutubeVideoParams = explode('&', $strYoutubeVideoParams);
        }
        $strYoutubeVideoID = array_shift($aYoutubeVideoParams);
        if (empty($aYoutubeVideoParams)) {
          $strEmbedSrc = $strYoutubeVideoID;
        } else {
          foreach ($aYoutubeVideoParams as $key => $strVal) {
            // check and replace params if needed //
            $aParam = explode('=', $strVal);
            if ($aParam[0] === 't') {
              $aYoutubeVideoParams[$key] = 'start='.preg_replace('~[^0-9]~', '', $aParam[1]);
            }
          }
          $strEmbedSrc = $strYoutubeVideoID.'?'.implode('&', $aYoutubeVideoParams);
        }
        if (!isset($strEmbedSrc) || empty($strEmbedSrc)) {
          $strEmbedCode = "" . "$strYoutubeLink, $strYoutubeVideoParams";
        } else {
          $strEmbedCode = '<iframe width="280" height="160" src="https://www.youtube.com/embed/'.$strEmbedSrc.'" frameborder="0" allowfullscreen=""></iframe>';
        }
      }
    } else if ($aInfoWindowData['video_link_type']['value'] === "facebook" && !empty(trim($aInfoWindowData['facebook_link']['value']))) {
      $strFacebookLink = $aInfoWindowData['facebook_link']['value'];
      $strFacebookLinkRegex = '~^https?://(www.)?facebook.com/[a-zA-Z0-9]+/videos/[a-zA-Z0-9]+/?$~i';
      $mixCheckRes = preg_match( $strFacebookLinkRegex, $strFacebookLink );
      if (!$mixCheckRes) {
        $strEmbedCode = "";
      } else {
        $strFacebookLink = htmlentities(urlencode($strFacebookLink));
        $strEmbedCode = '<iframe src="https://www.facebook.com/plugins/video.php?href='.$strFacebookLink.'&show_text=0&width=560" width="280" height="160" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>';//.'<pre>'.$strFacebookLink.'</pre>';
      }
    } else if ($aInfoWindowData['video_link_type']['value'] === "vimeo" && !empty(trim($aInfoWindowData['vimeo_link']['value']))) {
      $strVimeokLink = $aInfoWindowData['vimeo_link']['value'];
      $strVimeoLinkRegex = '~^https?://(www.)?vimeo.com/([0-9]+)/?$~i';
      $aMatches = array();
      $mixCheckRes = preg_match( $strVimeoLinkRegex, $strVimeokLink, $aMatches );
      if (!$mixCheckRes || !isset($aMatches[2]) || empty($aMatches[2])) {
        $strEmbedCode = "";
      } else {
        $strVimeoVideoID = $aMatches[2];
        $strEmbedCode = '<iframe src="https://player.vimeo.com/video/'.$strVimeoVideoID.'" width="340" height="200" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';//.'<pre>'.$strVimeokLink.'</pre>';
      }
    } else if ($aInfoWindowData['video_link_type']['value'] === "other" && !empty(trim($aInfoWindowData['embed_code']['value']))) {
      $strEmbedCode = $aInfoWindowData['embed_code']['value'];
      $strEmbedCode = stripslashes($strEmbedCode);
    } else {
      $strEmbedCode = "";
    }
    $aSearch = array( 'flashmob_city', 'organizer', 'school', 'embed_code', 'dancers', 'year', 'note' );
    foreach ($aSearch as $key => $value) {
      $aSearch[$key] = '%%'.$value.'%%';
    }
    if (empty($aInfoWindowData['flashmob_number_of_dancers']['value'])) {
      $strDancers = "";
    } else {
      $strDancers = "<br>Počet tancujúcich: ".$aInfoWindowData['flashmob_number_of_dancers']['value'];
    }
    $strLocation = trim($aInfoWindowData['flashmob_address']['value']);
    if (empty($strLocation)) {
      $strLocation = trim($aInfoWindowData['school_city']['value']);
      if ($strLocation === "null") {
        $strLocation = "";
      }
    }
    if (isset($aInfoWindowData['year']) && isset($aInfoWindowData['year']["value"])) {
      $strYear = '<br><strong>Rok</strong>: '.$aInfoWindowData['year']["value"];
    } else {
      $strYear = "";
    }
    if (isset($aInfoWindowData['note']) && isset($aInfoWindowData['note']["value"])) {
      $strNote = '<br>Poznámka: '.stripslashes($aInfoWindowData['note']["value"]);
    } else {
      $strNote = "";
    }
    $aReplace = array( $strLocation, $strOrganizer, $strSchool, $strEmbedCode, $strDancers, $strYear, $strNote );
    $strText = str_replace( $aSearch, $aReplace, $this->markerInfoWindowTemplate );
    return $strText;
    /*
     * Fields:
          'user_email', 'first_name', 'last_name', 'password', 'passwordconfirm',
          'school_name', 'fb_school_link', 'school_webpage', 'school_city',
          'flashmob_number_of_dancers', 'video_link_type', 'youtube_link', 'facebook_link', 'embed_code', 'flashmob_address',
    */
  }
  public function action__register_nf_florp_action( $actions ) {
    require_once __DIR__ . "/class.florp.actions.php";
    $actions['florp'] = new NF_Actions_Florp();
    return $actions;
  }
  
  public function action__update_user_profile( $aFormData ) {
    // Update the user's profile //
    // file_put_contents( __DIR__ . "/kk-debug-after-submission.log", var_export( $aFormData, true ) );
    
    $iUserID = get_current_user_id();
    $aUserData = array();
    foreach ($aFormData["fields"] as $strKey => $aData) {
      $strFieldKey = $aData['key'];
      $mixValue = $aData['value'];
      if (in_array($strFieldKey, $this->aUserFields)) {
        $aUserData[$strFieldKey] = $mixValue;
      } elseif (in_array($strFieldKey, $this->aMetaFields)) {
        $aMetaData[$strFieldKey] = $mixValue;
      }
    }
    
    if (!empty($aUserData)) {
      $aUserData['ID'] = $iUserID;
      $mixRes = wp_update_user( $aUserData );
    }
    if (!empty($aMetaData)) {
      foreach ($aMetaData as $strKey => $mixValue) {
        if (($strKey === "youtube_link" && !empty($mixValue) && $aMetaData['video_link_type'] !== 'youtube')
            || ($strKey === "facebook_link" && !empty($mixValue) && $aMetaData['video_link_type'] !== 'facebook')
            || ($strKey === "embed_code" && !empty($mixValue) && $aMetaData['video_link_type'] !== 'other')
            || ($strKey === "school_city" && $mixValue === "null")) {
          delete_user_meta( $iUserID, $strKey );
        } else {
          update_user_meta( $iUserID, $strKey, $mixValue );
        }
      }
    }
    setcookie('florp-form-saved', "1", time() + (1 * 24 * 60 * 60), '/');
  }
  
  public static function activate() {
//     if ( !wp_next_scheduled( 'ai1ecf_add_missing_featured_images' ) ) {
//       wp_schedule_event( time(), 'hourly', 'ai1ecf_add_missing_featured_images');
//     }
  }
  
  public static function deactivate() {
//     wp_clear_scheduled_hook('ai1ecf_add_missing_featured_images');
  }

}

$FLORP = new FLORP();
register_activation_hook(__FILE__, array('FLORP', 'activate'));
register_deactivation_hook(__FILE__, array('FLORP', 'deactivate'));

function florp_profile_form( $aAttributes = array() ) {
  global $FLORP;
  echo $FLORP->profile_form( $aAttributes );
}
function florp_profile_form_loader( $aAttributes = array() ) {
  return;
  global $FLORP;
  echo $FLORP->profile_form_loader( $aAttributes );
}
function florp_popup_anchor( $aAttributes = array() ) {
  global $FLORP;
  echo $FLORP->popup_anchor( $aAttributes );
}
function florp_get_map_image() {
  global $FLORP;
  return $FLORP->getMapImage();
}
