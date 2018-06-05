<?php
/**
 * Plugin Name: Flashmob Organizer Profile (with login/registration page)
 * Plugin URI: https://github.com/charliecek/flashmob-organizer-profile
 * Description: Creates shortcodes for flashmob organizer login / registration / profile editing form and for maps showing cities with videos of flashmobs for each year
 * Author: charliecek
 * Author URI: http://charliecek.eu/
 * Version: 3.0.0
 */

class FLORP{

  private $strVersion = '3.0.0';
  private $iMainBlogID = 1;
  private $iFlashmobBlogID = 6;
  private $iProfileFormNinjaFormIDMain;
  private $iProfileFormNinjaFormIDFlashmob;
  private $iProfileFormPopupIDMain;
  private $iProfileFormPopupIDFlashmob;
  private $strOptionsPageSlug = 'florp-options';
  private $strOptionKey = 'florp-options';
  private $aOptionDefaults = array();
  private $aOptionFormKeys = array();
  private $aBooleanOptions = array();
  private $aUserFields;
  private $aUserFieldsMap;
  private $aMetaFields;
  private $aMetaFieldsToClean;
  private $aLocationFields;
  private $strProfileFormWrapperID = 'florp-profile-form-wrapper-div';
  private $strClickTriggerClass = 'florp-click-register-trigger';
  private $strClickTriggerGetParam = 'popup-florp';
  private $strClickTriggerAnchor = 'popup-florp';
  private $strClickTriggerCookieKey = 'florp-popup';
  private $aOptions;
  private $aRegisteredUserCount;
  private $aFlashmobSubscribers;
  private $bDisplayingProfileFormNinjaForm = false;
  private $strNinjaFormExportPathMain = __DIR__ . '/nf-export/export-main.php';
  private $strNinjaFormExportPathFlashmob = __DIR__ . '/nf-export/export-flashmob.php';
  private $strExportVarName = 'aFlorpNinjaFormExportData';
  private $isMainBlog = false;
  private $isFlashmobBlog = false;

  public function __construct() {
    // TODO: if not multisite, deactivate plugin with notice //
    $this->aOptions = get_site_option( $this->strOptionKey, array() );
    $this->aOptionDefaults = array(
      'bReloadAfterSuccessfulSubmissionMain'      => false,
      'bReloadAfterSuccessfulSubmissionFlashmob'  => false,
      'aYearlyMapOptions'                         => array(),
      'iFlashmobYear'                             => isset($this->aOptions['iCurrentFlashmobYear']) ? $this->aOptions['iCurrentFlashmobYear'] : intval(date( 'Y' )),
      'iFlashmobMonth'                            => 1,
      'iFlashmobDay'                              => 1,
      'iFlashmobHour'                             => 0,
      'iFlashmobMinute'                           => 0,
      'iFlashmobBlogID'                           => 6,
      'iMainBlogID'                               => 1,
      'iProfileFormNinjaFormIDMain'               => 0,
      'iProfileFormPopupIDMain'                   => 0,
      'iProfileFormNinjaFormIDFlashmob'           => 0,
      'iProfileFormPopupIDFlashmob'               => 0,
      'bLoadMapsLazy'                             => true,
      'bLoadMapsAsync'                            => true,
      'bLoadVideosLazy'                           => true,
      'bUseMapImage'                              => true,
      'strVersion'                                => '0',
    );
    $this->aOptionFormKeys = array(
      'florp_reload_after_ok_submission_main'     => 'bReloadAfterSuccessfulSubmissionMain',
      'florp_reload_after_ok_submission_flashmob' => 'bReloadAfterSuccessfulSubmissionFlashmob',
      'florp_flashmob_year'                       => 'iFlashmobYear',
      'florp_flashmob_month'                      => 'iFlashmobMonth',
      'florp_flashmob_day'                        => 'iFlashmobDay',
      'florp_flashmob_hour'                       => 'iFlashmobHour',
      'florp_flashmob_minute'                     => 'iFlashmobMinute',
      'florp_flashmob_blog_id'                    => 'iFlashmobBlogID',
      'florp_main_blog_id'                        => 'iMainBlogID',
      'florp_profile_form_ninja_form_id_main'     => 'iProfileFormNinjaFormIDMain',
      'florp_profile_form_popup_id_main'          => 'iProfileFormPopupIDMain',
      'florp_profile_form_ninja_form_id_flashmob' => 'iProfileFormNinjaFormIDFlashmob',
      'florp_profile_form_popup_id_flashmob'      => 'iProfileFormPopupIDFlashmob',
      'florp_load_maps_lazy'                      => 'bLoadMapsLazy',
      'florp_load_maps_async'                     => 'bLoadMapsAsync',
      'florp_load_videos_lazy'                    => 'bLoadVideosLazy',
      'florp_use_map_image'                       => 'bUseMapImage',
    );
    $aDeprecatedKeys = array(
      'iCurrentFlashmobYear',
      'bHideFlashmobFields',
      'bReloadAfterSuccessfulSubmissionMain,bReloadAfterSuccessfulSubmissionFlashmob' => 'bReloadAfterSuccessfulSubmission',
      'iProfileFormNinjaFormIDFlashmob' => 'iProfileFormNinjaFormID',
      'iProfileFormPopupIDFlashmob' => 'iProfileFormPopupID',
    );
    $this->aBooleanOptions = array(
      'bReloadAfterSuccessfulSubmissionMain', 'bReloadAfterSuccessfulSubmissionFlashmob', 'bLoadMapsAsync', 'bLoadMapsLazy', 'bLoadVideosLazy', 'bUseMapImage',
    );
    $this->aOptionKeysByBlog = array(
      'main'      => array(
        'bReloadAfterSuccessfulSubmissionMain',
        'aYearlyMapOptions',
        'iFlashmobYear',
        'iFlashmobMonth',
        'iFlashmobDay',
        'iFlashmobHour',
        'iFlashmobMinute',
        'iMainBlogID',
        'iProfileFormNinjaFormIDMain',
        'iProfileFormPopupIDMain',
        'bLoadMapsLazy',
        'bLoadMapsAsync',
        'bLoadVideosLazy',
        'strVersion',
      ),
      'flashmob'  => array(
        'iFlashmobBlogID',
        'bReloadAfterSuccessfulSubmissionFlashmob',
        'iProfileFormNinjaFormIDFlashmob',
        'iProfileFormPopupIDFlashmob',
        'bUseMapImage',
      ),
    );

    // Get options and set defaults //
    if (empty($this->aOptions)) {
      // no options, set to defaults //
      $this->aOptions = $this->aOptionDefaults;
      update_site_option( $this->strOptionKey, $this->aOptions, true );
    } else {
      // add missing options //
      $bUpdate = false;
      foreach ($this->aOptionDefaults as $key => $val) {
        if (!isset($this->aOptions[$key])) {
          $this->aOptions[$key] = $val;
          $bUpdate = true;
        }
      }
      // remove old options //
      foreach ($aDeprecatedKeys as $strNewKey => $strOldKey) {
        if (isset($this->aOptions[$strOldKey])) {
          if (!is_numeric($strNewKey)) {
            $aNewOptionKeys = explode( ',', $strNewKey );
            foreach( $aNewOptionKeys as $strNewKey1 ) {
              $this->aOptions[$strNewKey1] = $this->aOptions[$strOldKey];
            }
          } elseif (isset($this->aOptions[$strNewKey])) {
            $this->aOptions[$strNewKey] = $this->aOptions[$strOldKey];
          }
          unset($this->aOptions[$strOldKey]);
          $bUpdate = true;
        }
      }
      // update if necessary //
      if ($bUpdate) {
        update_site_option( $this->strOptionKey, $this->aOptions, true );
      }
    }

    foreach ($this->aOptions as $key => $val) {
      if (property_exists($this, $key)) {
        if (strpos($key, 'i') === 0) {
          $iVal = intval($val);
          $this->aOptions[$key] = $iVal;
          $this->$key = $iVal;
        } else {
          $this->$key = $val;
        }
      } elseif (strpos($key, 'i') === 0) {
        $iVal = intval($val);
        $this->aOptions[$key] = $iVal;
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
    $this->aFlashmobSubscribers = array(
      'flashmob_organizer' => array(),
      'teacher' => array(),
      'subscriber_only' => array(),
      'all' => array(),
    );
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

    // SHORTCODES //
    add_shortcode( 'florp-form', array( $this, 'profile_form' ));
    // add_shortcode( 'florp-form-loader', array( $this, 'profile_form_loader' ));
    add_shortcode( 'florp-popup-anchor', array( $this, 'popup_anchor' ));
    add_shortcode( 'florp-map', array( $this, 'map' ));
    add_shortcode( 'florp-registered-count', array( $this, 'getRegisteredUserCount' ));
    add_shortcode( 'florp-registered-counter-impreza', array( $this, 'registeredUserImprezaCounter' ));
    add_shortcode( 'florp-popup-links', array( $this, 'popupLinks' ));

    // FILTERS //
    // add_filter( 'ninja_forms_render_default_value', array( $this, 'filter__set_nf_default_values'), 10, 3 );
    add_filter( 'us_meta_tags', array( $this, 'filter__us_meta_tags' ));
    // add_filter( 'us_meta_tags', array( $this, 'filter__us_meta_tags_before_echo' ));
    // add_filter( 'ninja_forms_preview_display_field', array( $this, 'filter__ninja_forms_preview_display_field' ));
    // add_filter( 'ninja_forms_display_fields', array( $this, 'filter__ninja_forms_display_fields' ));
    add_filter( 'ninja_forms_localize_fields', array( $this, 'filter__ninja_forms_localize_fields' ));
    add_filter( 'ninja_forms_localize_fields_preview', array( $this, 'filter__ninja_forms_localize_fields' ));
    add_filter( 'ninja_forms_register_fields', array( $this, 'filter__ninja_forms_register_fields' ));
    add_action( 'ninja_forms_display_form_settings', array( $this, 'filter__displaying_profile_form_nf_start' ), 10, 2 );

    // ACTIONS //
    add_action( 'ninja_forms_register_actions', array( $this, 'action__register_nf_florp_action' ));
    add_action( 'ninja_forms_after_submission', array( $this, 'action__update_user_profile' ));
    add_action( 'after_setup_theme', array( $this, 'action__remove_admin_bar' ));
    add_action( 'wp_ajax_florp_map_ajax', array( $this, 'action__map_ajax_callback' ));
    add_action( 'wp_ajax_nopriv_florp_map_ajax', array( $this, 'action__map_ajax_callback' ) );
    add_action( 'wp_ajax_get_markerInfoHTML', array( $this, 'action__get_markerInfoHTML_callback' ));
    add_action( 'wp_ajax_nopriv_get_markerInfoHTML', array( $this, 'action__get_markerInfoHTML_callback' ));
    add_action( 'wp_ajax_get_mapUserInfo', array( $this, 'action__get_mapUserInfo_callback' ));
    add_action( 'wp_ajax_nopriv_get_mapUserInfo', array( $this, 'action__get_mapUserInfo_callback' ));
    add_action( 'admin_menu', array( $this, "action__add_options_page" ));
    add_action( 'wp_enqueue_scripts', array( $this, 'action__wp_enqueue_scripts' ), 9999 );
    add_action( 'ninja_forms_enqueue_scripts', array( $this, 'action__ninja_forms_enqueue_scripts' ));
    add_action( 'ninja_forms_loaded', array( $this, 'action__register_merge_tags' ));
    add_action( 'ninja_forms_loaded', array( $this, 'action__import_profile_form' ));
    add_action( 'login_head', array( $this, 'action__reset_password_redirect' ));
    add_action( 'ninja_forms_before_container', array( $this, 'action__displaying_profile_form_nf_end' ), 10, 3 );
    add_action( 'ninja_forms_before_container_preview', array( $this, 'action__displaying_profile_form_nf_end' ), 10, 3 );
    add_action( 'plugins_loaded', array( $this, 'action__plugins_loaded' ));
    add_action( 'init', array( $this, 'action__init' ));

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
    $this->aMetaFields = array( 'webpage', 'school_name', 'school_webpage', 'school_city', 'subscriber_type',
                          'flashmob_number_of_dancers', 'video_link_type', 'youtube_link', 'facebook_link', 'vimeo_link', 'embed_code', 'flashmob_address', 'longitude', 'latitude' );
    $this->aMetaFieldsToClean = array(
                          'flashmob_number_of_dancers', 'video_link_type', 'youtube_link', 'facebook_link', 'vimeo_link', 'embed_code', 'flashmob_address', 'longitude', 'latitude' );
    $this->aLocationFields = array( "school_city", "flashmob_address", "longitude", "latitude" );
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

  private function migrate_subscribers( $iBlogFrom, $iBlogTo ) {
    $aArgsFlashmobBlogSubscribers = array(
      'blog_id' => $iBlogFrom,
      'role'    => 'subscriber'
    );
    $aFlashmobBlogSubscribers = get_users( $aArgsFlashmobBlogSubscribers );
    foreach ($aFlashmobBlogSubscribers as $oUser) {
      add_user_to_blog( $iBlogTo, $oUser->ID, 'subscriber' );
      remove_user_from_blog( $oUser->ID, $iBlogFrom );
    }
  }

  public function run_upgrades() {
//     $this->aOptions['strVersion'] = '0'; // NOTE DEVEL TEMP
//     update_site_option( $this->strOptionKey, $this->aOptions, true ); // NOTE DEVEL TEMP

    // Migrate users from Flashmob blog to main blog //
    $this->migrate_subscribers( $this->iFlashmobBlogID, $this->iMainBlogID );

    // Remvoe deprecated meta //
    $aArgsMainBlogSubscribers = array(
      'blog_id' => $this->iMainBlogID,
    );
    $aMainBlogSubscribersUsers = get_users( $aArgsMainBlogUsers );
    foreach ($aMainBlogSubscribersUsers as $key => $oUser) {
      delete_user_meta( $oUser->ID, 'som_organizator_rueda_flashmobu' );
    }

    // Version based upgrades //
    $strVersionInOptions = $this->aOptions['strVersion'];
    $strCurrentVersion = $this->strVersion;

    $strUpgradeFlashmobSubscribersToOrganizers = '3.0.0';
    if (version_compare( $strVersionInOptions, $strUpgradeFlashmobSubscribersToOrganizers, '<' )) {
      // Before 3.0.0, there were ONLY subscribers who were the organizers //
      // From 3.0.0 on, we have also subscribers who are not organizers (subscribers, teachers) //
      $aOrganizers = $this->getFlashmobSubscribers('all');
      foreach ($aOrganizers as $key => $oUser) {
        update_user_meta( $oUser->ID, 'subscriber_type', array( 'flashmob_organizer' ) );
      }
    }

    if (version_compare( $strVersionInOptions, $strCurrentVersion, '<' )) {
      $this->aOptions['strVersion'] = $strCurrentVersion;
      update_site_option( $this->strOptionKey, $this->aOptions, true );
    }

    $strOldExportPath = __DIR__ . '/nf-export/export.php';
    if (file_exists($strOldExportPath)) {
      rename($strOldExportPath, $this->strNinjaFormExportPathFlashmob);
    }

  }

  private function set_variables_per_subsite() {
    $iCurrentBlogID = get_current_blog_id();
    $this->isMainBlog = ($iCurrentBlogID == $this->iMainBlogID);
    $this->isFlashmobBlog = ($iCurrentBlogID == $this->iFlashmobBlogID);
  }

  public function action__plugins_loaded() {
    $this->run_upgrades();
    $this->set_variables_per_subsite();

    $strLwaBasename = 'login-with-ajax/login-with-ajax.php';
    if (is_plugin_active( $strLwaBasename )) {
      deactivate_plugins( $strLwaBasename, true );
    }
    if (is_plugin_active( $strLwaBasename ) || defined('LOGIN_WITH_AJAX_VERSION')) {
      if (is_admin() && current_user_can( 'activate_plugins' )) {
        add_action( 'admin_notices', array( $this, 'action__admin_notices__lwa_is_active' ));
      }
    } else {
      require_once __DIR__ . '/lwa/login-with-ajax.php';
    }
  }

  public function action__init() {
    if (is_admin() && current_user_can( 'activate_plugins' ) && defined('FLORP_DEVEL') && FLORP_DEVEL === true) {
      add_action( 'admin_notices', array( $this, 'action__admin_notices__florp_devel_is_on' ));
    }
  }

  public function action__admin_notices__lwa_is_active() {
    echo '<div class="notice notice-error"><p>Nepodarilo sa automaticky deaktivovať plugin "Login With Ajax". Prosíme, spravte tak pre najlepšie fungovanie pluginu "Profil organizátora SVK flashmobu".</p></div>';
  }

  public function action__admin_notices__florp_devel_is_on() {
    echo '<div class="notice notice-warning"><p>FLORP_DEVEL constant is on. Contact your site admin if you think this is not right!</p></div>';
    if (defined('FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION') && FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION === true) {
      echo '<div class="notice notice-warning"><p>Flashmob organizer archivation is off!</p></div>';
    }
  }

  public function filter__ninja_forms_preview_display_field( $aField ) {
    // NOTE: OFF //
    $aFieldSettings = $aField['settings'];
    if ('recaptcha_logged-out-only' === $aFieldSettings['type']) {
      return false;
    }
    return true;
  }

  public function filter__displaying_profile_form_nf_start( $aFormSettings, $iFormID ) {
    if ($this->isMainBlog && $iFormID == $this->iProfileFormNinjaFormIDMain) {
      $this->bDisplayingProfileFormNinjaForm = true;
    } elseif ($this->isFlashmobBlog && $iFormID == $this->iProfileFormNinjaFormIDFlashmob) {
      $this->bDisplayingProfileFormNinjaForm = true;
    }
    return $aFormSettings;
  }

  public function action__displaying_profile_form_nf_end( $iFormID, $aFormSettings, $aFormFields ) {
    $this->bDisplayingProfileFormNinjaForm = false;
  }

  public function filter__ninja_forms_localize_fields( $aField ) {
    $bLoggedIn = is_user_logged_in();
    if ($bLoggedIn) {
      // Hide our recaptcha field //
      if ('recaptcha_logged-out-only' === $aField['settings']['type']) {
        $aField['settings']["container_class"] .= " hidden";
      }
    }

    if (!$this->bDisplayingProfileFormNinjaForm) {
      return $aField;
    }

    if ($this->isMainBlog && $iFormID == $this->iProfileFormNinjaFormIDMain) {
      // Settings specific to the NF on the Flashmob Blog //
      if ($bLoggedIn) {
        $iUserID = get_current_user_id();
        $aSubscriberTypesOfUser = get_user_meta( $iUserID, 'subscriber_type', true );
        // echo "<pre>" .var_export($aSubscriberTypesOfUser, true). "</pre>";
        if ('listcheckbox' === $aField['settings']['type'] && 'subscriber_type' === $aField['settings']['key']) {
          foreach ($aField['settings']['options'] as $iOptionKey => $aOption) {
            $strValue = $aOption['value'];
            if (is_array($aSubscriberTypesOfUser) && in_array($strValue, $aSubscriberTypesOfUser)) {
              $aField['settings']['options'][$iOptionKey]['selected'] = 1;
            }
          }
        }

        if (isset($aField['settings']['container_class'])) {
          $bHide = true;
          if (stripos($aField['settings']['container_class'], 'florp-subscriber-type-field_all') !== false
                  || stripos($aField['settings']['container_class'], 'florp-registration-field') !== false) {
            $bHide = false;
          } else {
            // Go through subscriber types of user and leave field unhidden if matched //
            foreach ($aSubscriberTypesOfUser as $strSubscriberType) {
              if (stripos($aField['settings']['container_class'], 'florp-subscriber-type-field_'.$strSubscriberType) !== false
                  || stripos($aField['settings']['container_class'], 'florp-subscriber-type-field_any') !== false) {
                $bHide = false;
              }
            }
          }
          if ($bHide) {
            $aField['settings']['container_class'] .= " hidden";
          }
        }
  //       if ('checkbox' === $aField['settings']['type'] && 'som_organizator_rueda_flashmobu' === $aField['settings']['key']) {
  //         $iUserID = get_current_user_id();
  //         $strIsRuedaFlashmobOrganizer = get_user_meta( $iUserID, $aField['settings']['key'], true );
  //         $strCheckboxValue = ($strIsRuedaFlashmobOrganizer == '1') ? 'checked' : 'unchecked';
  //         $aField['settings']['default_value'] = $strCheckboxValue;
  //       }
      }

      // echo "<pre>" .var_export($aField, tDrue). "</pre>";
      if(!$bLoggedIn){
        // Registration form //
        if (isset($aField['settings']['container_class']) && stripos($aField['settings']['container_class'], 'florp-registration-field') === false) {
          $aField['settings']['container_class'] .= " hidden";
        } elseif (isset($aField['settings']['key']) && ($aField['settings']['key'] === 'user_pass' || $aField['settings']['key'] === 'passwordconfirm')) {
          $aField['settings']['required'] = true;
          $aField['settings']['desc_text'] = '';
        } elseif (isset($aField['settings']['type']) && ($aField['settings']['type'] === 'submit')) {
          $aField['settings']['label'] = 'Zaregistruj ma';
          $aField['settings']['processing_label'] = 'Registrujem';
        }
      }
    } elseif ($this->isFlashmobBlog && $iFormID == $this->iProfileFormNinjaFormIDFlashmob) {
      // Settings specific to the NF on the Flashmob Blog //
    }
    return $aField;
  }

  public function filter__set_nf_default_values( $strDefaultValue, $strFieldType, $aFieldSettings ) {
    // NOTE: OFF //
    return $strDefaultValue;
  }

  public function filter__ninja_forms_display_fields( $aFields ) {
    // NOTE: OFF //
    $bLoggedIn = is_user_logged_in();
    if($bLoggedIn){
      // Full profile form (with our recaptcha hidden) //
      foreach ($aFields as $key => $aField) {
        if ('recaptcha_logged-out-only' === $aField['type']) {
          $aFields[$key]["container_class"] .= " hidden";
          break;
        }
      }
    }

    $bIsProfileForm = false;
    foreach ($aFields as $aField) {
      if (isset($aField['key']) && ($aField['key'] === 'is_profile_form')) {
        $bIsProfileForm = true;
        break;
      } elseif (isset($aField['key']) && ($aField['key'] === 'flashmob_address')) {
        $bIsProfileForm = true;
        break;
      }
    }
    if (!$bIsProfileForm) {
      // If this is not our flashmob form, we are not changing it //
      return $aFields;
    }

    if(!$bLoggedIn){
      // Registration form //
      // var_dump($aFields);
      foreach ($aFields as $key => $aField) {
        if (isset($aField['container_class']) && stripos($aField['container_class'], 'florp-registration-field') === false) {
          $aFields[$key]['container_class'] .= " hidden";
        } elseif (isset($aField['key']) && ($aField['key'] === 'user_pass' || $aField['key'] === 'passwordconfirm')) {
          $aFields[$key]['required'] = true;
          $aFields[$key]['desc_text'] = '';
        } elseif (isset($aField['type']) && ($aField['type'] === 'submit')) {
          $aFields[$key]['label'] = 'Zaregistruj ma';
          $aFields[$key]['processing_label'] = 'Registrujem';
        }
      }
    }
    return $aFields;
  }
  
  public function profile_form( $aAttributes ) {
    $strShortcodeOutput = do_shortcode( '[ninja_form id='.$this->iProfileFormNinjaFormIDMain.']' );
    return '<div id="'.$this->strProfileFormWrapperID.'">' . $strShortcodeOutput.'</div>';
  }
  
  public function profile_form_loader( $aAttributes ) {
    // NOTE: OFF //
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
  
  private function getFlashmobSubscribers( $strType ) {
    if (empty($this->aFlashmobSubscribers[$strType])) {
      $aArgs = array(
        'blog_id' => $this->iMainBlogID,
        'role'          => 'subscriber'
      );
      $aArgsTypeSpecific = array();
      switch ($strType) {
        case 'flashmob_organizer':
        case 'teacher':
          $aArgsTypeSpecific = array(
            'meta_query' => array(
              array(
                'key'     => 'subscriber_type',
                'value'   => $strType,
                'compare' => 'LIKE'
              )
            )
          );
          break;
        case 'subscriber_only':
        case 'all':
        default:
          // Getting all users //
          break;
      }
      $aArgs = array_merge( $aArgs, $aArgsTypeSpecific );
      $aUsers = get_users( $aArgs );
      switch ($strType) {
        case 'flashmob_organizer':
        case 'teacher':
          // Check if 'LIKE' operator didn't match anything unwanted //
          $aRemoveKeys = array();
          foreach ($aUsers as $key => $oUser) {
            $aSubscriberTypesOfUser = get_user_meta( $oUser->ID, 'subscriber_type', true );
            if (empty($aSubscriberTypesOfUser) || !in_array( $strType, $aSubscriberTypesOfUser )) {
              $aRemoveKeys[] = $iKey;
            }
          }
          if (!empty($aRemoveKeys)) {
            foreach ($aRemoveKeys as $iKey) {
              unset($aUsers[$iKey]);
            }
          }
          $this->aFlashmobSubscribers[$strType] = $aUsers;
          break;
        case 'subscriber_only':
        case 'all':
        default:
          $this->aFlashmobSubscribers = array(
            'flashmob_organizer' => array(),
            'teacher' => array(),
            'subscriber_only' => array(),
            'all' => array(),
          );
          $aSubscriberTypes = array_keys( $this->aFlashmobSubscribers );
          $this->aFlashmobSubscribers['all'] = $aUsers;
          foreach ($aUsers as $oUser) {
            $aSubscriberTypesOfUser = get_user_meta( $oUser->ID, 'subscriber_type', true );
            if (empty($aSubscriberTypesOfUser)) {
              $this->aFlashmobSubscribers['subscriber_only'][] = $oUser;
            } else {
              foreach ($aSubscriberTypes as $strSubscriberType) {
                if ($strSubscriberType === 'all' || $strSubscriberType === 'subscriber_only') {
                  continue;
                }
                if (in_array( $strSubscriberType, $aSubscriberTypesOfUser )) {
                  $this->aFlashmobSubscribers[$strSubscriberType][] = $oUser;
                }
              }
            }
          }
          break;
      }
    }
    return $this->aFlashmobSubscribers[$strType];
  }

  public function getRegisteredUserCount( $aAttributes ) {
    $bOnMapOnly = isset($aAttributes['on-map-only']) || (is_array($aAttributes) && in_array('on-map-only', $aAttributes));
    if ($bOnMapOnly && -1 != $this->aRegisteredUserCount['on-map-only']) {
      return $this->aRegisteredUserCount['on-map-only'];
    } elseif (!$bOnMapOnly && -1 != $this->aRegisteredUserCount['all']) {
      return $this->aRegisteredUserCount['all'];
    }
    $aUsers = $this->getFlashmobSubscribers('flashmob_organizer');
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
      $aUsers = $this->getFlashmobSubscribers('flashmob_organizer');
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
    $aUsers = $this->getFlashmobSubscribers('flashmob_organizer');
    foreach ($aUsers as $key => $oUser) {
      foreach ($this->aMetaFieldsToClean as $keyVal) {
        delete_user_meta( $oUser->ID, $keyVal );
      }
    }
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
    if (!$this->aOptions['bUseMapImage']) {
      return $aMetaTags;
    }
    $sLangSlug = 'sk';
    if (function_exists('pll_current_language')) {
      $sLangSlug = pll_current_language('slug');
    }
    if ($this->isFlashmobBlog && $sLangSlug == 'sk') {
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
    // NOTE: OFF //
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
    if ($this->isMainBlog) {
      $iPopupID = $this->iProfileFormPopupIDMain;
      $iNFID = $this->iProfileFormNinjaFormIDMain;
      $bReloadAfterSuccessfulSubmission = $this->bReloadAfterSuccessfulSubmissionMain;
    } elseif ($this->isFlashmobBlog) {
      $iPopupID = $this->iProfileFormPopupIDFlashmob;
      $iNFID = $this->iProfileFormNinjaFormIDFlashmob;
      $bReloadAfterSuccessfulSubmission = $this->bReloadAfterSuccessfulSubmissionFlashmob;
    } else {
      $iPopupID = 0;
      $iNFID = 0;
      $bReloadAfterSuccessfulSubmission = false;
    }
    $aJS = array(
      'hide_flashmob_fields'          => $this->aOptions['bHideFlashmobFields'] ? 1 : 0,
      'reload_ok_submission'          => $bReloadAfterSuccessfulSubmission ? 1 : 0,
      'reload_ok_cookie'              => 'florp-form-saved',
      'florp_trigger_anchor'          => $this->strClickTriggerAnchor,
      'map_ajax_action'               => 'florp_map_ajax',
      'get_markerInfoHTML_action'     => 'get_markerInfoHTML',
      'get_mapUserInfo_action'        => 'get_mapUserInfo',
      'ajaxurl'                       => admin_url( 'admin-ajax.php'),
      'security'                      => wp_create_nonce( 'srd-florp-security-string' ),
      'video_link_type'               => get_user_meta( $iUserID, 'video_link_type', true ),
      'school_city'                   => get_user_meta( $iUserID, 'school_city', true ),
      'click_trigger_class'           => $this->strClickTriggerClass,
      'do_trigger_popup_click'        => $bDoTriggerPopupClick,
      'general_map_options'           => $this->aGeneralMapOptions,
      'form_id'                       => $iNFID,
      'logging_in_msg'                => "Prihlasujeme Vás... Prosíme, počkajte, kým sa stránka znovu načíta.",
      'popup_id'                      => $iPopupID,
      'load_maps_lazy'                => $this->aOptions['bLoadMapsLazy'] ? 1 : 0,
      'load_maps_async'               => $this->aOptions['bLoadMapsAsync'] ? 1 : 0,
      'load_videos_lazy'              => $this->aOptions['bLoadVideosLazy'] ? 1 : 0,
    );
    if (is_user_logged_in()) {
      $oCurrentUser = wp_get_current_user();
      $aJS['user_id'] = $oCurrentUser->ID;
    }
    wp_localize_script( 'florp_form_js', 'florp', $aJS );
    
    wp_enqueue_style( 'florp_form_css', plugins_url('css/florp-form.css', __FILE__), false, $this->strVersion, 'all');
  }

  public function action__ninja_forms_enqueue_scripts( $aFormData ) {
    // Add recaptcha JS if form contains our recaptcha field //
    // do_action( 'ninja_forms_enqueue_scripts', array( 'form_id' => $form_id ) ); //
    $iFormID = $aFormData['form_id'];
    $aFormFields = Ninja_Forms()->form( $iFormID )->get_fields();

    $bFormHasRecaptchaLoggedOutOnly = false;
    foreach ($aFormFields as $oFormFieldModel) {
      $strType = $oFormFieldModel->get_setting( 'type' );
      if ('recaptcha_logged-out-only' === $strType) {
        $bFormHasRecaptchaLoggedOutOnly = true;
        break;
      }
    }
    if ($bFormHasRecaptchaLoggedOutOnly) {
      $ver = Ninja_Forms::VERSION;
      $recaptcha_lang = Ninja_Forms()->get_setting('recaptcha_lang');
      wp_enqueue_script('nf-google-recaptcha', 'https://www.google.com/recaptcha/api.js?hl=' . $recaptcha_lang . '&onload=nfRenderRecaptcha&render=explicit', array( 'jquery', 'nf-front-end-deps' ), $ver, TRUE );
    }
  }

  public function action__add_options_page() {
    // Shown on each blog - links get the admin to the right settings page url //
    add_menu_page(
      "Profil organizátora slovenského flashmobu",
      'Profil organizátora SVK flashmobu',
      'manage_options',
      'florp-main',
      array( $this, "options_page" ),
      plugins_url( 'flashmob-organizer-profile/img/florp-icon-30.png' ),
      58
    );
  }

  public function options_page() {
    // echo "<h1>" . __("Flashmob Organizer Profile Options", "florp" ) . "</h1>";
    echo "<div class=\"wrap\"><h1>" . "Nastavenia profilu organizátora slovenského flashmobu" . "</h1>";

    if (isset($_POST['save-florp-options'])) {
      $this->save_option_page_options($_POST);
    }

    $optionsFlashmobSite = '';
    $optionsMainSite = '';
    $aSites = wp_get_sites();
    $strMainBlogDomain = '';
    $strFlashmobBlogDomain = '';
    foreach ( $aSites as $i => $aSite ) {
      if ($aSite['public'] != 1 || $aSite['deleted'] == 1 || $aSite['archived'] == 1) {
        continue;
      }
      $strTitle = $aSite['domain'];
      $iID = $aSite['blog_id'];
      if ($this->iFlashmobBlogID == $iID) {
        $strSelectedFlashmobSite = 'selected="selected"';
        $strFlashmobBlogDomain = $aSite['domain'];
      } else {
        $strSelectedFlashmobSite = '';
      }
      if ($this->iMainBlogID == $iID) {
        $strSelectedMainSite = 'selected="selected"';
        $strMainBlogDomain = $aSite['domain'];
      } else {
        $strSelectedMainSite = '';
      }
      $optionsFlashmobSite .= '<option value="'.$iID.'" '.$strSelectedFlashmobSite.'>'.$strTitle.'</option>';
      $optionsMainSite .= '<option value="'.$iID.'" '.$strSelectedMainSite.'>'.$strTitle.'</option>';
    }

    if (!$this->isMainBlog && strlen($strMainBlogDomain) > 0) {
      echo "<p>Spoločné nastavenia a nastavenia pre hlavnú stránku sú <a href=\"http://{$strMainBlogDomain}/wp-admin/admin.php?page=florp-main\">tu</a>.</p>";
    }
    if (!$this->isFlashmobBlog && strlen($strFlashmobBlogDomain) > 0) {
      echo "<p>Nastavenia pre flashmobovú stránku sú <a href=\"http://{$strFlashmobBlogDomain}/wp-admin/admin.php?page=florp-main\">tu</a>.</p>";
    }
    if (!$this->isMainBlog && !$this->isMainBlog) {
      echo "</div><!-- .wrap -->";
      return;
    }

    // echo "<pre>" .var_export($this->aOptions, true). "</pre>";
    // echo "<pre>" .var_export(array_merge($this->aOptions, array('aYearlyMapOptions' => 'removedForPreview')), true). "</pre>";
    // $aMapOptions = $this->get_map_options_array(false, 0);
    // echo "<pre>" .var_export($aMapOptions, true). "</pre>";
    // echo "<pre>" .var_export($this->getFlashmobSubscribers('subscriber_only'), true). "</pre>";
    // echo "<pre>" .var_export($this->getFlashmobSubscribers('flashmob_organizer'), true). "</pre>";
    // echo "<pre>" .var_export($this->getFlashmobSubscribers('teacher'), true). "</pre>";
    // echo "<pre>" .var_export($this->getFlashmobSubscribers('all'), true). "</pre>";

    $aBooleanOptionsChecked = array();
    foreach ($this->aBooleanOptions as $strOptionKey) {
      if ($this->aOptions[$strOptionKey] === true) {
        $aBooleanOptionsChecked[$strOptionKey] = 'checked="checked"';
      } else {
        $aBooleanOptionsChecked[$strOptionKey] = '';
      }
    }

    $optionNone = '<option value="0">Žiadny</option>';

    $aVariablesMain = array(
      'optionsMainSite' => $optionsMainSite,
      'optionNone' => $optionNone,
      'aBooleanOptionsChecked' => $aBooleanOptionsChecked,
    );
    $aVariablesFlashmob = array(
      'optionsFlashmobSite' => $optionsFlashmobSite,
      'optionNone' => $optionNone,
      'aBooleanOptionsChecked' => $aBooleanOptionsChecked,
    );
    $aVariablesCommon = array(
      'aBooleanOptionsChecked' => $aBooleanOptionsChecked,
    );

    echo str_replace(
      array( '%%optionsMainSite%%', '%%optionsFlashmobSite%%', '%%optionsCommon%%' ),
      array( $this->options_page_main( $aVariablesMain ), $this->options_page_flashmob( $aVariablesFlashmob ), $this->options_page_common( $aVariablesCommon ) ),
      '
        <form action="" method="post">
          <table style="width: 100%">
            %%optionsMainSite%%
            %%optionsFlashmobSite%%
            %%optionsCommon%%
          </table>

          <span style="">
            <input id="save-florp-options-bottom" class="button button-primary button-large" name="save-florp-options" type="submit" value="Ulož" />
          </span>
        </form>
        </div><!-- .wrap -->
      '
    );
  }

  private function options_page_main( $aVariables = array() ) {
    if (is_array($aVariables) && !empty($aVariables)) {
      foreach ($aVariables as $strVarName => $mixVarValue) {
        ${$strVarName} = $mixVarValue;
      }
    }

    if (!$this->isMainBlog) {
      return '';
    }

    $optionsNinjaFormsMain = $optionNone;
    if (function_exists('Ninja_Forms')) {
      $aForms = Ninja_Forms()->form()->get_forms();
      foreach( $aForms as $objForm ){
        $iID = $objForm->get_id();
        $strTitle = $objForm->get_setting( 'title' );
        if ($this->iProfileFormNinjaFormIDMain == $iID) {
          $strSelectedMain = 'selected="selected"';
        } else {
          $strSelectedMain = '';
        }
        $optionsNinjaFormsMain .= '<option value="'.$iID.'" '.$strSelectedMain.'>'.$strTitle.'</option>';
      }
    }

    $optionsPopupsMain = $optionNone;
    if (function_exists('get_all_popups')) {
      $aPopupsWPQuery = get_all_popups();
//       var_dump($aPopupsWPQuery);

      if ( $aPopupsWPQuery->have_posts() ) {
        while ( $aPopupsWPQuery->have_posts() ) :
          $aPopupsWPQuery->next_post();
          $iID = $aPopupsWPQuery->post->ID;
          $strTitle = $aPopupsWPQuery->post->post_title;
          if ($this->iProfileFormPopupIDMain == $iID) {
            $strSelectedMain = 'selected="selected"';
          } else {
            $strSelectedMain = '';
          }
          $optionsPopupsMain .= '<option value="'.$iID.'" '.$strSelectedMain.'>'.$strTitle.'</option>';
        endwhile;
      }
    }

    return str_replace(
      array( '%%reloadCheckedMain%%',
        '%%optionsNinjaFormsMain%%',
        '%%optionsPopupsMain%%',
        '%%optionsMainSite%%' ),
      array( $aBooleanOptionsChecked['bReloadAfterSuccessfulSubmissionMain'],
        $optionsNinjaFormsMain,
        $optionsPopupsMain,
        $optionsMainSite ),
      '
            <tr style="width: 98%; padding:  5px 1%;">
              <th colspan="2"><h3>Hlavná stránka</h3></th>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_main_blog_id">Podstránka</label></th>
              <td>
                <select id="florp_main_blog_id" name="florp_main_blog_id">%%optionsMainSite%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_profile_form_ninja_form_id_main">Registračný / profilový formulár (spomedzi Ninja Form formulárov)</label></th>
              <td>
                <select id="florp_profile_form_ninja_form_id_main" name="florp_profile_form_ninja_form_id_main">%%optionsNinjaFormsMain%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_profile_form_popup_id_main">PUM Popup, v ktorom je registračný / profilový formulár</label></th>
              <td>
                <select id="florp_profile_form_popup_id_main" name="florp_profile_form_popup_id_main">%%optionsPopupsMain%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                <label for="florp_reload_after_ok_submission_main">Znovu načítať celú stránku po vypnutí popup-u po úspešnom uložení formulára?</label>
              </th>
              <td>
                <input id="florp_reload_after_ok_submission_main" name="florp_reload_after_ok_submission_main" type="checkbox" %%reloadCheckedMain%% value="1"/>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th colspan="2">
                <span style="font-size: smaller;">Znovunačítanie je odporúčané zapnúť iba ak je problém s obnovením mapky / mapiek po uložení formuláru.</span>
              </th>
            </tr>
      '
    );
  }

  private function options_page_flashmob( $aVariables = array() ) {
    if (is_array($aVariables) && !empty($aVariables)) {
      foreach ($aVariables as $strVarName => $mixVarValue) {
        ${$strVarName} = $mixVarValue;
      }
    }

    if (!$this->isFlashmobBlog) {
      return '';
    }

    $optionsNinjaFormsFlashmob = $optionNone;
    $optionsPopupsFlashmob = $optionNone;

    if (function_exists('Ninja_Forms')) {
      $aForms = Ninja_Forms()->form()->get_forms();
      foreach( $aForms as $objForm ){
        $iID = $objForm->get_id();
        $strTitle = $objForm->get_setting( 'title' );
        if ($this->iProfileFormNinjaFormIDFlashmob == $iID) {
          $strSelectedFlashmob = 'selected="selected"';
        } else {
          $strSelectedFlashmob = '';
        }
        $optionsNinjaFormsFlashmob .= '<option value="'.$iID.'" '.$strSelectedFlashmob.'>'.$strTitle.'</option>';
      }
    }

    if (function_exists('get_all_popups')) {
      $aPopupsWPQuery = get_all_popups();
//       var_dump($aPopupsWPQuery);

      if ( $aPopupsWPQuery->have_posts() ) {
        while ( $aPopupsWPQuery->have_posts() ) :
          $aPopupsWPQuery->next_post();
          $iID = $aPopupsWPQuery->post->ID;
          $strTitle = $aPopupsWPQuery->post->post_title;
          if ($this->iProfileFormPopupIDFlashmob == $iID) {
            $strSelectedFlashmob = 'selected="selected"';
          } else {
            $strSelectedFlashmob = '';
          }
          $optionsPopupsFlashmob .= '<option value="'.$iID.'" '.$strSelectedFlashmob.'>'.$strTitle.'</option>';
        endwhile;
      }
    }

    return str_replace(
      array( '%%reloadCheckedFlashmob%%',
        '%%optionsNinjaFormsFlashmob%%',
        '%%optionsPopupsFlashmob%%',
        '%%optionsFlashmobSite%%' ),
      array( $aBooleanOptionsChecked['bReloadAfterSuccessfulSubmissionFlashmob'],
        $optionsNinjaFormsFlashmob,
        $optionsPopupsFlashmob,
        $optionsFlashmobSite ),
      '
            <tr style="width: 98%; padding:  5px 1%;">
              <th colspan="2"><h3>Flashmobobá podstránka</h3></th>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_flashmob_blog_id">Podstránka</label></th>
              <td>
                <select id="florp_flashmob_blog_id" name="florp_flashmob_blog_id">%%optionsFlashmobSite%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_profile_form_ninja_form_id_flashmob">Registračný / profilový formulár (spomedzi Ninja Form formulárov)</label></th>
              <td>
                <select id="florp_profile_form_ninja_form_id_flashmob" name="florp_profile_form_ninja_form_id_flashmob">%%optionsNinjaFormsFlashmob%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_profile_form_popup_id_flashmob">PUM Popup, v ktorom je registračný / profilový formulár</label></th>
              <td>
                <select id="florp_profile_form_popup_id_flashmob" name="florp_profile_form_popup_id_flashmob">%%optionsPopupsFlashmob%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                <label for="florp_reload_after_ok_submission_flashmob">Znovu načítať celú stránku po vypnutí popup-u po úspešnom uložení formulára?</label>
              </th>
              <td>
                <input id="florp_reload_after_ok_submission_flashmob" name="florp_reload_after_ok_submission_flashmob" type="checkbox" %%reloadCheckedFlashmob%% value="1"/>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th colspan="2">
                <span style="font-size: smaller;">Znovunačítanie je odporúčané zapnúť iba ak je problém s obnovením mapky / mapiek po uložení formuláru.</span>
              </th>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                <label for="florp_use_map_image">Použiť obrázok mapy slovenských flashmobov pri náhľade stránky pri zdieľaní (FB)?</label>
              </th>
              <td>
                <input id="florp_use_map_image" name="florp_use_map_image" type="checkbox" %%useMapImageChecked%% value="1"/>
              </td>
            </tr>
      '
    );
  }

  private function options_page_common( $aVariables = array() ) {
    if (is_array($aVariables) && !empty($aVariables)) {
      foreach ($aVariables as $strVarName => $mixVarValue) {
        ${$strVarName} = $mixVarValue;
      }
    }

    if (!$this->isMainBlog) {
      return '';
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

    return str_replace(
      array( '%%loadMapsAsyncChecked%%',
        '%%loadMapsLazyChecked%%',
        '%%loadVideosLazyChecked%%',
        '%%useMapImageChecked%%',
        '%%optionsYears%%', '%%optionsMonths%%', '%%optionsDays%%', '%%optionsHours%%', '%%optionsMinutes%%' ),
      array( $aBooleanOptionsChecked['bLoadMapsAsync'],
        $aBooleanOptionsChecked['bLoadMapsLazy'],
        $aBooleanOptionsChecked['bLoadVideosLazy'],
        $aBooleanOptionsChecked['bUseMapImage'],
        $aNumOptions['optionsYears'], $optionsMonths, $aNumOptions['optionsDays'], $aNumOptions['optionsHours'], $aNumOptions['optionsMinutes'] ),
      '
            <tr style="width: 98%; padding:  5px 1%;">
              <th colspan="2"><h3>Spoločné nastavenia</h3></th>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_flashmob_year">Dátum a čas slovenského flashmobu</label></th>
              <td>
                <select id="florp_flashmob_year" name="florp_flashmob_year">%%optionsYears%%</select>
                / <select id="florp_flashmob_month" name="florp_flashmob_month">%%optionsMonths%%</select>
                / <select id="florp_flashmob_day" name="florp_flashmob_day">%%optionsDays%%</select>
                <select id="florp_flashmob_hour" name="florp_flashmob_hour">%%optionsHours%%</select>
                : <select id="florp_flashmob_minute" name="florp_flashmob_minute">%%optionsMinutes%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th colspan="2">
                <span style="font-size: smaller;">Pozor: Ak zmeníte rok flashmobu, aktuálny rok sa archivuje a položky týkajúce sa presného miesta a videa sa u každého registrovaného účastníka vymažú.</span>
              </th>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                <label for="florp_load_maps_lazy">Načítavať skryté mapy až po kliknutí na príslušnú záložku?</label>
              </th>
              <td>
                <input id="florp_load_maps_lazy" name="florp_load_maps_lazy" type="checkbox" %%loadMapsLazyChecked%% value="1"/>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                <label for="florp_load_maps_async">Načítavať mapy asynchrónne?</label>
              </th>
              <td>
                <input id="florp_load_maps_async" name="florp_load_maps_async" type="checkbox" %%loadMapsAsyncChecked%% value="1"/>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                <label for="florp_load_videos_lazy">Načítavať skryté videá až po kliknutí na príslušnú záložku?</label>
              </th>
              <td>
                <input id="florp_load_videos_lazy" name="florp_load_videos_lazy" type="checkbox" %%loadVideosLazyChecked%% value="1"/>
              </td>
            </tr>
      '
    );
  }

  private function save_option_page_options( $aPostedOptions ) {
    if ($this->isMainBlog) {
      $aKeysToSave = $this->aOptionKeysByBlog['main'];

      $iFlashmobYearCurrent = intval($this->aOptions['iFlashmobYear']);
      $iFlashmobYearNew = isset($aPostedOptions['florp_flashmob_year']) ? intval($aPostedOptions['florp_flashmob_year']) : $iFlashmobYearCurrent;
      if (isset($this->aOptions['aYearlyMapOptions'][$iFlashmobYearNew])) {
        echo '<span class="warning">Rok flashmobu možno nastaviť len na taký, pre ktorý ešte nie sú archívne dáta v DB!</span>';
        return false;
      } elseif ($iFlashmobYearNew != $iFlashmobYearCurrent) {
        if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION') && FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION === true) {
          // NOT ARCHIVING //
        } else {
          $this->archive_current_year_map_options();
          echo '<span class="info">Dáta flashmobu z roku '.$iFlashmobYearCurrent.' boli archivované.</span>';
        }
      }

      // Migrate users from Flashmob blog to main blog on change of Main blog //
      $iNewMainBlogID = intval($aPostedOptions['florp_main_blog_id']);
      if ($iNewMainBlogID !== $this->iMainBlogID) {
        $this->migrate_subscribers( $this->iMainBlogID, $iNewMainBlogID );
      }
    } elseif ($this->isFlashmobBlog) {
      $aKeysToSave = $this->aOptionKeysByBlog['flashmob'];
    } else {
      return;
    }


    foreach ($this->aBooleanOptions as $strOptionKey) {
      if (in_array( $strOptionKey, $aKeysToSave )) {
        $this->aOptions[$strOptionKey] = false;
      }
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

    $this->set_variables_per_subsite();
    if ($this->isMainBlog) {
      $this->iProfileFormNinjaFormIDMain = intval($this->aOptions['iProfileFormNinjaFormIDMain']);
      $this->iProfileFormPopupIDMain = intval($this->aOptions['iProfileFormPopupIDMain']);
    } elseif ($this->isFlashmobBlog) {
      $this->iProfileFormNinjaFormIDFlashmob = intval($this->aOptions['iProfileFormNinjaFormIDFlashmob']);
      $this->iProfileFormPopupIDFlashmob = intval($this->aOptions['iProfileFormPopupIDFlashmob']);
    }

    $this->export_ninja_form();

    return true;
  }

  private function export_ninja_form( $iFormID = false, $strExportPath = false ) {
    if (!defined('FLORP_DEVEL') || FLORP_DEVEL !== true ) {
      return;
    }
    if (!function_exists('Ninja_Forms')) {
      return;
    }

    if ($this->isMainBlog) {
      if (false === $iFormID) {
        $iFormID = $this->iProfileFormNinjaFormIDMain;
      }
      if (false === $strExportPath) {
        $strExportPath = $this->strNinjaFormExportPathMain;
      }
    } elseif ($this->isFlashmobBlog) {
      if (false === $iFormID) {
        $iFormID = $this->iProfileFormNinjaFormIDFlashmob;
      }
      if (false === $strExportPath) {
        $strExportPath = $this->strNinjaFormExportPathFlashmob;
      }
    } else {
      return;
    }
    if ($iFormID == 0) {
      if (file_exists($strExportPath)) {
        unlink( $strExportPath );
      }
      return;
    }

    $aExport = array();
    $oFormModel = Ninja_Forms()->form( $iFormID )->get();
    $aFormSettings = $oFormModel->get_settings();
    if (!empty($aFormSettings)) {
      $aExport['form_settings'] = $aFormSettings;
      $aExport['field_settings'] = array();
      $aFormFieldModels = Ninja_Forms()->form( $iFormID )->get_fields();
      foreach ($aFormFieldModels as $oFormFieldModel) {
        $aFieldSettings = $oFormFieldModel->get_settings();
        if (!empty($aFieldSettings)) {
          $iID = $oFormFieldModel->get_id();
          $aExport['field_settings'][$iID] = $aFieldSettings;
        }
      }
      $aExport['action_settings'] = array();
      $aFormActionModels = Ninja_Forms()->form( $iFormID )->get_actions();
      foreach ($aFormActionModels as $oFormActionModel) {
        $aActionSettings = $oFormActionModel->get_settings();
        if (!empty($aActionSettings)) {
          $iID = $oFormActionModel->get_id();
          $aExport['action_settings'][$iID] = $aActionSettings;
        }
      }
    }
    $strExportContent = '<?php if ( ! defined( \'ABSPATH\' ) ) exit;'.PHP_EOL.'$'.$this->strExportVarName.' = '.var_export($aExport, true).'; ?>';
    file_put_contents( $strExportPath, $strExportContent );
  }

  public function action__import_profile_form() {
    if (defined('FLORP_DEVEL') && FLORP_DEVEL === true) { return; }
    if ($this->isMainBlog) {
      $strExportPath = $this->strNinjaFormExportPathMain;
    } elseif ($this->isFlashmobBlog) {
      $strExportPath = $this->strNinjaFormExportPathFlashmob;
    } else {
      return;
    }
    if (file_exists($strExportPath)) {
      include_once $strExportPath;
      $aImportedFormData = ${$this->strExportVarName};
      if (!is_array($aImportedFormData) || empty($aImportedFormData)) {
        return;
      }

      foreach (Ninja_Forms()->form()->get_forms() as $oFormModel) {
        $iID = $oFormModel->get_id();
        $aFormSettings = $oFormModel->get_settings();
        if ($aFormSettings['title'] == $aImportedFormData['form_settings']['title']) {
          $oFormModel->update_setting( 'title', $aFormSettings['title'] . " OLD: " . date('Y-m-d H:i:s') )->save();
        }
      }

      // Create new form //
      $oFormModel = Ninja_Forms()->form()->get();
      $oFormModel->update_settings( $aImportedFormData['form_settings'] )->save();
      $iNewFormID = $oFormModel->get_id();
      foreach ($aImportedFormData['field_settings'] as $aFieldSettings) {
        $oNewField = Ninja_Forms()->form( $iNewFormID )->field()->get();
        $oNewField->update_settings( $aFieldSettings )->save();
      }
      foreach ($aImportedFormData['action_settings'] as $ActionSettings) {
        $oNewAction = Ninja_Forms()->form( $iNewFormID )->action()->get();
        $oNewAction->update_settings( $ActionSettings )->save();
      }
      $oFormModel->save();
      rename( $strExportPath, $strExportPath.'.imported-'.date('Ymd-His'));

      if ($this->isMainBlog) {
        $this->iProfileFormNinjaFormIDMain = $iNewFormID;
        $this->aOptions['iProfileFormNinjaFormIDMain'] = $this->iProfileFormNinjaFormIDMain;
      } elseif ($this->isFlashmobBlog) {
        $this->iProfileFormNinjaFormIDFlashmob = $iNewFormID;
        $this->aOptions['iProfileFormNinjaFormIDFlashmob'] = $this->iProfileFormNinjaFormIDFlashmob;
      }
      update_site_option( $this->strOptionKey, $this->aOptions, true );
    }
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
  
  public function filter__ninja_forms_register_fields( $aFields ) {
    require_once __DIR__ . "/nf-custom-fields/Recaptcha_logged-out-only.php";
    $aFields['recaptcha_logged-out-only'] = new NF_Fields_RecaptchaLoggedOutOnly();
    return $aFields;
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
      $aSubscriberTypesOfUser = get_user_meta( $oUser->ID, 'subscriber_type', true );
      $aMapOptionsArray = $this->getOneUserMapInfo($oUser);
      if (!is_array($aSubscriberTypesOfUser) || !in_array('flashmob_organizer', $aSubscriberTypesOfUser)) {
        foreach ($this->aLocationFields as $strFieldKey) {
          unset($aMapOptionsArray[$strFieldKey]);
        }
      }
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
    require_once __DIR__ . "/class.success-message-logged-in.php";
    $actions['success-message-logged-in'] = new NF_Actions_SuccessMessageLoggedIn();
    require_once __DIR__ . "/class.success-message-logged-out.php";
    $actions['success-message-logged-out'] = new NF_Actions_SuccessMessageLoggedOut();
    return $actions;
  }
  
  private function generate_username( $strFirstName, $strLastName ) {
    $strUserNameBase = $strFirstName.".".$strLastName;
    
    $strOriginalLocale = setlocale(LC_CTYPE, 0);

    // set locale to UK //
    setlocale(LC_CTYPE, 'en_GB');
    // transliterate //
    $strUserNameBase = iconv('UTF-8', 'ASCII//TRANSLIT', $strUserNameBase);
    // reset locale //
    setlocale(LC_CTYPE, $strOriginalLocale);
    // convert to lower case and remove invalid characters //
    $strUserNameBase = strtolower($strUserNameBase);
    $strUserNameBase = preg_replace( '~[^a-z0-9.]~', '', $strUserNameBase );

    $strUserName = $strUserNameBase;

    $iSuffix = 0;
    while (username_exists($strUserName)) {
      $iSuffix++;
      $strUserName = $strUserNameBase . "." . $mixSuffix;
    }
    return $strUserName;
  }
  
  public function action__update_user_profile( $aFormData ) {
    // Update the user's profile //
    // file_put_contents( __DIR__ . "/kk-debug-after-submission.log", var_export( $aFormData, true ) );

    if (intval($aFormData['form_id']) !== $this->iProfileFormNinjaFormIDMain) {
      // Not the profile form //
      return;
    }

    if (is_user_logged_in()) {
      $iUserID = get_current_user_id();
    } else {
      // Get field values by keys //
      $aFieldData = array();
      foreach ($aFormData["fields"] as $strKey => $aData) {
        $aFieldData[$aData["key"]] = $aData['value'];
      }
      // generate username //
      $strUsername = $this->generate_username( $aFieldData['first_name'], $aFieldData['last_name'] );
      // Create new user //
      $mixResult = wp_create_user( $strUsername, $aFieldData['user_pass'], $aFieldData['user_email'] );
      if ( is_wp_error($mixResult) ) {
        file_put_contents( __DIR__ . "/kk-debug-after-submission-create-error.log", var_export( array( $aFieldData, $aFormData ), true ) );
        return;
      } else {
        // Success
        $iUserID = $mixResult;
        if (is_multisite()) {
          add_user_to_blog( $this->iMainBlogID, $iUserID, 'subscriber' );
        }
        $strBlogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        LoginWithAjax::new_user_notification( $strUsername, $aFieldData['user_pass'], $aFieldData['user_email'], $strBlogname );

        // New user notification to admins //
        $message  = sprintf(__('New user registration on your site %s:'), $strBlogname) . "\n\n";
        $message .= sprintf(__('Username: %s'), $strUsername ) . "\n\n";
        $message .= sprintf(__('E-mail: %s'), $aFieldData['user_email'] ) . "\n";
        $aAdminArgs = array(
          'blog_id' => get_current_blog_id(),
          'role'    => 'administrator'
        );
        $aAdmins = get_users( $aAdminArgs );
        if (empty($aAdmins) || (defined('FLORP_DEVEL') && FLORP_DEVEL === true)) {
          @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $strBlogname), $message);
        } else {
          foreach ($aAdmins as $iKey => $oAdmin) {
            @wp_mail($oAdmin->user_email, sprintf(__('[%s] New User Registration'), $strBlogname), $message);
          }
        }
      }
    }

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

  public function get_profile_form_id() {
    return $this->iProfileFormNinjaFormIDMain;
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
function florp_get_profile_form_id() {
  global $FLORP;
  return $FLORP->get_profile_form_id();
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
