<?php
/**
 * Plugin Name: Flashmob Organizer Profile (with login/registration page)
 * Plugin URI: https://github.com/charliecek/flashmob-organizer-profile
 * Description: Creates shortcodes for flashmob organizer login / registration / profile editing form and for maps showing cities with videos of flashmobs for each year
 * Short Description: Creates flashmob shortcodes, forms and maps
 * Author: charliecek
 * Author URI: http://charliecek.eu/
 * Version: 5.0.0
 * Requires at least: 4.8
 * Tested up to: 4.9.8
 * Requires PHP: 5.6
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.html
 */

class FLORP{

  private $strVersion = '5.0.0';
  private $iMainBlogID = 1;
  private $iFlashmobBlogID = 6;
  private $iIntfBlogID = 6;
  private $iProfileFormNinjaFormIDMain;
  private $iProfileFormNinjaFormIDFlashmob;
  private $iProfileFormNinjaFormIDIntf;
  private $iProfileFormPopupIDMain;
  private $iProfileFormPopupIDFlashmob;
  private $iProfileFormPopupIDIntf;
  private $strOptionsPageSlug = 'florp-options';
  private $strOptionKey = 'florp-options';
  private $aOptionDefaults = array();
  private $aOptionFormKeys = array();
  private $aBooleanOptions = array();
  private $aArrayOptions = array();
  private $aUserFields;
  private $aUserFieldsMap;
  private $aMetaFields;
  private $aMetaFieldsFlashmobToArchive;
  private $aFlashmobMetaFieldsToClean;
  private $aLocationFields;
  private $strProfileFormWrapperID = 'florp-profile-form-wrapper-div';
  private $strClickTriggerClass = 'florp-click-register-trigger';
  private $strClickTriggerClassFlashmob = 'florp-click-participant-trigger';
  private $strClickTriggerClassIntf = 'florp-click-international-participant-trigger';
  private $strClickTriggerGetParam = 'popup-florp';
  private $strClickTriggerAnchor = 'popup-florp';
  private $strClickTriggerCookieKey = 'florp-popup';
  private $aOptions;
  private $aRegisteredUserCount;
  private $aFlashmobSubscribers;
  private $bDisplayingProfileFormNinjaForm = false;
  private $strNinjaFormExportPathMain = __DIR__ . '/nf-export/export-main.php';
  private $strNinjaFormExportPathFlashmob = __DIR__ . '/nf-export/export-flashmob.php';
  private $strNinjaFormExportPathIntf = __DIR__ . '/nf-export/export-intf.php';
  private $strExportVarName = 'aFlorpNinjaFormExportData';
  private $isMainBlog = false;
  private $isFlashmobBlog = false;
  private $isIntfBlog = false;
  private $iProfileFormPageIDMain;
  private $iProfileFormPageIDFlashmob;
  private $iProfileFormPageIDIntf;
  private $strUserRolePending = 'florp-pending';
  private $strUserRoleApproved = 'subscriber';
  private $strUserRolePendingName = "Čaká na schválenie";
  private $strUserRoleRegistrationAdmin = 'florp-registration-admin';
  private $strUserRoleRegistrationAdminName = "Administrátor registrácií";
  private $strUserRoleRegistrationAdminSvk = 'florp-registration-admin-svk'; // Is a capability as well //
  private $strUserRoleRegistrationAdminSvkName = "Administrátor registrácií na SVK flashmob";
  private $strUserRoleRegistrationAdminIntf = 'florp-registration-admin-intf'; // Is a capability as well //
  private $strUserRoleRegistrationAdminIntfName = "Administrátor registrácií na medzinárodný flashmob";
  private $strPendingUserPageContentHTML;
  private $strUserApprovedMessage;
  private $strBeforeLoginFormHtmlMain;
  private $strBeforeLoginFormHtmlFlashmob;
  private $strBeforeLoginFormHtmlIntf;
  private $iFlashmobTimestamp = 0;
  private $iIntfFlashmobTimestamp = 0;
  private $bHideFlashmobFields;
  private $aSubscriberTypes = array("flashmob_organizer", "teacher");
  private $bIntfCityPollDisabled = false;
  private $oFlorpChartInstance;
  private $bReloadChartOnIntfFormSubmission = true;
  private $strIntfChartClass = "florp-intf-chart";

  public function __construct() {
    $this->load_options();

    $this->set_variables();

    require_once __DIR__ . "/class.florp.chart.php";
    $this->oFlorpChartInstance = new FLORP_CHART();

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

    $this->maybe_add_crons();

    // BEGIN archived yearly map options until 2016 //
    $aYearlyMapOptionsUntil2017 = array(
      2017 =>
      array (
        22 =>
        array (
          'first_name' => 'Jaroslav',
          'flashmob_address' => 'Polus City Center, Bratislava',
          'flashmob_number_of_dancers' => '54',
          'last_name' => 'Hluch',
          'latitude' => '48.16823489999999',
          'longitude' => '17.13840920000007',
          'school_city' => 'Bratislava',
          'flashmob_city' => 'Bratislava',
          'school_name' => 'Salsa by Norika',
          'school_webpage' => 'vlastna',
          'custom_school_webpage' => 'http://www.norika.sk/',
          'video_link' => 'http://vimeo.com/239140418',
          'user_webpage' => 'https://www.facebook.com/salsaruedajarohluch/',
        ),
        29 =>
        array(
          'first_name' => 'Miloš',
          'last_name' => 'Majtán',
          'school_city' => 'Trenčín',
          'flashmob_city' => 'Trenčín',
          'school_name' => 'Cubano Project',
          'school_webpage' => 'vlastna',
          'custom_school_webpage' => 'http://www.cubanoproject.sk/',
          'video_link' => 'https://vimeo.com/237284082',
          'user_webpage' => 'http://www.cubanoproject.sk/',
        ),
        30 =>
        array(
          'first_name' => 'Lucia',
          'flashmob_address' => 'Caffe Verdon Hlavná 2, Trnava',
          'flashmob_number_of_dancers' => '12',
          'last_name' => 'Rumik',
          'latitude' => '48.376578',
          'longitude' => '17.58580810000001',
          'school_city' => 'Trnava',
          'flashmob_city' => 'Trnava',
          'video_link' => 'https://m.youtube.com/watch?v=gs9mzJUONE8',
        ),
        31 =>
        array(
          'video_link' => 'https://www.facebook.com/1889991401237031/videos/2018771095025727/',
          'first_name' => 'Lucia',
          'flashmob_address' => 'Bánovce nad Bebravou, Slovakia',
          'flashmob_number_of_dancers' => '13',
          'last_name' => 'Šandrik',
          'latitude' => '48.71894065133083',
          'longitude' => '18.258365891015615',
          'flashmob_city' => 'Bánovce nad Bebravou',
          'school_city' => 'Bánovce nad Bebravou',
          'school_name' => 'Salsa BN',
          'school_webpage' => 'vlastna',
          'custom_school_webpage' => 'https://www.facebook.com/Salsa-BN-1889991401237031/',
          'user_webpage' => 'https://www.facebook.com/lucia.blazkova.1',
        ),
        32 =>
        array(
          'first_name' => 'Barbora',
          'last_name' => 'Boboková',
          'flashmob_city' => 'Prievidza',
          'school_city' => 'Prievidza',
          'school_name' => 'Cubano Project',
          'school_webpage' => 'vlastna',
          'custom_school_webpage' => 'http://www.cubanoproject.sk/',
          'video_link' => 'https://vimeo.com/237284082',
        ),
        33 =>
        array(
          'first_name' => 'Dáša',
          'flashmob_address' => 'Zvolen',
          'flashmob_number_of_dancers' => '24',
          'last_name' => 'Sásiková',
          'latitude' => '48.5761806',
          'longitude' => '19.137115499999936',
          'school_city' => 'Zvolen',
          'flashmob_city' => 'Zvolen',
          'school_name' => 'Salsa Loco Zvolen',
          'video_link' => 'https://www.youtube.com/watch?v=YZFKkCm0LTs&t=29s',
        ),
      ),
      2016 =>
      array(
        22 =>
        array (
          'first_name' => 'Jaroslav',
          'last_name' => 'Hluch',
          'webpage' => 'https://www.facebook.com/jaroslav.hluch',
          'flashmob_city' => 'Bratislava',
          'video_link' => 'http://vimeo.com/191247547',
          'flashmob_address' => 'Nákupné centrum Centrál, Bratislava',
          'longitude' => '17.129393',
          'latitude' => '48.157427',
        ),
        1000 =>
        array (
          'first_name' => 'Jana',
          'last_name' => 'Kvantová',
          'webpage' => 'https://www.facebook.com/jana.kvantova',
          'flashmob_city' => 'Piešťany',
          'video_link' => 'https://www.facebook.com/tvkarpaty/videos/1275355985822296/',
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
          'flashmob_city' => 'Bojnice',
          'video_link' => 'https://www.youtube.com/watch?v=CCCMo8Jdf9c',
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
          'flashmob_city' => 'Prievidza',
          'video_link' => 'https://www.youtube.com/watch?v=8LHBuWI5Hc4',
          'flashmob_address' => 'Prievidza',
          'longitude' => '18.624538',
          'latitude' => '48.774521',
        ),
        1002 =>
        array (
          'first_name' => 'Zuzana',
          'last_name' => 'Žilinská',
          'webpage' => 'https://www.facebook.com/zzilinska',
          'flashmob_city' => 'Levice',
          'video_link' => 'https://www.youtube.com/watch?v=_uVA-dEF8BM',
          'flashmob_address' => 'Levice',
          'longitude' => '18.598438',
          'latitude' => '48.217424',
        ),
        1003 =>
        array (
          'first_name' => 'Michal',
          'last_name' => 'Mravec',
          'webpage' => 'https://www.facebook.com/michal.mravec.7',
          'flashmob_city' => 'Žilina',
          'video_link' => 'https://www.youtube.com/watch?v=5gvAasxL8mQ',
          'flashmob_address' => 'OC Mirage, Žilina',
          'longitude' => '18.7408',
          'latitude' => '49.21945',
        ),
        1004 =>
        array (
          'first_name' => 'Vladimír',
          'last_name' => 'Svorad',
          'webpage' => 'https://www.facebook.com/vladimir.svorad.9',
          'flashmob_city' => 'Topolčany',
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
          'flashmob_city' => 'Bratislava',
          'video_link' => 'https://www.youtube.com/watch?v=Xqo7MhkatQU',
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
          'flashmob_city' => 'Bratislava',
          'video_link' => 'https://www.youtube.com/watch?v=lIcB_YlAMqU',
          'flashmob_address' => 'Eurovea, Bratislava',
          'longitude' => '17.121326',
          'latitude' => '48.140501',
        ),
        1005 =>
        array (
          'first_name' => 'Ivana',
          'last_name' => 'Kubišová',
          'webpage' => 'https://www.facebook.com/ivana.kubisova',
          'flashmob_city' => 'Banská Bystrica',
          'video_link' => 'https://www.youtube.com/watch?v=omPI_p1mBJE',
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
          'flashmob_city' => 'Hlohovec',
          'video_link' => 'https://www.youtube.com/watch?v=Dmgn-MEODgI',
          'flashmob_address' => 'Hlohovec',
          'longitude' => '17.803329',
          'latitude' => '48.425158',
        ),
        1006 =>
        array (
          'first_name' => 'José',
          'last_name' => 'Garcia',
          'webpage' => 'https://www.facebook.com/josegarciask',
          'flashmob_city' => 'Košice',
          'video_link' => 'https://www.youtube.com/watch?v=Ub0vgUypxGs',
          'flashmob_address' => 'Košice',
          'longitude' => '21.261075',
          'latitude' => '48.716386',
        ),
        1007 =>
        array (
          'first_name' => 'Eva',
          'last_name' => 'Macháčková',
          'webpage' => 'https://www.facebook.com/evinamachackova',
          'flashmob_city' => 'Piešťany',
          'video_link' => 'https://www.youtube.com/watch?v=rJSCefB6qJw',
          'flashmob_address' => 'Piešťany',
          'longitude' => '17.827155',
          'latitude' => '48.591797',
        ),
        32 =>
        array (
          'first_name' => 'Barbora',
          'last_name' => 'Boboková',
          'flashmob_city' => 'Prievidza',
          'video_link' => 'https://www.youtube.com/watch?v=Bz7-QD8TO9Y',
          'flashmob_address' => 'Prievidza',
          'longitude' => '18.624538',
          'latitude' => '48.774521',
        ),
        1004 =>
        array (
          'first_name' => 'Vladimír',
          'last_name' => 'Svorad',
          'webpage' => 'https://www.facebook.com/vladimir.svorad.9',
          'flashmob_city' => 'Topolčany',
          'video_link' => 'https://www.youtube.com/watch?v=wAX6EjZOJH4',
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
          'flashmob_city' => 'Bratislava',
          'flashmob_number_of_dancers' => '16',
          'video_link' => 'https://www.youtube.com/watch?v=y_aSUdDk3Cw',
          'flashmob_address' => 'Nákupné centrum Polus, Bratislava',
          'longitude' => '17.138409',
          'latitude' => '48.168235',
          'note' => 'za video ďakujeme Michalovi Hrabovcovi (a teamu).',
        ),
      ),
    );
    if (empty($this->aOptions['aYearlyMapOptions'])) {
      $this->aOptions['aYearlyMapOptions'] = $aYearlyMapOptionsUntil2017;
      $this->save_options();
    }

    // Reimport users from 2017 (missing flashmob_city) //
    if (!$this->aOptions['bLeadersFrom2017Reimported'] && isset($this->aOptions['aYearlyMapOptions']) && !empty($this->aOptions['aYearlyMapOptions']) && isset($this->aOptions['aYearlyMapOptions'][2017]) && !empty($this->aOptions['aYearlyMapOptions'][2017])) {
      foreach ($aYearlyMapOptionsUntil2017[2017] as $iUserID => $aData) {
        $this->aOptions['aYearlyMapOptions'][2017][$iUserID] = $aData;
      }
      $this->aOptions['bLeadersFrom2017Reimported'] = true;
      $this->save_options();
    }
//     // NOTE DEVEL TEMP
//     for ($i = 2013; $i <= 2017; $i++) {
//       $this->aOptions['aYearlyMapOptions'][$i] = $aYearlyMapOptionsUntil2017[$i];
//     }
//     $this->save_options();
    // END archived yearly map options until 2016 //

    // BEGIN SHORTCODES //
    add_shortcode( 'florp-form', array( $this, 'profile_form' ));
    // add_shortcode( 'florp-form-loader', array( $this, 'profile_form_loader' ));
    add_shortcode( 'florp-popup-anchor', array( $this, 'popup_anchor' ));
    add_shortcode( 'florp-map', array( $this, 'map_flashmob' ));
    add_shortcode( 'florp-map-teachers', array( $this, 'map_teachers' ));
    add_shortcode( 'florp-registered-count', array( $this, 'getRegisteredUserCount' ));
    add_shortcode( 'florp-registered-counter-impreza', array( $this, 'registeredUserImprezaCounter' ));
    add_shortcode( 'florp-popup-links', array( $this, 'popupLinks' )); // DEPRECATED //
    add_shortcode( 'florp-profile', array( $this, 'main_blog_profile' ));
    add_shortcode( 'florp-leader-participant-list', array( $this, 'leader_participants_table_shortcode' ));
    add_shortcode( 'florp-intf-chart', array( $this, 'shortcode_intf_chart' ));
    // END SHORTCODES //

    // BEGIN FILTERS //
    // add_filter( 'ninja_forms_render_default_value', array( $this, 'filter__set_nf_default_values'), 10, 3 );
    add_filter( 'us_meta_tags', array( $this, 'filter__us_meta_tags' ));
    // add_filter( 'us_meta_tags', array( $this, 'filter__us_meta_tags_before_echo' ));
    // add_filter( 'ninja_forms_preview_display_field', array( $this, 'filter__ninja_forms_preview_display_field' ));
    // add_filter( 'ninja_forms_display_fields', array( $this, 'filter__ninja_forms_display_fields' ));
    add_filter( 'ninja_forms_localize_fields', array( $this, 'filter__ninja_forms_localize_fields' ));
    add_filter( 'ninja_forms_localize_fields_preview', array( $this, 'filter__ninja_forms_localize_fields' ));
    add_filter( 'ninja_forms_register_fields', array( $this, 'filter__ninja_forms_register_fields' ));
    add_filter( 'ninja_forms_display_form_settings', array( $this, 'filter__displaying_profile_form_nf_start' ), 10, 2 );
    add_filter( 'the_content', array( $this, 'filter__the_content' ), 9999 );
    add_filter( 'us_load_header_settings', array( $this, 'filter__us_load_header_settings' ), 11 );
    add_filter( 'florp_chart_get_datatable', array( $this, 'filter__get_intf_chart_datatable' ), 10, 3 );
    add_filter( 'the_posts', array( $this, 'fakepage_intf_participant_form' ), -10);
    add_filter( 'the_posts', array( $this, 'fakepage_svk_participant_form' ), -10);
    // END FILTERS //

    // BEGIN ACTIONS //
    add_action( 'ninja_forms_register_actions', array( $this, 'action__register_nf_florp_action' ));
    add_action( 'ninja_forms_after_submission', array( $this, 'action__update_user_profile' ));
    add_action( 'after_setup_theme', array( $this, 'action__remove_admin_bar' ));
    add_action( 'wp_ajax_get_markerInfoHTML', array( $this, 'action__get_markerInfoHTML_callback' ));
    add_action( 'wp_ajax_nopriv_get_markerInfoHTML', array( $this, 'action__get_markerInfoHTML_callback' ));
    add_action( 'wp_ajax_get_leaderParticipantsTable', array( $this, 'action__get_leaderParticipantsTable_callback' ));
    add_action( 'wp_ajax_nopriv_get_leaderParticipantsTable', array( $this, 'action__get_leaderParticipantsTable_callback' ));
    add_action( 'wp_ajax_get_mapUserInfo', array( $this, 'action__get_mapUserInfo_callback' ));
    add_action( 'wp_ajax_nopriv_get_mapUserInfo', array( $this, 'action__get_mapUserInfo_callback' ));
      // BEGIN Participant & tshirt admin actions //
      add_action( 'wp_ajax_delete_florp_participant', array( $this, 'action__delete_florp_participant_callback' ));
        add_action( 'wp_ajax_delete_florp_intf_participant', array( $this, 'action__delete_florp_intf_participant_callback' ));
      add_action( 'wp_ajax_florp_tshirt_paid', array( $this, 'action__florp_tshirt_paid_callback' ));
        add_action( 'wp_ajax_florp_intf_tshirt_paid', array( $this, 'action__florp_intf_tshirt_paid_callback' ));
      add_action( 'wp_ajax_florp_tshirt_send_payment_warning', array( $this, 'action__florp_tshirt_send_payment_warning_callback' ));
        add_action( 'wp_ajax_florp_intf_tshirt_send_payment_warning', array( $this, 'action__florp_intf_tshirt_send_payment_warning_callback' ));
      add_action( 'wp_ajax_florp_tshirt_cancel_order', array( $this, 'action__florp_tshirt_cancel_order_callback' ));
        add_action( 'wp_ajax_florp_intf_tshirt_cancel_order', array( $this, 'action__florp_intf_tshirt_cancel_order_callback' ));
      add_action( 'wp_ajax_florp_tshirt_delivered', array( $this, 'action__florp_tshirt_delivered_callback' ));
        add_action( 'wp_ajax_florp_intf_tshirt_delivered', array( $this, 'action__florp_intf_tshirt_delivered_callback' ));
      add_action( 'wp_ajax_florp_participant_paid_fee', array( $this, 'action__florp_participant_paid_fee_callback' ));
        add_action( 'wp_ajax_florp_intf_participant_paid_fee', array( $this, 'action__florp_intf_participant_paid_fee_callback' ));
      add_action( 'wp_ajax_florp_participant_attend', array( $this, 'action__florp_participant_attend_callback' ));
        add_action( 'wp_ajax_florp_intf_participant_attend', array( $this, 'action__florp_intf_participant_attend_callback' ));
      // SVK only //
      add_action( 'wp_ajax_add_order_date', array( $this, 'action__add_order_date_callback' ));
      add_action( 'wp_ajax_delete_nf_submission', array( $this, 'action__delete_nf_submission_callback' ));
      add_action( 'wp_ajax_import_flashmob_nf_submission', array( $this, 'action__import_flashmob_nf_submission_callback' ));
      // END Participant & tshirt admin actions //
    add_action( 'wp_ajax_florp_create_subsite', array( $this, 'action__florp_create_subsite_callback' ));
    add_action( 'wp_ajax_cancel_flashmob', array( $this, 'action__cancel_flashmob_callback' ));
    add_action( 'wp_ajax_move_flashmob_participants', array( $this, 'action__move_flashmob_participants_callback' ));
    add_action( 'admin_menu', array( $this, "action__remove_admin_menu_items" ), 9999 );
    add_action( 'admin_menu', array( $this, "action__add_options_page" ));
    add_action( 'wp_enqueue_scripts', array( $this, 'action__wp_enqueue_scripts' ), 9999 );
    add_action( 'admin_enqueue_scripts', array( $this, 'action__admin_enqueue_scripts' ));
    add_action( 'ninja_forms_enqueue_scripts', array( $this, 'action__ninja_forms_enqueue_scripts' ));
    add_action( 'ninja_forms_loaded', array( $this, 'action__register_merge_tags' ));
    add_action( 'ninja_forms_loaded', array( $this, 'action__import_profile_form' ));
    add_action( 'ninja_forms_save_form', array( $this, 'action__export_profile_form' ));
    add_action( 'login_head', array( $this, 'action__reset_password_redirect' ));
    add_action( 'ninja_forms_before_container', array( $this, 'action__displaying_profile_form_nf_end' ), 10, 3 );
    add_action( 'ninja_forms_before_container_preview', array( $this, 'action__displaying_profile_form_nf_end' ), 10, 3 );
    add_action( 'plugins_loaded', array( $this, 'action__plugins_loaded' ));
    add_action( 'init', array( $this, 'action__init' ));
    add_action( 'set_user_role', array( $this, 'action__set_user_role' ), 10, 3 );
    add_action( 'lwa_before_login_form', array( $this, 'action__lwa_before_login_form' ));
    add_action( 'florp_notify_leaders_about_participants_cron', array( $this, 'notify_leaders_about_participants' ) );
    // END ACTIONS //

    // BEGIN FORM FIELDS //
    $this->aUserFields = array( 'user_email', 'first_name', 'last_name', 'user_pass' );
    $this->aUserFieldsMap = array( 'first_name', 'last_name' );
    $this->aMetaFieldsFlashmobToArchive = array( 'flashmob_organizer', 'flashmob_city',
                          'user_webpage', 'school_webpage', 'custom_school_webpage', // <= only in archived map options //
                          'school_name', 'facebook', 'webpage', 'custom_webpage',
                          'hide_leader_info', 'flashmob_number_of_dancers', 'video_link', 'flashmob_address', 'longitude', 'latitude' );
    $this->aMetaFieldsTeacher = array('teacher', 'courses_city', 'courses_info', 'courses_in_city_2', 'courses_city_2', 'courses_info_2', 'courses_in_city_3', 'courses_info_3', 'courses_city_3');
    $this->aMetaFields = array_merge( $this->aMetaFieldsFlashmobToArchive,
                        $this->aMetaFieldsTeacher,
                        array(
                          'user_city', 'flashmob_leader_tshirt_size', 'flashmob_leader_tshirt_gender', 'flashmob_leader_tshirt_color', 'preference_newsletter',
                        ));
    $this->aFlashmobMetaFieldsToClean = array(
                          'flashmob_organizer', 'flashmob_city',
                          'flashmob_number_of_dancers', 'video_link', 'flashmob_address', 'longitude', 'latitude',
                          'flashmob_leader_tshirt_size', 'flashmob_leader_tshirt_gender', 'flashmob_leader_tshirt_color' );
    $this->aLocationFields = array(
      'flashmob_organizer'  => array( "flashmob_city", "flashmob_address", "longitude", "latitude" ),
      'teacher'             => array( "courses_city", "courses_city_2", "courses_city_3" ),
    );
    // END FORM FIELDS //

    $this->aGeneralMapOptions = array(
      'map_init_raw'  => array(
        'zoom'        => 8,
        'mapTypeId'   => 'roadmap',
        'scrollwheel' => false,
        'keyboardShortcuts' => false,
      ),
      'map_init_aux'  => array(
        'center'      => array( 'lat' => 48.669026, 'lng' => 19.699024 ),
      ),
      'markers'   => array(
        'icon'        => plugins_url( 'flashmob-organizer-profile/img/florp-icon-40.png' ), //"http://flashmob.salsarueda.dance/wp-content/uploads/sites/6/2013/05/marker40.png",
      ),
      'custom'    => array(
        'height'          => 590,
        'height_preview'  => 350,
        'zoom_preview'    => 7,
        'disable_zoom'    => 1,
      ),
      'og_map'    => array(
        'zoom'      => 7,
        'maptype'   => 'roadmap',
        'center'    => '48.72,19.7',
        'size'      => '640x320',
        'key'       => $this->aOptions['strGoogleMapsKeyStatic'],
        'region'    => 'sk',
      ),
      'og_map_image_alt'  => "Mapka registrovaných organizátorov rueda flashmobu na Slovensku",
      'fb_app_id'         => $this->aOptions['strFbAppID'],
    );
    $this->aLeaderSubmissionHistoryViews = array( 'progress_vertical', 'progress_horizontal', 'table' );
    $this->strLeaderSubmissionHistoryViewsCookieKey = "florp-history-table-admin-view";
    $this->strLeaderSubmissionHistoryView = $this->aLeaderSubmissionHistoryViews[0];
    $this->strDateFormat = get_option('date_format')." ".get_option('time_format');
  }

  private function get_default_options() {
    $aNfFieldTypes = array();
    $aNfSubmissions = array();
    $aSites = wp_get_sites();
    foreach ($aSites as $i => $aSite) {
      if ($aSite['public'] != 1 || $aSite['deleted'] == 1 || $aSite['archived'] == 1) {
        continue;
      }
      $iID = intval($aSite['blog_id']);
      $aNfFieldTypes[$iID] = array('done' => false, 'field_types' => array());
      $aNfSubmissions[$iID] = array('done' => false, 'forms' => array());
    }

    return array(
      'bReloadAfterSuccessfulSubmissionMain'      => false,
      'bReloadAfterSuccessfulSubmissionFlashmob'  => false,
      'strLeaderParticipantsTableClass'           => "florp-leader-participants-table",
      'bParticipantRegistrationProcessed'         => false,
      'bLeadersFrom2017Reimported'                => false,
      'aYearlyMapOptions'                         => array(),
      'aOptionChanges'                            => array(),
      'aNfSubmissions'                            => $aNfSubmissions,
      'aNfFieldTypes'                             => $aNfFieldTypes,
      'iFlashmobYear'                             => isset($this->aOptions['iCurrentFlashmobYear']) ? $this->aOptions['iCurrentFlashmobYear'] : intval(date( 'Y' )),
      'iFlashmobMonth'                            => 1,
      'iFlashmobDay'                              => 1,
      'iFlashmobHour'                             => 0,
      'iFlashmobMinute'                           => 0,
      'iFlashmobBlogID'                           => 6,
      'iMainBlogID'                               => 1,
      'iNewsletterBlogID'                         => 0,
      'iCloneSourceBlogID'                        => 0,
      'iIntfBlogID'                               => 6,
      'iProfileFormNinjaFormIDMain'               => 0,
      'iProfileFormNinjaFormImportVersionMain'    => 0,
      'iProfileFormPopupIDMain'                   => 0,
      'iProfileFormNinjaFormIDFlashmob'           => 0,
      'iProfileFormNinjaFormImportVersionFlashmob'=> 0,
      'iProfileFormPopupIDFlashmob'               => 0,
      'iProfileFormNinjaFormIDIntf'               => 0,
      'iProfileFormNinjaFormImportVersionIntf'    => 0,
      'iProfileFormPopupIDIntf'                   => 0,
      'bLoadMapsLazy'                             => true,
      'bLoadMapsAsync'                            => true,
      'bLoadVideosLazy'                           => true,
      'bUseMapImage'                              => true,
      'strVersion'                                => '0',
      'iProfileFormPageIDMain'                    => 0,
      'iProfileFormPageIDFlashmob'                => 0,
      'iProfileFormPageIDIntf'                    => 0,
      'bApproveUsersAutomatically'                => false,
      'strPendingUserPageContentHTML'             => '<p>Ďakujeme, že ste sa registrovali.</p>
<p>Vaša registrácia čaká na schválenie. Akonáhle Vás schválime, dostanete o tom notifikáciu na emailovú adresu, ktorú ste zadali pri registrácii.</p>
<p>Váš SalsaRueda.Dance team</p>',
      'strUserApprovedMessage'                    => '<p>Vaša registrácia bola schválená!</p>
<p><a href="%PROFILE_URL%">Prihláste sa</a> emailovou adresou a heslom, ktoré ste zadali pri registrácii.</p>
<p>Váš SalsaRueda.Dance team</p>',
      'strUserApprovedSubject'                    => 'Vaša registrácia na %BLOGURL% bola schválená',
      'strBeforeLoginFormHtmlMain'                => '',
      'strBeforeLoginFormHtmlFlashmob'            => '',
      'strBeforeLoginFormHtmlIntf'                => '',
      'strGoogleMapsKeyStatic'                    => 'AIzaSyC_g9bY9qgW7mA0L1EupZ4SDYrBQWWi-V0',
      'strGoogleMapsKey'                          => 'AIzaSyBaPowbVdIBpJqo_yhEfLn1v60EWbow6ZY',
      'strFbAppID'                                => '768253436664320',
      'strRegistrationSuccessfulMessage'          => "Prihlasujeme Vás... Prosíme, počkajte, kým sa stránka znovu načíta.",
      'strLoginSuccessfulMessage'                 => "Prihlásenie prebehlo úspešne, prosíme, počkajte, kým sa stránka znovu načíta.",
      'strRegistrationErrorMessage'               => "<strong>CHYBA</strong>: Pri registrácii nastala chyba.",
      'strLoginErrorMessage'                      => "<strong>CHYBA</strong>: Neplatné používateľské meno alebo heslo.",
      'bPreventDirectMediaDownloads'              => false,
      'strNewsletterAPIKey'                       => '',
      'strNewsletterListsMain'                    => '',
      'strNewsletterListsFlashmob'                => '',
      'aParticipants'                             => array(),
      'aIntfParticipants'                         => array(),
      'aTshirts'                                  => array( "leaders" => array(), "participants" => array() ),
      'aTshirtsIntf'                              => array(),
      'aOrderDates'                               => array(),
      'strParticipantRegisteredSubject'           => 'Boli ste prihásený na flashmob',
      'strParticipantRegisteredMessage'           => '<p>Ďakujeme, že ste sa prihlásili na flashmob!</p>
<p>Váš SalsaRueda.Dance team</p>',
      'strParticipantRemovedSubject'              => 'Váš flashmob bol zrušený',
      'strParticipantRemovedMessage'              => '<p>Žiaľ, flashmob, na ktorý ste sa prihlásili, bol zrušený.</p>
<p>Nezúfajte však! Pozrite si <a href="http://flashmob.salsarueda.dance" target="blank">mapku flashmobov na našej stránke</a> a ak máte niektorý flashmob po ruke, prihláste sa na ten!</p>
<p>Váš SalsaRueda.Dance team</p>',
      'strLeaderParticipantListNotificationMsg'   => '<p>Tu sú Vaši noví účastníci:</p><p>%PARTICIPANT_LIST%</p><p>Celý zoznam si môžete pozrieť <a href="%PROFILE_URL%">vo Vašom profile</a>.</p><p>Váš SalsaRueda.Dance team</p>',
      'strLeaderParticipantListNotificationSbj'   => 'Máte nových účastníkov prihlásených na flashmob',
      'logs'                                      => array(),
      'strLoginBarLabelLogin'                     => 'Prihlásiť sa',
      'strLoginBarLabelLogout'                    => 'Odhlásiť sa',
      'strLoginBarLabelProfile'                   => 'Môj profil',
      'strMarkerInfoWindowTemplateOrganizer'      => '<div class="florp-marker-infowindow-wrapper">
<h5 class="florp-flashmob-location">%%flashmob_city%%</h5>
<p>%%signup%% %%organizer%% %%year%% %%school%% %%facebook%% %%web%% %%dancers%% %%note%%</p>
%%embed_code%%</div>',
      'strMarkerInfoWindowTemplateTeacher'        => '<div class="florp-marker-infowindow-wrapper">
<h5 class="florp-course-location">%%courses_city%%</h5>
<p>%%teacher%% %%school%%</p>
<div class="florp-course-info">%%courses_info%%</div>
</div>',
      'strSignupLinkLabel'                        => 'Prihlásiť na Flashmob',
      'strInfoWindowLabel_organizer'              => '<strong>Líder</strong>',
      'strInfoWindowLabel_teacher'                => '<strong>Líder</strong>',
      'strInfoWindowLabel_signup'                 => '',
      'strInfoWindowLabel_participant_count'      => 'Prihlásených účastníkov',
      'strInfoWindowLabel_year'                   => '<strong>Rok</strong>',
      'strInfoWindowLabel_school'                 => 'Škola / skupina',
      'strInfoWindowLabel_web'                    => '<strong>Web</strong>',
      'strInfoWindowLabel_facebook'               => '<strong>Facebook</strong>',
      'strInfoWindowLabel_dancers'                => 'Počet tancujúcich',
      'strInfoWindowLabel_note'                   => 'Poznámka',
      'strInfoWindowLabel_embed_code'             => '',
      'strInfoWindowLabel_courses_info'           => '',
      'iCoursesNumberEnabled'                     => 1,
      'strTshirtPaymentWarningNotificationSbj'    => 'Chýba nám platba za objednané tričko',
      'strTshirtPaymentWarningNotificationMsg'    => '<p>Prosíme, pošlite platbu za objednané tričko.</p><p>Váš SalsaRueda.Dance team</p>',
      'bTshirtOrderingDisabled'                   => false,
      'bTshirtOrderingDisabledOnlyDisable'        => false,
      'bOnlyFlorpProfileNinjaFormFlashmob'        => true,
      'bOnlyFlorpProfileNinjaFormMain'            => true,
      'iTshirtPaymentWarningDeadline'             => 14,
      'iTshirtPaymentWarningButtonDeadline'       => -1,
      'iTshirtOrderDeliveredBeforeFlashmobDdl'    => 9,
      'aUnhideFlashmobFieldsForUsers'             => array(),
      'aHideFlashmobFieldsForUsers'               => array(),
      'strIntfParticipantRegisteredSubject'       => 'Boli ste prihásený na medzinárodný flashmob',
      'iIntfTshirtOrderDeliveredBeforeFlashmobDdl'=> 9,
      'bIntfTshirtOrderingDisabled'               => false,
      'bIntfTshirtOrderingDisabledOnlyDisable'    => false,
      'iIntfTshirtPaymentWarningButtonDeadline'   => -1,
      'iIntfTshirtPaymentWarningDeadline'         => 14,
      'iIntfCityPollDeadline'                     => 31,
      'strIntfTshirtPaymentWarningNotificationSbj'=> 'Chýba nám platba za objednané tričko',
      'strNewsletterListsIntf'                    => '',
      'strIntfParticipantRegisteredMessage'       => '<p>Ďakujeme, že ste sa prihlásili na flashmob!</p>
<p>Váš SalsaRueda.Dance team</p>',
      'strIntfTshirtPaymentWarningNotificationMsg'=> '<p>Prosíme, pošlite platbu za objednané tričko.</p><p>Váš SalsaRueda.Dance team</p>',
      'iIntfFlashmobYear'                         => intval(date( 'Y' )),
      'iIntfFlashmobMonth'                        => 1,
      'iIntfFlashmobDay'                          => 1,
      'iIntfFlashmobHour'                         => 0,
      'iIntfFlashmobMinute'                       => 0,
      'aIntfCityPollUsers'                        => get_users( ['blog_id' => $this->iMainBlogID, 'role' => $this->strUserRoleApproved, 'fields' => 'ID'] ),
      'strIntfCityPollExtraCities'                => '',
      'bTshirtOrdersAdminEnabled'                 => false,
      'bEditSubmissions'                          => false,
    );
  }

  private function load_options() {
    // BEGIN options //
    $this->aOptions = get_site_option( $this->strOptionKey, array() );
    $this->aOptionDefaults = $this->get_default_options();
    $this->aOptionFormKeys = array(
      'florp_reload_after_ok_submission_main'         => 'bReloadAfterSuccessfulSubmissionMain',
      'florp_reload_after_ok_submission_flashmob'     => 'bReloadAfterSuccessfulSubmissionFlashmob',
      'florp_flashmob_year'                           => 'iFlashmobYear',
      'florp_flashmob_month'                          => 'iFlashmobMonth',
      'florp_flashmob_day'                            => 'iFlashmobDay',
      'florp_flashmob_hour'                           => 'iFlashmobHour',
      'florp_flashmob_minute'                         => 'iFlashmobMinute',
      'florp_flashmob_blog_id'                        => 'iFlashmobBlogID',
      'florp_main_blog_id'                            => 'iMainBlogID',
      'florp_newsletter_blog_id'                      => 'iNewsletterBlogID',
      'florp_clone_source_blog_id'                    => 'iCloneSourceBlogID',
      'florp_intf_blog_id'                            => 'iIntfBlogID',
      'florp_profile_form_ninja_form_id_main'         => 'iProfileFormNinjaFormIDMain',
      'florp_profile_form_popup_id_main'              => 'iProfileFormPopupIDMain',
      'florp_profile_form_ninja_form_id_flashmob'     => 'iProfileFormNinjaFormIDFlashmob',
      'florp_profile_form_popup_id_flashmob'          => 'iProfileFormPopupIDFlashmob',
      'florp_profile_form_ninja_form_id_intf'         => 'iProfileFormNinjaFormIDIntf',
      'florp_profile_form_popup_id_intf'              => 'iProfileFormPopupIDIntf',
      'florp_load_maps_lazy'                          => 'bLoadMapsLazy',
      'florp_load_maps_async'                         => 'bLoadMapsAsync',
      'florp_load_videos_lazy'                        => 'bLoadVideosLazy',
      'florp_use_map_image'                           => 'bUseMapImage',
      'florp_profile_form_page_id_main'               => 'iProfileFormPageIDMain',
      'florp_profile_form_page_id_flashmob'           => 'iProfileFormPageIDFlashmob',
      'florp_profile_form_page_id_intf'               => 'iProfileFormPageIDIntf',
      'florp_pending_user_page_content_html'          => 'strPendingUserPageContentHTML',
      'florp_user_approved_message'                   => 'strUserApprovedMessage',
      'florp_user_approved_subject'                   => 'strUserApprovedSubject',
      'florp_approve_users_automatically'             => 'bApproveUsersAutomatically',
      'florp_before_login_form_html_main'             => 'strBeforeLoginFormHtmlMain',
      'florp_before_login_form_html_flashmob'         => 'strBeforeLoginFormHtmlFlashmob',
      'florp_before_login_form_html_intf'             => 'strBeforeLoginFormHtmlIntf',
      'florp_google_maps_key'                         => 'strGoogleMapsKey',
      'florp_google_maps_key_static'                  => 'strGoogleMapsKeyStatic',
      'florp_fb_app_id'                               => 'strFbAppID',
      'florp_registration_successful_message'         => 'strRegistrationSuccessfulMessage',
      'florp_login_successful_message'                => 'strLoginSuccessfulMessage',
      'florp_prevent_direct_media_downloads'          => 'bPreventDirectMediaDownloads',
      'florp_newsletter_api_key'                      => 'strNewsletterAPIKey',
      'florp_newsletter_lists_main'                   => 'strNewsletterListsMain',
      'florp_newsletter_lists_flashmob'               => 'strNewsletterListsFlashmob',
      'florp_participant_registered_subject'          => 'strParticipantRegisteredSubject',
      'florp_participant_registered_message'          => 'strParticipantRegisteredMessage',
      'florp_participant_removed_subject'             => 'strParticipantRemovedSubject',
      'florp_participant_removed_message'             => 'strParticipantRemovedMessage',
      'florp_leader_participant_list_notif_msg'       => 'strLeaderParticipantListNotificationMsg',
      'florp_leader_participant_list_notif_sbj'       => 'strLeaderParticipantListNotificationSbj',
      'florp_login_bar_label_login'                   => 'strLoginBarLabelLogin',
      'florp_login_bar_label_logout'                  => 'strLoginBarLabelLogout',
      'florp_login_bar_label_profile'                 => 'strLoginBarLabelProfile',
      'florp_infowindow_template_organizer'           => 'strMarkerInfoWindowTemplateOrganizer',
      'florp_infowindow_template_teacher'             => 'strMarkerInfoWindowTemplateTeacher',
      'florp_signup_link_label'                       => 'strSignupLinkLabel',
      'florp_infowindow_label_organizer'              => 'strInfoWindowLabel_organizer',
      'florp_infowindow_label_teacher'                => 'strInfoWindowLabel_teacher',
      'florp_infowindow_label_signup'                 => 'strInfoWindowLabel_signup',
      'florp_infowindow_label_participant_count'      => 'strInfoWindowLabel_participant_count',
      'florp_infowindow_label_year'                   => 'strInfoWindowLabel_year',
      'florp_infowindow_label_dancers'                => 'strInfoWindowLabel_dancers',
      'florp_infowindow_label_school'                 => 'strInfoWindowLabel_school',
      'florp_infowindow_label_web'                    => 'strInfoWindowLabel_web',
      'florp_infowindow_label_facebook'               => 'strInfoWindowLabel_facebook',
      'florp_infowindow_label_note'                   => 'strInfoWindowLabel_note',
      'florp_infowindow_label_embed_code'             => 'strInfoWindowLabel_embed_code',
      'florp_infowindow_label_courses_info'           => 'strInfoWindowLabel_courses_info',
      'florp_courses_number_enabled'                  => 'iCoursesNumberEnabled',
      'florp_tshirt_payment_warning_notif_sbj'        => 'strTshirtPaymentWarningNotificationSbj',
      'florp_tshirt_payment_warning_notif_msg'        => 'strTshirtPaymentWarningNotificationMsg',
      'florp_tshirt_ordering_disabled'                => 'bTshirtOrderingDisabled',
      'florp_tshirt_ordering_only_disable'            => 'bTshirtOrderingDisabledOnlyDisable',
      'florp_only_florp_profile_nf_flashmob'          => 'bOnlyFlorpProfileNinjaFormFlashmob',
      'florp_only_florp_profile_nf_main'              => 'bOnlyFlorpProfileNinjaFormMain',
      'florp_tshirt_payment_warning_deadline'         => 'iTshirtPaymentWarningDeadline',
      'florp_tshirt_payment_warning_btn_deadline'     => 'iTshirtPaymentWarningButtonDeadline',
      'florp_tshirt_order_delivered_b4_flash_ddl'     => 'iTshirtOrderDeliveredBeforeFlashmobDdl',
      'florp_hide_flashmob_fields_individual'         => 'aHideFlashmobFieldsForUsers',
      'florp_unhide_flashmob_fields_individual'       => 'aUnhideFlashmobFieldsForUsers',
      'florp_intf_participant_registered_subject'     => 'strIntfParticipantRegisteredSubject',
      'florp_intf_participant_registered_message'     => 'strIntfParticipantRegisteredMessage',
      'florp_intf_tshirt_order_delivered_b4_flash_ddl'=> 'iIntfTshirtOrderDeliveredBeforeFlashmobDdl',
      'florp_intf_tshirt_ordering_disabled'           => 'bIntfTshirtOrderingDisabled',
      'florp_intf_tshirt_ordering_only_disable'       => 'bIntfTshirtOrderingDisabledOnlyDisable',
      'florp_intf_tshirt_payment_warning_btn_deadline'=> 'iIntfTshirtPaymentWarningButtonDeadline',
      'florp_intf_tshirt_payment_warning_deadline'    => 'iIntfTshirtPaymentWarningDeadline',
      'florp_intf_tshirt_payment_warning_notif_sbj'   => 'strIntfTshirtPaymentWarningNotificationSbj',
      'florp_intf_tshirt_payment_warning_notif_msg'   => 'strIntfTshirtPaymentWarningNotificationMsg',
      'florp_newsletter_lists_intf'                   => 'strNewsletterListsIntf',
      'florp_intf_flashmob_year'                      => 'iIntfFlashmobYear',
      'florp_intf_flashmob_month'                     => 'iIntfFlashmobMonth',
      'florp_intf_flashmob_day'                       => 'iIntfFlashmobDay',
      'florp_intf_flashmob_hour'                      => 'iIntfFlashmobHour',
      'florp_intf_flashmob_minute'                    => 'iIntfFlashmobMinute',
      'florp_intf_city_poll_deadline'                 => 'iIntfCityPollDeadline',
      'florp_intf_city_poll_users'                    => 'aIntfCityPollUsers',
      'florp_intf_city_poll_extra_cities'             => 'strIntfCityPollExtraCities',
    );
    $aDeprecatedKeys = array(
      // new => old //
      // OR: old //
      'iCurrentFlashmobYear',
      'bHideFlashmobFields',
      'bReloadAfterSuccessfulSubmissionMain,bReloadAfterSuccessfulSubmissionFlashmob' => 'bReloadAfterSuccessfulSubmission',
      'iProfileFormNinjaFormIDFlashmob' => 'iProfileFormNinjaFormID',
      'iProfileFormPopupIDFlashmob' => 'iProfileFormPopupID',
      'strGoogleMapsKey' => 'strGoogleMapKey',
      'bCoursesInfoDisabled',
      // 'aIntfCityPollUsers',
    );
    $this->aBooleanOptions = array(
      'bReloadAfterSuccessfulSubmissionMain', 'bReloadAfterSuccessfulSubmissionFlashmob',
      'bLoadMapsAsync', 'bLoadMapsLazy', 'bLoadVideosLazy', 'bUseMapImage',
      'bApproveUsersAutomatically',
      'bPreventDirectMediaDownloads',
      'bTshirtOrderingDisabled',
      'bTshirtOrderingDisabledOnlyDisable',
      'bOnlyFlorpProfileNinjaFormMain',
      'bOnlyFlorpProfileNinjaFormFlashmob',
      'bIntfTshirtOrderingDisabledOnlyDisable',
      'bIntfTshirtOrderingDisabled',
      'bTshirtOrdersAdminEnabled',
    );
    $this->aArrayOptions = array(
      'aHideFlashmobFieldsForUsers',
      'aUnhideFlashmobFieldsForUsers',
      'aIntfCityPollUsers',
    );
    $this->aOptionKeysByBlog = array(
      'main'      => array(
        'aYearlyMapOptions',
        'aParticipants',
        'aTshirts',
        'aTshirtsIntf',
        'bReloadAfterSuccessfulSubmissionMain',
        'iFlashmobYear',
        'iFlashmobMonth',
        'iFlashmobDay',
        'iFlashmobHour',
        'iFlashmobMinute',
        'iMainBlogID',
        'iNewsletterBlogID',
        'iCloneSourceBlogID',
        'iProfileFormNinjaFormIDMain',
        'iProfileFormPopupIDMain',
        'bLoadMapsLazy',
        'bLoadMapsAsync',
        'bLoadVideosLazy',
        'strVersion',
        'iProfileFormPageIDMain',
        'bApproveUsersAutomatically',
        'strPendingUserPageContentHTML',
        'strUserApprovedMessage',
        'strUserApprovedSubject',
        'strBeforeLoginFormHtmlMain',
        'strGoogleMapsKey',
        'strGoogleMapsKeyStatic',
        'strFbAppID',
        'strRegistrationSuccessfulMessage',
        'strLoginSuccessfulMessage',
        'bPreventDirectMediaDownloads',
        'strNewsletterAPIKey',
        'strNewsletterListsMain',
        'strLeaderParticipantListNotificationMsg',
        'strLeaderParticipantListNotificationSbj',
        'strLoginBarLabelLogin',
        'strLoginBarLabelLogout',
        'strLoginBarLabelProfile',
        'strMarkerInfoWindowTemplateOrganizer',
        'strMarkerInfoWindowTemplateTeacher',
        'strSignupLinkLabel',
        'strInfoWindowLabel_organizer',
        'strInfoWindowLabel_teacher',
        'strInfoWindowLabel_signup',
        'strInfoWindowLabel_participant_count',
        'strInfoWindowLabel_year',
        'strInfoWindowLabel_dancers',
        'strInfoWindowLabel_school',
        'strInfoWindowLabel_web',
        'strInfoWindowLabel_facebook',
        'strInfoWindowLabel_note',
        'strInfoWindowLabel_embed_code',
        'strInfoWindowLabel_courses_info',
        'iCoursesNumberEnabled',
        'bOnlyFlorpProfileNinjaFormMain',
        'aHideFlashmobFieldsForUsers',
        'aUnhideFlashmobFieldsForUsers',
        'bTshirtOrdersAdminEnabled',
      ),
      'flashmob'  => array(
        'iFlashmobBlogID',
        'bReloadAfterSuccessfulSubmissionFlashmob',
        'iProfileFormNinjaFormIDFlashmob',
        'iProfileFormPopupIDFlashmob',
        'bUseMapImage',
        'iProfileFormPageIDFlashmob',
        'strBeforeLoginFormHtmlFlashmob',
        'strNewsletterListsFlashmob',
        'strParticipantRegisteredMessage',
        'strParticipantRegisteredSubject',
        'strParticipantRemovedMessage',
        'strParticipantRemovedSubject',
        'strTshirtPaymentWarningNotificationSbj',
        'strTshirtPaymentWarningNotificationMsg',
        'bTshirtOrderingDisabled',
        'bTshirtOrderingDisabledOnlyDisable',
        'bOnlyFlorpProfileNinjaFormFlashmob',
        'iTshirtPaymentWarningDeadline',
        'iTshirtPaymentWarningButtonDeadline',
        'iTshirtOrderDeliveredBeforeFlashmobDdl',
      ),
      'international' => array(
        'iIntfBlogID',
        'iProfileFormPageIDIntf',
        'iProfileFormPopupIDIntf',
        'iProfileFormNinjaFormIDIntf',
        'strIntfParticipantRegisteredSubject',
        'iIntfTshirtOrderDeliveredBeforeFlashmobDdl',
        'bIntfTshirtOrderingDisabled',
        'bIntfTshirtOrderingDisabledOnlyDisable',
        'iIntfTshirtPaymentWarningButtonDeadline',
        'iIntfTshirtPaymentWarningDeadline',
        'strIntfTshirtPaymentWarningNotificationSbj',
        'strNewsletterListsIntf',
        'strBeforeLoginFormHtmlIntf',
        'iIntfFlashmobYear',
        'iIntfFlashmobMonth',
        'iIntfFlashmobDay',
        'iIntfFlashmobHour',
        'iIntfFlashmobMinute',
        'iIntfCityPollDeadline',
        'aIntfParticipants',
        'aIntfCityPollUsers',
        'strIntfCityPollExtraCities',
      ),
    );
    $this->aSeparateOptionKeys = array( 'logs', 'aParticipants', 'aIntfParticipants', 'aTshirts', 'aTshirtsIntf', 'aYearlyMapOptions', 'aOrderDates', 'aOptionChanges', 'aNfSubmissions', 'aNfFieldTypes' );

    // Get options and set defaults //
    if (empty($this->aOptions)) {
      // no options, set to defaults //
      $this->aOptions = $this->aOptionDefaults;
      $this->save_options();
    } else {
      // add missing options //
      $bUpdate = false;
      foreach($this->aSeparateOptionKeys as $strOptionKey) {
        $mixOptionValue = get_site_option( $this->strOptionKey . "-" . $strOptionKey, array() );
        if (empty($mixOptionValue)) {
          // This will use the value from $this->aOptions or set the default one //
          $bUpdate = true;
        } else {
          $this->aOptions[$strOptionKey] = $mixOptionValue;
        }
      }

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
        $this->save_options();
      }
    }
    if (empty($this->aOptions['aTshirtsIntf'])) {
      $this->aOptions['aTshirtsIntf'] = array();
      $this->aOptions['aTshirtsIntf'][$this->aOptions['iIntfFlashmobYear']] = array();
      $this->save_options();
    }
    // foreach ($this->aOptions['aIntfParticipants'][2019] as $key => $value) {
    //   $this->aOptions['aIntfParticipants'][2019][$key]['registered'] -= (7*24*3600);
    // }
    // $this->save_options();
    // $this->aOptions['bTshirtOrdersAdminEnabled'] = false;
    // $this->save_options();
    // END options //
  }

  private function get_options() {
    return $this->aOptions;
  }

  private function get_option( $strOptionKey ) {
    if (isset($this->aOptions[$strOptionKey])) {
      return $this->aOptions[$strOptionKey];
    }
    return false;
  }

  private function maybe_save_options($bSave = true) {
    if ($bSave) {
      $this->save_options();
    }
  }

  private function save_options() {
    $aOptionsRest = array();
    foreach ($this->aOptionDefaults as $strOptionKey => $mixDefaultValue) {
      $mixValue = $this->aOptions[$strOptionKey];
      if (in_array($strOptionKey, $this->aSeparateOptionKeys)) {
        update_site_option( $this->strOptionKey . "-" . $strOptionKey, $mixValue, true );
      } else {
        $aOptionsRest[$strOptionKey] = $mixValue;
      }
    }
    update_site_option( $this->strOptionKey, $aOptionsRest, true );
  }

  private function save_option( $strOptionKey, $strOptionValue ) {
    $this->aOptions[$strOptionKey] = $strOptionValue;
    $this->save_options();
  }

  private function migrate_subscribers( $iBlogFrom, $iBlogTo ) {
    $aArgsFlashmobBlogSubscribers = array(
      'blog_id' => $iBlogFrom,
      'role'    => $this->strUserRoleApproved
    );
    $aFlashmobBlogSubscribers = get_users( $aArgsFlashmobBlogSubscribers );
    foreach ($aFlashmobBlogSubscribers as $oUser) {
      add_user_to_blog( $iBlogTo, $oUser->ID, $this->strUserRoleApproved );
      remove_user_from_blog( $oUser->ID, $iBlogFrom );
    }
  }

  public function run_upgrades() {
    // $this->aOptions['strVersion'] = '0'; // NOTE DEVEL TEMP
    // $this->save_options(); // NOTE DEVEL TEMP

    //  // NOTE DEVEL TEMP
    // $this->aOptions['aYearlyMapOptions'][2013][22] = array (
    //   'first_name' => 'Jaroslav',
    //   'last_name' => 'Hluch a team',
    //   'flashmob_city' => 'Bratislava',
    //   'flashmob_number_of_dancers' => '16',
    //   'video_link_type' => 'youtube',
    //   'youtube_link' => 'https://www.youtube.com/watch?v=y_aSUdDk3Cw',
    //   'flashmob_address' => 'Nákupné centrum Polus, Bratislava',
    //   'longitude' => '17.138409',
    //   'latitude' => '48.168235',
    //   'webpage' => 'http://example.com',
    //   'school_webpage' => 'http://norika.sk',
    //   'note' => 'za video ďakujeme Michalovi Hrabovcovi (a teamu).',
    // );

    // Migrate users from Flashmob blog to main blog //
    $this->migrate_subscribers( $this->iFlashmobBlogID, $this->iMainBlogID );

    // Make needed meta changes //
    $aArgsMainBlogSubscribers = array(
      'blog_id' => $this->iMainBlogID,
    );
    $aMainBlogSubscribersUsers = get_users( $aArgsMainBlogUsers );

    $aOldVideoLinkMetaKeys = array(
      'facebook' => 'facebook_link',
      'youtube' => 'youtube_link',
      'vimeo' => 'vimeo_link',
      'e' => 'embed_code'
    );
    $strVideoLinkTypeMetaKey = "video_link_type";
    foreach ($aMainBlogSubscribersUsers as $key => $oUser) {
      // Remove deprecated meta //
      if (get_user_meta( $oUser->ID, 'som_organizator_rueda_flashmobu', true )) {
        delete_user_meta( $oUser->ID, 'som_organizator_rueda_flashmobu' );
      }

      // Transform subscriber_type meta to corresponding checkboxes //
      $mixSubscriberTypesOfUser = get_user_meta( $oUser->ID, 'subscriber_type', true );
      $aSubscriberTypesOfUser = array();
      if ("" === $mixSubscriberTypesOfUser) {
        // test via wpdb
        global $wpdb;
        $strQuery = "SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = {$oUser->ID} AND meta_key = 'flashmob_organizer'";
        $res = $wpdb->get_var($strQuery);
        if (!is_null($res)) {
          delete_user_meta( $oUser->ID, 'subscriber_type' );
        }
      } elseif (is_array($mixSubscriberTypesOfUser)) {
        if (empty($mixSubscriberTypesOfUser)) {
          delete_user_meta( $oUser->ID, 'subscriber_type' );
        } else {
          $aSubscriberTypesOfUser = $mixSubscriberTypesOfUser;
        }
      } else {
        $aSubscriberTypesOfUser = (array) $mixSubscriberTypesOfUser;
      }
      if (!empty($aSubscriberTypesOfUser)) {
        foreach ($this->aSubscriberTypes as $strType) {
          $sVal = '0';
          if (in_array($strType, $aSubscriberTypesOfUser)) {
            $sVal = '1';
          }
          update_user_meta( $oUser->ID, $strType, $sVal );
        }
        delete_user_meta( $oUser->ID, 'subscriber_type' );
      }

      // Copy school_city => flashmob_city, school_city => user_city //
      $strSchoolCity = get_user_meta( $oUser->ID, 'school_city', true );
      if (!empty($strSchoolCity)) {
        update_user_meta( $oUser->ID, 'user_city', $strSchoolCity );
        update_user_meta( $oUser->ID, 'flashmob_city', $strSchoolCity );
        delete_user_meta( $oUser->ID, 'school_city' );
      }

      // Change school_webpage => custom_webpage (and select 'vlastna' as school_webpage) //
      $strSchoolWebpage = get_user_meta( $oUser->ID, 'school_webpage', true );
      $strUserWebpage = get_user_meta( $oUser->ID, 'webpage', true );
      if (!empty($strSchoolWebpage) && !in_array($strSchoolWebpage, array('vlastna', 'flashmob', 'vytvorit'))) {
        update_user_meta( $oUser->ID, 'webpage', 'vlastna' );
        update_user_meta( $oUser->ID, 'custom_webpage', $strSchoolWebpage );
        if (!empty($strUserWebpage)) {
          update_user_meta( $oUser->ID, 'facebook', $strUserWebpage );
        }
      } elseif (in_array($strSchoolWebpage, array('vlastna', 'flashmob', 'vytvorit'))) {
        update_user_meta( $oUser->ID, 'webpage', $strSchoolWebpage );
        if (!empty($strUserWebpage)) {
          update_user_meta( $oUser->ID, 'facebook', $strUserWebpage );
        }
      }
      delete_user_meta( $oUser->ID, 'school_webpage' );

      // user_webpage => facebook //
      $strUserWebpage = get_user_meta( $oUser->ID, 'user_webpage', true );
      if (!empty($strUserWebpage)) {
        update_user_meta( $oUser->ID, 'facebook', $strUserWebpage );
        delete_user_meta( $oUser->ID, 'user_webpage' );
      }

      // custom_school_webpage => custom_webpage //
      $strCustomSchoolWebpage = get_user_meta( $oUser->ID, 'custom_school_webpage', true );
      if (!empty($strCustomSchoolWebpage)) {
        update_user_meta( $oUser->ID, 'custom_webpage', $strCustomSchoolWebpage );
        delete_user_meta( $oUser->ID, 'custom_school_webpage' );
      }

      // preferences:newsletter => preference_newsletter //
      // preferences:tshirt* => remove, it's automatic //
      $mixPreferencesOfUser = get_user_meta( $oUser->ID, 'preferences', true );
      $aPreferencesOfUser = array();
      if ("" === $mixPreferencesOfUser) {
        // test via wpdb
        global $wpdb;
        $strQuery = "SELECT meta_value FROM {$wpdb->usermeta} WHERE user_id = {$oUser->ID} AND meta_key = 'flashmob_organizer'";
        $res = $wpdb->get_var($strQuery);
        if (!is_null($res)) {
          delete_user_meta( $oUser->ID, 'preferences' );
        }
      } elseif (is_array($mixPreferencesOfUser)) {
        if (empty($mixPreferencesOfUser)) {
          delete_user_meta( $oUser->ID, 'preferences' );
        } else {
          $aPreferencesOfUser = $mixPreferencesOfUser;
        }
      } else {
        $aPreferencesOfUser = (array) $mixPreferencesOfUser;
      }
      if (!empty($aPreferencesOfUser)) {
        if (in_array("newsletter", $aPreferencesOfUser)) {
          update_user_meta( $oUser->ID, 'preference_newsletter', '1');
        }
        delete_user_meta( $oUser->ID, 'preferences' );
      }

      $strVideoLinkType = get_user_meta( $oUser->ID, $strVideoLinkTypeMetaKey, true );
      if ($strVideoLinkType && isset($aOldVideoLinkMetaKeys[$strVideoLinkType])) {
        $strVideoLink = get_user_meta( $oUser->ID, $aOldVideoLinkMetaKeys[$strVideoLinkType], true );
        if (!empty($strVideoLink)) {
          update_user_meta( $oUser->ID, 'video_link', $strVideoLink );
        }
        foreach ($aOldVideoLinkMetaKeys as $strLinkType => $strMetaKey) {
          delete_user_meta( $oUser->ID, $strMetaKey );
        }
        delete_user_meta( $oUser->ID, $strVideoLinkTypeMetaKey );
      }
    }

    // Upgrade archived map options as well //
    $bSaveOptions = false;
    foreach ($this->aOptions['aYearlyMapOptions'] as $iYear => $aUsersInYear) {
      foreach ($aUsersInYear as $iUserID => $aArchivedMeta) {
        if (isset($aArchivedMeta[$strVideoLinkTypeMetaKey])) {
          $bSaveOptions = true;
          $strVideoLinkType = $aArchivedMeta[$strVideoLinkTypeMetaKey];
          $strVideoLinkKey = $aOldVideoLinkMetaKeys[$strVideoLinkType];
          if (isset($aArchivedMeta[$strVideoLinkKey]) && !empty($aArchivedMeta[$strVideoLinkKey])) {
            $strVideoLink = $aArchivedMeta[$strVideoLinkKey];
            $this->aOptions['aYearlyMapOptions'][$iYear][$iUserID]['video_link'] = $strVideoLink;
          }
          foreach( $aOldVideoLinkMetaKeys as $strLinkType => $strMetaKey) {
            if (isset($aArchivedMeta[$strMetaKey])) {
              unset($this->aOptions['aYearlyMapOptions'][$iYear][$iUserID][$strMetaKey]);
            }
          }
          unset($this->aOptions['aYearlyMapOptions'][$iYear][$iUserID][$strVideoLinkTypeMetaKey]);
        }

        $strSchoolWebpage = $aArchivedMeta['school_webpage'];
        if (!empty($strSchoolWebpage) && !in_array($strSchoolWebpage, array('vlastna', 'flashmob', 'vytvorit'))) {
          $bSaveOptions = true;
          $this->aOptions['aYearlyMapOptions'][$iYear][$iUserID]['school_webpage'] = 'vlastna';
          $this->aOptions['aYearlyMapOptions'][$iYear][$iUserID]['custom_school_webpage'] = $strSchoolWebpage;
        }

        $strUserWebpage = $aArchivedMeta['webpage'];
        if (!empty($strUserWebpage)) {
          $bSaveOptions = true;
          $this->aOptions['aYearlyMapOptions'][$iYear][$iUserID]['user_webpage'] = $strUserWebpage;
          unset($this->aOptions['aYearlyMapOptions'][$iYear][$iUserID]['webpage']);
        }
      }
    }
    if ($bSaveOptions) {
      $this->save_options();
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
        update_user_meta( $oUser->ID, 'flashmob_organizer', '1' );
      }
    }

    if (version_compare( $strVersionInOptions, $strCurrentVersion, '<' )) {
      $this->aOptions['strVersion'] = $strCurrentVersion;
      $this->save_options();
    }

    $strOldExportPath = __DIR__ . '/nf-export/export.php';
    if (file_exists($strOldExportPath)) {
      rename($strOldExportPath, $this->strNinjaFormExportPathFlashmob);
    }

    // // BEGIN participant registration date import //
    // if (!$this->aOptions["bParticipantRegistrationProcessed"] && !empty($this->aOptions['aParticipants'])) {
    //   $aParticipantRegistrationDates = array(
    //     'erika.csicsaiova@skgeodesy.sk' => '17.09.2018',
    //     'k.siskova@zoznam.sk' => '17.09.2018',
    //     'jarohluch+1@gmail.com' => '17.09.2018',
    //     'martinbenkosj@gmail.com' => '17.09.2018',
    //     'anikorigoalmasi@gmail.com' => '16.09.2018',
    //     'rigoletto@pobox.sk' => '16.09.2018',
    //     'alenamachova30@gmail.com' => '16.09.2018',
    //     'jdtsikulova@gmail.com' => '16.09.2018',
    //     'zuzana.meszaros@gmail.com' => '16.09.2018',
    //     'furitimea86@gmail.com' => '15.09.2018',
    //     's.gaalova@pobox.sk' => '15.09.2018',
    //     'daniela.krasinska@gmail.com' => '15.09.2018',
    //     'evasevcova@yahoo.com' => '15.09.2018',
    //     'gaal.j@pobox.sk' => '15.09.2018',
    //     'iveta.neilinger@gmail.com' => '15.09.2018',
    //     'lengyeltibi1@gmail.com' => '15.09.2018',
    //     'ivonagreen@gmail.com' => '14.09.2018',
    //     'keszike@freemail.hu' => '14.09.2018',
    //     'farkasg324@gmail.com' => '14.09.2018',
    //     'szabi84@centrum.sk' => '14.09.2018',
    //     'jurajsmart@gmail.com' => '14.09.2018',
    //     'akatona81@gmail.com' => '13.09.2018',
    //     'blahutova.dominika@gmail.com' => '13.09.2018',
    //     'kerecsenx@freemail.hu' => '13.09.2018',
    //     'pavol.martinca@gmail.com' => '11.09.2018',
    //     'iivabla@gmail.com' => '09.09.2018',
    //   );
    //   $bUpdated = false;
    //   foreach ($this->aOptions['aParticipants'] as $iLeaderID => $aParticipants) {
    //     foreach ($aParticipants as $strEmail => $aParticipantData) {
    //       if (isset($aParticipantRegistrationDates[$strEmail]) && (!isset($this->aOptions['aParticipants'][$iLeaderID][$strEmail]['registered']) || $this->aOptions['aParticipants'][$iLeaderID][$strEmail]['registered'] === 0)) {
    //         $strDate = $aParticipantRegistrationDates[$strEmail];
    //         $aDateParts = explode( ".", $strDate );
    //         // $iTimeZoneOffset = get_option( 'gmt_offset', 0 );
    //         $iTime = mktime( 0, 0, 0, $aDateParts[1], $aDateParts[0], $aDateParts[2] );
    //         if ($iTime !== false) {
    //           $this->aOptions['aParticipants'][$iLeaderID][$strEmail]['registered'] = $iTime;
    //           $bUpdated = true;
    //         }
    //       }
    //     }
    //   }
    //   if ($bUpdated) {
    //     $this->save_options();
    //   }
    //   $this->aOptions["bParticipantRegistrationProcessed"] = true;
    //   $this->save_options();
    // }
    // // END participant registration date import //
  }

  private function set_variables() {
    foreach ($this->aOptions as $key => $val) {
      if ($key === "strVersion") {
        continue;
      }
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
    $this->iFlashmobTimestamp = intval(mktime( $this->aOptions['iFlashmobHour'] - $iTimeZoneOffset, $this->aOptions['iFlashmobMinute'], 0, $this->aOptions['iFlashmobMonth'], $this->aOptions['iFlashmobDay'], $this->aOptions['iFlashmobYear'] ));
    $this->iIntfFlashmobTimestamp = intval(mktime( $this->aOptions['iIntfFlashmobHour'] - $iTimeZoneOffset, $this->aOptions['iIntfFlashmobMinute'], 0, $this->aOptions['iIntfFlashmobMonth'], $this->aOptions['iIntfFlashmobDay'], $this->aOptions['iIntfFlashmobYear'] ));

    $iNow = time();
    if ($this->iFlashmobTimestamp < $iNow) {
      $this->bHideFlashmobFields = false;
    } else {
      $this->bHideFlashmobFields = true;
    }

    $this->aMarkerInfoWindowTemplates = array(
      'flashmob_organizer' => $this->aOptions['strMarkerInfoWindowTemplateOrganizer'],
      'teacher' => $this->aOptions['strMarkerInfoWindowTemplateTeacher'],
    );

    // Slovak Flashmob //
    // This is from when ordered tshirts are delivered after the flashmob; should be 23:59 on the date iTshirtOrderDeliveredBeforeFlashmobDdl days before flashmob //
    $this->iTshirtOrderDeliveredBeforeFlashmobDdlTimestamp = intval(mktime( 23 - $iTimeZoneOffset, 59, 59, $this->aOptions['iFlashmobMonth'], $this->aOptions['iFlashmobDay'] - $this->aOptions['iTshirtOrderDeliveredBeforeFlashmobDdl'], $this->aOptions['iFlashmobYear'] ));
    $this->iTshirtOrderDeliveredBeforeFlashmobDdlTime = date('Y/m/d H:i:s', $this->iTshirtOrderDeliveredBeforeFlashmobDdlTimestamp + $iTimeZoneOffset*3600);
    $this->iTshirtOrderDeliveredBeforeFlashmobDdlDate = date('d.m.Y', $this->iTshirtOrderDeliveredBeforeFlashmobDdlTimestamp + $iTimeZoneOffset*3600);

    // This is when the warnings are first shown; should be from 00:00 on the date iTshirtPaymentWarningDeadline days before flashmob //
    $this->iTshirtPaymentWarningDeadlineTimestamp = intval(mktime( 0 - $iTimeZoneOffset, 0, 0, $this->aOptions['iFlashmobMonth'], $this->aOptions['iFlashmobDay'] - $this->aOptions['iTshirtPaymentWarningDeadline'], $this->aOptions['iFlashmobYear'] ));
    $this->iTshirtPaymentWarningDeadlineTime = date('Y/m/d H:i:s', $this->iTshirtPaymentWarningDeadlineTimestamp + $iTimeZoneOffset*3600);

    // This is when the warning buttons are forced shown; should be from 00:00 on the date iTshirtPaymentWarningButtonDeadline days before flashmob //
    if ($this->aOptions['iTshirtPaymentWarningButtonDeadline'] > -1) {
      $this->iTshirtPaymentWarningButtonDeadlineTimestamp = intval(mktime( 0 - $iTimeZoneOffset, 0, 0, $this->aOptions['iFlashmobMonth'], $this->aOptions['iFlashmobDay'] - $this->aOptions['iTshirtPaymentWarningButtonDeadline'], $this->aOptions['iFlashmobYear'] ));
      $this->iTshirtPaymentWarningButtonDeadlineTime = date('Y/m/d H:i:s', $this->iTshirtPaymentWarningButtonDeadlineTimestamp + $iTimeZoneOffset*3600);
    } else {
      $this->iTshirtPaymentWarningButtonDeadlineTime = "-";
    }

    // International Flashmob //
    // This is from when ordered tshirts are delivered after the flashmob; should be 23:59 on the date iTshirtOrderDeliveredBeforeFlashmobDdl days before flashmob //
    $this->iIntfTshirtOrderDeliveredBeforeFlashmobDdlTimestamp = intval(mktime( 23 - $iTimeZoneOffset, 59, 59, $this->aOptions['iIntfFlashmobMonth'], $this->aOptions['iIntfFlashmobDay'] - $this->aOptions['iIntfTshirtOrderDeliveredBeforeFlashmobDdl'], $this->aOptions['iIntfFlashmobYear'] ));
    $this->iIntfTshirtOrderDeliveredBeforeFlashmobDdlTime = date('Y/m/d H:i:s', $this->iIntfTshirtOrderDeliveredBeforeFlashmobDdlTimestamp + $iTimeZoneOffset*3600);
    $this->iIntfTshirtOrderDeliveredBeforeFlashmobDdlDate = date('d.m.Y', $this->iIntfTshirtOrderDeliveredBeforeFlashmobDdlTimestamp + $iTimeZoneOffset*3600);

    // This is when the warnings are first shown; should be from 00:00 on the date iIntfTshirtPaymentWarningDeadline days before flashmob //
    $this->iIntfTshirtPaymentWarningDeadlineTimestamp = intval(mktime( 0 - $iTimeZoneOffset, 0, 0, $this->aOptions['iIntfFlashmobMonth'], $this->aOptions['iIntfFlashmobDay'] - $this->aOptions['iIntfTshirtPaymentWarningDeadline'], $this->aOptions['iIntfFlashmobYear'] ));
    $this->iIntfTshirtPaymentWarningDeadlineTime = date('Y/m/d H:i:s', $this->iIntfTshirtPaymentWarningDeadlineTimestamp + $iTimeZoneOffset*3600);

    // This is when the warning buttons are forced shown; should be from 00:00 on the date iIntfTshirtPaymentWarningButtonDeadline days before flashmob //
    if ($this->aOptions['iIntfTshirtPaymentWarningButtonDeadline'] > -1) {
      $this->iIntfTshirtPaymentWarningButtonDeadlineTimestamp = intval(mktime( 0 - $iTimeZoneOffset, 0, 0, $this->aOptions['iIntfFlashmobMonth'], $this->aOptions['iIntfFlashmobDay'] - $this->aOptions['iIntfTshirtPaymentWarningButtonDeadline'], $this->aOptions['iIntfFlashmobYear'] ));
      $this->iIntfTshirtPaymentWarningButtonDeadlineTime = date('Y/m/d H:i:s', $this->iIntfTshirtPaymentWarningButtonDeadlineTimestamp + $iTimeZoneOffset*3600);
    } else {
      $this->iIntfTshirtPaymentWarningButtonDeadlineTime = "-";
    }

    // This is from when the city poll is closed; should be 23:59 on the date iIntfCityPollDeadline days before flashmob //
    $this->iIntfCityPollDdlTimestamp = intval(mktime( 23 - $iTimeZoneOffset, 59, 59, $this->aOptions['iIntfFlashmobMonth'], $this->aOptions['iIntfFlashmobDay'] - $this->aOptions['iIntfCityPollDeadline'], $this->aOptions['iIntfFlashmobYear'] ));
    $this->iIntfCityPollDdlTime = date('Y/m/d H:i:s', $this->iIntfCityPollDdlTimestamp + $iTimeZoneOffset*3600);
    $this->iIntfCityPollDdlDate = date('d.m.Y', $this->iIntfCityPollDdlTimestamp + $iTimeZoneOffset*3600);
    $this->bIntfCityPollDisabled = ($this->iIntfCityPollDdlTimestamp <= time());


    $this->set_variables_per_subsite();
  }

  private function set_variables_per_subsite() {
    $iCurrentBlogID = get_current_blog_id();
    $this->isMainBlog = ($iCurrentBlogID == $this->iMainBlogID);
    $this->isFlashmobBlog = ($iCurrentBlogID == $this->iFlashmobBlogID);
    $this->isIntfBlog = ($iCurrentBlogID == $this->iIntfBlogID);
  }

  private function get_registration_user_role() {
    if ($this->aOptions['bApproveUsersAutomatically']) {
      return $this->strUserRoleApproved;
    } else {
      return $this->strUserRolePending;
    }
  }

  private function get_admin_notices( $strType ) {
    $aNotices = array();
    switch ($strType) {
      case 'htaccess_remove_failed':
        $aNotices[] = array( 'warning' => 'Could not re-enable media files download: could not remove HTACCESS file.' );
        break;
      case 'htaccess_revert_failed':
        $aNotices[] = array( 'warning' => 'Could not re-enable media files download: could not rename old HTACCESS file to <code>.htaccess</code>.' );
        break;
      case 'htaccess_rename_failed':
        $aNotices[] = array( 'warning' => 'Could not prevent media files download: could not rename HTACCESS file.' );
        break;
      case 'htaccess_renamed':
        $aNotices[] = array( 'info' => 'There was an HTACCESS in WP_CONTENT_DIR. It was renamed and replaced by a media download preventing HTACCESS file (by FLORP).' );
        break;
      case 'htaccess_save_failed':
        $aNotices[] = array( 'warning' => 'Could not prevent media files download: could not save HTACCESS file.' );
        break;
      case 'florp_devel_is_on':
        $aNotices[] = array( 'warning' => 'FLORP_DEVEL constant is on. Contact your site admin if you think this is not right!' );
        if (defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
          $aNotices[] = array( 'warning' => 'FLORP_DEVEL_FAKE_ACTIONS constant is on.' );
        }
        if (defined('FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION') && FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION === true) {
          $aNotices[] = array( 'warning' => 'Flashmob organizer map archivation is off!' );
        }
        break;
      case 'florp_edit_submissions_is_on':
        if (defined('FLORP_EDIT_SUBMISSIONS') && FLORP_EDIT_SUBMISSIONS === true) {
          $aNotices[] = array( 'warning' => 'FLORP_EDIT_SUBMISSIONS constant is on.' );
        }
        break;
      case 'florp_devel_purge_participants_save_is_on':
        $aNotices[] = array( 'warning' => 'FLORP_DEVEL_PURGE_PARTICIPANTS_ON_SAVE constant is on. Contact your site admin if you think this is not right!' );
        break;
      case 'florp_devel_purge_tshirts_save_is_on':
        $aNotices[] = array( 'warning' => 'FLORP_DEVEL_PURGE_TSHIRTS_ON_SAVE constant is on. Contact your site admin if you think this is not right!' );
        break;
      case 'lwa_is_active':
        $aNotices[] = array( 'error' => 'Nepodarilo sa automaticky deaktivovať plugin "Login With Ajax". Prosíme, spravte tak pre najlepšie fungovanie pluginu "Profil organizátora SVK flashmobu".' );
        break;
    }

    $strNotices = "";
    foreach ($aNotices as $aOneNotice) {
      foreach ($aOneNotice as $strNoticeType => $strNoticeText) {
        $strNotices .= '<div class="notice notice-'.$strNoticeType.'"><p>'.$strNoticeText.'</p></div>'.PHP_EOL;
      }
    }
    return $strNotices;
  }

  private function prevent_direct_media_downloads($bForce = false) {
    if (!current_user_can('administrator') || !is_admin()) {
      return;
    }

    $strHtaccessPath = WP_CONTENT_DIR . "/.htaccess";
    if (!$this->aOptions['bPreventDirectMediaDownloads']) {
      // Remove htaccess file if present //
      if (file_exists($strHtaccessPath)) {
        $bRes = unlink( $strHtaccessPath );
        if (!$bRes || file_exists($strHtaccessPath)) {
          // Show error message //
          add_action( 'admin_notices', array( $this, 'action__admin_notices__htaccess_remove_failed' ));
          return;
        }
        foreach (scandir(WP_CONTENT_DIR, SCANDIR_SORT_DESCENDING) as $strFileOrDirName) {
          if (strpos($strFileOrDirName, '.htaccess.old-')) {
            $bRes = rename( WP_CONTENT_DIR.'/'.$strFileOrDirName, $strHtaccessPath );
            if (!$bRes) {
              // Show error message
              add_action( 'admin_notices', array( $this, 'action__admin_notices__htaccess_revert_failed' ));
              return;
            }
            break;
          }
        }
      }
      return;
    }

    $bHtaccessExists = false;
    $strComment = '# FLORP: Prevent direct download of media files';
    if (file_exists($strHtaccessPath)) {
      if (!$bForce) {
        if (filemtime($strHtaccessPath) <= (time() - 12*3600)) {
          $bForce = true;
        } else {
          return;
        }
      }
      $strContents = file_get_contents( $strHtaccessPath );
      if (false !== strpos( $strContents, $strComment )) {
        // OK - comment is in the file that is present //
        $bHtaccessExists = true;
      } else {
        $bRes = rename( $strHtaccessPath, $strHtaccessPath.'.old-'.date('Ymd-His'));
        if ($bRes) {
          // Show info message //
          add_action( 'admin_notices', array( $this, 'action__admin_notices__htaccess_renamed' ));
        } else {
          // Show error message and finish //
          add_action( 'admin_notices', array( $this, 'action__admin_notices__htaccess_rename_failed' ));
          return;
        }
      }
    }

    $aMediaDlPreventionRuleLines = array(
      "{$strComment}",
      "<IfModule mod_rewrite.c>",
      "  RewriteEngine On",
      "  RewriteCond %{REQUEST_URI} \.(mp4|mp3|avi)$ [NC]",
    );
    $bSiteMissing = false;
    $aSites = wp_get_sites();
    $strProtocol = is_ssl() ? 'https' : 'http';
    foreach ( $aSites as $i => $aSite ) {
      if ($aSite['public'] != 1 || $aSite['deleted'] == 1 || $aSite['archived'] == 1) {
        continue;
      }
      $strLine1 = "  RewriteCond %{HTTP_REFERER} !^{$strProtocol}://{$aSite['domain']}$ [NC]";
      $strLine2 = "  RewriteCond %{HTTP_REFERER} !^{$strProtocol}://{$aSite['domain']}/.*$ [NC]";
      $aMediaDlPreventionRuleLines[] = $strLine1;
      $aMediaDlPreventionRuleLines[] = $strLine2;
      if ($bHtaccessExists && (false === strpos( $strContents, $aSite['domain'] ) || false === strpos( $strContents, $strLine1 ) || false === strpos( $strContents, $strLine2 ))) {
        $bSiteMissing = true;
      }
    }

    $aMediaDlPreventionRuleLines = array_merge($aMediaDlPreventionRuleLines, array(
      "  RewriteRule ^.* - [F,L]",
      "</IfModule>",
    ));
    $strMediaDlPreventionRules = implode( PHP_EOL, $aMediaDlPreventionRuleLines );

    if ($bForce || !$bHtaccessExists || $bSiteMissing) {
      // Do write //
      $bRes = file_put_contents( $strHtaccessPath, $strMediaDlPreventionRules );
      if (false === $bRes || !file_exists($strHtaccessPath)) {
        // Show error message
        add_action( 'admin_notices', array( $this, 'action__admin_notices__htaccess_save_failed' ));
        return;
      }
    } elseif (!$bForce) {
      // Touch //
      touch( $strHtaccessPath );
    }

    return;
  }

  private function get_newsletter_subscriber( $strEmail ) {
    if ($this->aOptions['iNewsletterBlogID'] === 0) {
      return array();
    }
    global $wpdb;
    $strBlogPrefix = $wpdb->get_blog_prefix($this->aOptions['iNewsletterBlogID']);
    $strNewsletterTable = $strBlogPrefix . 'newsletter';
    $strQuery = $wpdb->prepare( 'SELECT * FROM '.$strNewsletterTable.' WHERE `email` = %s', $strEmail );

    $aRow = $wpdb->get_row( $strQuery, ARRAY_A );
    if ( null === $aRow ) {
      return array();
    }
    return $aRow;
  }

  private function is_newsletter_subscriber( $strEmail ) {
    // TODO: check also LISTs of the subscriber  //
    $aRow = $this->get_newsletter_subscriber( $strEmail );
    if ($aRow) {
      return isset($aRow["status"]) && $aRow["status"] === "C"; // Confirmed //
    }
    return false;
  }

  private function execute_newsletter_rest_api_call( $strAction = '', $aData = array() ) {
    if ($this->aOptions['iNewsletterBlogID'] === 0) {
      return array( 'error' => "Newsletter blog ID is not set!" );
    }

    $strURL = get_home_url( $this->aOptions['iNewsletterBlogID'], '/wp-json/newsletter/v1/'.$strAction );
    if ($this->isMainBlog) {
      $strLists = $this->aOptions['strNewsletterListsMain'];
    } elseif ($this->isFlashmobBlog) {
      $strLists = $this->aOptions['strNewsletterListsFlashmob'];
    } else {
      return array( 'error' => "Not on either of main or flashmob blogs!" );
    }

    if (!isset($aData['email'])) {
      return array( 'error' => "Email is missing!" );
    }
    if (strlen(trim($this->aOptions['strNewsletterAPIKey'])) > 0) {
      $aData = array_merge( $aData, array(
        'api_key' => trim($this->aOptions['strNewsletterAPIKey']),
      ));
    }
    $bIsSubscriber = $this->is_newsletter_subscriber( $aData['email'] );

    if (($bIsSubscriber && $strAction === "subscribe") || (!$bIsSubscriber && ($strAction === "unsubscribe" /*|| $strAction === "subscribers/delete"*/))) {
      return array(
        'ok' => $bIsSubscriber ? "{$aData['email']} is a confirmed subscriber already" : "{$aData['email']} is not subscribed",
        'action' => $strAction,
        'request' => array(),
        'full-response' => array( 'bIsSubscriber' => $bIsSubscriber, 'strAction' => $strAction, 'strEmail' => $aData['email'] ),
      );
    }

    $aRequestArgs = array(
      'method' => 'POST',
      'timeout' => 15,
      // 'redirection' => 5,
      // 'httpversion' => '1.0',
      // 'blocking' => true,
      'headers' => array(
        "content-type" => "application/json",
      ),
    );

    switch ($strAction) {
      case 'subscribe':
        if (strlen(trim($strLists)) > 0) {
          $aData = array_merge( $aData, array(
            'lists' => array_map( "trim", explode( ',', $strLists ) ),
          ));
        }
        $aRequestArgs['body'] = json_encode($aData);
        break;
      case 'unsubscribe':
      case 'subscribers/delete':
        $aDelData = array(
          'email'   => $aData['email'],
          'api_key' => $aData['api_key'],
        );
        if (isset($aData['send_emails'])) {
          $aDelData['send_emails'] = $aData['send_emails'];
        }
        $aRequestArgs['body'] = json_encode( $aDelData );
        break;
      default:
        return array( 'error' => "Invalid action!" );
    }

    // $ curl -X POST http://<your-site>/wp-json/newsletter/v1/subscribe -d '{"email":"test@example.com", "name":"My name", "gender":"f"}'
    $mixResponse = wp_remote_post( $strURL, $aRequestArgs );

    if ( is_wp_error( $mixResponse ) ) {
      return array( 'error' => $mixResponse->get_error_message(), 'request' => $aRequestArgs );
    } else {
      $strResponseBody = $mixResponse['body'];
      $aResponseBody = json_decode( $strResponseBody, true );
      $aResponse = $mixResponse['response'];
      if ($aResponse['code'] < 400 && $aResponseBody && (is_array($aResponseBody) || $aResponseBody === 'OK')) {
        return array( 'ok' => $aResponseBody, 'action' => $strAction, 'request' => $aRequestArgs, 'full-response' => $mixResponse );
      } else {
        if ($strAction === 'subscribe' && $aResponseBody && is_array($aResponseBody) && $aResponseBody['message'] === "Email address already exists") {
          return array( 'body' => $aResponseBody, 'action' => $strAction, 'request' => $aRequestArgs, 'issue' => 'email-exists', 'full-response' => $mixResponse );
        } elseif (($strAction === 'unsubscribe' || $strAction === 'subscribers/delete') && $aResponse['code'] === 404) {
          return array( 'ok' => $aResponseBody, 'action' => $strAction, 'request' => $aRequestArgs, 'full-response' => $mixResponse );
        }
        return array( 'body' => $aResponseBody, 'action' => $strAction, 'request' => $aRequestArgs, 'full-response' => $mixResponse );
      }
    }
  }

  public function action__plugins_loaded() {
    $this->run_upgrades();
    $this->set_variables_per_subsite();

    $this->prevent_direct_media_downloads();

    // Add and/or clean up user roles //
    if ($this->isMainBlog) {
      if (!get_role($this->strUserRolePending)) {
        add_role($this->strUserRolePending, $this->strUserRolePendingName, array());
      }
      $oRole = get_role($this->strUserRoleRegistrationAdminSvk);
      if (!$oRole) {
        $oRole = add_role($this->strUserRoleRegistrationAdminSvk, $this->strUserRoleRegistrationAdminSvkName, array('read', $this->strUserRoleRegistrationAdminSvk));
      } else {
        if (!$oRole->has_cap($this->strUserRoleRegistrationAdminSvk)) {
          $oRole->add_cap($this->strUserRoleRegistrationAdminSvk);
        }
        if (!$oRole->has_cap('read')) {
          $oRole->add_cap('read');
        }
      }
    } elseif (get_role($this->strUserRolePending)) {
      $aPendingArgs = array(
        'blog_id' => get_current_blog_id(),
        'role'    => $this->strUserRolePending
      );
      $aPendingUsers = get_users( $aPendingArgs );
      if (empty($aPendingUsers)) {
        remove_role($this->strUserRolePending);
      }
    }
    if ($this->isFlashmobBlog) {
      $oRole = get_role($this->strUserRoleRegistrationAdmin);
      if (!$oRole) {
        $oRole = add_role($this->strUserRoleRegistrationAdmin, $this->strUserRoleRegistrationAdminName, array('read', $this->strUserRoleRegistrationAdminSvk, $this->strUserRoleRegistrationAdminIntf));
      } else {
        if (!$oRole->has_cap($this->strUserRoleRegistrationAdminSvk)) {
          $oRole->add_cap($this->strUserRoleRegistrationAdminSvk);
        }
        if (!$oRole->has_cap($this->strUserRoleRegistrationAdminIntf)) {
          $oRole->add_cap($this->strUserRoleRegistrationAdminIntf);
        }
        if (!$oRole->has_cap('read')) {
          $oRole->add_cap('read');
        }
      }
      $oRole = get_role($this->strUserRoleRegistrationAdminSvk);
      if (!$oRole) {
        $oRole = add_role($this->strUserRoleRegistrationAdminSvk, $this->strUserRoleRegistrationAdminSvkName, array('read', $this->strUserRoleRegistrationAdminSvk));
      } else {
        if (!$oRole->has_cap($this->strUserRoleRegistrationAdminSvk)) {
          $oRole->add_cap($this->strUserRoleRegistrationAdminSvk);
        }
        if (!$oRole->has_cap('read')) {
          $oRole->add_cap('read');
        }
      }
      $oRole = get_role($this->strUserRoleRegistrationAdminIntf);
      if (!$oRole) {
        $oRole = add_role($this->strUserRoleRegistrationAdminIntf, $this->strUserRoleRegistrationAdminIntfName, array('read', $this->strUserRoleRegistrationAdminIntf));
      } else {
        if (!$oRole->has_cap($this->strUserRoleRegistrationAdminIntf)) {
          $oRole->add_cap($this->strUserRoleRegistrationAdminIntf);
        }
        if (!$oRole->has_cap('read')) {
          $oRole->add_cap('read');
        }
      }
    }
    if ($this->isMainBlog || $this->isFlashmobBlog) {
      foreach ($GLOBALS['wp_roles']->role_objects as $key => $oRole) {
        if ($oRole->has_cap('manage_options') && !$oRole->has_cap($this->strUserRoleRegistrationAdminSvk)) {
          $oRole->add_cap($this->strUserRoleRegistrationAdminSvk);
        }
        if ($oRole->has_cap('manage_options') && !$oRole->has_cap($this->strUserRoleRegistrationAdminIntf)) {
          $oRole->add_cap($this->strUserRoleRegistrationAdminIntf);
        }
      }
    }

    // Deactivate and include LWA on main blog //
    if ($this->isMainBlog) {
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
  }

  public function action__init() {
    if (is_admin() && current_user_can( 'activate_plugins' ) && defined('FLORP_DEVEL') && FLORP_DEVEL === true) {
      add_action( 'admin_notices', array( $this, 'action__admin_notices__florp_devel_is_on' ));
    }
    if (is_admin() && current_user_can( 'activate_plugins' ) && defined('FLORP_EDIT_SUBMISSIONS') && FLORP_EDIT_SUBMISSIONS === true) {
      add_action( 'admin_notices', array( $this, 'action__admin_notices__florp_edit_submissions_is_on' ));
    }
    if (is_admin() && current_user_can( 'activate_plugins' ) && defined('FLORP_DEVEL_PURGE_PARTICIPANTS_ON_SAVE') && FLORP_DEVEL_PURGE_PARTICIPANTS_ON_SAVE === true) {
      add_action( 'admin_notices', array( $this, 'action__admin_notices__florp_devel_purge_participants_save_is_on' ));
    }
    if (is_admin() && current_user_can( 'activate_plugins' ) && defined('FLORP_DEVEL_PURGE_TSHIRTS_ON_SAVE') && FLORP_DEVEL_PURGE_TSHIRTS_ON_SAVE === true) {
      add_action( 'admin_notices', array( $this, 'action__admin_notices__florp_devel_purge_tshirts_save_is_on' ));
    }

    if (is_admin() && current_user_can( $this->strUserRoleRegistrationAdminIntf ) && isset($_POST['florp-download-intf-participant-csv'])) {
      $this->serveParticipantCSV(true);
    }
    if (is_admin() && current_user_can( $this->strUserRoleRegistrationAdminSvk ) && isset($_POST['florp-download-participant-csv'])) {
      $this->serveParticipantCSV();
    }
    if (is_admin() && current_user_can( $this->strUserRoleRegistrationAdminIntf ) && isset($_POST['florp-download-intf-tshirt-csv'])) {
      $this->serveTshirtCSV(true);
    }
    if (is_admin() && current_user_can( $this->strUserRoleRegistrationAdminSvk ) && isset($_POST['florp-download-tshirt-csv'])) {
      $this->serveTshirtCSV();
    }

    if (is_admin() && current_user_can( 'activate_plugins' )) {
      // Set cookie for leader submission history view //
      $strCookieKey = $this->strLeaderSubmissionHistoryViewsCookieKey;
      $aViews = $this->aLeaderSubmissionHistoryViews;
      if (isset($_POST) && isset($_POST['view']) && in_array($_POST['view'], $aViews)) {
        $strView = $_POST['view'];
        setcookie($strCookieKey, $strView, time() + (365 * 24 * 60 * 60), '/');
      } elseif (isset($_COOKIE) && isset($_COOKIE[$strCookieKey]) && in_array($_COOKIE[$strCookieKey], $aViews)) {
        // OK //
        $strView = $_COOKIE[$strCookieKey];
      } else {
        $strView = $aViews[0];
        setcookie($strCookieKey, $strView, time() + (365 * 24 * 60 * 60), '/');
      }
      if (!isset($_COOKIE[$strCookieKey]) && isset($strView)) {
        setcookie($strCookieKey, $strView, time() + (365 * 24 * 60 * 60), '/');
      }
      $this->strLeaderSubmissionHistoryView = $strView;
    }
  }

  public function action__admin_notices__lwa_is_active() {
    echo $this->get_admin_notices('lwa_is_active');
  }

  public function action__admin_notices__florp_devel_is_on() {
    echo $this->get_admin_notices('florp_devel_is_on');
  }

  public function action__admin_notices__florp_edit_submissions_is_on() {
    echo $this->get_admin_notices('florp_edit_submissions_is_on');
  }

  public function action__admin_notices__florp_devel_purge_participants_save_is_on() {
    echo $this->get_admin_notices('florp_devel_purge_participants_save_is_on');
  }

  public function action__admin_notices__florp_devel_purge_tshirts_save_is_on() {
    echo $this->get_admin_notices('florp_devel_purge_tshirts_save_is_on');
  }

  public function action__admin_notices__htaccess_remove_failed() {
    if (!current_user_can('administrator') || !is_admin()) {
      return;
    }
    echo $this->get_admin_notices('htaccess_remove_failed');
  }

  public function action__admin_notices__htaccess_rename_failed() {
    if (!current_user_can('administrator') || !is_admin()) {
      return;
    }
    echo $this->get_admin_notices('htaccess_rename_failed');
  }

  public function action__admin_notices__htaccess_renamed() {
    if (!current_user_can('administrator') || !is_admin()) {
      return;
    }
    echo $this->get_admin_notices('htaccess_renamed');
  }

  public function action__admin_notices__htaccess_revert_failed() {
    if (!current_user_can('administrator') || !is_admin()) {
      return;
    }
    echo $this->get_admin_notices('htaccess_revert_failed');
  }

  public function action__admin_notices__htaccess_save_failed() {
    if (!current_user_can('administrator') || !is_admin()) {
      return;
    }
    echo $this->get_admin_notices('htaccess_save_failed');
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
    } elseif ($this->isIntfBlog && $iFormID == $this->iProfileFormNinjaFormIDIntf) {
      $this->bDisplayingProfileFormNinjaForm = true;
    }
    return $aFormSettings;
  }

  public function action__displaying_profile_form_nf_end( $iFormID, $aFormSettings, $aFormFields ) {
    if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_DEBUG_PARTICIPANT_EDIT_FORMS') && FLORP_DEVEL_DEBUG_PARTICIPANT_EDIT_FORMS === true) {
      $bLoggedIn = is_user_logged_in(); // TODO DEVEL
      if ($this->bDisplayingProfileFormNinjaForm && $iFormID == $this->iProfileFormNinjaFormIDIntf && $bLoggedIn && $GLOBALS['florp-intf-participant-form-edit']) {
        $iYear = $_REQUEST['year'];
        $strEmail = $_REQUEST['email'];
        $aParticipantData = $this->aOptions['aIntfParticipants'][$iYear][$strEmail];
        echo "<pre>"; var_dump($aParticipantData); echo "</pre>";
      }
      if ($this->bDisplayingProfileFormNinjaForm && $iFormID == $this->iProfileFormNinjaFormIDFlashmob && $bLoggedIn && $GLOBALS['florp-svk-participant-form-edit']) {
        $iLeaderID = $_REQUEST['leader_id'];
        $strEmail = $_REQUEST['email'];
        $aParticipantData = $this->aOptions['aParticipants'][$iLeaderID][$strEmail];
        echo "<pre>"; var_dump($aParticipantData); echo "</pre>";
      }
    }
    $this->bDisplayingProfileFormNinjaForm = false;
  }

  private function get_intf_poll_cities() {
    $aLeaders = $this->getFlashmobSubscribers( 'all', true );
    $aLeadersByID = array();
    foreach ($aLeaders as $oLeader) {
      $aLeadersByID[$oLeader->ID] = $oLeader;
    }
    $aFlashmobCities = array();
    foreach ($this->aOptions['aIntfCityPollUsers'] as $mixUserIDOrFlashmobCity) {
      if (is_int($mixUserIDOrFlashmobCity) || (is_string($mixUserIDOrFlashmobCity) && preg_match('~\d+~', $mixUserIDOrFlashmobCity))) {
        if (isset($aLeadersByID[$mixUserIDOrFlashmobCity])) {
          $strFlashmobCity = get_user_meta( $mixUserIDOrFlashmobCity, 'flashmob_city', true );
          if (empty($strFlashmobCity)) {
            continue;
          }
          $aFlashmobCities[] = $strFlashmobCity;
        } else {
          continue;
        }
      } else {
        $aFlashmobCities[] = $mixUserIDOrFlashmobCity;
      }
    }
    if (!empty($this->aOptions['strIntfCityPollExtraCities'])) {
      $aExtraCities = array_map('trim', explode(',', $this->aOptions['strIntfCityPollExtraCities']));
      foreach ($aExtraCities as $strFlashmobCity) {
        $aFlashmobCities[] = $strFlashmobCity;
      }
    }
    sort($aFlashmobCities);
    return $aFlashmobCities;
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

    if (stripos($aField['settings']['container_class'], 'florp-intf') !== false) {
      // Settings specific to the international signup form //

      // Populate the poll options //
      if ($aField['settings']['key'] == 'intf_city') {
        if ($this->bIntfCityPollDisabled) {
          $aField['settings']['required'] = false;
          $aField['settings']['container_class'] .= " florp-hidden";
        } else {
          $aFlashmobCities = $this->get_intf_poll_cities();
          if (!empty($aFlashmobCities)) {
            reset($aField['settings']['options']);
            $iFirstKey = key($aField['settings']['options']);
            $aOption = $aField['settings']['options'][$iFirstKey];
            foreach ($aFlashmobCities as $strFlashmobCity) {
              $aOption["label"] = $strFlashmobCity;
              $aOption["value"] = $strFlashmobCity;
              $aField['settings']['options'][] = $aOption;
            }
          }
        }
      }

      // Set default value of tshirt preference to unchecked if ordering is disabled //
      if ($this->aOptions['bIntfTshirtOrderingDisabled'] && $aField['settings']['type'] === 'listcheckbox' && $aField['settings']['key'] === 'preferences') {
        foreach ($aField['settings']['options'] as $iKey => $aOption) {
          if ($aOption['value'] === 'flashmob_participant_tshirt') {
            $aField['settings']['options'][$iKey]['selected'] = 0;
            break;
          }
        }
      }

      // Hide tshirt payment deadline warning if it's not relevant yet //
      if ($aField['settings']['type'] === 'html' && isset($aField['settings']['container_class']) && stripos($aField['settings']['container_class'], 'florp-tshirt-after-flashmob-warning') !== false) {
        $aField['settings']['default'] = str_replace("%%iTshirtOrderDeliveredBeforeFlashmobDdlDate%%", $this->iIntfTshirtOrderDeliveredBeforeFlashmobDdlDate, $aField['settings']['default']);
        if ($this->iIntfTshirtPaymentWarningDeadlineTimestamp > time()) {
          $aField['settings']['container_class'] .= " florp-hidden";
        }
      }

      // Hide non-profile and non-registration fields //
      $bHide = true;
      if (stripos($aField['settings']['container_class'], 'florp-registration-field') !== false
            || stripos($aField['settings']['container_class'], 'florp-profile-field') !== false) {
        $bHide = false;
      }
      if ($bHide) {
        $aField['settings']['container_class'] .= " hidden";
      }
    } elseif ($this->isMainBlog) {
      // Settings specific to the NF on the Main Blog //

      // Replace flashmob date/time in flashmob_organizer single checkbox //
      if ('checkbox' === $aField['settings']['type'] && 'flashmob_organizer' === $aField['settings']['key']) {
        $aPatterns = array(
          '~{flashmob_date(\[[^\]]*\])?}~' => get_option('date_format'),
          '~{flashmob_time(\[[^\]]*\])?}~' => get_option('time_format'),
        );
        foreach ($aPatterns as $strPattern => $strDefaultFormat) {
          $aMatches = array();
          if (preg_match_all( $strPattern, $aField['settings']['label'], $aMatches )) {
            foreach ($aMatches[0] as $iKey => $strMatchFull) {
              if (empty($aMatches[1][$iKey])) {
                $strFormat = $strDefaultFormat;
              } else {
                $strFormat = trim($aMatches[1][$iKey], "[]");
              }
              $strTimeOrDate = date( $strFormat, $this->iFlashmobTimestamp );
              $aField['settings']['label'] = str_replace( $strMatchFull, $strTimeOrDate, $aField['settings']['label'] );
            }
          }
        }
      }

      if ($bLoggedIn) {
        $iUserID = get_current_user_id();

        // Set newsletter preference //
        if ($aField['settings']['type'] === 'listcheckbox' && $aField['settings']['key'] === 'preference_newsletter') {
          $oUser = get_user_by( 'id', $iUserID );
          $bIsNewsletterSubscriber = $this->is_newsletter_subscriber( $oUser->user_email );
          $aField['settings']['options'][0]['selected'] = $bIsNewsletterSubscriber ? 1 : 0;
        }

        // Set checked as default value on checkboxes saved as checked //
        if ($aField['settings']['type'] === 'checkbox') {
          $strValue = get_user_meta( $iUserID, $aField['settings']['key'], true );
          $aField['settings']['default_value'] = ($strValue == '1') ? 'checked' : 'unchecked';
        }
        if ($aField['settings']['type'] === 'listradio') {
          $strValue = get_user_meta( $iUserID, $aField['settings']['key'], true );
          foreach ($aField['settings']['options'] as $iKey => $aOption) {
            $aField['settings']['options'][$iKey]['selected'] = 0;
            if ($aOption['value'] === $strValue) {
              $aField['settings']['options'][$iKey]['selected'] = 1;
            }
          }
        }
        if ($aField['settings']['type'] === 'listselect') {
          $strValue = get_user_meta( $iUserID, $aField['settings']['key'], true );
          foreach ($aField['settings']['options'] as $iKey => $aOption) {
            if ($aOption['value'] === $strValue) {
              $aField['settings']['options'][$iKey]['selected'] = 1;
            }
          }
        }

        if (isset($aField['settings']['container_class'])) {
          // Hide fields //
          $bHide = true;
          if (stripos($aField['settings']['container_class'], 'florp-registration-field') !== false
                  || stripos($aField['settings']['container_class'], 'florp-profile-field') !== false) {
            $bHide = false;
          } else {
            // Go through subscriber types of user and leave field unhidden if matched //
            if (isset($aSubscriberTypesOfUser) && is_array($aSubscriberTypesOfUser) && !empty($aSubscriberTypesOfUser)) {
              foreach ($aSubscriberTypesOfUser as $strSubscriberType) {
                if (stripos($aField['settings']['container_class'], 'florp-togglable-field_'.$strSubscriberType) !== false
                    || stripos($aField['settings']['container_class'], 'florp-togglable-field_any') !== false) {
                  $bHide = false;
                  break;
                }
              }
            }
          }
          if ($bHide) {
            $aField['settings']['container_class'] .= " hidden";
          }
        }

        // Set number of dancers //
        if ($aField['settings']['type'] === 'number' || $aField['settings']['type'] === 'quantity') {
          $aField['settings']['default'] = get_user_meta( $iUserID, $aField['settings']['key'], true );
        }

        // Hide and uncheck teacher course fields by iCoursesNumberEnabled //
        $aCourseCheckboxes = array(
          'courses_in_city_2' => 2,
          'courses_in_city_3' => 3,
        );
        foreach ($aCourseCheckboxes as $sKey => $iNum) {
          if ($aField['settings']['key'] == $sKey && $iNum > $this->aOptions['iCoursesNumberEnabled']) {
            // .hide-field-florp force-hides the container //
            $aField['settings']['container_class'] .= " florp-hidden hide-field-florp";
            $aField['settings']['default_value'] = 'unchecked';
          }
        }
      }

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
    } elseif ($this->isFlashmobBlog) {
      // Settings specific to the NF on the Flashmob Blog //

      // Set default value of tshirt preference to unchecked if ordering is disabled //
      if ($this->aOptions['bTshirtOrderingDisabled'] && $aField['settings']['type'] === 'listcheckbox' && $aField['settings']['key'] === 'preferences') {
        foreach ($aField['settings']['options'] as $iKey => $aOption) {
          if ($aOption['value'] === 'flashmob_participant_tshirt') {
            $aField['settings']['options'][$iKey]['selected'] = 0;
            break;
          }
        }
      }

      // Hide tshirt payment deadline warning if it's not relevant yet //
      if ($aField['settings']['type'] === 'html' && isset($aField['settings']['container_class']) && stripos($aField['settings']['container_class'], 'florp-tshirt-after-flashmob-warning') !== false) {
        $aField['settings']['default'] = str_replace("%%iTshirtOrderDeliveredBeforeFlashmobDdlDate%%", $this->iTshirtOrderDeliveredBeforeFlashmobDdlDate, $aField['settings']['default']);
        if ($this->iTshirtPaymentWarningDeadlineTimestamp > time()) {
          $aField['settings']['container_class'] .= " florp-hidden";
        }
      }

      // Hide non-profile and non-registration fields //
      $bHide = true;
      if (stripos($aField['settings']['container_class'], 'florp-registration-field') !== false
            || stripos($aField['settings']['container_class'], 'florp-profile-field') !== false) {
        $bHide = false;
      }
      if ($bHide) {
        $aField['settings']['container_class'] .= " hidden";
      }
    }

    $bParticipantFormEdit = false;
    $strFieldKey = $aField['settings']['key'];
    if ($bLoggedIn && $GLOBALS['florp-intf-participant-form-edit']) {
      $bParticipantFormEdit = false;
      $iYear = $_REQUEST['year'];
      $strEmail = $_REQUEST['email'];
      $aParticipantData = $this->aOptions['aIntfParticipants'][$iYear][$strEmail];
      $strJsArrayKey = 'florp-intf-participant-form-edit-js';
      if (isset($aParticipantData[$strFieldKey]) || $strFieldKey === 'submission_editing') {
        $bParticipantFormEdit = true;
        $strSubmissionEditingText = "intf,{$iYear},{$strEmail}";
        if (!is_array($GLOBALS[$strJsArrayKey])) {
          $GLOBALS[$strJsArrayKey] = array();
        }
        if ($strFieldKey === 'preferences') {
          $GLOBALS[$strJsArrayKey]['tshirt_ordering_disabled_intf'] = 0;
        }
        if ($strFieldKey === 'intf_city' && $aParticipantData[$strFieldKey] !== 'null') {
          $GLOBALS[$strJsArrayKey]['intf_city_poll_disabled'] = 0;
          $aField['settings']['required'] = true;
          $aField['settings']['container_class'] = str_replace("florp-hidden", "", $aField['settings']['container_class']);
          $aFlashmobCities = $this->get_intf_poll_cities();
          if (!empty($aFlashmobCities)) {
            reset($aField['settings']['options']);
            $iFirstKey = key($aField['settings']['options']);
            $aOption = $aField['settings']['options'][$iFirstKey];
            foreach ($aFlashmobCities as $strFlashmobCity) {
              $aOption["label"] = $strFlashmobCity;
              $aOption["value"] = $strFlashmobCity;
              $aField['settings']['options'][] = $aOption;
            }
          }
        }
      }

      if ($aField['settings']['element_class']) {
        $aField['settings']['element_class'] = str_replace("florp-clear-on-submission", "", $aField['settings']['element_class']);
      }
      if ($aField['settings']['container_class']) {
        $aField['settings']['container_class'] = str_replace("florp-clear-on-submission", "", $aField['settings']['container_class']);
      }
    }
    if ($bLoggedIn && $GLOBALS['florp-svk-participant-form-edit']) {
      $bParticipantFormEdit = false;
      $iLeaderID = $_REQUEST['leader_id'];
      $strEmail = $_REQUEST['email'];
      $aParticipantData = $this->aOptions['aParticipants'][$iLeaderID][$strEmail];
      $strJsArrayKey = 'florp-svk-participant-form-edit-js';
      if (isset($aParticipantData[$strFieldKey]) || $strFieldKey === 'submission_editing') {
        $bParticipantFormEdit = true;
        $strSubmissionEditingText = "svk,{$iLeaderID},{$strEmail}";
        if (!is_array($GLOBALS[$strJsArrayKey])) {
          $GLOBALS[$strJsArrayKey] = array();
        }
        if ($strFieldKey === 'preferences') {
          $GLOBALS[$strJsArrayKey]['tshirt_ordering_disabled'] = 0;
        }
      }

      if ($aField['settings']['element_class']) {
        $aField['settings']['element_class'] = str_replace("florp-clear-on-submission", "", $aField['settings']['element_class']);
      }
      if ($aField['settings']['container_class']) {
        $aField['settings']['container_class'] = str_replace("florp-clear-on-submission", "", $aField['settings']['container_class']);
      }
    }

    if ($bParticipantFormEdit) {
      switch ($aField['settings']['type']) {
        case "hidden":
          if ($strFieldKey === 'submission_editing') {
            $aField['settings']['default'] = $strSubmissionEditingText;
            break;
          }
        case "email":
        case "firstname":
        case "lastname":
          $aField['settings']['default'] = $aParticipantData[$strFieldKey];
          break;
        case 'listradio':
        case 'listselect':
          foreach ($aField['settings']['options'] as $iKey => $aOption) {
            $aField['settings']['options'][$iKey]['selected'] = ($aOption['value'] === $aParticipantData[$strFieldKey]) ? 1 : 0;
          }
          break;
        case 'listcheckbox':
          foreach ($aParticipantData[$strFieldKey] as $checkedValue) {
            foreach ($aField['settings']['options'] as $iKey => $aOption) {
              $aField['settings']['options'][$iKey]['selected'] = ($aOption['value'] === $checkedValue) ? 1 : 0;
            }
          }
          break;
      }
      // echo "<pre>"; var_dump($strFieldKey, $aField['settings']['type'], $aParticipantData[$strFieldKey], $aField['settings']['default']); echo "</pre>";
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

  public function filter__the_content( $strTheContent ) {
    global $post;
    if ($post->post_type !== 'page') {
      return $strTheContent;
    }
    if (
          (($this->isMainBlog && $post->ID === $this->iProfileFormPageIDMain) || ($this->isFlashmobBlog && $post->ID === $this->iProfileFormPageIDFlashmob))
    ) {
      if (is_user_logged_in() && $this->isMainBlog) {
        $oUser = wp_get_current_user();
        if ( in_array( $this->strUserRolePending, (array) $oUser->roles ) ) {
          return $this->strPendingUserPageContentHTML;
        }
      }
      if (!is_user_logged_in() || !has_shortcode( $post->post_content, 'florp-profile' )) {
        return $this->main_blog_profile();
      }
    }
    return $strTheContent;
  }

  public function filter__us_load_header_settings( $aSettings ) {
    if (!$this->isMainBlog) {
      return $aSettings;
    }

    global $post;
    $bUserLoggedIn = is_user_logged_in();
    $aNewSettingsByType = array();
    $iSize = 14;
    $aNewSettingsCommon = array(
      'size'          => $iSize,
      'size_tablets'  => $iSize,
      'size_mobiles'  => $iSize,
    );
    $aFieldsToUse = array( 'text:1', 'text:4' );
    if ($this->iProfileFormPageIDMain > 0) {
      if (!is_object($post) || $post->post_type !== 'page' || $post->ID !== $this->iProfileFormPageIDMain) {
        // We are not on the profile page //
        $aNewSettingsByType['profile'] = array(
          'text' => $bUserLoggedIn ? $this->aOptions['strLoginBarLabelProfile'] : $this->aOptions['strLoginBarLabelLogin'],
          'link' => get_permalink( $this->iProfileFormPageIDMain ),
          'el_class' => 'florp_profile_link_profile',
        );
        // Make the top area visible everywhere //
        $aSettings["default"]["options"]["top_show"] = 1;
        $aSettings["tablets"]["options"]["top_show"] = 1;
        $aSettings["mobiles"]["options"]["top_show"] = 1;
      } else {
        // Make the top area invisible everywhere (i.e. no gap since it's supposed to be empty) //
        $aSettings["default"]["options"]["top_show"] = 0;
        $aSettings["tablets"]["options"]["top_show"] = 0;
        $aSettings["mobiles"]["options"]["top_show"] = 0;
      }
    }

    if ($bUserLoggedIn) {
      // Make the top area visible everywhere //
      $aSettings["default"]["options"]["top_show"] = 1;
      $aSettings["tablets"]["options"]["top_show"] = 1;
      $aSettings["mobiles"]["options"]["top_show"] = 1;
      if (is_object($post)) {
        $strRedir = get_permalink( $post->ID );
      } elseif ($_SERVER['HTTP_HOST'] && $_SERVER['REQUEST_URI']) {
        $strRedir = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
      } else {
        $strRedir = home_url();
      }
      $aNewSettingsByType['logout'] = array(
        'text' => $this->aOptions['strLoginBarLabelLogout'],
        'link' => wp_logout_url( $strRedir ),
        'el_class' => 'florp_profile_link_logout',
      );
    }

    if (count($aNewSettingsByType) > 0) {
      foreach ($aNewSettingsByType as $strType => $aNewSettings) {
        $bFound = false;
        foreach ($aSettings as $strDevice => $aDeviceSettings) {
          if ($strDevice === 'data') {
            continue;
          }
          foreach ($aDeviceSettings['layout']['hidden'] as $key => $strFieldID) {
            if (in_array( $strFieldID, $aFieldsToUse )) {
              $aSettings[$strDevice]['layout']['top_right'][] = $strFieldID;
              unset($aSettings[$strDevice]['layout']['hidden'][$key]);
              $bFound = true;
              break;
            }
          }
        }
        if ($bFound) {
          $aSettings['data'][$strFieldID] = array_merge( $aSettings['data'][$strFieldID], $aNewSettingsCommon, $aNewSettings );
        }
      }
      // echo "<!-- " .var_export($aSettings, true). " -->";
    }
    return $aSettings;
  }

  public function profile_form( $aAttributes ) {
    if ($this->isIntfBlog && isset($aAttributes['international'])) {
      $iNFID = $this->iProfileFormNinjaFormIDIntf;
    } elseif ($this->isMainBlog) {
      $iNFID = $this->iProfileFormNinjaFormIDMain;
    } elseif ($this->isFlashmobBlog) {
      $iNFID = $this->iProfileFormNinjaFormIDFlashmob;
    } else {
      return '';
    }
    if ($iNFID === 0) {
      return '';
    }
    $strShortcodeOutput = do_shortcode( '[ninja_form id='.$iNFID.']' );
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

  public function main_blog_profile( $aAttributes = array() ) {
    if ($this->isMainBlog) {
      $aDefaults = array(
        'hide_info_box' => '1',
        'registration' => '1',
      );
      if (is_array($aAttributes)) {
        $aAttributes = array_merge( $aDefaults, $aAttributes );
      } else {
        $aAttributes = $aDefaults;
      }
      $strAttributes = '';
      foreach ($aAttributes as $key => $val) {
        $strAttributes .= " {$key}='{$val}'";
      }
      $strShortcodeOutput = do_shortcode( '[login-with-ajax'.$strAttributes.']' );
      return '<div class="florp-profile-wrapper">'.$strShortcodeOutput.'</div>';
    } elseif ($this->isFlashmobBlog) {
      return '<div class="florp-profile-wrapper">'.$this->profile_form().'</div>';
    } else {
      return '';
    }
  }

  public function leader_participants_table_shortcode( $aAttributes ) {
    if (!$this->isMainBlog || !is_user_logged_in()) {
      return '';
    }

    $strClass = " class=\"{$this->aOptions['strLeaderParticipantsTableClass']}\"";
    $iUserID = get_current_user_id();
    $bIsFlashmobOrganizer = get_user_meta( $iUserID, 'flashmob_organizer', true ) == '1' ? true : false;
    if (!$bIsFlashmobOrganizer) {
      return '<p'.$strClass.'>Neorganizujete flashmob ' .  date( 'j.n.Y', $this->iFlashmobTimestamp ) . '.</p>';
    }
    $aParticipants = $this->get_flashmob_participants( $iUserID, false );
    if (empty($aParticipants)) {
      return '<p'.$strClass.'>Zatiaľ nemáte prihlásených účastníkov.</p>';
    }
    $aParticipantsOfUser = $aParticipants[$iUserID];
    if (empty($aParticipantsOfUser)) {
      return '<p'.$strClass.'>Zatiaľ nemáte prihlásených účastníkov.</p>';
    }

    return $this->get_leader_participants_table( $aParticipantsOfUser, false );
  }

  public function popup_anchor( $aAttributes ) {
    return '<a name="'.$this->strClickTriggerAnchor.'"></a>';
  }

  private function getIntfChartDataTable( $aAttributes, $aOptions ) {
    $aCities = $this->get_intf_poll_cities();
    $aCityNumbers = array();
    foreach ($aCities as $strCity) {
      $aCityNumbers[$strCity] = 0;
    }

    $bPercentage = false;
    if (isset($aAttributes['val-style']) && $aAttributes['val-style'] == 'percentage') {
      $bPercentage = true;
      $iTotalCount = 0;
    }

    foreach ($this->aOptions['aIntfParticipants'][$this->aOptions['iIntfFlashmobYear']] as $aParticipantData) {
      if (isset($aParticipantData['intf_city']) && !empty($aParticipantData['intf_city']) && 'null' != $aParticipantData['intf_city'] && in_array($aParticipantData['intf_city'], $aCities)) {
        $aCityNumbers[$aParticipantData['intf_city']]++;
        if ($bPercentage) {
          $iTotalCount++;
        }
      }
    }
    arsort($aCityNumbers);

    $iLimit = 0;
    if (isset($aAttributes['limit']) && (is_int($aAttributes['limit']) || preg_match('~\d+~', $aAttributes['limit']))) {
      $iLimit = intval($aAttributes['limit']);
    }
    // $iLimit = 3;

    $iCount = 1;
    $aHeader = [$aAttributes['row-name'], $aAttributes['col-name']];
    if (isset($aAttributes['color'])) {
      $aHeader[] = [ "role" => 'style' ];
    }
    $aDataTable[] = $aHeader;
    foreach ($aCityNumbers as $strCity => $iValue) {
      if ($iValue == 0) {
        continue;
      }
      if ($iLimit > 0 && $iCount > $iLimit) {
        break;
      }
      if ($bPercentage) {
        $iValue = round((100.0 * $iValue) / $iTotalCount, 2);
      }
      $aRow = [$strCity, $iValue];
      if (isset($aAttributes['color'])) {
        $aRow[] = $aAttributes['color'];
      }
      $aDataTable[] = $aRow;
      $iCount++;
    }
    return $aDataTable;
  }

  public function shortcode_intf_chart( $aAttributes ) {
    $aAttributes = shortcode_atts(array(
      'row-height'    => 0,
      'color'         => '#aaa',
      'row-name'      => 'Mesto',
      'col-name'      => 'Počet hlasov',
      'val-style'     => 'count', // OR: 'percentage'
      'limit'         => 0,
      'chart-title'   => null,
      'chart-height'  => null,
      'type'          => 'BarChart',
      'chartAreaLeft' => array( 230 => 35, 270 => 30, 340 => 25, 1000000 => 20 ), // key is max div width for given value //
    ), $aAttributes);
    $aOptions = array(
      'title'           => 'Mestá',
      'legend'          => 'none',
      'height'          => '400',
      'chartArea'       => array("left" => "20%", "width" => "75%"),
      // 'backgroundColor' => 'lightgray',
      // 'width' => '400',
    );
    $aStyleAttributes = array(
      // 'height' => '400px',
      'width' => '100%',
    );
    $aStyleItems = array();
    foreach ($aStyleAttributes as $key => $val) {
      if (isset($aAttributes["div-".$key])) {
        $aStyleAttributes[$key] = $aAttributes["div-".$key];
      }
      $aStyleItems[] = $key.": ".$aStyleAttributes[$key];
    }
    $aDivAttributes = array();
    if (!empty($aStyleItems)) {
      $aDivAttributes['style'] = implode("; ", $aStyleItems).';';
    }

    foreach ($aOptions as $key => $val) {
      if (isset($aAttributes["chart-".$key])) {
        $aOptions[$key] = $aAttributes["chart-".$key];
      }
    }

    $aDataTable = $this->getIntfChartDataTable($aAttributes, $aOptions);
    if (count($aDataTable) <= 1) {
      return '';
    }

    if (isset($aAttributes['row-height']) && $aAttributes['row-height'] > 0) {
      $aOptions["bar"] = array("groupWidth" => $aAttributes['row-height']);
    }

    if (is_null($this->oFlorpChartInstance)) {
      return '';
    }

    return $this->oFlorpChartInstance->get_chart( $aAttributes, $aDivAttributes, $aDataTable, $aOptions, $this->strIntfChartClass );
  }

  public function filter__get_intf_chart_datatable( $aDataTable, $aChartProperties, $aChartData ) {
    if (in_array($this->strIntfChartClass, $aChartProperties["containerClasses"])) {
      $aDataTableLoc = $this->getIntfChartDataTable($aChartData['attrs'], $aChartData['options'], $aChartData['dataTable']);
      // Only change the output if it's different from the previous value -- this prevents the reloading of charts e.g. on PUM close //
      if ($aDataTableLoc != $aChartData['dataTable']) {
        $aDataTable = $aDataTableLoc;
      }
    }

    return $aDataTable;
  }

  private function getFlashmobSubscribers( $strType, $bPending = false ) {
    if ($bPending) {
      // If getting pending users, do not save them in the aFlashmobSubscribers variable //
      $aBak = $this->aFlashmobSubscribers[$strType];
    }
    if (empty($this->aFlashmobSubscribers[$strType]) || $bPending) {
      $aArgs = array(
        'blog_id' => $this->iMainBlogID
      );
      if ($bPending) {
        $aArgs['role__in'] = array( $this->strUserRoleApproved, $this->strUserRolePending );
      } else {
        $aArgs['role'] = $this->strUserRoleApproved;
      }
      $aArgsTypeSpecific = array();
      switch ($strType) {
        case 'flashmob_organizer':
        case 'teacher':
          $aArgsTypeSpecific = array(
            'meta_query' => array(
              array(
                'key'     => $strType,
                'value'   => '1',
                'compare' => '='
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
          // Just update the global aFlashmobSubscribers for this type //
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
          $this->aFlashmobSubscribers['all'] = $aUsers;
          foreach ($aUsers as $oUser) {
            $bAtLeastOne = false;
            foreach( $this->aSubscriberTypes as $strSubscriberType) {
              $strVal = get_user_meta( $oUser->ID, $strSubscriberType, true );
              if ($strVal) {
                $bAtLeastOne = true;
                $this->aFlashmobSubscribers[$strSubscriberType][] = $oUser;
              }
            }
            if (!$bAtLeastOne) {
              $this->aFlashmobSubscribers['subscriber_only'][] = $oUser;
            }
          }
          break;
      }
    }
    if ($bPending) {
      // If getting pending users, do not save them in the aFlashmobSubscribers variable //
      $aReturn = $this->aFlashmobSubscribers[$strType];
      $this->aFlashmobSubscribers[$strType] = $aBak;
      return $aReturn;
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
          array($this, 'get_value_maybe_fix_unserialize_array'),
          get_user_meta( $oUser->ID )
        );
        $strFlashmobCity = trim($aAllMeta['flashmob_city']);
        $strFlashmobAddress = trim($aAllMeta['flashmob_address']);
        if (empty($strFlashmobCity) && empty($strFlashmobAddress)) {
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

  private function get_flashmob_participants( $iUserID = 0, $bUnnotifiedOnly = false, $bPending = false ) {
    $aParticipantsReturned = array();
    if ($iUserID === 0 && !$bUnnotifiedOnly) {
      $aParticipantsReturned = $this->aOptions['aParticipants'];
    } elseif ($bUnnotifiedOnly && $iUserID === 0) {
      foreach ($this->aOptions['aParticipants'] as $iLeaderID => $aParticipants) {
        foreach ($aParticipants as $strEmail => $aParticipantData) {
          if (isset($aParticipantData['leader_notified']) && $aParticipantData['leader_notified'] === true) {
            continue;
          }
          if (!isset($aParticipantsReturned[$iLeaderID])) {
            $aParticipantsReturned[$iLeaderID] = array(
              $strEmail => $aParticipantData
            );
          } else {
            $aParticipantsReturned[$iLeaderID][$strEmail] = $aParticipantData;
          }
        }
      }
    } elseif ($bUnnotifiedOnly && $iUserID > 0) {
      if (isset( $this->aOptions['aParticipants'][$iUserID] )) {
        foreach ($this->aOptions['aParticipants'][$iUserID] as $strEmail => $aParticipantData) {
          if (isset($aParticipantData['leader_notified']) && $aParticipantData['leader_notified'] === true) {
            continue;
          }
          if (!isset($aParticipantsReturned[$iUserID])) {
            $aParticipantsReturned[$iUserID] = array(
              $strEmail => $aParticipantData
            );
          } else {
            $aParticipantsReturned[$iUserID][$strEmail] = $aParticipantData;
          }
        }
      }
    } else {
      // !$bUnnotifiedOnly && $iUserID > 0
      $aParticipantsReturned = (isset($this->aOptions['aParticipants'][$iUserID])) ? array( $iUserID => $this->aOptions['aParticipants'][$iUserID] ) : array();
    }

    foreach ($aParticipantsReturned as $iLeaderID => $aParticipants) {
      $oLeader = get_user_by( 'id', $iLeaderID );
      if ( false === $oLeader ) {
        unset($aParticipantsReturned[$iLeaderID]);
        unset($this->aOptions['aParticipants'][$iLeaderID]);
        $this->save_options();
      } elseif ( !$bPending && in_array( $this->strUserRolePending, (array) $oLeader->roles ) ) {
        unset($aParticipantsReturned[$iLeaderID]);
      }
    }

    return $aParticipantsReturned;
  }

  public function notify_leaders_about_participants( $iUserID = 0 ) {
    if (!$this->isMainBlog) {
      return;
    }
    $aParticipantsNotNotified = $this->get_flashmob_participants( $iUserID, true );

    if (empty($aParticipantsNotNotified)) {
      return;
    }
    foreach ($aParticipantsNotNotified as $iLeaderID => $aParticipants) {
      if (empty($aParticipants)) {
        continue;
      }
      foreach ($aParticipants as $strEmail => $aParticipantData) {
        $this->aOptions['aParticipants'][$iLeaderID][$strEmail]['leader_notified'] = true;
      }

      $strTable = $this->get_leader_participants_table( $aParticipants, true );

      $strMessage = $this->aOptions['strLeaderParticipantListNotificationMsg'];
      if (strpos( $strMessage, "%PARTICIPANT_LIST%") === false) {
        $strMessage .= $strTable;
      } elseif (strpos( $strMessage, "<p>%PARTICIPANT_LIST%</p>") !== false) {
        $strMessage = str_replace( "<p>%PARTICIPANT_LIST%</p>", $strTable, $strMessage );
      } else {
        $strMessage = str_replace( "%PARTICIPANT_LIST%", $strTable, $strMessage );
      }

      $strProfilePageUrl = '';
      if ( $this->iProfileFormPageIDMain > 0 ) {
        $strProfilePageUrl = get_permalink( $this->iProfileFormPageIDMain );
      }
      $strMessage = str_replace( '%PROFILE_URL%', $strProfilePageUrl, $strMessage );

      $oLeader = get_user_by( 'id', $iLeaderID );
      $strBlogname = trim(wp_specialchars_decode(get_option('blogname'), ENT_QUOTES));
      $aHeaders = array('Content-Type: text/html; charset=UTF-8');
      $this->new_user_notification( $oLeader->user_login, '', $oLeader->user_email, $strBlogname, $strMessage, $this->aOptions['strLeaderParticipantListNotificationSbj'], $aHeaders );
    }
    $this->save_options();
  }

  private function get_leader_participants_table( $aParticipants, $bEmail = false ) {
    if (empty($aParticipants)) {
      return '';
    }
    if ($bEmail) {
      $sTblAtt = ' style="width: 100%; border: 1px solid #ccc;"';
      $sThAtt = ' style="border: 1px solid #ccc;"';
      $sTdAtt = ' style="border: 1px solid #ccc;"';
    } else {
      $sTblAtt = " class=\"{$this->aOptions['strLeaderParticipantsTableClass']}\"";
      $sThAtt = ' class="florp-leader-participants-hcell"';
      $sTdAtt = ' class="florp-leader-participants-cell"';
    }
    $aReplacements = array(
      'gender' => array(
        'from'  => array( 'muz', 'zena', 'par' ),
        'to'    => array( 'muž', 'žena', 'pár' )
      ),
      'dance_level' => array(
        'from'  => array( '_', 'zaciatocnik', 'pokrocily', 'ucitel' ),
        'to'    => array( ' ', 'začiatočník', 'pokročilý', 'učiteľ' )
      )
    );
    $strTable = "<table{$sTblAtt}><tr><th{$sThAtt}>Meno</th><th{$sThAtt}>Priezvisko</th><th{$sThAtt}>Pohlavie</th><th{$sThAtt}>Tanečná úroveň</th></tr>";
    foreach ($aParticipants as $strEmail => $aParticipantData) {
      foreach ($aReplacements as $strKey => $aReplacementArr) {
        $aParticipantData[$strKey] = str_replace( $aReplacementArr['from'], $aReplacementArr['to'], $aParticipantData[$strKey]);
      }
      $strTable .= "<tr><td{$sTdAtt}>{$aParticipantData['first_name']}</td><td{$sTdAtt}>{$aParticipantData['last_name']}</td><td{$sTdAtt}>{$aParticipantData['gender']}</td><td{$sTdAtt}>{$aParticipantData['dance_level']}</td></tr>";
    }
    $strTable .= "</table>";
    return $strTable;
  }

  private function get_flashmob_participant_count( $iUserID ) {
    if (!isset($this->aOptions['aParticipants'][$iUserID])) {
      return 0;
    }
    return count($this->aOptions['aParticipants'][$iUserID]);
  }

  public function popupLinks( $aAttributes = array() ) {
    // DEPRECATED //
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

  public function map_flashmob( $aAttributes ) {
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

    if ($bAllYears) {
      // Current year: //
      $aSchoolCities = array();
      $aSchoolCitiesNoVideo = array();
      $aMapOptionsNoVideo = array();
      $aMapOptionsArray = array();
      $aCurrentYearOptions = $this->get_flashmob_map_options_array(true, 0);
      $aVideoFields = array('facebook_link', 'youtube_link', 'vimeo_link', 'embed_code');
      foreach ($aCurrentYearOptions as $iUserID => $aOptions) {
        $strCity = $aOptions['flashmob_city'];
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
          $strCity = $aOptions['flashmob_city'];
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
      $aMapOptionsArray = $this->get_flashmob_map_options_array($iIsCurrentYear === 1, $mixYear);
    }

    if (isset($aAttributes['city-shown-on-load'])) {
      $strCity = trim($aAttributes['city-shown-on-load']);
      if (!empty($strCity)) {
        $strCity = strtolower($strCity);
        foreach ($aMapOptionsArray as $iUserID => $aOptions) {
          if (strtolower($aOptions['flashmob_city']) == $strCity || stripos($aOptions['flashmob_city'], $strCity) !== false || stripos($aOptions['flashmob_address'], $strCity) !== false) {
            $aMapOptionsArray[$iUserID]['showOnLoad'] = true;
            break;
          }
        }
      }
    }

    $aDivAttributes = array(
      'data-year' => $mixYear,
      'data-is-current-year' => $iIsCurrentYear,
      'data-map-type' => 'flashmob_organizer',
    );
    return $this->get_map_html( $aMapOptionsArray, $aDivAttributes, 'f_' );
  }

  public function map_teachers( $aAttributes ) {
    $aMapOptionsArray = $this->get_teacher_map_options_array();
    $aDivAttributes = array(
      'data-map-type' => 'teacher',
    );
    return $this->get_map_html( $aMapOptionsArray, $aDivAttributes, 't_' );
  }

  private function get_map_html( $aMapOptionsArray, $aDivAttributes = array(), $strDivID_prefix = '' ) {
    $iTimestamp = date('U');
    $strRandomString = wp_generate_password( 5, false );
    $strID = $strDivID_prefix . $iTimestamp . '_' . $strRandomString;

    $strMapOptionsArrayJson = json_encode( $aMapOptionsArray );
    $strMapScript = '<script type="text/javascript">
      if ("undefined" === typeof florp_map_options_object) {
        var florp_map_options_object = {};
      }
      florp_map_options_object["'.$strID.'"] = '.$strMapOptionsArrayJson.';
    </script>';
    $strMapDivHtml = '<div id="'.$strID.'" class="florp-map"';
    if (!empty($aDivAttributes)) {
      foreach ($aDivAttributes as $strAttrKey => $strAttrValue) {
        $strMapDivHtml .= $strAttrKey.'="'.$strAttrValue.'"';
      }
    }
    $strMapDivHtml .= '></div>';
    return $strMapScript.PHP_EOL.$strMapDivHtml;
  }

  private function get_flashmob_map_options_array( $bIsCurrentYear = true, $iYear = 0 ) {
    if ($bIsCurrentYear || $iYear == 0) {
      $aMapOptionsArray = array();
      // Construct the current year's user array //
      $aUsers = $this->getFlashmobSubscribers('flashmob_organizer');
      foreach ($aUsers as $key => $oUser) {
        $aMapOptionsArray[$oUser->ID] = $this->getOneUserMapInfo($oUser);
      }
    } elseif (isset($this->aOptions["aYearlyMapOptions"][$iYear])) {
      $aMapOptionsArray = $this->aOptions["aYearlyMapOptions"][$iYear];
      // $aMapOptionsArray['info'] = "byYear";
    } else {
      $aMapOptionsArray = array();
      // $aMapOptionsArray['info'] = "empty";
    }
    return $aMapOptionsArray;
  }

  private function get_teacher_map_options_array() {
    $aMapOptionsArray = array();
    $aUsers = $this->getFlashmobSubscribers('teacher');
    foreach ($aUsers as $key => $oUser) {
      $aMapOptionsArray[$oUser->ID] = $this->getOneUserMapInfo($oUser);
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
      array($this, 'get_value_maybe_fix_unserialize_array'),
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

  private function get_flashmob_map_options_array_to_archive() {
    $iFlashmobYear = $this->aOptions['iFlashmobYear'];
    $aMapOptions = $this->get_flashmob_map_options_array(true, $iFlashmobYear);
    foreach ($aMapOptions as $iUserID => $aUserMapOptions) {
      foreach ($aUserMapOptions as $strKey => $mixVal) {
        if (!in_array( $strKey, $this->aMetaFieldsFlashmobToArchive ) && !in_array( $strKey, $this->aUserFieldsMap )) {
          unset( $aMapOptions[$iUserID][$strKey] );
        }
      }
    }
    return $aMapOptions;
  }

  private function archive_current_year_map_options() {
    $iFlashmobYear = $this->aOptions['iFlashmobYear'];
    $this->aOptions['aYearlyMapOptions'][$iFlashmobYear] = $this->get_flashmob_map_options_array_to_archive();
    // TODO archive aParticipants, aIntfParticipants, aTshirts and aTshirtsIntf as well!
    $this->aOptions['aParticipants'] = array();
    $this->save_options();

    // clean user meta //
    $aUsers = $this->getFlashmobSubscribers('flashmob_organizer');
    foreach ($aUsers as $key => $oUser) {
      foreach ($this->aFlashmobMetaFieldsToClean as $keyVal) {
        if (strpos($keyVal, ':') === false) {
          // whole field //
          delete_user_meta( $oUser->ID, $keyVal );
        } else {
          // setting is an array and only one or more of its items should be cleaned //
          $aParts = explode( ':', $keyVal );
          $strMetaKey = $aParts[0];
          $mixMetaValuesToClean = explode( ',', $aParts[1] );
          if (empty($mixMetaValuesToClean) || !is_array($mixMetaValuesToClean)) {
            continue;
          }
          $aMetaValue = get_user_meta( $oUser->ID, $strMetaKey, true );
          if ($aMetaValue === '') {
            // empty, do nothing //
          } elseif (is_array($aMetaValue)) {
            // Setting was present => remove values that should be cleaned //
            $aNewVal = array_diff( $mixMetaValuesToClean, $aMetaValue );
            update_user_meta( $oUser->ID, $strMetaKey, $aNewVal );
          } else {
            // meta value is not an array - do something? //
          }
        }
      }
    }
  }

  public function getMapImage() {
    $aMapOptions = $this->aGeneralMapOptions;
    $aSizeArr = explode( "x", $aMapOptions['og_map']['size']);
    $aOptionsFromUsers = $this->get_flashmob_map_options_array();
    $aMarkerOptions = array( 'icon:'.urlencode($aMapOptions['markers']['icon']) );

    if (!empty($aOptionsFromUsers)) {
      foreach ($aOptionsFromUsers as $iUserID => $aOptions ) {
        if (isset($aOptions['latitude'],$aOptions['longitude']) && !empty($aOptions['latitude']) && !empty($aOptions['longitude'])) {
          $aMarkerOptions[] = $aOptions['latitude'].",".$aOptions['longitude'];
          continue;
        }
        if (isset($aOptions['flashmob_city'])) {
          $aOptions['flashmob_city'] = trim($aOptions['flashmob_city']);
          if (!empty($aOptions['flashmob_city'])) {
            $aMarkerOptions[] = urlencode($aOptions['flashmob_city']);
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

  private function get_tshirt_images( $bInternational = false ) {
    $aTshirtImages = array();
    $strPluginDirPath = WP_CONTENT_DIR . '/plugins/flashmob-organizer-profile';
    $strImagePath = $strPluginDirPath."/img/";
    $strImagePathEscaped = preg_quote($strImagePath, "~");
    $aTshirtImageCouples = array();
    $aTshirtFullImages = array( 'white' => array(), 'black' => array() );
    $strImageNamePatternPrefix = "";
    $strImageNamePattern = "t-shirt-*.png";
    if ($bInternational) {
      $strImageNamePatternPrefix = "intf-";
      $strImageNamePattern = "intf-t-shirt-*.png";
    }
    foreach ( glob($strImagePath . $strImageNamePattern) as $strImgName) {
      $aMatches = array();
      $mixType = false;
      if (preg_match( '~^('.$strImagePathEscaped.')?'.$strImageNamePatternPrefix.'t-shirt-chest-white-([a-zA-Z0-9_-]+).png$~', $strImgName, $aMatches )) {
        $strTshirtCitySlug = $aMatches[2];
        $strType = "white";
      } elseif (preg_match( '~^('.$strImagePathEscaped.')?'.$strImageNamePatternPrefix.'t-shirt-chest-black-([a-zA-Z0-9_-]+).png$~', $strImgName, $aMatches )) {
        $strTshirtCitySlug = $aMatches[2];
        $strType = "black";
      } elseif (preg_match( '~^('.$strImagePathEscaped.')?'.$strImageNamePatternPrefix.'t-shirt-white-([a-zA-Z0-9_-]+).png$~', $strImgName, $aMatches )) {
        $strTshirtCitySlug = $aMatches[2];
        $aTshirtFullImages['white'][$strTshirtCitySlug] = 1;
        continue;
      } elseif (preg_match( '~^('.$strImagePathEscaped.')?'.$strImageNamePatternPrefix.'t-shirt-black-([a-zA-Z0-9_-]+).png$~', $strImgName, $aMatches )) {
        $strTshirtCitySlug = $aMatches[2];
        $aTshirtFullImages['black'][$strTshirtCitySlug] = 1;
        continue;
      }
      if ($strType) {
        if (!isset($aTshirtImageCouples[$strTshirtCitySlug])) {
          $aTshirtImageCouples[$strTshirtCitySlug] = array(
            'white' => false,
            'black' => false,
          );
        }
        $aTshirtImageCouples[$strTshirtCitySlug][$strType] = true;
      }
    }
    foreach ($aTshirtImageCouples as $strTshirtCitySlug => $aTypes) {
      if ($aTypes['white'] && $aTypes['black']) {
        $aTshirtImages[$strTshirtCitySlug] = 1;
      }
    }

    return array(
      'availability' => $aTshirtImages,
      'couples' => $aTshirtImageCouples,
      'full' => $aTshirtFullImages,
    );
  }

  public function action__wp_enqueue_scripts() {
    $iUserID = get_current_user_id();
    wp_enqueue_script('florp_nf_action_controller', plugins_url('js/florp_nf_action_controller.js', __FILE__), array('jquery'), $this->strVersion, true);
    wp_enqueue_script('florp_form_js', plugins_url('js/florp-form.js', __FILE__), array('jquery'), $this->strVersion, true);

    wp_enqueue_script('florp-google-maps-with-key', '//maps.googleapis.com/maps/api/js?key='.$this->aOptions['strGoogleMapsKey'], array(), '', FALSE );
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

    if ($this->isMainBlog) {
      $iPopupIDMain = $this->iProfileFormPopupIDMain;
      $iNFIDMain = $this->iProfileFormNinjaFormIDMain;
      $bReloadAfterSuccessfulSubmissionMain = $this->bReloadAfterSuccessfulSubmissionMain;
    } else {
      $iPopupIDMain = 0;
      $iNFIDMain = 0;
      $bReloadAfterSuccessfulSubmissionMain = false;
    }

    if ($this->isFlashmobBlog) {
      $iPopupIDFlashmob = $this->iProfileFormPopupIDFlashmob;
      $iNFIDFlashmob = $this->iProfileFormNinjaFormIDFlashmob;
      $bReloadAfterSuccessfulSubmissionFlashmob = $this->bReloadAfterSuccessfulSubmissionFlashmob;
    } else {
      $iPopupIDFlashmob = 0;
      $iNFIDFlashmob = 0;
      $bReloadAfterSuccessfulSubmissionFlashmob = false;
    }

    if ($this->isIntfBlog) {
      $iPopupIDIntf = $this->iProfileFormPopupIDIntf;
      $iNFIDIntf = $this->iProfileFormNinjaFormIDIntf;
    } else {
      $iPopupIDIntf = 0;
      $iNFIDIntf = 0;
    }

    if ($this->isMainBlog) {
      $strBlogType = 'main';
    } elseif ($this->isFlashmobBlog) {
      $strBlogType = 'flashmob';
    } else {
      $strBlogType = 'other';
    }

    $aBlogTypes = array();
    if ($this->isMainBlog) {
      $aBlogTypes[] = 'main';
    }
    if ($this->isFlashmobBlog) {
      $aBlogTypes[] = 'flashmob';
    }
    if ($this->isIntfBlog) {
      $aBlogTypes[] = 'international';
    }

    if ($this->isMainBlog && is_user_logged_in() && $this->get_flashmob_participant_count( get_current_user_id() ) > 0) {
      $iHasParticipants = 1;
    } else {
      $iHasParticipants = 0;
    }

    $aTshirtImages = $this->get_tshirt_images();
    $aTshirtImagesIntf = $this->get_tshirt_images(true);

    $aHideFlashmobFields = array();
    $aLeaders = $this->getFlashmobSubscribers( 'all', true );
    foreach ($aLeaders as $oLeader) {
      $iLeaderID = $oLeader->ID;
      $aHideFlashmobFields[$iLeaderID] = $this->bHideFlashmobFields;
      if (in_array($iLeaderID, $this->aOptions['aHideFlashmobFieldsForUsers'])) {
        $aHideFlashmobFields[$iLeaderID] = true;
      } elseif (in_array($iLeaderID, $this->aOptions['aUnhideFlashmobFieldsForUsers'])) {
        $aHideFlashmobFields[$iLeaderID] = false;
      }
    }
    $mixHideFlashmobFields = $this->bHideFlashmobFields ? 1 : 0;
    if ($this->isMainBlog) {
      if (is_user_logged_in() && isset($aHideFlashmobFields[$iUserID])) {
        // Use the user's option //
        $mixHideFlashmobFields = $aHideFlashmobFields[$iUserID] ? 1 : 0;
      } else {
        // Nothing //
      }
    } elseif ($this->isFlashmobBlog) {
      // Use the whole array of who should have flashmob fields disabled and who shouldn't //
      $mixHideFlashmobFields = $aHideFlashmobFields;
    }

    $aJS = array(
      'hide_flashmob_fields'              => $mixHideFlashmobFields,
      'reload_ok_submission'              => $bReloadAfterSuccessfulSubmission ? 1 : 0, // DEPRECATED //
      'reload_ok_submission_main'         => $bReloadAfterSuccessfulSubmissionMain ? 1 : 0,
      'reload_ok_submission_flashmob'     => $bReloadAfterSuccessfulSubmissionFlashmob ? 1 : 0,
      'using_og_map_image'                => $this->aOptions['bUseMapImage'] ? 1 : 0,
      'blog_type'                         => $strBlogType, // DEPRECATED //
      'blog_types'                        => $aBlogTypes,
      'reload_ok_cookie'                  => 'florp-form-saved',
      'florp_trigger_anchor'              => $this->strClickTriggerAnchor,
      'get_markerInfoHTML_action'         => 'get_markerInfoHTML',
      'get_mapUserInfo_action'            => 'get_mapUserInfo',
      'ajaxurl'                           => admin_url( 'admin-ajax.php'),
      'security'                          => wp_create_nonce( 'srd-florp-security-string' ),
      'flashmob_city'                     => get_user_meta( $iUserID, 'flashmob_city', true ),
      'click_trigger_class_main'          => $this->strClickTriggerClass,
      'click_trigger_class_flashmob'      => $this->strClickTriggerClass,
      'click_trigger_class_intf'          => $this->strClickTriggerClass,
      'do_trigger_popup_click_main'       => $bDoTriggerPopupClick, // For when registration is in popup //
      'general_map_options'               => $this->aGeneralMapOptions,
      'form_id'                           => $iNFID, // DEPRECATED //
      'form_id_main'                      => $iNFIDMain,
      'form_id_flashmob'                  => $iNFIDFlashmob,
      'form_id_intf'                      => $iNFIDIntf,
      'logging_in_msg'                    => $this->aOptions['strRegistrationSuccessfulMessage'],
      'popup_id'                          => $iPopupID, // DEPRECATED //
      'popup_id_main'                     => $iPopupIDMain,
      'popup_id_flashmob'                 => $iPopupIDFlashmob,
      'popup_id_intf'                     => $iPopupIDIntf,
      'load_maps_lazy'                    => $this->aOptions['bLoadMapsLazy'] ? 1 : 0,
      'load_maps_async'                   => $this->aOptions['bLoadMapsAsync'] ? 1 : 0,
      'load_videos_lazy'                  => $this->aOptions['bLoadVideosLazy'] ? 1 : 0,
      'has_participants'                  => $iHasParticipants,
      'img_path'                          => plugins_url( 'flashmob-organizer-profile/img/' ),
      'tshirt_imgs_couples'               => $aTshirtImages['availability'],
      'tshirt_imgs_full'                  => $aTshirtImages['full'],
      'intf_tshirt_imgs_couples'          => $aTshirtImagesIntf['availability'],
      'intf_tshirt_imgs_full'             => $aTshirtImagesIntf['full'],
      'courses_info_disabled'             => $this->aOptions['iCoursesNumberEnabled'] == 0 ? 1 : 0,
      'courses_number_enabled'            => intval($this->aOptions['iCoursesNumberEnabled']),
      'tshirt_ordering_disabled'          => $this->aOptions['bTshirtOrderingDisabled'] ? 1 : 0,
      'tshirt_ordering_only_disable'      => $this->aOptions['bTshirtOrderingDisabledOnlyDisable'] ? 1 : 0,
      'tshirt_ordering_disabled_intf'     => $this->aOptions['bIntfTshirtOrderingDisabled'] ? 1 : 0,
      'tshirt_ordering_only_disable_intf' => $this->aOptions['bIntfTshirtOrderingDisabledOnlyDisable'] ? 1 : 0,
      'intf_city_poll_disabled'           => $this->bIntfCityPollDisabled ? 1 : 0,
      // 'all_imgs'                          => glob($strImagePath . "t-shirt-*.png"),
      'reload_charts_on_intff_submission' => $this->bReloadChartOnIntfFormSubmission ? 1 : 0,
      'intf_chart_class'                  => $this->strIntfChartClass,
    );
    if (is_user_logged_in()) {
      $aJS['user_id'] = $iUserID;
      $aJS['leader_participant_table_class'] = $this->aOptions['strLeaderParticipantsTableClass'];
      $aJS['get_leaderParticipantsTable_action'] = 'get_leaderParticipantsTable';

      if ($GLOBALS['florp-svk-participant-form-edit'] && is_array($GLOBALS['florp-svk-participant-form-edit-js'])) {
        $aJS = array_merge($aJS, $GLOBALS['florp-svk-participant-form-edit-js']);
      }
      if ($GLOBALS['florp-intf-participant-form-edit'] && is_array($GLOBALS['florp-intf-participant-form-edit-js'])) {
        $aJS = array_merge($aJS, $GLOBALS['florp-intf-participant-form-edit-js']);
      }
    }
    wp_localize_script( 'florp_form_js', 'florp', $aJS );

    wp_enqueue_style( 'florp_form_css', plugins_url('css/florp-form.css', __FILE__), false, $this->strVersion, 'all');
  }

  public function action__admin_enqueue_scripts( $strHook ) {
    $aPermittedHooks = array(
      // 'toplevel_page_florp-main',
      'slovensky-flashmob_page_florp-leaders',
      'slovensky-flashmob_page_florp-participants',
      'slovensky-flashmob_page_florp-tshirts',
      'slovensky-flashmob_page_florp-subsites',
      'slovensky-flashmob_page_florp-history',
      'toplevel_page_florp-admin',
      'florp-admin_page_florp-option-changes',
      'florp-admin_page_florp-leader-submission-history',
      // 'slovensky-flashmob_page_florp-lwa',
      'medzinarodny-flashmob_page_florp-intf-participants',
      'medzinarodny-flashmob_page_florp-intf-tshirts',
    );
    if (in_array($strHook, $aPermittedHooks)) {
      wp_enqueue_script('florp_admin_js', plugins_url('js/florp-admin.js', __FILE__), array('jquery'), $this->strVersion, true);

      wp_register_style( 'florp_admin_css', plugins_url('css/florp-admin.css', __FILE__), false, $this->strVersion );
      wp_enqueue_style( 'florp_admin_css' );

      // jQuery timepicker plugin //
      wp_register_script( 'jQueryTimepickerJs', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), null, true );
      wp_enqueue_script('jQueryTimepickerJs');
      wp_register_style( 'jQueryTimepickerCss', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css' );
      $wp_scripts = wp_scripts();
      wp_enqueue_style(
        'jquery-ui-theme-smoothness',
        sprintf(
          '//ajax.googleapis.com/ajax/libs/jqueryui/%s/themes/smoothness/jquery-ui.css', // working for https as well now
          $wp_scripts->registered['jquery-ui-core']->ver
        )
      );
      wp_enqueue_style('jQueryTimepickerCss');
    } else {
      // echo $strHook;
    }
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

  public function action__remove_admin_menu_items() {
    $oUser = wp_get_current_user();
    $strAdminEmail = get_option('admin_email');
    if( $oUser && isset($oUser->user_email) && $strAdminEmail !== $oUser->user_email ) {
      $aMenuPages = array(
        'ninja-forms' => array(
          'admin.php?page=ninja-forms#new-form',
          'edit.php?post_type=nf_sub',
          'nf-import-export',
          'nf-settings',
          'nf-system-status',
          'ninja-forms#apps',
        ),
        'edit.php?post_type=popup' => array(),
      );
      foreach ($aMenuPages as $strMenuPage => $aSubMenuPages) {
        if (is_array($aSubMenuPages) && !empty($aSubMenuPages)) {
          foreach ($aSubMenuPages as $strSubmenuPage) {
            remove_submenu_page( $strMenuPage, $strSubmenuPage );
          }
        }
        remove_menu_page( $strMenuPage );
      }
    }
  }

  public function action__add_options_page() {
    $oUser = wp_get_current_user();
    if ($oUser->user_email === 'charliecek@gmail.com' || $oUser->user_email === get_option('admin_email')) {
      add_menu_page(
        "FLORP Admin",
        'FLORP Admin',
        'manage_options',
        'florp-admin',
        array( $this, 'option_changes_table_admin' ),
        "dashicons-admin-generic",
        58
      );
      $page = add_submenu_page(
        'florp-admin',
        'Option changes',
        'Option changes',
        'manage_options',
        // 'florp-option-changes',
        'florp-admin',
        array( $this, 'option_changes_table_admin' )
      );
      $page = add_submenu_page(
        'florp-admin',
        'Leader submission history',
        'Leader submission history',
        'manage_options',
        'florp-leader-submission-history',
        array( $this, 'leader_submission_history_table_admin' )
      );
    }

    // Shown on each blog - links get the admin to the right settings page url //
    add_menu_page(
      "Profil organizátora slovenského flashmobu",
      'Slovenský Flashmob',
      'manage_options',
      'florp-main',
      array( $this, "options_page" ),
      plugins_url( 'flashmob-organizer-profile/img/florp-icon-30.png' ),
      58
    );
    if ($this->isMainBlog) {
      $page = add_submenu_page(
        'florp-main',
        'Profil organizátora slovenského flashmobu',
        'Nastavenia profilu',
        'manage_options',
        'florp-main',
        array( $this, 'options_page' )
      );
      $page = add_submenu_page(
        'florp-main',
        'Zoznam lídrov',
        'Zoznam lídrov',
        'manage_options',
        'florp-leaders',
        array( $this, 'leaders_table_admin' )
      );
      $page = add_submenu_page(
        'florp-main',
        'Zoznam účastníkov',
        'Zoznam účastníkov',
        'manage_options',
        'florp-participants',
        array( $this, 'participants_table_admin' )
      );
      $page = add_submenu_page(
        'florp-main',
        'Tričká',
        'Tričká',
        $this->strUserRoleRegistrationAdminSvk,
        'florp-tshirts',
        array( $this, 'tshirts_table_admin' )
      );
      $page = add_submenu_page(
        'florp-main',
        'Podstránky lídrov',
        'Podstránky lídrov',
        'manage_options',
        'florp-subsites',
        array( $this, 'subsites_table_admin' )
      );
      $page = add_submenu_page(
        'florp-main',
        'Predošlé roky',
        'Predošlé roky',
        'manage_options',
        'florp-history',
        array( $this, 'leaders_history_table_admin' )
      );
    }
    if ($this->isFlashmobBlog) {
      $page = add_submenu_page(
        'florp-main',
        'Profil organizátora slovenského flashmobu',
        'Nastavenia profilu',
        'manage_options',
        'florp-main',
        array( $this, 'options_page' )
      );
      $page = add_submenu_page(
        'florp-main',
        'Zoznam účastníkov',
        'Zoznam účastníkov',
        'manage_options',
        'florp-participants',
        array( $this, 'participants_table_admin' )
      );
      $page = add_submenu_page(
        'florp-main',
        'Tričká',
        'Tričká',
        $this->strUserRoleRegistrationAdminSvk,
        'florp-tshirts',
        array( $this, 'tshirts_table_admin' )
      );
    }

    if ($this->isIntfBlog) {
      add_menu_page(
        "Medzinárodný Flashmob",
        'Medzinárodný Flashmob',
        'manage_options',
        'florp-international',
        array( $this, "options_page_international" ),
        // plugins_url( 'flashmob-organizer-profile/img/florp-icon-30.png' ),
        "dashicons-admin-site",
        58
      );
      $page = add_submenu_page(
        'florp-international',
        'Medzinárodný Flashmob',
        'Nastavenia prihlásenia',
        'manage_options',
        'florp-international',
        array( $this, 'options_page_international' )
      );
      $page = add_submenu_page(
        'florp-international',
        'Zoznam účastníkov',
        'Zoznam účastníkov',
        'manage_options',
        'florp-intf-participants',
        array( $this, 'participants_table_admin_intf' )
      );
      $page = add_submenu_page(
        'florp-international',
        'Tričká',
        'Tričká',
        $this->strUserRoleRegistrationAdminIntf,
        'florp-intf-tshirts',
        array( $this, 'tshirts_table_admin_intf' )
      );
    }
  }

  public function leaders_table_admin() {
    echo "<div class=\"wrap\"><h1>" . "Zoznam lídrov" . "</h1>";

    if (defined('FLORP_DEVEL') && FLORP_DEVEL === true) {
      // echo "<pre>";var_dump($this->aOptions['aParticipants']);echo "</pre>"; // NOTE DEVEL
      // echo "<pre>";var_dump($this->aOptions['aParticipants'][55]);echo "</pre>"; // NOTE DEVEL
      // for ($i = 40; $i <= 44; $i++) {
      //   $iLeaderID = 55;
      //   $strEmail = 'kosar.karol+'.$i.'@gmail.com';
      //   $this->aOptions['aParticipants'][$iLeaderID][$strEmail] = $this->aOptions['aParticipants'][54]['kosar.karol+1@gmail.com'];
      //   $this->aOptions['aParticipants'][$iLeaderID][$strEmail]['user_email'] = $strEmail;
      //   $this->aOptions['aParticipants'][$iLeaderID][$strEmail]['flashmob_city'] = 'Brezová pod Bradlom';
      // }
      // $this->save_options();
      // update_user_meta(54, 'flashmob_organizer', '0');
      // update_user_meta(55, 'flashmob_organizer', '1');
      // update_user_meta(56, 'flashmob_organizer', '1');
      // update_user_meta(29, 'flashmob_organizer', '0');
      // update_user_meta(32, 'flashmob_organizer', '0');
    }

    $aUsers = $this->getFlashmobSubscribers( 'all', true );
    $aCancelFlashmobProperties = array(
      'buttonLabels' => array(),
      'userDropdowns' => array(),
      'userDropdownNames' => array(),
      'actions' => array(),
    );
    foreach ($aUsers as $oLeader) {
      $iLeaderID = $oLeader->ID;
      $aCancelFlashmobProperties['buttonLabels'][$iLeaderID] = "Zrušiť flashmob";
      $aCancelFlashmobProperties['userDropdowns'][$iLeaderID] = "<br/>\n<select name=\"florp_cancel_flashmob_reassign_participants-{$iLeaderID}\"><option value=\"0\">[nikoho, zmazať]</option>";
      $aCancelFlashmobProperties['userDropdownNames'][$iLeaderID] = "florp_cancel_flashmob_reassign_participants-{$iLeaderID}";
      foreach ($aUsers as $oUser) {
        $iUserID = $oUser->ID;
        $aAllMeta = array_map(
          array($this, 'get_value_maybe_fix_unserialize_array'),
          get_user_meta( $iUserID )
        );
        $bIsOrganizer = false;
        foreach( $this->aSubscriberTypes as $strSubscriberType) {
          if (!in_array($strSubscriberType, $this->aMetaFieldsFlashmobToArchive)) {
            continue;
          }
          $bIsOrganizer = isset($aAllMeta[$strSubscriberType]) && $aAllMeta[$strSubscriberType];
          break;
        }
        if (!$bIsOrganizer) {
          continue;
        }
        $strSelected = "";
        if ($iUserID === $iLeaderID) {
          $strSelected = ' selected="selected"';
        }
        $aCancelFlashmobProperties['userDropdowns'][$iLeaderID] .= "<option value=\"{$iUserID}\"{$strSelected}>{$iUserID}: {$oUser->first_name} {$oUser->last_name}</option>";
      }

      $aCancelFlashmobProperties['userDropdowns'][$iLeaderID] .= "</select>";
      $bIsOrganizer = false;

      $aAllMeta = array_map(
        array($this, 'get_value_maybe_fix_unserialize_array'),
        get_user_meta( $iLeaderID )
      );
      foreach( $this->aSubscriberTypes as $strSubscriberType) {
        if (!in_array($strSubscriberType, $this->aMetaFieldsFlashmobToArchive)) {
          continue;
        }
        $bIsOrganizer = isset($aAllMeta[$strSubscriberType]) && $aAllMeta[$strSubscriberType];
        break;
      }
      $aParticipants = $this->get_flashmob_participants( $iLeaderID, false, true );
      $bHasParticipants = (count($aParticipants) > 0);

      if (!$bHasParticipants) {
        $aCancelFlashmobProperties['userDropdowns'][$iLeaderID] = "";
        $aCancelFlashmobProperties['userDropdownNames'][$iLeaderID] = false;
      }

      if ($bIsOrganizer) {
        $aCancelFlashmobProperties['actions'][$iLeaderID] = "cancel_flashmob";
        if ($bHasParticipants) {
          $aCancelFlashmobProperties['buttonLabels'][$iLeaderID] .= " a presunúť účastníkov na:";
        }
      } elseif ($bHasParticipants) {
        $aCancelFlashmobProperties['actions'][$iLeaderID] = "move_flashmob_participants";
        $aCancelFlashmobProperties['buttonLabels'][$iLeaderID] = "Presunúť účastníkov na:";
      } else {
        $aCancelFlashmobProperties['actions'][$iLeaderID] = false;
        $aCancelFlashmobProperties['buttonLabels'][$iLeaderID] = false;
      }
    }

    $strEcho = '<table class="widefat striped"><th>Meno</th><th>Email</th><th>Mesto</th><th>Preferencie</th><th>Profil</th><th>Účastníci</th>';
    foreach ($aUsers as $oUser) {
      $iUserID = $oUser->ID;
      $aAllMeta = array_map(
        array($this, 'get_value_maybe_fix_unserialize_array'),
        get_user_meta( $iUserID )
      );
      $strIsPending = "";
      if (in_array( $this->strUserRolePending, (array) $oUser->roles )) {
        $strIsPending = " ({$this->strUserRolePendingName})";
      }
      $strButtons = "";
      $strRowID = "florpRow-".$iUserID;
      if ($aCancelFlashmobProperties['buttonLabels'][$iUserID] && $aCancelFlashmobProperties['actions'][$iUserID]) {
        $strDoubleCheckQuestion = "Ste si istý?";
        $strButtonLabel = $aCancelFlashmobProperties['buttonLabels'][$iUserID];
        $strButtonID = "florpButton-cancelFlashmob-".$iUserID;
        $strDataUseInputNames = '';
        if ($aCancelFlashmobProperties['userDropdownNames'][$iUserID]) {
          $strDataUseInputNames = ' data-use-input-names="'.$aCancelFlashmobProperties['userDropdownNames'][$iUserID].'"';
        }
        $strButtons = '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" data-user-id="'.$iUserID.'"'.$strDataUseInputNames.' data-sure="0" data-action="'.$aCancelFlashmobProperties['actions'][$iUserID].'" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabel.'</span>';
        if ($aCancelFlashmobProperties['userDropdowns'][$iUserID]) {
          $strButtons .= " ".$aCancelFlashmobProperties['userDropdowns'][$iUserID];
        }
      }
      $strEcho .= '<tr class="row" data-row-id="'.$strRowID.'">';
      $strEcho .=   '<td><span title="ID: '.$iUserID.'">'.$oUser->first_name.' '.$oUser->last_name.$strIsPending.'</span>'.$strButtons.'</td>';
      $strEcho .=   '<td><a name="'.$iUserID.'">'.$oUser->user_email.'</a></td>';
      $strEcho .=   '<td>'.$aAllMeta['flashmob_city'].'</td>';
      $strEcho .=   '<td>';
      foreach( $this->aSubscriberTypes as $strSubscriberType) {
        if ($this->aOptions['iCoursesNumberEnabled'] == 0 && in_array($strSubscriberType, $this->aMetaFieldsTeacher)) {
          continue;
        }
        $bChecked = isset($aAllMeta[$strSubscriberType]) && $aAllMeta[$strSubscriberType];
        $strValue = $bChecked ? '<input type="checkbox" disabled checked /><span class="hidden">yes</span>' : '<input type="checkbox" disabled /><span class="hidden">no</span>';
        $strLabel = str_replace(
          array('flashmob_organizer', 'teacher'),
          array('Zorganizuje Flashmob', 'Učí kurzy'),
          $strSubscriberType
        );
        $strEcho .= $strLabel.": ".$strValue.'<br>';
      }
      $strEcho .=   '</td>';
      $strEcho .=   '<td>';
      $aCoursesInfoKeys = array( 'courses_info', 'courses_info_2', 'courses_info_3' );
      $aSingleCheckboxes = array( 'courses_in_city_2', 'courses_in_city_3', 'preference_newsletter', 'hide_leader_info' );
      foreach ($this->aMetaFields as $strMetaKey) {
        if (!isset($aAllMeta[$strMetaKey]) || (!is_bool($aAllMeta[$strMetaKey]) && !is_numeric($aAllMeta[$strMetaKey]) && empty($aAllMeta[$strMetaKey])) || $aAllMeta[$strMetaKey] === 'null' || in_array($strMetaKey, $this->aSubscriberTypes)) {
          continue;
        }

        if ($this->aOptions['iCoursesNumberEnabled'] == 0 && in_array($strMetaKey, $this->aMetaFieldsTeacher)) {
          continue;
        }

        if (in_array( $strMetaKey, $aCoursesInfoKeys )) {
          continue;
        }

        if (is_array($aAllMeta[$strMetaKey])) {
          $strValue = implode( ', ', $aAllMeta[$strMetaKey]);
        } elseif (in_array($strMetaKey, $aSingleCheckboxes) || is_bool($aAllMeta[$strMetaKey])) {
          $strValue = $aAllMeta[$strMetaKey] ? '<input type="checkbox" disabled checked /><span class="hidden">yes</span>' : '<input type="checkbox" disabled /><span class="hidden">no</span>';
        } else {
          $strValue = $aAllMeta[$strMetaKey];
        }
        $strFieldName = ucfirst( str_replace( '_', ' ', $strMetaKey ) );
        if (stripos( $strValue, 'https://' ) === 0 || stripos( $strValue, 'http://' ) === 0) {
          $strEcho .= '<a href="'.$strValue.'" target="_blank">'.$strFieldName.'</a><br>';
        } else {
          $strEcho .= '<strong>' . $strFieldName . '</strong>: ' . $strValue.'<br>';
        }
      }
      $aParticipants = $this->get_flashmob_participants( $iUserID, false, true );
      if (empty($aParticipants) || empty($aParticipants[$iUserID])) {
        $iParticipantCount = 0;
      } else {
        $iParticipantCount = count($aParticipants[$iUserID]);
      }
      $strEcho .= '<strong>Participant count</strong>: ' . $iParticipantCount .'<br>';
      $strEcho .=   '</td>';
      $strEcho .=   '<td>';
      if (!empty($aParticipants)) {
        $aParticipantsOfUser = $aParticipants[$iUserID];
        if (!empty($aParticipantsOfUser)) {
          foreach ($aParticipantsOfUser as $strEmail => $aParticipantData) {
            $strEcho .= "<a href=\"".admin_url('admin.php?page=florp-participants')."#{$aParticipantData['user_email']}\">{$aParticipantData['first_name']} {$aParticipantData['last_name']}</a><br>";
          }
        }
      }
      $strEcho .=   '</td>';
      $strEcho .= '</tr>';
    }
    $strEcho .= '</table>';
    echo $strEcho;
    echo $this->get_missed_submissions_table( $this->iMainBlogID );

    echo '</div><!-- .wrap -->';
  }

  public function participants_table_admin() {
    echo "<div class=\"wrap\"><h1>" . "Zoznam účastníkov slovenského flashmobu" . "</h1>";

    $strEcho = '<table class="widefat striped"><th>Meno</th><th>Email</th><th>Mesto</th><th>Líder</th><th>Profil</th>';
    $aParticipants = $this->get_flashmob_participants( 0, false, true );
    // echo "<pre>";var_dump($aParticipants);echo "</pre>"; // NOTE DEVEL
    // echo "<pre>";var_dump($this->get_flashmob_participant_csv());echo "</pre>"; // NOTE DEVEL

    if (!empty($aParticipants)) {
      $aReplacements = array(
        'gender' => array(
          'from'  => array( 'muz', 'zena', 'par' ),
          'to'    => array( 'muž', 'žena', 'pár' )
        ),
        'dance_level' => array(
          'from'  => array( '_', 'zaciatocnik', 'pokrocily', 'ucitel' ),
          'to'    => array( ' ', 'začiatočník', 'pokročilý', 'učiteľ' )
        ),
        'preferences' => array(
          'from'  => array( 'flashmob_participant_tshirt', 'newsletter_subscribe' ),
          'to'    => array( 'Chcem pamätné Flashmob tričko', 'Chcem dostávať newsletter' )
        )
      );

      $aParticipantsFlat = array();
      foreach ($aParticipants as $iLeaderID => $aParticipantsOfLeader) {
        foreach ($aParticipantsOfLeader as $strEmail => $aParticipantData) {
          $strKey = $strEmail."_".$iLeaderID;
          $aParticipantsFlat[$strKey] = $aParticipantData;
          $aParticipantsFlat[$strKey]['leader_user_id'] = $iLeaderID;
          $aParticipantsFlat[$strKey]['user_email'] = $strEmail;
        }
      }
      uasort($aParticipantsFlat, array($this, "participant_sort"));

      foreach ($aParticipantsFlat as $strKeyFlat => $aParticipantData) {
        $iLeaderID = $aParticipantData['leader_user_id'];
        $strEmail = $aParticipantData['user_email'];
        foreach ($aReplacements as $strKey => $aReplacementArr) {
          $aParticipantData[$strKey] = str_replace( $aReplacementArr['from'], $aReplacementArr['to'], $aParticipantData[$strKey]);
        }

        $strRowID = "florpRow-".$iLeaderID."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
        $strDoubleCheckQuestion = "Ste si istý?";
        $strButtons = "";

        if (isset($aParticipantData["paid_fee"])) {
          // Paid fee info //
          $strTitle = ' title="'.date( $this->strDateFormat, $aParticipantData["paid_fee"] ).'"';
          $strLabel = "Zaplatil(a) reg. poplatok";
          $strButtons .= '<span data-button-id="florpButton-paid-fee-'.$iLeaderID.'-'.preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail). '" class="notice notice-success"'.$strTitle.'>'.$strLabel.'</span>';
        } else {
          // Delete button //
          $strButtonLabel = "Zmazať";
          $strButtonID = "florpButton-".$iLeaderID."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
          $strButtons = '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" data-leader-id="'.$iLeaderID.'" data-participant-email="'.$strEmail.'" data-sure="0" data-action="delete_florp_participant" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabel.'</span>';

          // Paid fee button //
          $strButtonLabel = "Zaplatil(a) reg. poplatok";
          $strButtonID = "florpButton-paid-fee-".$iLeaderID."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
          $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" data-leader-id="'.$iLeaderID.'" data-participant-email="'.$strEmail.'" data-sure="0" data-action="florp_participant_paid_fee" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabel.'</span>';
        }

        if (isset($aParticipantData["attend"])) {
          // Attendance info //
          $strTitle = "";
          if (isset($aParticipantData["attend_set_timestamp"])) {
            $strTitle = ' title="'.date( $this->strDateFormat, $aParticipantData["attend_set_timestamp"] ).'"';
          }
          $strLabelForHiding = "Zúčastní/-il(a) sa";
          $strLabel = $aParticipantData["attend"] == "1" ? $strLabelForHiding : "Nezúčastní/-il(a) sa";
          $strButtons .= '<span data-button-id="florpButton-attend'.$aParticipantData["attend"].'-'.$iLeaderID.'-'.preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail). '" class="notice notice-success"'.$strTitle.' data-text="'.$strLabelForHiding.'">'.$strLabel.'</span>';
        } else {
          // Will/Did attend button //
          $strButtonID = "florpButton-attend1-".$iLeaderID."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
          $strButtonLabel = "Zúčastní/-il(a) sa";
          $strLabelForHiding = $strButtonLabel;
          $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" data-leader-id="'.$iLeaderID.'" data-participant-email="'.$strEmail.'" data-sure="0" data-action="florp_participant_attend" data-attend="1" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'" data-text="'.$strLabelForHiding.'">'.$strButtonLabel.'</span>';

          // Won't/Didn't attend button //
          $strButtonID = "florpButton-attend0-".$iLeaderID."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
          $strButtonLabel = "Nezúčastní/-il(a) sa";
          $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" data-leader-id="'.$iLeaderID.'" data-participant-email="'.$strEmail.'" data-sure="0" data-action="florp_participant_attend" data-attend="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'" data-text="'.$strLabelForHiding.'">'.$strButtonLabel.'</span>';
        }

        $strEcho .= '<tr class="row" data-row-id="'.$strRowID.'">';
        $strEditSubmission = '';
        if ($this->aOptions['bEditSubmissions'] || (isset($_POST['edit-submissions']) && $_POST['edit-submissions'] === 'on') || (defined('FLORP_EDIT_SUBMISSIONS') && FLORP_EDIT_SUBMISSIONS === true)) {
          $strDomain = '';
          if (!$this->isFlashmobBlog) {
            $strDomain = 'http://flashmob.salsarueda.dance';
          }
          $strEditSubmission = ' <span class="submission-edit">(<a href="'.$strDomain.'/edit-svk-participant-submission/?leader_id='.$iLeaderID.'&email='.urlencode($strEmail).'" target="_blank">Edit</a>)</span>';
        }
        $strEcho .=   '<td>'.$aParticipantData['first_name'].' '.$aParticipantData['last_name'].$strEditSubmission.$strButtons.'</td>';
        $strEcho .=   '<td><a name="'.$aParticipantData['user_email'].'">'.$aParticipantData['user_email'].'</a></td>';
        $oLeader = get_user_by( 'id', $iLeaderID );
        $strLeadersFlashmobCity = get_user_meta( $iLeaderID, 'flashmob_city', true );
        $strWarning = "";
        if ($strLeadersFlashmobCity !== $aParticipantData['flashmob_city']) {
          $strTitle = " title=\"Pozor: pri registrácii účastníka mal líder nastavené mesto flashmobu na  {$aParticipantData['flashmob_city']}!\"";
          $strWarning = ' <span '.$strTitle.' class="dashicons dashicons-warning"></span>';
        }
        $strEcho .=   '<td>'.$strLeadersFlashmobCity.$strWarning.'</td>';
        $strIsPending = "";
        if (in_array( $this->strUserRolePending, (array) $oLeader->roles )) {
          $strIsPending = " ({$this->strUserRolePendingName})";
        }
        $strEcho .=   '<td><a href="'.admin_url('admin.php?page=florp-leaders')."#{$iLeaderID}\">{$oLeader->first_name} {$oLeader->last_name}</a>{$strIsPending}</td>";
        $strEcho .=   '<td>';
        $aTimestamps = array( 'registered', 'tshirt_order_cancelled_timestamp', 'updated_timestamp', 'paid_fee', 'attend_set_timestamp' );
        $bOrderedTshirt = isset($aParticipantData['preferences']) && is_array($aParticipantData['preferences']) && in_array('Chcem pamätné Flashmob tričko', $aParticipantData['preferences']);
        $aSkip = array( 'first_name', 'last_name', 'user_email', 'flashmob_city', 'leader_user_id' );
        if (!isset($aParticipantData['leader_notified'])) {
          $aParticipantData['leader_notified'] = false;
        }
        foreach ($aParticipantData as $strKey => $mixValue) {
          if (!isset($mixValue) || (!is_bool($mixValue) && !is_numeric($mixValue) && empty($mixValue)) || $mixValue === 'null' || in_array( $strKey, $aSkip )) {
            continue;
          }
          if (in_array($strKey, $aTimestamps)) {
            $strKey = str_replace("_timestamp", "", $strKey);
            $strValue = date( $this->strDateFormat, $mixValue );
          } elseif (is_array($mixValue)) {
            $strValue = implode( ', ', $mixValue);
          } elseif (is_bool($mixValue)) {
            $strValue = $mixValue ? '<input type="checkbox" disabled checked /><span class="hidden">yes</span>' : '<input type="checkbox" disabled /><span class="hidden">no</span>';
          } else {
            $strValue = $mixValue;
          }
          $strFieldName = ucfirst( str_replace( '_', ' ', $strKey ) );
          if (false !== stripos($strKey, 'tshirt') && !$bOrderedTshirt) {
            // Not relevant //
            /*
            echo "<pre>";
            var_dump($aParticipantData['user_email'], $strKey, $bOrderedTshirt, $aParticipantData['preferences'], is_array($aParticipantData['preferences']), in_array('flashmob_participant_tshirt', $aParticipantData['preferences']));
            echo "</pre>";
            //*/
          } else {
            $strEcho .= '<strong>' . $strFieldName . '</strong>: ' . $strValue.'<br>';
          }
        }
        $strEcho .=   '</td>';
        $strEcho .= '</tr>';
      }
    }
    $strEcho .= '</table>';
    if (!empty($aParticipants)) {
      $strEcho .= '<form action="" method="post">';
      $strEcho .= '<input type="hidden" name="security" value="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">';
      $strEcho .= '<input type="hidden" name="florp-download-participant-csv" value="1">';
      $strEcho .= '<input id="florp-download-participant-csv-all" class="button button-primary button-large" name="florp-download-participant-csv-all" type="submit" value="Stiahni CSV - všetko" />';
      $strEcho .= '<input id="florp-download-participant-csv-notshirts" class="button button-primary button-large" name="florp-download-participant-csv-notshirts" type="submit" value="Stiahni CSV - bez tričiek" />';
      $strEcho .= '</form>';
    }
    echo $strEcho;
    echo $this->get_missed_submissions_table( $this->iFlashmobBlogID );
    echo '</div><!-- .wrap -->';
  }

  public function participants_table_admin_intf() {
    echo "<div class=\"wrap\"><h1>" . "Zoznam účastníkov medzinárodného flashmobu" . "</h1>";

    $strEcho = '<table class="widefat striped"><th>Meno</th><th>Email</th><th>Mesto (kde tancuje)</th><th>Profil</th>'.PHP_EOL;
    $aParticipants = $this->aOptions['aIntfParticipants'];
    // echo "<pre>";var_dump($aParticipants);echo "</pre>"; // NOTE DEVEL
    // echo "<pre>";var_dump($this->get_flashmob_participant_csv('all', true));echo "</pre>"; // NOTE DEVEL

    if (!empty($aParticipants)) {
      $aReplacements = array(
        'gender' => array(
          'from'  => array( 'muz', 'zena', 'par' ),
          'to'    => array( 'muž', 'žena', 'pár' )
        ),
        'dance_level' => array(
          'from'  => array( '_', 'zaciatocnik', 'pokrocily', 'ucitel' ),
          'to'    => array( ' ', 'začiatočník', 'pokročilý', 'učiteľ' )
        ),
        'preferences' => array(
          'from'  => array( 'flashmob_participant_tshirt', 'newsletter_subscribe' ),
          'to'    => array( 'Chcem pamätné Flashmob tričko', 'Chcem dostávať newsletter' )
        )
      );
      $aLabels = array(
        'intf_city' => "Mesto (anketa)"
      );

      $aParticipantsFlat = array();
      $iYear = $this->aOptions['iIntfFlashmobYear'];
      foreach ($aParticipants[$iYear] as $strEmail => $aParticipantData) {
        $strKey = $strEmail."_".$iYear;
        $aParticipantsFlat[$strKey] = $aParticipantData;
        $aParticipantsFlat[$strKey]['year'] = $iYear;
        $aParticipantsFlat[$strKey]['user_email'] = $strEmail;
      }
      uasort($aParticipantsFlat, array($this, "participant_sort"));

      foreach ($aParticipantsFlat as $strKeyFlat => $aParticipantData) {
        $strEmail = $aParticipantData['user_email'];
        foreach ($aReplacements as $strKey => $aReplacementArr) {
          $aParticipantData[$strKey] = str_replace( $aReplacementArr['from'], $aReplacementArr['to'], $aParticipantData[$strKey]);
        }
        $strDoubleCheckQuestion = "Ste si istý?";
        $strRowID = "florpRow-".$iYear."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);

        $strButtons = "";

        if (isset($aParticipantData["paid_fee"])) {
          // Paid fee info //
          $strTitle = ' title="'.date( $this->strDateFormat, $aParticipantData["paid_fee"] ).'"';
          $strLabel = "Zaplatil(a) reg. poplatok";
          $strButtons .= '<span data-button-id="florpButton-paid-fee-'.$iYear.'-'.preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail). '" class="notice notice-success"'.$strTitle.'>'.$strLabel.'</span>';
        } else {
          // Delete button //
          $strButtonID = "florpButton-".$iYear."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
          $strButtonLabel = "Zmazať";
          $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" data-year="'.$iYear.'" data-participant-email="'.$strEmail.'" data-sure="0" data-action="delete_florp_intf_participant" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabel.'</span>';

          // Paid fee button //
          $strButtonLabel = "Zaplatil(a) reg. poplatok";
          $strButtonID = "florpButton-paid-fee-".$iYear."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
          $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" data-year="'.$iYear.'" data-participant-email="'.$strEmail.'" data-sure="0" data-action="florp_intf_participant_paid_fee" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabel.'</span>';
        }

        if (isset($aParticipantData["attend"])) {
          // Attendance info //
          $strTitle = "";
          if (isset($aParticipantData["attend_set_timestamp"])) {
            $strTitle = ' title="'.date( $this->strDateFormat, $aParticipantData["attend_set_timestamp"] ).'"';
          }
          $strLabelForHiding = "Zúčastní/-il(a) sa";
          $strLabel = $aParticipantData["attend"] == "1" ? $strLabelForHiding : "Nezúčastní/-il(a) sa";
          $strButtons .= '<span data-button-id="florpButton-attend'.$aParticipantData["attend"].'-'.$iYear.'-'.preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail). '" class="notice notice-success"'.$strTitle.' data-text="'.$strLabelForHiding.'">'.$strLabel.'</span>';
        } else {
          // Will/Did attend button //
          $strButtonID = "florpButton-attend1-".$iYear."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
          $strButtonLabel = "Zúčastní/-il(a) sa";
          $strLabelForHiding = $strButtonLabel;
          $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" data-year="'.$iYear.'" data-participant-email="'.$strEmail.'" data-sure="0" data-action="florp_intf_participant_attend" data-attend="1" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'" data-text="'.$strLabelForHiding.'">'.$strButtonLabel.'</span>';

          // Won't/Didn't attend button //
          $strButtonID = "florpButton-attend0-".$iYear."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
          $strButtonLabel = "Nezúčastní/-il(a) sa";
          $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" data-year="'.$iYear.'" data-participant-email="'.$strEmail.'" data-sure="0" data-action="florp_intf_participant_attend" data-attend="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'" data-text="'.$strLabelForHiding.'">'.$strButtonLabel.'</span>';
        }

        $strEcho .= '<tr class="row" data-row-id="'.$strRowID.'">'.PHP_EOL;
        $strEditSubmission = '';
        if ($this->aOptions['bEditSubmissions'] || (isset($_POST['edit-submissions']) && $_POST['edit-submissions'] === 'on') || (defined('FLORP_EDIT_SUBMISSIONS') && FLORP_EDIT_SUBMISSIONS === true)) {
          $strEditSubmission = ' <span class="submission-edit">(<a href="/edit-intf-participant-submission/?year='.$iYear.'&email='.urlencode($strEmail).'" target="_blank">Edit</a>)</span>';
        }
        $strEcho .=   '<td>'.$aParticipantData['first_name'].' '.$aParticipantData['last_name'].$strEditSubmission.$strButtons.'</td>'.PHP_EOL;
        $strEcho .=   '<td><a name="'.$aParticipantData['user_email'].'">'.$aParticipantData['user_email'].'</a></td>'.PHP_EOL;
        $strEcho .=   '<td>'.$aParticipantData['flashmob_city'].'</td>'.PHP_EOL;
        $aTimestamps = array( 'registered', 'paid_fee', 'attend_set_timestamp', 'updated_timestamp' );
        $aSkip = array( 'first_name', 'last_name', 'user_email', 'flashmob_city' );
        $bOrderedTshirt = isset($aParticipantData['preferences']) && is_array($aParticipantData['preferences']) && in_array('Chcem pamätné Flashmob tričko', $aParticipantData['preferences']);
        $strEcho .=   '<td>'.PHP_EOL;
        foreach ($aParticipantData as $strKey => $mixValue) {
          if (!isset($mixValue) || (!is_bool($mixValue) && !is_numeric($mixValue) && empty($mixValue)) || $mixValue === 'null' || in_array( $strKey, $aSkip )) {
            continue;
          }
          if (in_array($strKey, $aTimestamps)) {
            $strKey = str_replace("_timestamp", "", $strKey);
            $strValue = date( $this->strDateFormat, $mixValue );
          } elseif (is_array($mixValue)) {
            $strValue = implode( ', ', $mixValue);
          } elseif (is_bool($mixValue)) {
            $strValue = $mixValue ? '<input type="checkbox" disabled checked /><span class="hidden">yes</span>' : '<input type="checkbox" disabled /><span class="hidden">no</span>';
          } else {
            $strValue = $mixValue;
          }
          if (isset($aLabels[$strKey])) {
            $strFieldName = $aLabels[$strKey];
          } else {
            $strFieldName = ucfirst( str_replace( '_', ' ', $strKey ) );
          }
          if (false !== stripos($strKey, 'tshirt') && !$bOrderedTshirt) {
            // Not relevant //
            /*
            echo "<pre>";
            var_dump($aParticipantData['user_email'], $strKey, $bOrderedTshirt, $aParticipantData['preferences'], is_array($aParticipantData['preferences']), in_array('flashmob_participant_tshirt', $aParticipantData['preferences']));
            echo "</pre>";
            //*/
          } else {
            $strEcho .= '<strong>' . $strFieldName . '</strong>: ' . $strValue.'<br>'.PHP_EOL;
          }
        }
        $strEcho .=   '</td>'.PHP_EOL;
        $strEcho .= '</tr>'.PHP_EOL;
      }
    }
    $strEcho .= '</table>';
    if (!empty($aParticipants)) {
      $strEcho .= '<form action="" method="post">';
      $strEcho .= '<input type="hidden" name="security" value="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">';
      $strEcho .= '<input type="hidden" name="florp-download-intf-participant-csv" value="1">';
      $strEcho .= '<input id="florp-download-intf-participant-csv-all" class="button button-primary button-large" name="florp-download-intf-participant-csv-all" type="submit" value="Stiahni CSV - všetko" />';
      $strEcho .= '<input id="florp-download-intf-participant-csv-notshirts" class="button button-primary button-large" name="florp-download-intf-participant-csv-notshirts" type="submit" value="Stiahni CSV - bez tričiek" />';
      $strEcho .= '</form>';
    }
    echo $strEcho;
    // echo $this->get_missed_submissions_table( $this->iFlashmobBlogID );
    echo '</div><!-- .wrap -->';
  }

  public function tshirts_table_admin_intf() {
    return $this->tshirts_table_admin(true);
  }

  public function tshirts_table_admin($bIntf = false) {
    echo "<div class=\"wrap\">\n<h1>" . "Tričká" . "</h1>\n";

    $aTshirts = $this->get_tshirts('all', false, $bIntf);
    if (empty($aTshirts)) {
      echo "<p>Nie sú objednané žiadne tričká.</p>\n</div><!-- .wrap -->";
      return;
    }
    // echo "<pre>"; var_dump($aTshirts); echo "</pre>"; // NOTE DEVEL

    $strHeaderLeaderOrYear = $bIntf ? "<th>Rok</th>" : "<th>Líder</th>";
    $strEcho = '<table class="widefat striped"><th>Meno</th><th>Email</th><th>Mesto</th><th>Typ</th>'.$strHeaderLeaderOrYear.'<th>Vlastnosti</th>';

    $sIntfActionPart = $bIntf ? "_intf" : "";
    $sIntfBtnIdPart = $bIntf ? "-intf" : "";

    $iUnpaid = 0;
    $iPaid = 0;
    foreach ($aTshirts as $aTshirtData) {
      $strButtons = "";
      $strDoubleCheckQuestion = "Ste si istý?";
      $strButtonLabelPaid = "Zaplatil tričko";
      $strButtonLabelPaymentWarning = "Upozorniť na neskorú platbu";
      $strButtonLabelCancelOrder = "Zrušiť objednávku";
      $strButtonLabelDelivered = "Tričko odovzdané";
      // We collect the data and button attributes/properties //
      $strData = "";
      foreach ($aTshirtData as $strKey => $mixValue) {
        if ($strKey === "properties" || in_array($strKey, array("id"))) {
          continue;
        } elseif (is_bool($mixValue)) {
          $strValue = $mixValue ? '1' : '0';
        } else {
          $strValue = $mixValue;
        }
        $strValue = str_replace("'", "\'", $strValue);
        $strData .= " data-{$strKey}='{$strValue}'";
      }
      foreach ($aTshirtData['properties'] as $strKey => $strValue) {
        $strValue = str_replace("'", "\'", $strValue);
        $strData .= " data-{$strKey}='{$strValue}'";
      }
      $strRowID = "florpRow-".$aTshirtData["id"];
      $strPaidButtonID = "florpButton-paid-".$aTshirtData["id"];
      $strPaymentWarningButtonID = "florpButton-paymentWarning-".$aTshirtData["id"];
      $strCancelOrderButtonID = "florpButton-cancelOrder-".$aTshirtData["id"];
      $strDeliveredButtonID = "florpButton-tshirtDelivered-".$aTshirtData["id"];

      $strButtons = '';
      if ($aTshirtData["is_leader"]) {
        // no button
        $strButtons = "";
        $iPaid++;
      } elseif ($aTshirtData["is_paid"]) {
        $strTitle = "";
        if (isset($aTshirtData["paid_timestamp"])) {
          $strTitle = ' title="'.date( $this->strDateFormat, $aTshirtData["paid_timestamp"] ).'"';
        }
        $strButtons .= '<span data-button-id="'.$strPaidButtonID.'" class="notice notice-success"'.$strTitle.'>'.$strButtonLabelPaid.'</span>';
        $iPaid++;
      } else {
        $iUnpaid++;

        // Paid button //
        $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabelPaid.'" data-button-id="'.$strPaidButtonID.'" data-row-id="'.$strRowID.'" '.$strData.' data-action="florp'.$sIntfActionPart.'_tshirt_paid" data-sure="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabelPaid.'</span>';

        // Cancel button //
        $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabelCancelOrder.'" data-button-id="'.$strCancelOrderButtonID.'" data-row-id="'.$strRowID.'" '.$strData.' data-action="florp'.$sIntfActionPart.'_tshirt_cancel_order" data-sure="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabelCancelOrder.'</span>';

        // Warning button //
        if (
            (!$bIntf && isset($this->aOptions['strTshirtPaymentWarningNotificationMsg'], $this->aOptions['strTshirtPaymentWarningNotificationSbj']) && !empty($this->aOptions['strTshirtPaymentWarningNotificationMsg']) && !empty($this->aOptions['strTshirtPaymentWarningNotificationSbj']))
            || ($bIntf && isset($this->aOptions['strIntfTshirtPaymentWarningNotificationMsg'], $this->aOptions['strIntfTshirtPaymentWarningNotificationSbj']) && !empty($this->aOptions['strIntfTshirtPaymentWarningNotificationMsg']) && !empty($this->aOptions['strIntfTshirtPaymentWarningNotificationSbj']))
          ) {
          $strWarningClass = "";
          $bShow = true;
          if (
            (!$bIntf && $this->aOptions['iTshirtPaymentWarningButtonDeadline'] > -1 && $this->iTshirtPaymentWarningButtonDeadlineTimestamp <= time())
            || ($bIntf && $this->aOptions['iIntfTshirtPaymentWarningButtonDeadline'] > -1 && $this->iIntfTshirtPaymentWarningButtonDeadlineTimestamp <= time())
          ) {
            // Show //
            $strWarningClass = " button-warning";
          } elseif (isset($aTshirtData["registered_timestamp"]) && $aTshirtData["registered_timestamp"] > 0) {
            $iTimestampNow = (int) current_time( 'timestamp' );
            if ($iTimestampNow - $aTshirtData["registered_timestamp"] > (7*24*3600)) {
              $strWarningClass = " button-warning";
            } else {
              $bShow = false;
            }
          }
          if ($bShow) {
            $strButtons .= '';
            if ($aTshirtData["payment_warning_sent"]) {
              $strTitle = "";
              if (isset($aTshirtData["payment_warning_sent_timestamp"])) {
                $strTitle = ' title="'.date( $this->strDateFormat, $aTshirtData["payment_warning_sent_timestamp"] ).'"';
              }
              $strButtons .= '<span data-button-id="'.$strPaymentWarningButtonID.'" class="notice notice-success"'.$strTitle.' data-text="'.$strButtonLabelPaymentWarning.'">Upozornený na neskorú platbu</span>';
            } else {
              $strButtons .= '<span class="button double-check'.$strWarningClass.'" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabelPaymentWarning.'" data-button-id="'.$strPaymentWarningButtonID.'" data-row-id="'.$strRowID.'" '.$strData.' data-action="florp'.$sIntfActionPart.'_tshirt_send_payment_warning" data-sure="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabelPaymentWarning.'</span>';
            }
          }
        }
      }

      // Delivered button //
      if ($aTshirtData["is_delivered"]) {
        $strTitle = "";
        if (isset($aTshirtData["delivered_timestamp"])) {
          $strTitle = ' title="'.date( $this->strDateFormat, $aTshirtData["delivered_timestamp"] ).'"';
        }
        $strButtons .= '<span data-button-id="'.$strDeliveredButtonID.'" class="notice notice-success"'.$strTitle.'>'.$strButtonLabelDelivered.'</span>';
      } else {
        $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabelDelivered.'" data-button-id="'.$strDeliveredButtonID.'" data-row-id="'.$strRowID.'" '.$strData.' data-action="florp'.$sIntfActionPart.'_tshirt_delivered" data-sure="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabelDelivered.'</span>';
      }

      // BEGIN Participant administration buttons //
      $strEmail = $aTshirtData["email"];
      if ($bIntf) {
        $iLeaderIdOrYear = $aTshirtData["year"];
        $aParticipantData = $this->aOptions['aIntfParticipants'][$iLeaderIdOrYear][$strEmail];
        $strDataLeaderIdOrYear = 'data-year="'.$iLeaderIdOrYear.'"';
        $strIntfActionPart = "_intf";
      } elseif (!$aTshirtData['is_leader']) {
        $iLeaderIdOrYear = $aTshirtData["leader_id"];
        $aParticipantData = $this->aOptions['aParticipants'][$iLeaderIdOrYear][$strEmail];
        $strDataLeaderIdOrYear = 'data-leader-id="'.$iLeaderIdOrYear.'"';
        $strIntfActionPart = "";
      }
      $strDataHide = 'data-hide="1"';

      if ($bIntf || !$aTshirtData['is_leader']) {
        if (isset($aParticipantData["paid_fee"])) {
          // Paid fee info //
          $strTitle = ' title="'.date( $this->strDateFormat, $aParticipantData["paid_fee"] ).'"';
          $strLabel = "Zaplatil(a) reg. poplatok";
          $strButtons .= '<span data-button-id="florpButton-paid-fee-'.$iLeaderIdOrYear.'-'.preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail). '" class="notice notice-success"'.$strTitle.' '.$strDataHide.'>'.$strLabel.'</span>';
        } else {
          // Paid fee button //
          $strButtonLabel = "Zaplatil(a) reg. poplatok";
          $strButtonID = "florpButton-paid-fee-".$iLeaderIdOrYear."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
          $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" '.$strDataLeaderIdOrYear.' data-participant-email="'.$strEmail.'" data-sure="0" data-action="florp'.$strIntfActionPart.'_participant_paid_fee" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'" '.$strDataHide.'>'.$strButtonLabel.'</span>';
        }

        if (isset($aParticipantData["attend"])) {
          // Attendance info //
          $strTitle = "";
          if (isset($aParticipantData["attend_set_timestamp"])) {
            $strTitle = ' title="'.date( $this->strDateFormat, $aParticipantData["attend_set_timestamp"] ).'"';
          }
          $strLabelForHiding = "Zúčastní/-il(a) sa";
          $strLabel = $aParticipantData["attend"] == "1" ? $strLabelForHiding : "Nezúčastní/-il(a) sa";
          $strButtons .= '<span data-button-id="florpButton-attend'.$aParticipantData["attend"].'-'.$iLeaderIdOrYear.'-'.preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail). '" class="notice notice-success"'.$strTitle.' data-text="'.$strLabelForHiding.'" '.$strDataHide.'>'.$strLabel.'</span>';
        } else {
          // Will/Did attend button //
          $strButtonID = "florpButton-attend1-".$iLeaderIdOrYear."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
          $strButtonLabel = "Zúčastní/-il(a) sa";
          $strLabelForHiding = $strButtonLabel;
          $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" '.$strDataLeaderIdOrYear.' data-participant-email="'.$strEmail.'" data-sure="0" data-action="florp'.$strIntfActionPart.'_participant_attend" data-attend="1" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'" data-text="'.$strLabelForHiding.'" '.$strDataHide.'>'.$strButtonLabel.'</span>';

          // Won't/Didn't attend button //
          $strButtonID = "florpButton-attend0-".$iLeaderIdOrYear."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
          $strButtonLabel = "Nezúčastní/-il(a) sa";
          $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" '.$strDataLeaderIdOrYear.' data-participant-email="'.$strEmail.'" data-sure="0" data-action="florp'.$strIntfActionPart.'_participant_attend" data-attend="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'" data-text="'.$strLabelForHiding.'" '.$strDataHide.'>'.$strButtonLabel.'</span>';
        }
      }
      // END Participant administration buttons //

      $strEcho .= '<tr class="row" data-row-id="'.$strRowID.'">';
      $strEcho .=   '<td>'.$aTshirtData['name'].$strButtons.'</td>';
      $strEcho .=   '<td><a name="'.$aTshirtData['email'].'">'.$aTshirtData['email'].'</a></td>';

      $strWarning = "";
      if (!$bIntf && isset($aTshirtData['flashmob_city_at_registration'])) {
        $strTitle = " title=\"Pozor: pri registrácii účastníka mal líder nastavené mesto flashmobu na  {$aTshirtData['flashmob_city_at_registration']}!\"";
        $strWarning = ' <span '.$strTitle.' class="dashicons dashicons-warning"></span>';
      }
      $strEcho .=   '<td>'.$aTshirtData['flashmob_city'].$strWarning.'</td>';
      $strEcho .=   '<td>'.$aTshirtData['type'].'</td>';
      if ($bIntf) {
        $strEcho .=   '<td>'.$aTshirtData['year'].'</td>';
      } else {
        $strEcho .=   '<td>'.$aTshirtData['leader'].'</td>';
      }
      $strEcho .=   '<td>';
      foreach ($aTshirtData['properties'] as $strKey => $strValue) {
        $strFieldName = ($bIntf && $strKey === 'intf_city') ? "Mesto (anketa)" : ucfirst( str_replace( '_', ' ', $strKey ) );
        $strEcho .= '<strong>' . $strFieldName . '</strong>: ' . $strValue.'<br>';
      }
      $strEcho .=   '</td>';
      $strEcho .= '</tr>';
    }
    $strEcho .= '</table>';
    $strEcho .= '<form action="" method="post">';
    $strEcho .= '<input type="hidden" name="security" value="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">';
    $strEcho .= '<input type="hidden" name="florp-download'.$sIntfBtnIdPart.'-tshirt-csv" value="1">';
    if ($iUnpaid > 0 && $iPaid > 0) {
      $strEcho .= '<input id="florp-download'.$sIntfBtnIdPart.'-tshirt-csv-all" class="button button-primary button-large" name="florp-download'.$sIntfBtnIdPart.'-tshirt-csv-all" type="submit" value="Stiahni CSV - všetko" />';
      $strEcho .= '<input id="florp-download'.$sIntfBtnIdPart.'-tshirt-csv-unpaid" class="button button-primary button-large" name="florp-download'.$sIntfBtnIdPart.'-tshirt-csv-unpaid" type="submit" value="Stiahni CSV - nezaplatené" />';
      $strEcho .= '<input id="florp-download'.$sIntfBtnIdPart.'-tshirt-csv-paid" class="button button-primary button-large" name="florp-download'.$sIntfBtnIdPart.'-tshirt-csv-paid" type="submit" value="Stiahni CSV - zaplatené" />';
    } elseif ($iUnpaid > 0) {
      $strEcho .= '<input id="florp-download'.$sIntfBtnIdPart.'-tshirt-csv-unpaid" class="button button-primary button-large" name="florp-download'.$sIntfBtnIdPart.'-tshirt-csv-unpaid" type="submit" value="Stiahni CSV - nezaplatené (všetko)" />';
    } elseif ($iPaid > 0) {
      $strEcho .= '<input id="florp-download'.$sIntfBtnIdPart.'-tshirt-csv-paid" class="button button-primary button-large" name="florp-download'.$sIntfBtnIdPart.'-tshirt-csv-paid" type="submit" value="Stiahni CSV - zaplatené (všetko)" />';
    }

    if ($this->aOptions['bTshirtOrdersAdminEnabled'] && !$bIntf) {// TODO not implemented for INTF yet
      // Order date table //
      $aOrderDates = $this->get_tshirt_order_dates(false, $bIntf);

      $strEcho .= "<p></p>\n<h1>Dátumy objednávok</h1>";
      $strEcho .= '<table class="widefat striped florpTshirtOrderTable"><th>Dátum</th><th>Typ</th><th>Stiahnuť zahrnuté objednávky (CSV)</th><th>Stiahnuť objednávky po tomto dátume (CSV)</th>';
      if (!empty($aOrderDates)) {
        foreach ($aOrderDates as $iTimestamp => $aOrderData) {
          $aOrderData['id'] = $iTimestamp;
          $strEcho .= $this->get_tshirt_order_dates_row( $aOrderData );
        }
      }
      $strEcho .= '</table>';
      $strEcho .= '</form>';

      // 'Add order' button with select - all / paid / unpaid
      $strRowID = "florpRow-addOrderDate-0";
      $strButtonID = "florpButton-addOrderDate-0-new";
      $strButtonLabel = "Pridaj";
      $strAction = "add_order_date";
      $strDoubleCheckQuestion = "Ste si istý?";
      $strData = "";
      $strEcho .= "<p class=\"row addOrderDateParagraph\" data-row-id=\"{$strRowID}\">Pridať dátum objednávky: ";
      $strEcho .= '<input type="hidden" id="orderdate_timestamp_field" name="orderdate_timestamp" value="0">';
      $strEcho .= '<input type="text" name="orderdate" data-alt-field="#orderdate_timestamp_field" class="jquery-datetimepicker" autocomplete="off" value="">';
      $strEcho .= '<select name="ordertype"><option value="all">Všetko (ešte neobjednané)</option><option value="paid">Zaplatené (ešte neobjednané)</option><option value="unpaid">Nezaplatené (ešte neobjednané)</option></select>';
      $strEcho .= ' <span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'"'.$strData.' data-use-input-names="orderdate,orderdate_timestamp,ordertype" data-action="'.$strAction.'" data-sure="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabel.'</span>';
      $strEcho .= "</p>";
    }
    echo $strEcho;
    echo '</div><!-- .wrap -->';
  }

  public function leaders_history_table_admin() {
    echo "<div class=\"wrap\"><h1>" . "Predošlé roky" . "</h1>";
    $aUsers = $this->getFlashmobSubscribers( 'all', true );
    $strEcho = '<table class="widefat striped"><th>Rok</th><th>Meno</th><th>M(i)esto Flashmobu</th><th>Profil</th>';
    foreach ($this->aOptions["aYearlyMapOptions"] as $iYear => $aMapOptionsForYear) {
      foreach ($aMapOptionsForYear as $iUserID => $aOptions) {
        $strButtons = "";
        $strEcho .= '<tr>';
        $strEcho .=   '<td>'.$iYear.'</td>';
        $strEcho .=   '<td>'.$aOptions['first_name'].' '.$aOptions['last_name'].$strButtons.'</td>';
        $strFlashmobLocation = "-";
        if (isset($aOptions['flashmob_address'])) {
          $strFlashmobLocation = $aOptions['flashmob_address'];
        } elseif (isset($aOptions['flashmob_city'])) {
          $strFlashmobLocation = $aOptions['flashmob_city'];
        } elseif (isset($aOptions['school_city'])) {
          $strFlashmobLocation = "({$aOptions['school_city']})";
        }
        $strEcho .=   '<td>'.$strFlashmobLocation.'</td>';
        $strEcho .=   '<td>';
        $aSkip = array( 'first_name', 'last_name' );
        foreach ($aOptions as $strKey => $strValue) {
          if (in_array( $strKey, $aSkip )) {
            continue;
          }

          $strFieldName = ucfirst( str_replace( '_', ' ', $strKey ) );
          if (stripos( $strValue, 'https://' ) === 0 || stripos( $strValue, 'http://' ) === 0) {
            $strEcho .= '<a href="'.$strValue.'" target="_blank">'.$strFieldName.'</a><br>';
          } else {
            $strEcho .= '<strong>' . $strFieldName . '</strong>: ' . $strValue.'<br>';
          }
        }
        $strEcho .=   '</td>';
        $strEcho .= '</tr>';
      }
    }
    $strEcho .= '</table>';
    echo $strEcho;
    echo '</div><!-- .wrap -->';
  }

  public function subsites_table_admin() {
    echo "<div class=\"wrap\">\n<h1>" . "Podstránky lídrov" . "</h1>\n";
    $aUsers = $this->getFlashmobSubscribers( 'all', true );
    $strDoubleCheckQuestion = "Ste si istý?";
    $strAction = 'florp_create_subsite';
    $strDomainEnding = "." . $this->get_root_domain();
    $aUserSubdomains = array();
    $strEcho = '<table class="widefat striped"><th>Mesto</th><th>Líder</th><th>Podstránka</th>'."\n";
    foreach ($aUsers as $oUser) {
      $aAllMeta = array_map(
        array($this, 'get_value_maybe_fix_unserialize_array'),
        get_user_meta( $oUser->ID )
      );
      $strSubDomainPage = false;
      if (
              !empty($aAllMeta['flashmob_city'])
           && (
                ($strSubDomainPage = $this->findCityWebpage($aAllMeta['flashmob_city'], false))
             || (!empty($aAllMeta['webpage']) && $aAllMeta['webpage'] === "vytvorit")
          )
      ) {
        $strCity = $aAllMeta['flashmob_city'];
        $strRowID = "florpRow-subsite-{$oUser->ID}";
        if ($strSubDomainPage) {
          $strSubsite = $strSubDomainPage;
          $aUserSubdomains[] = $strSubDomainPage;
        } elseif (!$aData["bInfoWindow"]) {
          $strSubsite = "<span data-user_id=\"{$oUser->ID}\">Vytvoriť:</span>";
          $aVariations = $this->getCitySubdomainVariations( $strCity );
          foreach ($aVariations as $strVariation) {
            $strButtonLabel = $strVariation . $strDomainEnding;
            $strButtonID = "florpButton-createSubsite-{$oUser->ID}-{$strVariation}";
            $aButtonData = array(
              'user_id' => $oUser->ID,
              'subdomain' => $strVariation,
            );
            $strData = "";
            foreach ($aButtonData as $strKey => $strValue) {
              $strData .= " data-{$strKey}=\"{$strValue}\"";
            }
            $strSubsite .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'"'.$strData.' data-action="'.$strAction.'" data-sure="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabel.'</span>';
          }
        }
        $strEcho .= "<tr class=\"row\" data-row-id=\"{$strRowID}\">";
        $strEcho .=   "<td>{$strCity}</td>\n";
        $strEcho .=   "<td>{$oUser->first_name} {$oUser->last_name}<br>\n{$oUser->user_email}</td>\n";
        $strEcho .=   "<td class=\"subsite\">{$strSubsite}</td>";
        $strEcho .= "</tr>\n";
      } else {
        continue;
      }
    }
    $aSites = wp_get_sites();
    $strRootDomain = "";
    foreach ($aSites as $i => $aSite) {
      if ($aSite['public'] != 1 || $aSite['deleted'] == 1 || $aSite['archived'] == 1) {
        continue;
      }
      $strDomain = $aSite['domain'];
      $iID = intval($aSite['blog_id']);
      $aParts = explode( ".", $strDomain );
      if (!is_array($aParts) || count($aParts) !== 3) {
        continue;
      }
      $aSkipDomains = array( 'ruedon.salsarueda.dance', 'festivaly.salsarueda.dance' );
      if ($iID === $this->aOptions['iFlashmobBlogID'] || $iID === $this->aOptions['iMainBlogID'] || in_array($strDomain, $aSkipDomains) || in_array($strDomain, $aUserSubdomains)) {
        continue;
      }
      $strEcho .= "<tr><td>-</td><td>-</td><td>{$strDomain}</td></tr>";
    }
    $strEcho .= "</table>";

    $strRowID = "florpRow-subsite-0";
    $strButtonID = "florpButton-createSubsite-0-new";
    $strButtonLabel = "Vytvoriť";
    $strData = "";
    $strEcho .= "<p class=\"row\" data-row-id=\"{$strRowID}\">Vytvoriť inú podstránku: ";
    $strEcho .= '<input type="text" name="subdomain" value="">'.$strDomainEnding;
    $strEcho .= ' <span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'"'.$strData.' data-use-input-names="subdomain" data-action="'.$strAction.'" data-sure="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabel.'</span>';
    $strEcho .= "</p>";
    echo $strEcho;
    echo '</div><!-- .wrap -->';
  }

  public function option_changes_table_admin() {
    echo "<div class=\"wrap\">\n<h1>" . "Option changes" . "</h1>\n";
    $strEcho = '<table class="widefat striped"><th>Date</th><th>User</th><th>Changed option key</th><th>From</th><th>To</th>'."\n";
    // echo "<pre>"; var_dump($this->aOptions['aOptionChanges']); echo "</pre>"; // NOTE DEVEL
    $aTestIDsToDelete = array( 1538506746, 1538506194 );
    foreach ($aTestIDsToDelete as $iTimestamp) {
      if (isset($this->aOptions['aOptionChanges'][$iTimestamp])) {
        unset($this->aOptions['aOptionChanges'][$iTimestamp]);
        $this->save_options();
      }
    }

    foreach ($this->aOptions['aOptionChanges'] as $iTimestamp => $aChanges) {
      $iUserID = $aChanges['_user_id'];
      $oUser = get_user_by( 'id', $iUserID );
      $iChangeCount = count($aChanges) - 1;
      if ($iChangeCount <= 0) {
        continue;
      }
      $iTimeZoneOffset = get_option( 'gmt_offset', 0 );
      $strDate = date( $this->strDateFormat, $iTimestamp + $iTimeZoneOffset*3600 );

      $strEcho .= "<tr data-timestamp=\"{$iTimestamp}\" class=\"row\">";
      $strEcho .=   "<td rowspan=\"{$iChangeCount}\">{$strDate}</td>\n";
      $strEcho .=   "<td rowspan=\"{$iChangeCount}\">{$iUserID}: {$oUser->first_name} {$oUser->last_name}</td>\n";
      foreach ($aChanges as $strKey => $aChange) {
        if ($strKey === '_user_id') {
          continue;
        }
        if (in_array($strKey, $this->aBooleanOptions)) {
          $from = $aChange['from'] ? "True" : "False";
          $to = $aChange['to'] ? "True" : "False";
        } else {
          if (is_array($aChange['from'])) {
            $from = implode(', ', $aChange['from']);
          } else {
            $from = $aChange['from'];
          }
          if (is_array($aChange['to'])) {
            $to = implode(', ', $aChange['to']);
          } else {
            $to = $aChange['to'];
          }
        }
        if (strpos($strKey, "ajax__") === 0) {
          $from_type = "";
          $to_type = "";
        } else {
          $from_type = " (".gettype($aChange['from']).")";
          $to_type = " (".gettype($aChange['to']).")";
        }
        $strEcho .=   "<td>{$strKey}</td><td>{$from}{$from_type}</td><td>{$to}{$to_type}</td>";
        $strEcho .= "</tr>\n";
      }
    }
    $strEcho .= "</table>";

    echo $strEcho;
    echo '</div><!-- .wrap -->';
    // $this->aOptions['aOptionChanges'] = array(); $this->save_options(); // NOTE DEVEL
  }

  public function leader_submission_history_table_admin() {
    echo "<div class=\"wrap\">\n<h1>" . "Leader submission history" . "</h1>\n";
    $aNfSubmissionHistory = $this->get_nf_submissions( false, 'history' );
    if (defined('FLORP_DEVEL') && FLORP_DEVEL === true) {
      // echo "<pre>";var_dump($aNfSubmissionHistory);echo "</pre>"; // NOTE DEVEL
    }

    $aViews = $this->aLeaderSubmissionHistoryViews;

    if (isset($this->strLeaderSubmissionHistoryView) && in_array($this->strLeaderSubmissionHistoryView, $aViews)) {
      $strView = $this->strLeaderSubmissionHistoryView;
    } else {
      $strView = $aViews[0];
      $this->strLeaderSubmissionHistoryView = $strView;
    }
    $strEcho = '<form action="" method="post">';
    $strEcho .= '<label for="florp-view">Choose view:</label> <select id="florp-view" name="view" onchange="if (this.value != 0) { this.form.submit(); }">';
    foreach ($aViews as $strViewOption) {
      $strSelected = "";
      if ($strView == $strViewOption) {
        $strSelected = ' selected="selected"';
      }
      $strEcho .= "<option value=\"{$strViewOption}\"{$strSelected}>".ucfirst(str_replace( '_', ' ', $strViewOption ))."</option>";
    }
    $strEcho .= '</select>';
    $strEcho .= '</form>';

    if ($strView === 'table') {
      $strEcho .= $this->leader_submission_history_table_admin__table($aNfSubmissionHistory);
    } elseif ($strView == 'progress_horizontal') {
      $strEcho .= $this->leader_submission_history_table_admin__progress_horizontal($aNfSubmissionHistory);
    } else {
      $strEcho .= $this->leader_submission_history_table_admin__progress_vertical($aNfSubmissionHistory);
    }
    echo $strEcho;
    echo '</div><!-- .wrap -->';
  }

  private function leader_submission_history_table_admin__progress_vertical($aNfSubmissionHistory) {
    $aData = $this->get_leader_submission_history_table_progress_data($aNfSubmissionHistory);
    return $this->get_leader_submission_history_table_progress_table($aData, false);
  }

  private function get_leader_submission_history_table_progress_data ($aNfSubmissionHistory) {
    $aSkip = array();
    $iTimeZoneOffset = get_option( 'gmt_offset', 0 );
    $aReturn = array();
    foreach ($aNfSubmissionHistory as $strEmail => $aSubmissionsOfUser) {
      $iChangeCount = $aSubmissionsOfUser['_count'];
      $oLeader = get_user_by( 'email', $strEmail );
      if (false === $oLeader) {
        $strLeaderID = "";
        $strNameOrEmail = $strEmail;
      } else {
        $strLeaderID = $oLeader->ID . ": ";
        $strNameOrEmail = "<span title=\"{$strEmail}\">{$oLeader->first_name} {$oLeader->last_name}</span>";
      }
      if ($iChangeCount <= 0) {
        continue;
      }
      $aReturn[$strEmail] = array(
        'caption' => "{$strLeaderID}{$strNameOrEmail}"
      );

      $aReturn[$strEmail]['columns'] = array();
      $aReturn[$strEmail]['rows'] = array();
      foreach ($aSubmissionsOfUser['_submissions'] as $strSubmissionChangeID => $aSubmissionData) {
        $iTimestamp = $aSubmissionData['_meta']['_submission_timestamp'];
        $strDateFormat = $this->strDateFormat;
        $aDate = array(
          'ts' => $aSubmissionData['_meta']['_submission_timestamp'],
          'dt' => $aSubmissionData['_meta']['_submission_date'],
          'dtWpFormat' => isset($aSubmissionData['_meta']['_submission_date_wp_format']) ? $aSubmissionData['_meta']['_submission_date_wp_format'] : date( $strDateFormat, $aSubmissionData['_meta']['_submission_timestamp'] ),
        );
        $aReturn[$strEmail]['columns'][$iTimestamp] = $aDate;
        if ($aSubmissionData['_resave']) {
          $aReturn[$strEmail]['columns'][$iTimestamp]['resave'] = true;
          continue;
        }
        $bRows = false;
        if ($aSubmissionData['_first']) {
          foreach ($aSubmissionData['_data'] as $strKey => $mixValue) {
            if ($this->aOptions['iCoursesNumberEnabled'] == 0 && in_array($strKey, $this->aMetaFieldsTeacher)) {
              continue;
            }
            if (!isset($mixValue) || (!is_bool($mixValue) && !is_numeric($mixValue) && empty($mixValue)) || $mixValue === 'null' || in_array( $strKey, $aSkip )) {
              continue;
            }
            if (!isset($aReturn[$strEmail]['rows'][$strKey])) {
              $aReturn[$strEmail]['rows'][$strKey] = array();
            }
            $aReturn[$strEmail]['rows'][$strKey][$iTimestamp] = $mixValue;
            $bRows = true;
          }
        } else {
          foreach ($aSubmissionData['_changes'] as $strKey => $aChange) {
            if (!isset($aReturn[$strEmail]['rows'][$strKey])) {
              $aReturn[$strEmail]['rows'][$strKey] = array();
            }
            $aReturn[$strEmail]['rows'][$strKey][$iTimestamp] = $aChange['to'];
            $bRows = true;
          }
        }
        if (!$bRows) {
          $aReturn[$strEmail]['columns'][$iTimestamp]['resave'] = true;
        }
      }
    }
    return $aReturn;
  }

  private function get_leader_submission_history_table_progress_table ($aData, $bHorizontal = true) {
    $strEcho = "";
    $aTimestamps = array();
    foreach ($aData as $strEmail => $aUser) {
      $strAdditionalClasses = "";
      if ($bHorizontal) {
        $strAdditionalClasses = " noFilter";
      } else {
        $strAdditionalClasses = " florpNoWrap florpHorizontalScroll florpFirstColFrozen";
      }
      $strEcho .= "<h4 class=\"florpTableCaption\">{$aUser['caption']}</h4>".PHP_EOL;
      $strEcho .= '<table class="widefat striped'.$strAdditionalClasses.'">'.PHP_EOL;

      if ($bHorizontal) {
        // Hotizontal //
        $aColumns = $aUser['columns'];
        $aRows = $aUser['rows'];
        // Headers //
        $strEcho .= '<tr>'.PHP_EOL;
        $strEcho .= "<th>Field key</th>".PHP_EOL;
        foreach ($aColumns as $iTimestamp => $aCol) {
          $strDate = isset($aCol['dtWpFormat']) ? $aCol['dtWpFormat'] : $aCol['dt'];
          $strEcho .= "<th>{$strDate}</th>";
        }
        $strEcho .= '</tr>'.PHP_EOL;

        foreach ($aRows as $strFieldKey => $aRow) {
          $strEcho .= '<tr>'.PHP_EOL;
          $strKey = $strFieldKey;
          if (in_array($strFieldKey, $aTimestamps)) {
            $strKey = str_replace("_timestamp", "", $strFieldKey);
          }
          $strFieldName = ucfirst( str_replace( '_', ' ', $strKey ) );
          $strEcho .= "<th>{$strFieldName}</th>".PHP_EOL;
          foreach ($aColumns as $iTimestamp => $aCol) {
            $strEcho .= '<td>'.PHP_EOL;
            if ($aCol['resave']) {
              $strEcho .= "[resave without change]";
            } elseif (isset($aRow[$iTimestamp])) {
              $mixValue = $aRow[$iTimestamp];
              if (in_array($strFieldKey, $aTimestamps)) {
                $strKey = str_replace("_timestamp", "", $strKey);
                $strValue = date( $this->strDateFormat, $mixValue );
              } elseif (is_array($mixValue)) {
                $strValue = implode( ', ', $mixValue);
              } elseif (is_bool($mixValue)) {
                $strValue = $mixValue ? '<input type="checkbox" disabled checked /><span class="hidden">yes</span>' : '<input type="checkbox" disabled /><span class="hidden">no</span>';
              } else {
                $strValue = $mixValue;
              }
              $strEcho .= $strValue;
            } else {
              // No change for this column //
            }
            $strEcho .= '</td>'.PHP_EOL;
          }
          $strEcho .= '</tr>'.PHP_EOL;
        }
      } else {
        // Vertical //
        $aColumns = $aUser['rows'];
        $aRows = $aUser['columns'];
        // Headers //
        $strEcho .= '<tr>'.PHP_EOL;
        $strEcho .= "<th>Date</th>".PHP_EOL;
        foreach ($aColumns as $strFieldKey => $aColumn) {
          $strKey = $strFieldKey;
          if (in_array($strFieldKey, $aTimestamps)) {
            $strKey = str_replace("_timestamp", "", $strFieldKey);
          }
          $strFieldName = ucfirst( str_replace( '_', ' ', $strKey ) );
          $strEcho .= "<th>{$strFieldName}</th>".PHP_EOL;
        }
        $strEcho .= '</tr>'.PHP_EOL;

        foreach ($aRows as $iTimestamp => $aRow) {
          $strEcho .= '<tr>'.PHP_EOL;
          $strDate = isset($aRow['dtWpFormat']) ? $aRow['dtWpFormat'] : $aRow['dt'];
          $strEcho .= "<td>{$strDate}</td>";
          foreach ($aColumns as $strFieldKey => $aColumn) {
            $strEcho .= '<td>'.PHP_EOL;
            if ($aRow['resave']) {
              $strEcho .= "[resave without change]";
            } elseif (isset($aColumn[$iTimestamp])) {
              $mixValue = $aColumn[$iTimestamp];
              if (in_array($strFieldKey, $aTimestamps)) {
                $strKey = str_replace("_timestamp", "", $strKey);
                $strValue = date( $this->strDateFormat, $mixValue );
              } elseif (is_array($mixValue)) {
                $strValue = implode( ', ', $mixValue);
              } elseif (is_bool($mixValue)) {
                $strValue = $mixValue ? '<input type="checkbox" disabled checked /><span class="hidden">yes</span>' : '<input type="checkbox" disabled /><span class="hidden">no</span>';
              } else {
                $strValue = $mixValue;
              }
              $strEcho .= $strValue;
            } else {
              // No change for this column //
            }
            $strEcho .= '</td>'.PHP_EOL;
          }
          $strEcho .= '</tr>'.PHP_EOL;
        }
      }

      $strEcho .= '</table>'.PHP_EOL;
      $strEcho .= '<p></p>'.PHP_EOL;
    }
    return $strEcho;
  }

  private function leader_submission_history_table_admin__progress_horizontal($aNfSubmissionHistory) {
    $aData = $this->get_leader_submission_history_table_progress_data($aNfSubmissionHistory);
    return $this->get_leader_submission_history_table_progress_table($aData, true);
  }

  private function leader_submission_history_table_admin__table($aNfSubmissionHistory) {
    $strEcho = '<table class="widefat striped noFilter"><th>User</th><th>Date</th><th>Changed option</th><th>From</th><th>To</th>'."\n";
    $iTimeZoneOffset = get_option( 'gmt_offset', 0 );
    $aSkip = array();
    // echo $strEcho; return;

    foreach ($aNfSubmissionHistory as $strEmail => $aSubmissions) {
      $iChangeCount = $aSubmissions['_count'];
      $oLeader = get_user_by( 'email', $strEmail );
      if (false === $oLeader) {
        $strLeaderID = "";
        $strNameOrEmail = $strEmail;
      } else {
        $strLeaderID = $oLeader->ID . ": ";
        $strNameOrEmail = "<span title=\"{$strEmail}\">{$oLeader->first_name} {$oLeader->last_name}</span>";
      }
      if ($iChangeCount <= 0) {
        continue;
      }
      $iRows = 0;
      foreach ($aSubmissions['_submissions'] as $strSubmissionChangeID => $aSubmissionData) {
        if ($aSubmissionData['_first']) {
          foreach ($aSubmissionData['_data'] as $strKey => $mixValue) {
            if ($this->aOptions['iCoursesNumberEnabled'] == 0 && in_array($strKey, $this->aMetaFieldsTeacher)) {
              continue;
            }
            if (!isset($mixValue) || (!is_bool($mixValue) && !is_numeric($mixValue) && empty($mixValue)) || $mixValue === 'null' || in_array( $strKey, $aSkip )) {
              continue;
            }
            $iRows++;
          }
        } elseif ($aSubmissionData['_resave']) {
          $iRows++;
        } else {
          $iRows += count($aSubmissionData['_changes']);
        }
      }
      $strEcho .= "<tr class=\"row\">";
      $strEcho .=   "<td rowspan=\"{$iRows}\">{$strLeaderID}{$strNameOrEmail}</td>\n";
      foreach ($aSubmissions['_submissions'] as $strSubmissionChangeID => $aSubmissionData) {
        $strDateFormat = $this->strDateFormat;
        $strDate = isset( $aSubmissionData['_meta']['_submission_date_wp_format'] ) ? $aSubmissionData['_meta']['_submission_date_wp_format'] : date( $strDateFormat, $aSubmissionData['_meta']['_submission_timestamp'] );

        if ($aSubmissionData['_first']) {
          $iRows = 0;
          foreach ($aSubmissionData['_data'] as $strKey => $mixValue) {
            if ($this->aOptions['iCoursesNumberEnabled'] == 0 && in_array($strKey, $this->aMetaFieldsTeacher)) {
              continue;
            }
            if (!isset($mixValue) || (!is_bool($mixValue) && !is_numeric($mixValue) && empty($mixValue)) || $mixValue === 'null' || in_array( $strKey, $aSkip )) {
              continue;
            }
            $iRows++;
          }
          $strRowspan = " rowspan=\"{$iRows}\"";
        } elseif ($aSubmissionData['_resave']) {
          $strRowspan = "";
        } else {
          $iRowspan = count($aSubmissionData['_changes']);
          $strRowspan = " rowspan=\"{$iRowspan}\"";
        }
        $strEcho .=   "<td{$strRowspan}>{$strDate}</td>\n";
        $bFirst = false;
        $bResave = false;
        if ($aSubmissionData['_first']) {
          $bFirst = true;
          $strSubmission = "";
          $aTimestamps = array();
          foreach ($aSubmissionData['_data'] as $strKey => $mixValue) {
            if ($this->aOptions['iCoursesNumberEnabled'] == 0 && in_array($strKey, $this->aMetaFieldsTeacher)) {
              continue;
            }
            if (!isset($mixValue) || (!is_bool($mixValue) && !is_numeric($mixValue) && empty($mixValue)) || $mixValue === 'null' || in_array( $strKey, $aSkip )) {
              continue;
            }
            if (in_array($strKey, $aTimestamps)) {
              $strKey = str_replace("_timestamp", "", $strKey);
              $strValue = date( $this->strDateFormat, $mixValue );
            } elseif (is_array($mixValue)) {
              $strValue = implode( ', ', $mixValue);
            } elseif (is_bool($mixValue)) {
              $strValue = $mixValue ? '<input type="checkbox" disabled checked /><span class="hidden">yes</span>' : '<input type="checkbox" disabled /><span class="hidden">no</span>';
            } else {
              $strValue = $mixValue;
            }
            $strFieldName = ucfirst( str_replace( '_', ' ', $strKey ) );
            $strType = " (".gettype($mixValue).")";
            // $strSubmission .= '<strong title="'.$strKey.'">' . $strFieldName . '</strong>: ' . $strValue.$strType.'<br>';
            $strEcho .= '<td><strong title="'.$strKey.'">' . $strFieldName . '</strong></td><td>-</td><td>' . $strValue . '</td>';
            $strEcho .= "</tr>\n";
          }
          //$strEcho .=   "<td colspan=\"3\">{$strSubmission}</td>";
        } elseif ($aSubmissionData['_resave']) {
          $strEcho .=   "<td colspan=\"3\">[resave without change]</td>";
          $strEcho .= "</tr>\n";
        } else {
          foreach ($aSubmissionData['_changes'] as $strKey => $aChange) {
            if ($strKey === '_user_id') {
              continue;
            }
            if (in_array($strKey, $this->aBooleanOptions)) {
              $from = $aChange['from'] ? "True" : "False";
              $to = $aChange['to'] ? "True" : "False";
            } else {
              if (is_array($aChange['from'])) {
                $from = implode(', ', $aChange['from']);
              } else {
                $from = $aChange['from'];
              }
              if (is_array($aChange['to'])) {
                $to = implode(', ', $aChange['to']);
              } else {
                $to = $aChange['to'];
              }
            }
            if (is_null($from)) {
              $from = "[null]";
              $from_type = "";
            } else {
              $from_type = " (".gettype($aChange['from']).")";
            }
            if (is_null($to)) {
              $to = "[null]";
              $to_type = "";
            } else {
              $to_type = " (".gettype($aChange['to']).")";
            }
            if ($to === '') {
              $to = "[empty]";
            }
            if ($from === '') {
              $from = "[empty]";
            }
            $strFieldName = ucfirst( str_replace( '_', ' ', $strKey ) );
            // $strEcho .= "<td><strong title=\"{$strKey}\">{$strFieldName}</strong></td><td>{$from}{$from_type}</td><td>{$to}{$to_type}</td>";
            $strEcho .= "<td><strong title=\"{$strKey}\">{$strFieldName}</strong></td><td>{$from}</td><td>{$to}</td>";
            $strEcho .= "</tr>\n";
          }
        }
      }
    }
    $strEcho .= "</table>";

    return $strEcho;
    // $this->aOptions['aOptionChanges'] = array(); $this->save_options(); // NOTE DEVEL
  }

  private function get_tshirt_order_date_data( $iTshirtID ) {
    $aOrderDates = $this->aOptions['aOrderDates'];
    if (empty($aOrderDates)) {
      return false;
    }
    foreach ($aOrderDates as $iKey => $aOrderData) {
      if (in_array($iTshirtID, $aOrderData['orders'])) {
        $aReturn = $aOrderData;
        $aReturn['id'] = $iKey;
        if (!isset($aReturn['datetime'])) {
          $iTimeZoneOffset = get_option( 'gmt_offset', 0 );
          $aReturn['datetime'] = date($this->strDateFormat, $iKey + $iTimeZoneOffset*3600);
        }
        return $aReturn;
      }
    }
    return false;
  }

  private function get_tshirt_order_dates( $iTimestamp = false, $bIntf = false ) {
    $aTshirts = $this->get_tshirts('all', false, $bIntf);
    if (empty($aTshirts)) {
      return $aTshirts;
    }

    $aOrderDates = $this->aOptions['aOrderDates'];
    if (empty($aOrderDates)) {
      return $aOrderDates;
    }
    ksort($aOrderDates);

    foreach ($aOrderDates as $iKey => $aOrderData) {
      $aOrderDates[$iKey]['aPaid'] = array();
      $aOrderDates[$iKey]['aUnpaid'] = array();
      $aOrderDates[$iKey]['aPaidAfter'] = array();
      $aOrderDates[$iKey]['aUnpaidAfter'] = array();
    }

    foreach ($aTshirts as $aTshirtData) {
      $bIsPaid = false;
      if ($aTshirtData["is_leader"]) {
        $bIsPaid = true;
      } elseif ($aTshirtData["is_paid"]) {
        $bIsPaid = true;
      }

      $iOrderKey = false;
      $aMatchingOrderDate = $this->get_tshirt_order_date_data($aTshirtData["id"]);
      if ($aMatchingOrderDate) {
        $iOrderKey = $aMatchingOrderDate['id'];
      }

      if ($iOrderKey !== false) {
        if ($bIsPaid) {
          $aOrderDates[$iOrderKey]['aPaid'][] = $aTshirtData["id"];
        } else {
          $aOrderDates[$iOrderKey]['aUnpaid'][] = $aTshirtData["id"];
        }
      }
      foreach ($aOrderDates as $iKey => $aOrderData) {
        if ($iOrderKey === false) {
          if ($aTshirtData["is_leader"]) {
            // Doesn't go anywhere //
          } elseif (isset($aTshirtData['registered_timestamp']) && $aTshirtData['registered_timestamp'] > $iKey) {
            if ($bIsPaid) {
              $aOrderDates[$iKey]['aPaidAfter'][] = $aTshirtData["id"];
            } else {
              $aOrderDates[$iKey]['aUnpaidAfter'][] = $aTshirtData["id"];
            }
          }
        } elseif ($iKey < $iOrderKey) {
          if ($bIsPaid) {
            $aOrderDates[$iKey]['aPaidAfter'][] = $aTshirtData["id"];
          } else {
            $aOrderDates[$iKey]['aUnpaidAfter'][] = $aTshirtData["id"];
          }
        }
      }
    }

    if ($iTimestamp === false) {
      return $aOrderDates;
    } elseif (isset($aOrderDates[$iTimestamp])) {
      return $aOrderDates[$iTimestamp];
    } else {
      return array();
    }
  }

  private function get_tshirt_orders_in_sent_order( $iKey, $strType = 'all' ) {
    $aOrderDates = $this->aOptions['aOrderDates'];
    if (empty($aOrderDates)) {
      return "No order dates";
    }

    if (!isset($aOrderDates[$iKey]) || empty($aOrderDates[$iKey]['orders'])) {
      return "Order doesn't exist";
    }

    $aTshirts = $this->get_tshirts($strType);
    if (empty($aTshirts)) {
      return "No tshirt orders";
    }
    $aReturn = array();
    foreach ($aOrderDates[$iKey]['orders'] as $strTshirtOrderID) {
      if (isset($aTshirts[$strTshirtOrderID])) {
        $aReturn[$strTshirtOrderID] = $aTshirts[$strTshirtOrderID];
      }
    }

    return $aReturn;
  }

  private function get_tshirt_orders_by_timestamp( $iTimestamp, $strType, $bBefore = true, $bIncludeSentOrders = true ) {
    $aOrderDates = $this->aOptions['aOrderDates'];
    $aUsedTshirtIDs = array();
    if ($bIncludeSentOrders) {
      foreach ($aOrderDates as $iKey => $aOrderData) {
        if ($bBefore && $iKey >= $iTimestamp) {
          $aUsedTshirtIDs = array_merge($aUsedTshirtIDs, $aOrderData['orders']);
        } elseif (!$bBefore && $iKey <= $iTimestamp) {
          $aUsedTshirtIDs = array_merge($aUsedTshirtIDs, $aOrderData['orders']);
        }
      }
    } else {
      foreach ($aOrderDates as $iKey => $aOrderData) {
        $aUsedTshirtIDs = array_merge($aUsedTshirtIDs, $aOrderData['orders']);
      }
    }

    $aTshirts = $this->get_tshirts( $strType );
    if (empty($aTshirts)) {
      return $aTshirts;
    }

    $aReturn = array();
    foreach ($aTshirts as $key => $aTshirtData) {
      if (in_array($aTshirtData['id'], $aUsedTshirtIDs)) {
        continue;
      }
      if ($bBefore) {
        if (!$aTshirtData["is_leader"] && $aTshirtData["registered_timestamp"] > 0 && $aTshirtData["registered_timestamp"] > $iTimestamp) {
          continue;
        }
      } else {
        if (!$aTshirtData["is_leader"] && $aTshirtData["registered_timestamp"] > 0 && $aTshirtData["registered_timestamp"] <= $iTimestamp) {
          continue;
        }
      }
      $aReturn[$key] = $aTshirtData;
    }

    return $aReturn;
  }

  private function get_tshirt_order_dates_row( $mixOrder ) {
    if (is_array($mixOrder)) {
      $aOrderData = $mixOrder;
      if (isset($aOrderData['id'])) {
        $iTimestamp = $aOrderData['id'];
      } else {
        return "";
      }
    } elseif (isset($this->aOptions['aOrderDates'][$mixOrder])) {
      $aOrderData = $this->get_tshirt_order_dates( $mixOrder );
      $iTimestamp = $mixOrder;
    } else {
      return "";
    }
    $strEcho = '<tr class="florpTshirtOrderTableRow-'.$iTimestamp.'">';
    if (isset($aOrderData['datetime']) && !empty($aOrderData['datetime'])) {
      $strDate = $aOrderData['datetime'];
    } else {
      $iTimeZoneOffset = get_option( 'gmt_offset', 0 );
      $strDate = date($this->strDateFormat, $iTimestamp + $iTimeZoneOffset*3600);
    }
    $strEcho .= '<td><span title="ID: '.$iTimestamp.'">'.$strDate.'</span></td>';
    $strEcho .= '<td>'.$aOrderData['type'].'</td>';
    $strEcho .= '<td>';
    if (count($aOrderData['aPaid']) > 0 && count($aOrderData['aUnpaid']) > 0) {
      $strEcho .= '<input id="florp-download-tshirt-csv-order-'.$iTimestamp.'-all" class="button button-primary button-large" name="florp-download-tshirt-csv-order-'.$iTimestamp.'-all" type="submit" value="Všetko" />';
      $strEcho .= '<input id="florp-download-tshirt-csv-order-'.$iTimestamp.'-unpaid" class="button button-primary button-large" name="florp-download-tshirt-csv-order-'.$iTimestamp.'-unpaid" type="submit" value="Nezaplatené" />';
      $strEcho .= '<input id="florp-download-tshirt-csv-order-'.$iTimestamp.'-paid" class="button button-primary button-large" name="florp-download-tshirt-csv-order-'.$iTimestamp.'-paid" type="submit" value="Zaplatené" />';
    } elseif (count($aOrderData['aPaid']) > 0) {
      $strEcho .= '<input id="florp-download-tshirt-csv-order-'.$iTimestamp.'-paid" class="button button-primary button-large" name="florp-download-tshirt-csv-order-'.$iTimestamp.'-paid" type="submit" value="Všetko - Zaplatené" />';
    } elseif (count($aOrderData['aUnpaid']) > 0) {
      $strEcho .= '<input id="florp-download-tshirt-csv-order-'.$iTimestamp.'-unpaid" class="button button-primary button-large" name="florp-download-tshirt-csv-order-'.$iTimestamp.'-unpaid" type="submit" value="Všetko - Nezaplatené" />';
    }
    $strEcho .= '</td>';
    $strEcho .= '<td>';
    if (count($aOrderData['aPaidAfter']) > 0 || count($aOrderData['aUnpaidAfter']) > 0) {
      if (count($aOrderData['aPaidAfter']) > 0 && count($aOrderData['aUnpaidAfter']) > 0) {
        $strEcho .= '<input id="florp-download-tshirt-csv-after-order-'.$iTimestamp.'-all" class="button button-primary button-large" name="florp-download-tshirt-csv-after-order-'.$iTimestamp.'-all" type="submit" value="Všetko" />';
        $strEcho .= '<input id="florp-download-tshirt-csv-after-order-'.$iTimestamp.'-unpaid" class="button button-primary button-large" name="florp-download-tshirt-csv-after-order-'.$iTimestamp.'-unpaid" type="submit" value="Nezaplatené" />';
        $strEcho .= '<input id="florp-download-tshirt-csv-after-order-'.$iTimestamp.'-paid" class="button button-primary button-large" name="florp-download-tshirt-csv-after-order-'.$iTimestamp.'-paid" type="submit" value="Zaplatené" />';
      } elseif (count($aOrderData['aPaidAfter']) > 0) {
        $strEcho .= '<input id="florp-download-tshirt-csv-after-order-'.$iTimestamp.'-paid" class="button button-primary button-large" name="florp-download-tshirt-csv-after-order-'.$iTimestamp.'-paid" type="submit" value="Všetko - Zaplatené" />';
      } elseif (count($aOrderData['aUnpaidAfter']) > 0) {
        $strEcho .= '<input id="florp-download-tshirt-csv-after-order-'.$iTimestamp.'-unpaid" class="button button-primary button-large" name="florp-download-tshirt-csv-after-order-'.$iTimestamp.'-unpaid" type="submit" value="Všetko - Nezaplatené" />';
      }
    }
    $strEcho .= '</td>';
    $strEcho .= '</tr>';
    return $strEcho;
  }

  private function nf_submission_sort($a, $b) {
    if (isset($a['_submission_timestamp'], $b['_submission_timestamp'])) {
      return $a['_submission_timestamp'] < $b['_submission_timestamp'] ? -1 : 1;
    } elseif (!isset($a['_submission_timestamp'])) {
      return -1;
    } elseif (!isset($b['_submission_timestamp'])) {
      return 1;
    } else {
      return 0;
    }
  }

  private function get_nf_submission( $iBlogID, $iFormID, $iSubmissionID ) {
    if ($iBlogID !== get_current_blog_id()) {
      $mixChangeBlogID = $iBlogID;
    }
    if ($iBlogID === $this->iMainBlogID) {
      $iProfileFormNinjaFormID = $this->iProfileFormNinjaFormIDMain;
      $strBlog = "main";
    } elseif ($iBlogID === $this->iFlashmobBlogID) {
      $iProfileFormNinjaFormID = $this->iProfileFormNinjaFormIDFlashmob;
      $strBlog = "flashmob";
    } else {
      return false;
    }
    if (false !== $mixChangeBlogID) {
      switch_to_blog($mixChangeBlogID);
    }
    if (!function_exists('Ninja_Forms')) {
      if (false !== $mixChangeBlogID) {
        restore_current_blog();
      }
      return false;
    }

    $aFields = Ninja_Forms()->form( $iFormID )->get_fields();
    $aKeyToType = array();
    foreach ($aFields as $oField) {
      $aKeyToType[$oField->get_setting('key')] = $oField->get_setting('type');
    }

    $aSubmission = Ninja_Forms()->form( $iFormID )->get_sub( $iSubmissionID );
    $aFieldValues = array_map(
      array($this, 'get_value_maybe_fix_unserialize_array'),
      $oSubmission->get_field_values()
    );
    if (!isset($aFieldValues["user_email"]) || empty($aFieldValues["user_email"])) {
      // Invalid submission //
      return false;
    }
    foreach ($aFieldValues as $strKey => $mixValue) {
      if (!isset($aKeyToType[$strKey])) {
        unset($aFieldValues[$strKey]);
      }
    }
    if ($sType === 'missed') {
      if ($strBlog === "main" && email_exists($aFieldValues["user_email"])) {
        return false;
      } elseif ($strBlog === "flashmob" && $this->flashmob_participant_exists($aFieldValues["user_email"])) {
        return false;
      }
    }
    $strDateFormat = $this->strDateFormat;
    $aFieldValues['_submission_date'] = $oSubmission->get_sub_date( 'Y-m-d H:i:s' );
    $aFieldValues['_submission_date_wp_format'] = $oSubmission->get_sub_date( $strDateFormat );
    $aFieldValues['_submission_timestamp'] = $oSubmission->get_sub_date( 'U' );
    $aFieldValues['_form_id'] = $iFormID;
    $aFieldValues['_submission_id'] = $iSubmissionID;
    $aFieldValues['_blog_id'] = $iBlogID;
    $aFieldValues['_field_types'] = $aKeyToType;
    $aNfSubmission = array_filter($aFieldValues, function($key) {
      $aPermittedKeys = array('_submission_date', '_submission_date_wp_format', '_submission_timestamp', '_form_id', '_submission_id', '_blog_id', '_field_types');
      return in_array($key, $aPermittedKeys) || strpos($key, "_") !== 0;
    }, ARRAY_FILTER_USE_KEY);

    if (false !== $mixChangeBlogID) {
      restore_current_blog();
    }
    return $aNfSubmission;
  }

  private function get_nf_submissions( $iBlogID = false, $sType = 'missed', $bUseCacheTypes = true, $bUseCacheSubmissions = true, $bClearCacheIfNotUsed = true ) {
    $aNfSubmissions = array();
    $aTypes = array( 'missed', 'all', 'history' );
    if (!in_array($sType, $aTypes)) {
      return false;
    }

    $mixChangeBlogID = false;
    $strBlog = "";
    if ($iBlogID !== false) {
      if ($iBlogID !== get_current_blog_id()) {
        $mixChangeBlogID = $iBlogID;
      }
      if ($iBlogID === $this->iMainBlogID) {
        $iProfileFormNinjaFormID = $this->iProfileFormNinjaFormIDMain;
        $strBlog = "main";
      } elseif ($iBlogID === $this->iFlashmobBlogID) {
        $iProfileFormNinjaFormID = $this->iProfileFormNinjaFormIDFlashmob;
        $strBlog = "flashmob";
      } else {
        return false;
      }
    } elseif ($this->isMainBlog) {
      $iBlogID = $this->iMainBlogID;
      $iProfileFormNinjaFormID = $this->iProfileFormNinjaFormIDMain;
      $strBlog = "main";
    } elseif ($this->isFlashmobBlog) {
      $iBlogID = $this->iFlashmobBlogID;
      $iProfileFormNinjaFormID = $this->iProfileFormNinjaFormIDFlashmob;
      $strBlog = "flashmob";
    } else {
      return false;
    }

    if ($bClearCacheIfNotUsed) {
      $aUseCache = array(
        'aNfFieldTypes' => $bUseCacheTypes,
        'aNfSubmissions' => $bUseCacheSubmissions,
      );
      if (!$bUseCacheTypes || !$bUseCacheSubmissions) {
        $aKeys = array( 'aNfFieldTypes', 'aNfSubmissions' );
        foreach ($aKeys as $strKey) {
          if (!$aUseCache[$strKey] && $this->aOptions[$strKey] !== $this->aOptionDefaults[$strKey]) {
            $this->aOptions[$strKey] = $this->aOptionDefaults[$strKey];
            $this->save_options();
          }
        }
      }
    }
    // echo "<pre>";var_dump($this->aOptions['aNfFieldTypes']);echo "</pre>"; // NOTE DEVEL
    // echo "<pre>";var_dump($this->aOptions['aNfSubmissions']);echo "</pre>"; // NOTE DEVEL
    // $this->aOptions['aNfSubmissions'] = $this->aOptionDefaults['aNfSubmissions']; // NOTE DEVEL
    // $this->aOptions['aNfFieldTypes'] = $this->aOptionDefaults['aNfFieldTypes']; // NOTE DEVEL
    // $this->save_options();return; // NOTE DEVEL

    if ($bUseCacheTypes && $this->aOptions['aNfFieldTypes'][$iBlogID]['done']) {
      // OK //
    } else {
      if (false !== $mixChangeBlogID) {
        switch_to_blog($mixChangeBlogID);
      }
      if (!function_exists('Ninja_Forms')) {
        if (false !== $mixChangeBlogID) {
          restore_current_blog();
        }
        return false;
      }
      $objProfileForm = Ninja_Forms()->form( $iProfileFormNinjaFormID )->get();
      $strProfileFormTitle = $objProfileForm->get_setting( 'title' );
      $aForms = Ninja_Forms()->form()->get_forms();
      foreach ($aForms as $objForm) {
        $iFormID = $objForm->get_id();
        if (isset($this->aOptions['aNfFieldTypes'][$iBlogID]['field_types'][$iFormID])) {
          continue;
        }
        $strTitle = $objForm->get_setting( 'title' );
        if (strpos($strTitle, $strProfileFormTitle) === false && strpos($strProfileFormTitle, $strTitle) === false) {
          continue;
        }
        $aFields = Ninja_Forms()->form( $iFormID )->get_fields();
        $aKeyToType = array();
        foreach ($aFields as $oField) {
          $aKeyToType[$oField->get_setting('key')] = $oField->get_setting('type');
        }
        unset($aFields);
        $this->aOptions['aNfFieldTypes'][$iBlogID]['field_types'][$iFormID] = $aKeyToType;
        $this->maybe_save_options($bUseCacheTypes);
      }
      if (false !== $mixChangeBlogID) {
        restore_current_blog();
      }
      $this->aOptions['aNfFieldTypes'][$iBlogID]['done'] = true;
      $this->maybe_save_options($bUseCacheTypes);
    }
    // echo "<pre>";var_dump($this->aOptions['aNfFieldTypes']);echo "</pre>"; // NOTE DEVEL

    if ($bUseCacheSubmissions && $this->aOptions['aNfSubmissions'][$iBlogID]['done']) {
      // OK //
    } else {
      if (false !== $mixChangeBlogID) {
        switch_to_blog($mixChangeBlogID);
      }
      if (!function_exists('Ninja_Forms')) {
        if (false !== $mixChangeBlogID) {
          restore_current_blog();
        }
        return false;
      }
      $objProfileForm = Ninja_Forms()->form( $iProfileFormNinjaFormID )->get();
      $strProfileFormTitle = $objProfileForm->get_setting( 'title' );
      $aForms = Ninja_Forms()->form()->get_forms();
      foreach ($aForms as $objForm) {
        $iFormID = $objForm->get_id();
        if (!isset($this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID])) {
          $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID] = array(
            'done' => false,
            'rows' => array(),
          );
        }
        if (isset($this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]) && isset($this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['done']) && $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['done'] === true) {
          // Form is there and done //
          continue;
        }
        $strTitle = $objForm->get_setting( 'title' );
        if (strpos($strTitle, $strProfileFormTitle) === false && strpos($strProfileFormTitle, $strTitle) === false) {
          $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['rows'] = false;
          $this->maybe_save_options($bUseCacheSubmissions);
          continue;
        }
        $aKeyToType = $this->aOptions['aNfFieldTypes'][$iBlogID]['field_types'][$iFormID];

        $aSubmissions = Ninja_Forms()->form( $iFormID )->get_subs();
        if (count($aSubmissions) === 0) {
          $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['rows'] = false;
          $this->maybe_save_options($bUseCacheSubmissions);
          continue;
        }
        foreach ($aSubmissions as $oSubmission) {
          $iSubmissionID = $oSubmission->get_id();
          if (isset($this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['rows'][$iSubmissionID])) {
            continue;
          }

          $aFieldValues = array_map(
            array($this, 'get_value_maybe_fix_unserialize_array'),
            $oSubmission->get_field_values()
          );
          if (!isset($aFieldValues["user_email"]) || empty($aFieldValues["user_email"])) {
            // Invalid submission //
            $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['rows'][$iSubmissionID] = false;
            $this->maybe_save_options($bUseCacheSubmissions);
            continue;
          }
          foreach ($aFieldValues as $strKey => $mixValue) {
            if (!isset($aKeyToType[$strKey])) {
              unset($aFieldValues[$strKey]);
            }
          }
          if (empty($aFieldValues)) {
            // Invalid submission //
            $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['rows'][$iSubmissionID] = false;
            $this->maybe_save_options($bUseCacheSubmissions);
            continue;
          }

          $strDateFormat = $this->strDateFormat;
          $aFieldValues['_submission_date'] = $oSubmission->get_sub_date( 'Y-m-d H:i:s' );
          $aFieldValues['_submission_date_wp_format'] = $oSubmission->get_sub_date( $strDateFormat );
          $aFieldValues['_submission_timestamp'] = $oSubmission->get_sub_date( 'U' );
          $aFieldValues['_form_id'] = $iFormID;
          $aFieldValues['_submission_id'] = $iSubmissionID;
          $aFieldValues['_blog_id'] = $iBlogID;

          $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['rows'][$iSubmissionID] = $aFieldValues;
          $this->maybe_save_options($bUseCacheSubmissions);
        }
        $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['done'] = true;
        $this->maybe_save_options($bUseCacheSubmissions);
      }
      if (false !== $mixChangeBlogID) {
        restore_current_blog();
      }
      $this->aOptions['aNfSubmissions'][$iBlogID]['done'] = true;
      $this->maybe_save_options($bUseCacheSubmissions);
    }

    foreach ($this->aOptions['aNfSubmissions'][$iBlogID]['forms'] as $iFormID => $aSubmissions) {
      if (!isset($aSubmissions['done']) || $aSubmissions['done'] !== true) {
        continue;
      }
      if (false === $aSubmissions['rows'] || !is_array($aSubmissions['rows'])) {
        continue;
      }
      foreach ($aSubmissions['rows'] as $iSubmissionID => $aFieldValues) {
        if (false === $aFieldValues) {
          continue;
        }
        if ($sType === 'missed') {
          if ($strBlog === "main" && email_exists($aFieldValues["user_email"])) {
            continue;
          } elseif ($strBlog === "flashmob" && $this->flashmob_participant_exists($aFieldValues["user_email"])) {
            continue;
          }
        }
        if ($sType === 'history' && $strBlog === "main" && email_exists($aFieldValues["user_email"])) {
          $bIncludeAdmins = (isset($_GET['include-admins']) && $_GET['include-admins'] == 1);
          $oUser = get_user_by( 'email', $aFieldValues["user_email"] );
          if (in_array("administrator", $oUser->roles) && !$bIncludeAdmins ) {
            continue;
          }
        }
        if (!isset($aNfSubmissions[$aFieldValues["user_email"]])) {
          $aNfSubmissions[$aFieldValues["user_email"]] = array();
        }
        $aNfSubmissions[$aFieldValues["user_email"]][] = array_filter($aFieldValues, function($key) {
          $aPermittedKeys = array('_submission_date', '_submission_date_wp_format', '_submission_timestamp', '_form_id', '_submission_id', '_blog_id');
          if ($this->aOptions['iCoursesNumberEnabled'] == 0 && in_array($key, $this->aMetaFieldsTeacher)) {
            return false;
          }
          return in_array($key, $aPermittedKeys) || strpos($key, "_") !== 0;
        }, ARRAY_FILTER_USE_KEY);

      }
    }

    if ($sType === 'history') {
      $aSkipKeys = array('_blog_id', '_submission_date', '_submission_date_wp_format', '_submission_timestamp', '_form_id', '_submission_id');
      $aNfSubmissionsRaw = $aNfSubmissions;
      $aNfSubmissions = array();
      foreach ($aNfSubmissionsRaw as $strEmail => $aSubmissionsOfUser) {
        $aNfSubmissions[$strEmail] = array(
          '_count' => count($aSubmissionsOfUser),
          '_submissions' => array(),
        );
        usort($aSubmissionsOfUser, array($this, "nf_submission_sort"));
        foreach ($aSubmissionsOfUser as $iKey => $aSubmissionData) {
          $aSubmissionMeta = array(
            '_submission_date' => $aSubmissionData['_submission_date'],
            '_submission_date_wp_format' => $aSubmissionData['_submission_date_wp_format'],
            '_submission_timestamp' => $aSubmissionData['_submission_timestamp'],
            '_form_id' => $aSubmissionData['_form_id'],
            '_submission_id' => $aSubmissionData['_submission_id'],
          );
          $strSubmissionChangeID = $aSubmissionMeta['_submission_timestamp']."_".$aSubmissionMeta['_form_id']."_".$aSubmissionMeta['_submission_id'];
          if (!empty($aSkipKeys)) {
            foreach ($aSkipKeys as $strskipKey) {
              if (isset($aSubmissionData[$strskipKey])) {
                unset($aSubmissionData[$strskipKey]);
              }
            }
          }
          $aNfSubmissions[$strEmail]['_submissions'][$strSubmissionChangeID] = array(
            '_resave' => false,
            '_first'  => false,
            '_meta' => $aSubmissionMeta,
          );

          if ($iKey === 0) {
            $aNfSubmissions[$strEmail]['_submissions'][$strSubmissionChangeID]['_first'] = true;
            $aNfSubmissions[$strEmail]['_submissions'][$strSubmissionChangeID]['_data'] = $aSubmissionData;
            continue;
          }

          $aPreviousSubmissionData = $aSubmissionsOfUser[$iKey - 1];
          if (!empty($aSkipKeys)) {
            foreach ($aSkipKeys as $strskipKey) {
              if (isset($aPreviousSubmissionData[$strskipKey])) {
                unset($aPreviousSubmissionData[$strskipKey]);
              }
            }
          }
          if ($aSubmissionData === $aPreviousSubmissionData) {
            $aNfSubmissions[$strEmail]['_submissions'][$strSubmissionChangeID]['_resave'] = true;
            continue;
          }
          $aNotInNew = array_diff_assoc($aSubmissionData, $aPreviousSubmissionData);
          $aNotInOld = array_diff_assoc($aPreviousSubmissionData, $aSubmissionData);
          if (empty($aNotInNew) && empty($aNotInOld)) {
            $aNfSubmissions[$strEmail]['_submissions'][$strSubmissionChangeID]['_resave'] = true;
            continue;
          }
          $aDiffKeys = array_unique(array_merge(array_keys($aNotInNew), array_keys($aNotInOld)));
          $aChanges = array();
          foreach ($aDiffKeys as $strKey) {
            $aChanges[$strKey] = array(
              'from'  => $aPreviousSubmissionData[$strKey],
              'to'    => $aSubmissionData[$strKey],
            );
          }
          $aNfSubmissions[$strEmail]['_submissions'][$strSubmissionChangeID]['_changes'] = $aChanges;
        }
      }
    }

    //echo "<pre>".var_export($aNfSubmissions, true)."</pre>"; // NOTE DEVEL
    return $aNfSubmissions;
  }

  private function get_missed_submissions_table( $iBlogID = false ) {
    $aMissedSubmissions = $this->get_nf_submissions( $iBlogID, 'missed', true, true, true ); // $sType = 'missed', $bUseCacheTypes = true, $bUseCacheSubmissions = true, $bClearCacheIfNotUsed = true
    if (false === $aMissedSubmissions || empty($aMissedSubmissions)) {
      return "";
    }
    $oUser = wp_get_current_user();
    if ($oUser->user_email !== 'charliecek@gmail.com' && $oUser->user_email !== get_option('admin_email')) {
      return "";
    }

    $strEcho = "<h1>" . "Chýbajúce dáta (možno)" . "</h1>";

    $strEcho .= '<table class="widefat striped"><th>Email</th><th>Dátum</th><th>Meno</th><th>Dáta</th>';
    $aReplacements = array(
      'gender' => array(
        'from'  => array( 'muz', 'zena', 'par' ),
        'to'    => array( 'muž', 'žena', 'pár' )
      ),
      'dance_level' => array(
        'from'  => array( '_', 'zaciatocnik', 'pokrocily', 'ucitel' ),
        'to'    => array( ' ', 'začiatočník', 'pokročilý', 'učiteľ' )
      ),
      'preferences' => array(
        'from'  => array( 'flashmob_participant_tshirt', 'newsletter_subscribe' ),
        'to'    => array( 'Chcem pamätné Flashmob tričko', 'Chcem dostávať newsletter' )
      )
    );
    foreach ($aMissedSubmissions as $strEmail => $aMissedSubmissionsOfUser) {
      foreach ($aMissedSubmissionsOfUser as $aSubmissionData) {
        foreach ($aReplacements as $strKey => $aReplacementArr) {
          $aSubmissionData[$strKey] = str_replace( $aReplacementArr['from'], $aReplacementArr['to'], $aSubmissionData[$strKey]);
        }
        $strButtonLabelDelete = "Zmazať riadok z NF";
        $strButtonLabelImport = "Importovať riadok z NF";
        $strDoubleCheckQuestion = "Ste si istý?";
        $strCommonIDPart = "missedSubmission-".$iBlogID."-".$aSubmissionData['_form_id']."-".$aSubmissionData['_submission_id']."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
        $strRowID = "florpRow-{$strCommonIDPart}";
        $strButtonID = "florpButton-{$strCommonIDPart}-delete";
        $strButtons = '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabelDelete.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" data-blog-id="'.$iBlogID.'" data-form-id="'.$aSubmissionData['_form_id'].'" data-submission-id="'.$aSubmissionData['_submission_id'].'" data-email="'.$strEmail.'" data-sure="0" data-action="delete_nf_submission" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabelDelete.'</span>';
        if ($iBlogID === $this->iFlashmobBlogID) {
          $strButtonID = "florpButton-{$strCommonIDPart}-import";
          $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabelImport.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" data-blog-id="'.$iBlogID.'" data-form-id="'.$aSubmissionData['_form_id'].'" data-submission-id="'.$aSubmissionData['_submission_id'].'" data-email="'.$strEmail.'" data-sure="0" data-action="import_flashmob_nf_submission" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabelImport.'</span>';
        }
        $strEcho .= '<tr class="row missedSubmissionRow" data-row-id="'.$strRowID.'" data-email="'.$aSubmissionData['user_email'].'">';
        $strEcho .=   '<td><a name="'.$aSubmissionData['user_email'].'">'.$aSubmissionData['user_email'].'</a></td>';
        $strDate = isset($aSubmissionData['_submission_date_wp_format']) ? $aSubmissionData['_submission_date_wp_format'] : $aSubmissionData['_submission_date'];
        $strEcho .=   '<td>'.$strDate.'</td>';
        $strEcho .=   '<td>'.$aSubmissionData['first_name'].' '.$aSubmissionData['last_name'].$strButtons.'</td>';
        $aSingleCheckboxes = array( 'courses_in_city_2', 'courses_in_city_3', 'preference_newsletter', 'hide_leader_info' );
        $aSkip = array( 'first_name', 'last_name', 'user_email', 'flashmob_city', '_submission_date', '_submission_date_wp_format', '_submission_timestamp', '_submission_id', '_form_id', '_blog_id' );
        $strEcho .= "<td>";
        foreach ($aSubmissionData as $strKey => $mixValue) {
          if (!isset($mixValue) || (!is_bool($mixValue) && !is_numeric($mixValue) && empty($mixValue)) || $mixValue === 'null' || in_array( $strKey, $aSkip )) {
            continue;
          }
          if ($strKey === 'leader_user_id') {
            $strKey = 'leader';
            $oLeader = get_user_by( 'id', $mixValue );
            $strValue = "{$mixValue}: ";
            if (false === $oLeader) {
              $strValue .= "[deleted]";
            } else {
              $strValue .= "{$oLeader->first_name} {$oLeader->last_name}";
              if (in_array( $this->strUserRolePending, (array) $oLeader->roles )) {
                $strValue .= " ({$strUserRolePendingName})";
              }
            }
          } elseif (is_array($mixValue)) {
            $strValue = implode( ', ', $mixValue);
          } elseif (in_array($strMetaKey, $aSingleCheckboxes) || is_bool($mixValue)) {
            $strValue = $mixValue ? '<input type="checkbox" disabled checked /><span class="hidden">yes</span>' : '<input type="checkbox" disabled /><span class="hidden">no</span>';
          } else {
            $strValue = $mixValue;
          }
          $strFieldName = ucfirst( str_replace( '_', ' ', $strKey ) );
          if (stripos( $strValue, 'https://' ) === 0 || stripos( $strValue, 'http://' ) === 0) {
            $strEcho .= '<a href="'.$strValue.'" target="_blank">'.$strFieldName.'</a><br>';
          } else {
            $strEcho .= '<strong>' . $strFieldName . '</strong>: ' . $strValue.'<br>';
          }
        }
        $strEcho .=   '</td>';
        $strEcho .= '</tr>';
      }
    }
    $strEcho .= '</table>';
    return $strEcho;
  }

  private function get_value_maybe_fix_unserialize_array( $a ) {
    if (is_string($a) && strpos($a, 'a:') === 0) {
      return maybe_unserialize( $a );
    } elseif (is_array($a) && count($a) === 1) {
      if (is_string($a[0]) && strpos($a[0], 'a:') === 0) {
        return maybe_unserialize( $a[0] );
      } else {
        return $a[0];
      }
    } else {
      return $a;
    }
  }

  private function get_tshirts_csv( $aTshirts, $bIntf = false, $bCSVHeaderOnly = false ) {
    $aReturn = array();
    if ($bIntf) {
      $aHeaderRow = array("Meno", "Email", "Mesto", "Typ", "Rok", "Webstránka", "Veľkosť trička", "Typ trička", "Farba trička", "Čas registrácie (účastník)", "Zaplatil tričko", "Čas označenia za zaplatené", "Upozornenie na platbu", "Čas upozornenia na platbu", "Tričko odovzdané", "Čas odovzdania trička");
    } else {
      $aHeaderRow = array("Meno", "Email", "Mesto", "Typ", "Líder", "Webstránka", "Veľkosť trička", "Typ trička", "Farba trička", "Čas registrácie (účastník)", "Zaplatil tričko", "Čas označenia za zaplatené", "Upozornenie na platbu", "Čas upozornenia na platbu", "Tričko odovzdané", "Čas odovzdania trička");
    }
    if ($this->aOptions['bTshirtOrdersAdminEnabled']) {
      $aHeaderRow[] = "Čas odoslania objednávky";
    }
    $aReturn[] = $aHeaderRow;
    if ($bCSVHeaderOnly) {
      return $aReturn;
    }
    foreach ($aTshirts as $aTshirtData) {
      $aRow = array(
        $aTshirtData["name"],
        $aTshirtData["email"],
        $aTshirtData["flashmob_city"],
        $aTshirtData["type"],
        $bIntf ? $aTshirtData["year"] : $aTshirtData["leader"],
        $aTshirtData["properties"]["webpage"],
        $aTshirtData["properties"]["tshirt_size"],
        $aTshirtData["properties"]["tshirt_gender"],
        $aTshirtData["properties"]["tshirt_color"],
        (!$bIntf && $aTshirtData["is_leader"]) ? "-" : (isset($aTshirtData["registered_timestamp"]) && $aTshirtData["registered_timestamp"] > 0 ? date('Y-m-d H:i:s', $aTshirtData["registered_timestamp"] ) : "-"),
        (!$bIntf && $aTshirtData["is_leader"]) ? "-" : ($aTshirtData["is_paid"] ? "1" : "0"),
        (!$bIntf && $aTshirtData["is_leader"]) ? "-" : ($aTshirtData["is_paid"] && $aTshirtData["paid_timestamp"] ? date('Y-m-d H:i:s', $aTshirtData["paid_timestamp"] ) : "-"),
        (!$bIntf && $aTshirtData["is_leader"]) ? "-" : ($aTshirtData["payment_warning_sent"] ? "1" : "0"),
        (!$bIntf && $aTshirtData["is_leader"]) ? "-" : ($aTshirtData["payment_warning_sent"] && $aTshirtData["payment_warning_sent_timestamp"] ? date('Y-m-d H:i:s', $aTshirtData["payment_warning_sent_timestamp"] ) : "-"),
        ($aTshirtData["is_delivered"] ? "1" : "0"),
        ($aTshirtData["is_delivered"] && $aTshirtData["delivered_timestamp"] ? date('Y-m-d H:i:s', $aTshirtData["delivered_timestamp"] ) : "-"),
      );
      if ($this->aOptions['bTshirtOrdersAdminEnabled']) {
        $aRow[] = $aTshirtData["properties"]["order_sent"];
      }
      $aReturn[] = $aRow;
    }
    return $aReturn;
  }

  private function get_tshirts($strPaidFlag = 'all', $bCSV = false, $bIntf = false ) {
    if ($bIntf) {
      return $this->get_tshirts_intf($strPaidFlag, $bCSV);
    }
    $aLeaders = $this->getFlashmobSubscribers( 'flashmob_organizer' );
    $aTshirtsOption = $this->aOptions["aTshirts"];
    // echo "<pre>";var_dump($aTshirtsOption);echo "</pre>";
    $aTshirts = array();
    foreach ($aLeaders as $oUser) {
      $aAllMeta = array_map(
        array($this, 'get_value_maybe_fix_unserialize_array'),
        get_user_meta( $oUser->ID )
      );
      $aRequiredTshirtProperties = array( 'flashmob_leader_tshirt_size', 'flashmob_leader_tshirt_gender', 'flashmob_leader_tshirt_color' );
      foreach ($aRequiredTshirtProperties as $strKey) {
        if (!isset($aAllMeta[$strKey]) || empty($aAllMeta[$strKey]) || ('null' === $aAllMeta[$strKey])) {
          continue 2;
        }
      }
      $aWebpageArgs = array(
        'id' => $oUser->ID,
        'bReturnAnchor' => !$bCSV,
        'bInfoWindow' => false,
      );
      $strID = "leader-".$oUser->ID;
      $aTshirts[$strID] = array(
        "id" => $strID,
        "name" => $oUser->first_name.' '.$oUser->last_name,
        "user_id" => $oUser->ID,
        "email" => $oUser->user_email,
        "is_leader" => true,
        "flashmob_city" => $aAllMeta['flashmob_city'],
        "type" => "Líder",
        "leader" => "-",
        "properties" => array(
          "webpage" => $this->get_leader_webpage($aWebpageArgs),
          "tshirt_size" => isset($aAllMeta['flashmob_leader_tshirt_size']) ? $aAllMeta['flashmob_leader_tshirt_size'] : "n/a",
          "tshirt_gender" => isset($aAllMeta['flashmob_leader_tshirt_gender']) ? $aAllMeta['flashmob_leader_tshirt_gender'] : "n/a",
          "tshirt_color" => isset($aAllMeta['flashmob_leader_tshirt_color']) ? $aAllMeta['flashmob_leader_tshirt_color'] : "n/a",
        ),
      );
    }
    $aParticipants = $this->get_flashmob_participants( 0, false, false );
    // echo "<pre>";var_dump($aParticipants);echo "</pre>";
    foreach ($aParticipants as $iLeaderID => $aParticipantsOfLeader) {
      foreach ($aParticipantsOfLeader as $strEmail => $aParticipantData) {
        if (!in_array("flashmob_participant_tshirt", $aParticipantData["preferences"])) {
          // echo "<pre>";var_dump($aParticipantData);echo "</pre>"; // NOTE DEVEL
          continue;
        }
        $aWebpageArgs = array(
          'id' => $iLeaderID,
          'bReturnAnchor' => !$bCSV,
          'bInfoWindow' => false,
        );
        $aToMerge = array();
        $oLeader = get_user_by( 'id', $iLeaderID );
        $strLeadersFlashmobCity = get_user_meta( $iLeaderID, 'flashmob_city', true );
        if ($strLeadersFlashmobCity !== $aParticipantData['flashmob_city']) {
          $aToMerge['flashmob_city_at_registration'] = $aParticipantData['flashmob_city'];
          $aToMerge['flashmob_city'] = $strLeadersFlashmobCity;
        }
        $strID = "participant-".$iLeaderID."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
        $aTshirts[$strID] = array_merge(array(
          "id" => $strID,
          "name" => $aParticipantData['first_name'].' '.$aParticipantData['last_name'],
          "user_id" => false,
          "leader_id" => $iLeaderID,
          "email" => $strEmail,
          "is_leader" => false,
          "flashmob_city" => $aParticipantData['flashmob_city'],
          "type" => "Účastník",
          "leader" => "{$oLeader->first_name} {$oLeader->last_name}",
          "registered_timestamp" => isset($aParticipantData["registered"]) ? $aParticipantData["registered"] : 0,
          "properties" => array(
            "webpage" => $this->get_leader_webpage($aWebpageArgs),
            "tshirt_size" => isset($aParticipantData['flashmob_participant_tshirt_size']) ? $aParticipantData['flashmob_participant_tshirt_size'] : "n/a",
            "tshirt_gender" => isset($aParticipantData['flashmob_participant_tshirt_gender']) ? $aParticipantData['flashmob_participant_tshirt_gender'] : "n/a",
            "tshirt_color" => isset($aParticipantData['flashmob_participant_tshirt_color']) ? $aParticipantData['flashmob_participant_tshirt_color'] : "n/a",
            "ordered" => isset($aParticipantData["registered"]) ? date($this->strDateFormat, $aParticipantData["registered"]) : "n/a",
          ),
        ), $aToMerge );
      }
    }
    foreach ($aTshirts as $key => $aTshirtData) {
      $bPaid = false;
      if ($aTshirtData["is_leader"]) {
        $bPaid = true;
        // $bPaid = (isset($aTshirtsOption["leaders"][$aTshirtData["user_id"]]) && isset($aTshirtsOption["leaders"][$aTshirtData["user_id"]]["paid"]) && $aTshirtsOption["leaders"][$aTshirtData["user_id"]]["paid"] === true);

        // Delivered //
        $bDelivered = (isset($aTshirtsOption["leaders"][$aTshirtData["user_id"]]) && isset($aTshirtsOption["leaders"][$aTshirtData["user_id"]]["is_delivered"]) && $aTshirtsOption["leaders"][$aTshirtData["user_id"]]["is_delivered"] === true);
        $aTshirts[$key]["is_delivered"] = $bDelivered;
        if ($bDelivered) {
          $aTshirts[$key]["delivered_timestamp"] = $aTshirtsOption["leaders"][$aTshirtData["user_id"]]['delivered-timestamp'];
        }
      } else {
        // Paid //
        $bPaid = (isset($aTshirtsOption["participants"][$aTshirtData["email"]]) && isset($aTshirtsOption["participants"][$aTshirtData["email"]]["paid"]) && $aTshirtsOption["participants"][$aTshirtData["email"]]["paid"] === true);
        if ($bPaid) {
          $aTshirts[$key]["paid_timestamp"] = $aTshirtsOption["participants"][$aTshirtData["email"]]['paid-timestamp'];
        }
        // Payment warning //
        $bPaymentWarningSent = (isset($aTshirtsOption["participants"][$aTshirtData["email"]]) && isset($aTshirtsOption["participants"][$aTshirtData["email"]]["payment_warning_sent"]) && $aTshirtsOption["participants"][$aTshirtData["email"]]["payment_warning_sent"] === true);
        $aTshirts[$key]["payment_warning_sent"] = $bPaymentWarningSent;
        if ($bPaymentWarningSent) {
          $aTshirts[$key]["payment_warning_sent_timestamp"] = $aTshirtsOption["participants"][$aTshirtData["email"]]['payment_warning_sent-timestamp'];
        }
        // Delivered //
        $bDelivered = (isset($aTshirtsOption["participants"][$aTshirtData["email"]]) && isset($aTshirtsOption["participants"][$aTshirtData["email"]]["is_delivered"]) && $aTshirtsOption["participants"][$aTshirtData["email"]]["is_delivered"] === true);
        $aTshirts[$key]["is_delivered"] = $bDelivered;
        if ($bDelivered) {
          $aTshirts[$key]["delivered_timestamp"] = $aTshirtsOption["participants"][$aTshirtData["email"]]['delivered-timestamp'];
        }
      }
      $aTshirts[$key]["is_paid"] = $bPaid;

      if ($this->aOptions['bTshirtOrdersAdminEnabled']) {
        $aTshirts[$key]['order_sent_timestamp'] = 0;
        $aTshirts[$key]['properties']['order_sent'] = "n/a";
        $aMatchingOrderDate = $this->get_tshirt_order_date_data( $aTshirtData['id'] );
        if ($aMatchingOrderDate) {
          $aTshirts[$key]['order_sent_timestamp'] = $aMatchingOrderDate["id"];
          $aTshirts[$key]['properties']['order_sent'] = $aMatchingOrderDate['datetime'];
        }
      }

      if ($strPaidFlag === 'unpaid' && $bPaid) {
        unset($aTshirts[$key]);
      } elseif ($strPaidFlag === 'paid' && !$bPaid) {
        unset($aTshirts[$key]);
      }
    }
    uasort($aTshirts, array($this, "tshirt_sort"));
    // echo "<pre>";var_dump($aTshirts);echo "</pre>";
    if ($bCSV) {
      if (empty($aTshirts)) {
        return array();
      }
      return $this->get_tshirts_csv( $aTshirts );
    }
    return $aTshirts;
  }

  private function get_tshirts_intf($strPaidFlag = 'all', $bCSV = false ) {
    $aParticipants = $this->aOptions['aIntfParticipants'];
    // echo "<pre>";var_dump($aParticipants);echo "</pre>";
    $aTshirtsOption = $this->aOptions["aTshirtsIntf"];
    if (!$bCSV) {
      // echo "<pre>";var_dump($aTshirtsOption);echo "</pre>"; // NOTE DEVEL
    }
    foreach ($aParticipants as $iYear => $aParticipantsInYear) {
      foreach ($aParticipantsInYear as $strEmail => $aParticipantData) {
        if (!is_array($aParticipantData["preferences"]) || !in_array("flashmob_participant_tshirt", $aParticipantData["preferences"])) {
          // echo "<pre>";var_dump($aParticipantData);echo "</pre>"; // NOTE DEVEL
          continue;
        }
        $strID = "intf-participant-".$iYear."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
        $aTshirts[$strID] = array(
          "id" => $strID,
          "name" => $aParticipantData['first_name'].' '.$aParticipantData['last_name'],
          "year" => $iYear,
          "email" => $strEmail,
          "flashmob_city" => $aParticipantData['flashmob_city'],
          "type" => "Účastník",
          "registered_timestamp" => isset($aParticipantData["registered"]) ? $aParticipantData["registered"] : 0,
          "properties" => array(
            "tshirt_size" => isset($aParticipantData['flashmob_participant_tshirt_size']) ? $aParticipantData['flashmob_participant_tshirt_size'] : "n/a",
            "tshirt_gender" => isset($aParticipantData['flashmob_participant_tshirt_gender']) ? $aParticipantData['flashmob_participant_tshirt_gender'] : "n/a",
            "tshirt_color" => isset($aParticipantData['flashmob_participant_tshirt_color']) ? $aParticipantData['flashmob_participant_tshirt_color'] : "n/a",
            "ordered" => isset($aParticipantData["registered"]) ? date($this->strDateFormat, $aParticipantData["registered"]) : "n/a",
          ),
        );
      }
    }
    foreach ($aTshirts as $key => $aTshirtData) {
      // Paid //
      $bPaid = (isset($aTshirtsOption[$aTshirtData['year']][$aTshirtData["email"]]) && isset($aTshirtsOption[$aTshirtData['year']][$aTshirtData["email"]]["paid"]) && $aTshirtsOption[$aTshirtData['year']][$aTshirtData["email"]]["paid"] === true);
      $aTshirts[$key]["is_paid"] = $bPaid;
      if ($bPaid) {
        $aTshirts[$key]["paid_timestamp"] = $aTshirtsOption[$aTshirtData['year']][$aTshirtData["email"]]['paid-timestamp'];
      }

      // Payment warning //
      $bPaymentWarningSent = (isset($aTshirtsOption[$aTshirtData['year']][$aTshirtData["email"]]) && isset($aTshirtsOption[$aTshirtData['year']][$aTshirtData["email"]]["payment_warning_sent"]) && $aTshirtsOption[$aTshirtData['year']][$aTshirtData["email"]]["payment_warning_sent"] === true);
      $aTshirts[$key]["payment_warning_sent"] = $bPaymentWarningSent;
      if ($bPaymentWarningSent) {
        $aTshirts[$key]["payment_warning_sent_timestamp"] = $aTshirtsOption[$aTshirtData['year']][$aTshirtData["email"]]['payment_warning_sent-timestamp'];
      }

      // Delivered //
      $bDelivered = (isset($aTshirtsOption[$aTshirtData['year']][$aTshirtData["email"]]) && isset($aTshirtsOption[$aTshirtData['year']][$aTshirtData["email"]]["is_delivered"]) && $aTshirtsOption[$aTshirtData['year']][$aTshirtData["email"]]["is_delivered"] === true);
      $aTshirts[$key]["is_delivered"] = $bDelivered;
      if ($bDelivered) {
        $aTshirts[$key]["delivered_timestamp"] = $aTshirtsOption[$aTshirtData['year']][$aTshirtData["email"]]['delivered-timestamp'];
      }

      if ($this->aOptions['bTshirtOrdersAdminEnabled']) {
        $aTshirts[$key]['order_sent_timestamp'] = 0;
        $aTshirts[$key]['properties']['order_sent'] = "n/a";
        $aMatchingOrderDate = $this->get_tshirt_order_date_data( $aTshirtData['id'] );
        if ($aMatchingOrderDate) {
          $aTshirts[$key]['order_sent_timestamp'] = $aMatchingOrderDate["id"];
          $aTshirts[$key]['properties']['order_sent'] = $aMatchingOrderDate['datetime'];
        }
      }

      if ($strPaidFlag === 'unpaid' && $bPaid) {
        unset($aTshirts[$key]);
      } elseif ($strPaidFlag === 'paid' && !$bPaid) {
        unset($aTshirts[$key]);
      }
    }
    uasort($aTshirts, array($this, "tshirt_sort"));
    // echo "<pre>";var_dump($aTshirts);echo "</pre>";
    if ($bCSV) {
      if (empty($aTshirts)) {
        return array();
      }
      return $this->get_tshirts_csv( $aTshirts, true );
    }
    return $aTshirts;
  }

  private function tshirt_sort($a, $b) {
    if ($a["is_leader"] && $b["is_leader"]) {
      return 0;
    } elseif ($a["is_leader"]) {
      return -1;
    } elseif ($b["is_leader"]) {
      return 1;
    } elseif (isset($a['registered_timestamp'], $b['registered_timestamp'])) {
      return $a['registered_timestamp'] < $b['registered_timestamp'] ? -1 : 1;
    } elseif (!isset($a['registered_timestamp'])) {
      return -1;
    } elseif (!isset($b['registered_timestamp'])) {
      return 1;
    } else {
      return 0;
    }
  }

  private function participant_sort($a, $b) {
    if (isset($a['registered']) && isset($b['registered'])) {
      // Both have registration timestamp //
      return $a['registered'] < $b['registered'] ? -1 : 1;
    } elseif (!isset($a['registered']) && !isset($b['registered'])) {
      // None have registration timestamp //
      if (isset($a['leader_user_id']) && isset($b['leader_user_id'])) {
        // Sort by leader ID //
        return $a['leader_user_id'] < $b['leader_user_id'] ? -1 : 1;
      } elseif (isset($a['leader_user_id'])) {
        // The one without leader ID goes to top //
        return 1;
      } elseif (isset($b['leader_user_id'])) {
        // The one without leader ID goes to top //
        return -1;
      } else {
        return 0;
      }
    } elseif (isset($a['registered'])) {
      // The one without registration timestamp goes to TOP //
      return 1;
    } elseif (isset($b['registered'])) {
      // The one without registration timestamp goes to TOP //
      return -1;
    } else {
      return 0;
    }
  }

  private function get_flashmob_participant_csv($sType = 'all', $bIntf = false, $iYear = 0) {
    $aParticipantCSV = array();
    $aParticipants = $bIntf ? $this->aOptions['aIntfParticipants'] : $this->get_flashmob_participants();
    if ($iYear === 0) {
      $iYear = $this->aOptions['iIntfFlashmobYear'];
    }
    // echo '<pre>'.var_export($aParticipants, true).'</pre>'; // NOTE DEVEL

    // Get participants as a flat array //
    $aParticipantsFlat = array();
    $aPreferences = array();
    foreach ($aParticipants as $iLeaderIDOrYear => $aParticipantsOfLeaderOrYear) {
      if ($bIntf && false !== $iYear && $iYear !== $iLeaderIDOrYear) {
        // Skip that year //
        continue;
      }
      foreach ($aParticipantsOfLeaderOrYear as $strEmail => $aParticipantData) {
        $bOrderedTshirt = isset($aParticipantData['preferences']) && is_array($aParticipantData['preferences']) && in_array('flashmob_participant_tshirt', $aParticipantData['preferences']);
        $strKey = $strEmail."_".$iLeaderIDOrYear;
        $aParticipantsFlat[$strKey] = $aParticipantData;
        if ($bIntf) {
          $aParticipantsFlat[$strKey]['year'] = $iLeaderIDOrYear;
        } else {
          $aParticipantsFlat[$strKey]['leader_user_id'] = $iLeaderIDOrYear;
        }
        $aParticipantsFlat[$strKey]['user_email'] = $strEmail;
        if (isset($aParticipantData['preferences'])) {
          unset($aParticipantsFlat[$strKey]['preferences']);
          foreach ($aParticipantData['preferences'] as $strPreferenceKey) {
            $strPreferenceKey = 'preference-'.$strPreferenceKey;
            if (!in_array( $strPreferenceKey, $aPreferences )) {
              $aPreferences[] = $strPreferenceKey;
            }
            $aParticipantsFlat[$strKey][$strPreferenceKey] = true;
          }
        }
        foreach ($aParticipantData as $key => $value) {
          if (false !== stripos($key, 'tshirt') && !$bOrderedTshirt) {
            $aParticipantsFlat[$strKey][$key] = "-";
          }
        }
      }
    }
    uasort($aParticipantsFlat, array($this, "participant_sort"));
    // echo '<pre>'.var_export($aParticipantsFlat, true).'</pre>'; // NOTE DEVEL

    // Get headers //
    $aHeaders = array();
    foreach ($aParticipantsFlat as $aParticipantData) {
      foreach ($aParticipantData as $strKey => $mixVal) {
        if (!isset($aHeaders[$strKey])) {
          if ($strKey == "intf_city") {
            $aHeaders[$strKey] = "Mesto (anketa)";
          } else {
            $aHeaders[$strKey] = ucfirst(str_replace( array( '_timestamp', '-', '_' ), array( '_date', ': ', ' ' ), $strKey ));
          }
        }
      }
    }
    $iColumnCount = count($aHeaders);
    $aParticipantCSV[] = $aHeaders;

    $aTimestamps = array( 'registered', 'paid_fee' );
    $aReplacements = array(
      'gender' => array(
        'from'  => array( 'muz', 'zena', 'par' ),
        'to'    => array( 'muž', 'žena', 'pár' )
      ),
      'flashmob_participant_tshirt_gender' => array(
        'from'  => array( 'muz', 'zena', 'par' ),
        'to'    => array( 'muž', 'žena', 'pár' )
      ),
      'dance_level' => array(
        'from'  => array( '_', 'zaciatocnik', 'pokrocily', 'ucitel' ),
        'to'    => array( ' ', 'začiatočník', 'pokročilý', 'učiteľ' )
      )
    );

    // Get the participant rows //
    foreach ($aParticipantsFlat as $aParticipantData) {
      $aRow = array();
      foreach ($aHeaders as $strFieldKey => $strHeaderName) {
        if (in_array($strFieldKey, $aPreferences) && !isset($aParticipantData[$strFieldKey])) {
          $aParticipantData[$strFieldKey] = false;
        }
        if (isset($aParticipantData[$strFieldKey])) {
          $mixVal = $aParticipantData[$strFieldKey];
          if (is_bool($mixVal)) {
            $strValue = $mixVal ? "1" : "0";
          } elseif (preg_match('~_timestamp$~', $strFieldKey) || in_array($strFieldKey, $aTimestamps)) {
            $strValue = date( $this->strDateFormat, $mixVal );
          } else {
            $strValue = strval($mixVal);
          }
          if (isset($aReplacements[$strFieldKey])) {
            $strValue = str_replace( $aReplacements[$strFieldKey]['from'], $aReplacements[$strFieldKey]['to'], $strValue );
          }
          $aRow[$strFieldKey] = $strValue;
        } else {
          $aRow[$strFieldKey] = "-";
        }
      }
      if ($sType === 'notshirts' && $aRow['preference-flashmob_participant_tshirt'] === "1") {
        continue;
      }
      if (count($aRow) === $iColumnCount) {
        $aParticipantCSV[] = $aRow;
      }
    }

    return $aParticipantCSV;
  }

  private function serveParticipantCSV($bIntf = false) {
    $bPassed = check_ajax_referer( 'srd-florp-admin-security-string', 'security', false );
    if (!$bPassed) {
      add_action( 'admin_notices', function() {
        echo '<div class="notice notice-error"><p>Request validation failed</p></div>'.PHP_EOL;
      });
      return;
    }

    $aButtonNames = array(
      'florp-download-participant-csv-all',
      'florp-download-participant-csv-notshirts',
      'florp-download-intf-participant-csv-all',
      'florp-download-intf-participant-csv-notshirts',
    );
    $strType = "";
    $bFound = false;
    foreach ($aButtonNames as $strButtonName) {
      if (isset($_POST[$strButtonName])) {
        $bFound = true;
        $strType = str_replace( "florp-download-participant-csv-", "", $strButtonName );
        $strType = str_replace( "florp-download-intf-participant-csv-", "", $strType );
        $aParticipants = $this->get_flashmob_participant_csv($strType, $bIntf);
        break;
      }
    }
    if (!$bFound) {
      add_action( 'admin_notices', function() {
        echo '<div class="notice notice-error"><p>Invalid request - unknown button was clicked</p></div>'.PHP_EOL;
        if (defined('FLORP_DEVEL') && FLORP_DEVEL === true) {
          echo '<div class="notice notice-info"><pre>'; var_dump($_POST); echo '</pre></div>'.PHP_EOL;
        }
      });
      return;
    }

    if (!is_array($aParticipants) || empty($aParticipants) || count($aParticipants) === 1) {
      $GLOBALS['florpInfo'] = "";
      // $GLOBALS['florpInfo'] = '<pre>'.var_export($aParticipants, true).'</pre>'; // NOTE DEVEL

      $GLOBALS['florpWarningReason'] = '';
      if (is_string($aParticipants)) {
        $GLOBALS['florpWarningReason'] = '<p>'.$aParticipants.'</p>';
      }
      add_action( 'admin_notices', function() {
        echo '<div class="notice notice-warning"><p>No participants to build CSV from</p>'.$GLOBALS['florpWarningReason'].$GLOBALS['florpInfo'].'</div>'.PHP_EOL;
      });
      return;
    }

    $strPrefix = $bIntf ? "international-" : "svk-";
    $strFileName = $strPrefix."participants-{$strType}-".current_time('Ymd-His').".csv";

    // output headers so that the file is downloaded rather than displayed
    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename="'.$strFileName.'"');

    // do not cache the file
    header('Pragma: no-cache');
    header('Expires: 0');

    // create a file pointer connected to the output stream
    $file = fopen('php://output', 'w');

    // output column headers and each row of the data
    foreach ($aParticipants as $aParticipantData) {
      fputcsv($file, $aParticipantData);
    }
    exit();
  }

  private function serveTshirtCSV($bIntf = false) {
    $bPassed = check_ajax_referer( 'srd-florp-admin-security-string', 'security', false );
    if (!$bPassed) {
      add_action( 'admin_notices', function() {
        echo '<div class="notice notice-error"><p>Request validation failed</p></div>'.PHP_EOL;
      });
      return;
    }
    $bOrderDateBased = false;
    $strFileNamePart = "";
    $strIntfRequestPart = $bIntf ? '-intf' : '';
    if (!isset($_POST["florp-download{$strIntfRequestPart}-tshirt-csv-all"]) && !isset($_POST["florp-download{$strIntfRequestPart}-tshirt-csv-unpaid"]) && !isset($_POST["florp-download{$strIntfRequestPart}-tshirt-csv-paid"])) {
      $bFound = false;
      $aMatches = array();
      foreach ($_POST as $key => $val) {
        if (preg_match('~^florp-download'.$strIntfRequestPart.'-tshirt-csv-(after-)?order-(\d+)-(all|unpaid|paid)$~', $key, $aMatches)) {
          $bFound = true;
          $bOrderDateBased = true;
          $bIncluded = empty($aMatches[1]) || strlen($aMatches[1]) === 0;
          $iTimestamp = intval($aMatches[2]);
          $strType = $aMatches[3];
          if (!$bIncluded) {
            $bBefore = false;
            $bIncludeSentOrders = true;
          }
          $strFileNamePart = $aMatches[1]."order-".$aMatches[2]."-".$aMatches[3];
          break;
        }
      }
      if (!$bFound) {
        add_action( 'admin_notices', function() {
          echo '<div class="notice notice-error"><p>Invalid request - unknown button was clicked</p></div>'.PHP_EOL;
          if (defined('FLORP_DEVEL') && FLORP_DEVEL === true) {
            echo '<div class="notice notice-info"><pre>'; var_dump($_POST); echo '</pre></div>'.PHP_EOL;
          }
        });
        return;
      }
    }

    $strPrefix = $bIntf ? "international-" : "svk-";
    $strFileName = $strPrefix . "tshirts-";
    if (isset($_POST["florp-download{$strIntfRequestPart}-tshirt-csv-all"])) {
      $aTshirts = $this->get_tshirts('all', true, $bIntf);
      $strFileName .= "all";
    } elseif (isset($_POST["florp-download{$strIntfRequestPart}-tshirt-csv-unpaid"])) {
      $aTshirts = $this->get_tshirts('unpaid', true, $bIntf);
      $strFileName .= "unpaid";
    } elseif (isset($_POST["florp-download{$strIntfRequestPart}-tshirt-csv-paid"])) {
      $aTshirts = $this->get_tshirts('paid', true, $bIntf);
      $strFileName .= "paid";
    } elseif ($this->aOptions['bTshirtOrdersAdminEnabled'] && $bOrderDateBased) { // TODO not implemented for INTF yet
      if ($bIncluded) {
        $aTshirts = $this->get_tshirt_orders_in_sent_order( $iTimestamp, $strType );
      } else {
        $aTshirts = $this->get_tshirt_orders_by_timestamp( $iTimestamp, $strType, $bBefore, $bIncludeSentOrders );
      }
      $aTshirts = $this->get_tshirts_csv( $aTshirts, $bIntf );
      $strFileName .= $strFileNamePart;
    }
    if (!is_array($aTshirts) || empty($aTshirts) || count($aTshirts) === 1) {
      $GLOBALS['florpInfo'] = "";
      // $aOrderDates = $this->aOptions['aOrderDates'];
      // $GLOBALS['florpInfo'] = var_export($aOrderDates[$iTimestamp]['orders'], true);
      // $aTshirtsAll = $this->get_tshirts();
      // $GLOBALS['florpInfo'] = '<pre>'.var_export($aTshirtsAll, true).'</pre>'; // NOTE DEVEL

      $GLOBALS['florpWarningReason'] = '';
      if (is_string($aTshirts)) {
        $GLOBALS['florpWarningReason'] = '<p>'.$aTshirts.'</p>';
      }
      add_action( 'admin_notices', function() {
        echo '<div class="notice notice-warning"><p>No tshirts to build CSV from</p>'.$GLOBALS['florpWarningReason'].$GLOBALS['florpInfo'].'</div>'.PHP_EOL;
      });
      return;
    }
    $strFileName .= "-".current_time('Ymd-His').".csv";

    // output headers so that the file is downloaded rather than displayed
    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename="'.$strFileName.'"');

    // do not cache the file
    header('Pragma: no-cache');
    header('Expires: 0');

    // create a file pointer connected to the output stream
    $file = fopen('php://output', 'w');

    // output column headers and each row of the data
    foreach ($aTshirts as $aTshirtData) {
      fputcsv($file, $aTshirtData);
    }
    exit();
  }

  private function add_option_change($strOptionKey, $from, $to, $bSave = true) {
    $aChangedOptions[$strOptionKey] = array(
      'from'  => $from,
      'to'    => $to
    );
    $iCurrentUserID = get_current_user_id();
    $aChangedOptions['_user_id'] = $iCurrentUserID;
    $this->aOptions['aOptionChanges'][time()] = $aChangedOptions;
    if ($bSave) {
      $this->save_options();
    }
  }

  public function action__delete_florp_participant_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not remove the flashmob participant '{$aData['participantEmail']}'";
    if (!isset($this->aOptions["aParticipants"]) || empty($this->aOptions["aParticipants"])) {
      $aData["message"] = $strErrorMessage;
    } else {
      if (isset($this->aOptions["aParticipants"][$aData["leaderId"]]) && isset($this->aOptions["aParticipants"][$aData["leaderId"]][$aData["participantEmail"]])) {
        $aData["removeRowOnSuccess"] = true;
        $aData["ok"] = true;
        if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
          $aData["message"] = "The flashmob participant '{$aData['participantEmail']}' was deleted successfully (NOT: FLORP_DEVEL is on!)";
        } else {
          unset($this->aOptions["aParticipants"][$aData["leaderId"]][$aData["participantEmail"]]);
          $this->add_option_change("ajax__delete_florp_participant", "", $aData["leaderId"].": ".$aData["participantEmail"], false);
          $this->save_options();
          $aData["message"] = "The flashmob participant '{$aData['participantEmail']}' was deleted successfully";
        }
      } else {
        $aData["message"] = $strErrorMessage;
      }
    }
    // sleep(3);
    echo json_encode($aData);
    wp_die();
  }

  public function action__delete_florp_intf_participant_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not remove the international flashmob participant '{$aData['participantEmail']}'";
    if (!isset($this->aOptions["aIntfParticipants"]) || empty($this->aOptions["aIntfParticipants"]) || !isset($aData['year'])) {
      $aData["message"] = $strErrorMessage;
    } else {
      if (isset($this->aOptions["aIntfParticipants"][$aData["year"]]) && isset($this->aOptions["aIntfParticipants"][$aData["year"]][$aData["participantEmail"]])) {
        $aData["removeRowOnSuccess"] = true;
        $aData["ok"] = true;
        if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
          $aData["message"] = "The flashmob participant '{$aData['participantEmail']}' was deleted successfully (NOT: FLORP_DEVEL is on!)";
        } else {
          unset($this->aOptions["aIntfParticipants"][$aData["year"]][$aData["participantEmail"]]);
          $this->add_option_change("ajax__delete_florp_intf_participant", "", $aData["year"].": ".$aData["participantEmail"], false);
          $this->save_options();
          $aData["message"] = "The international flashmob participant '{$aData['participantEmail']}' was deleted successfully";
        }
      } else {
        $aData["message"] = $strErrorMessage;
      }
    }
    // sleep(3);
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_participant_attend_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not set attendance of the Slovak flashmob participant '{$aData['participantEmail']}'";
    if (!isset($this->aOptions["aParticipants"]) || empty($this->aOptions["aParticipants"]) || !isset($aData['leaderId'])) {
      $aData["message"] = $strErrorMessage;
    } else {
      if (isset($this->aOptions["aParticipants"][$aData["leaderId"]]) && isset($this->aOptions["aParticipants"][$aData["leaderId"]][$aData["participantEmail"]]) && isset($aData["attend"])) {
        $iTimestampNow = (int) current_time( 'timestamp' );
        $strTitle = ' title="'.date( $this->strDateFormat, $iTimestampNow ).'"';
        $aData["removeRowOnSuccess"] = false;
        $aData["replaceButton"] = true;
        $aData["ok"] = true;
        $strReplaceWith = ($aData["attend"] == "1") ? "-attend0-" : "-attend1-";
        $strOtherButtonID = str_replace( "-attend{$aData['attend']}-", $strReplaceWith, $aData['buttonId']);
        $aData["hideSelector"] = "tr[data-row-id={$aData['rowId']}] span[data-button-id={$strOtherButtonID}]";
        $strLabelForHiding = "Zúčastní/-il(a) sa";
        $aData["replaceButtonHtml"] = '<span data-button-id="'.$aData['buttonId'].'" class="notice notice-success"'.$strTitle.' data-text="'.$strLabelForHiding.'">'.$aData['textDefault'].'</span>';
        if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
          $aData["message"] = "The Slovak flashmob participant {$aData['participantEmail']}'s attendance was set successfully (NOT: FLORP_DEVEL is on!)";
        } else {
          $this->aOptions["aParticipants"][$aData["leaderId"]][$aData["participantEmail"]]["attend"] = $aData["attend"];
          $this->aOptions["aParticipants"][$aData["leaderId"]][$aData["participantEmail"]]["attend_set_timestamp"] = $iTimestampNow;
          $this->add_option_change("ajax__florp_participant_attend", "", $aData["attend"] . " (".$aData["leaderId"].": ".$aData["participantEmail"].")", false);
          $this->save_options();
          $aData["message"] = "The Slovak flashmob participant {$aData['participantEmail']}'s attendance was set successfully";
        }
      } else {
        $aData["message"] = $strErrorMessage;
      }
    }
    // sleep(3);
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_intf_participant_attend_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not set attendance of the international flashmob participant '{$aData['participantEmail']}'";
    if (!isset($this->aOptions["aIntfParticipants"]) || empty($this->aOptions["aIntfParticipants"]) || !isset($aData['year'])) {
      $aData["message"] = $strErrorMessage;
    } else {
      if (isset($this->aOptions["aIntfParticipants"][$aData["year"]]) && isset($this->aOptions["aIntfParticipants"][$aData["year"]][$aData["participantEmail"]]) && isset($aData["attend"])) {
        $iTimestampNow = (int) current_time( 'timestamp' );
        $strTitle = ' title="'.date( $this->strDateFormat, $iTimestampNow ).'"';
        $aData["removeRowOnSuccess"] = false;
        $aData["replaceButton"] = true;
        $aData["ok"] = true;
        $strReplaceWith = ($aData["attend"] == "1") ? "-attend0-" : "-attend1-";
        $strOtherButtonID = str_replace( "-attend{$aData['attend']}-", $strReplaceWith, $aData['buttonId']);
        $aData["hideSelector"] = "tr[data-row-id={$aData['rowId']}] span[data-button-id={$strOtherButtonID}]";
        $strLabelForHiding = "Zúčastní/-il(a) sa";
        $aData["replaceButtonHtml"] = '<span data-button-id="'.$aData['buttonId'].'" class="notice notice-success"'.$strTitle.' data-text="'.$strLabelForHiding.'">'.$aData['textDefault'].'</span>';
        if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
          $aData["message"] = "The international flashmob participant {$aData['participantEmail']}'s attendance was set successfully (NOT: FLORP_DEVEL is on!)";
        } else {
          $this->aOptions["aIntfParticipants"][$aData["year"]][$aData["participantEmail"]]["attend"] = $aData["attend"];
          $this->aOptions["aIntfParticipants"][$aData["year"]][$aData["participantEmail"]]["attend_set_timestamp"] = $iTimestampNow;
          $this->add_option_change("ajax__florp_intf_participant_attend", "", $aData["attend"] . " (".$aData["year"].": ".$aData["participantEmail"].")", false);
          $this->save_options();
          $aData["message"] = "The international flashmob participant {$aData['participantEmail']}'s attendance was set successfully";
        }
      } else {
        $aData["message"] = $strErrorMessage;
      }
    }
    // sleep(3);
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_participant_paid_fee_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not set fee payment status of the Slovak flashmob participant '{$aData['participantEmail']}'";
    if (!isset($this->aOptions["aParticipants"]) || empty($this->aOptions["aParticipants"]) || !isset($aData['leaderId'])) {
      $aData["message"] = $strErrorMessage;
    } else {
      if (isset($this->aOptions["aParticipants"][$aData["leaderId"]]) && isset($this->aOptions["aParticipants"][$aData["leaderId"]][$aData["participantEmail"]])) {
        $iTimestampNow = (int) current_time( 'timestamp' );
        $strTitle = ' title="'.date( $this->strDateFormat, $iTimestampNow ).'"';
        $aData["removeRowOnSuccess"] = false;
        $aData["replaceButton"] = true;
        $aData["ok"] = true;
        $strDeleteButtonID = str_replace( "-paid-fee", "", $aData['buttonId']);
        $aData["hideSelector"] = "tr[data-row-id={$aData['rowId']}] span[data-button-id={$strDeleteButtonID}]";
        $aData["replaceButtonHtml"] = '<span data-button-id="'.$aData['buttonId'].'" class="notice notice-success"'.$strTitle.'>'.$aData['textDefault'].'</span>';
        if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
          $aData["message"] = "The Slovak flashmob participant {$aData['participantEmail']}'s was set successfully (NOT: FLORP_DEVEL is on!)";
        } else {
          $this->aOptions["aParticipants"][$aData["leaderId"]][$aData["participantEmail"]]["paid_fee"] = $iTimestampNow;
          $this->add_option_change("ajax__florp_participant_paid_fee", "", $aData["leaderId"].": ".$aData["participantEmail"], false);
          $this->save_options();
          $aData["message"] = "The Slovak flashmob participant {$aData['participantEmail']}'s payment status was set successfully";
        }
      } else {
        $aData["message"] = $strErrorMessage;
      }
    }
    // sleep(3);
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_intf_participant_paid_fee_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not set fee payment status of the international flashmob participant '{$aData['participantEmail']}'";
    if (!isset($this->aOptions["aIntfParticipants"]) || empty($this->aOptions["aIntfParticipants"]) || !isset($aData['year'])) {
      $aData["message"] = $strErrorMessage;
    } else {
      if (isset($this->aOptions["aIntfParticipants"][$aData["year"]]) && isset($this->aOptions["aIntfParticipants"][$aData["year"]][$aData["participantEmail"]])) {
        $iTimestampNow = (int) current_time( 'timestamp' );
        $strTitle = ' title="'.date( $this->strDateFormat, $iTimestampNow ).'"';
        $aData["removeRowOnSuccess"] = false;
        $aData["replaceButton"] = true;
        $aData["ok"] = true;
        $strDeleteButtonID = str_replace( "-paid-fee", "", $aData['buttonId']);
        $aData["hideSelector"] = "tr[data-row-id={$aData['rowId']}] span[data-button-id={$strDeleteButtonID}]";
        $aData["replaceButtonHtml"] = '<span data-button-id="'.$aData['buttonId'].'" class="notice notice-success"'.$strTitle.'>'.$aData['textDefault'].'</span>';
        if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
          $aData["message"] = "The international flashmob participant {$aData['participantEmail']}'s was set successfully (NOT: FLORP_DEVEL is on!)";
        } else {
          $this->aOptions["aIntfParticipants"][$aData["year"]][$aData["participantEmail"]]["paid_fee"] = $iTimestampNow;
          $this->add_option_change("ajax__florp_intf_participant_paid_fee", "", $aData["year"].": ".$aData["participantEmail"], false);
          $this->save_options();
          $aData["message"] = "The international flashmob participant {$aData['participantEmail']}'s payment status was set successfully";
        }
      } else {
        $aData["message"] = $strErrorMessage;
      }
    }
    // sleep(3);
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_tshirt_paid_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not mark the flashmob participant '{$aData['participantEmail']}' as having paid";
    if (!isset($this->aOptions["aTshirts"]) || empty($this->aOptions["aTshirts"])) {
      $aData["message"] = $strErrorMessage;
    } else {
      $iTimestampNow = (int) current_time( 'timestamp' );
      $aData["ok"] = true;
      $aData["removeRowOnSuccess"] = false;
      $aData["replaceButton"] = true;
      $strTitle = ' title="'.date( $this->strDateFormat, $iTimestampNow ).'"';
      $strPaymentWarningButtonID = str_replace( "-paid-", "-paymentWarning-", $aData['buttonId']);
      $strCancelOrderButtonID = str_replace( "-paid-", "-cancelOrder-", $aData['buttonId']);
      $aData["hideSelector"] = "tr[data-row-id={$aData['rowId']}] span[data-button-id={$strPaymentWarningButtonID}], tr[data-row-id={$aData['rowId']}] span[data-button-id={$strCancelOrderButtonID}]";
      $aData["replaceButtonHtml"] = '<span data-button-id="'.$aData['buttonId'].'" class="notice notice-success"'.$strTitle.'>'.$aData['textDefault'].'</span>';
      if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
        $aData["message"] = "The flashmob participant '{$aData['participantEmail']}' was marked as having paid successfully (NOT: FLORP_DEVEL is on!)";
      } else {
        $aOk = array(
          "paid" => true,
          "paid-timestamp" => $iTimestampNow,
        );
        if ($aData["is_leader"] === "1" || $aData["is_leader"] === 1 || $aData["is_leader"] === true) {
          if (isset($this->aOptions["aTshirts"]["leaders"][$aData["user_id"]])) {
            $this->aOptions["aTshirts"]["leaders"][$aData["user_id"]] = array_merge(
              $this->aOptions["aTshirts"]["leaders"][$aData["user_id"]],
              $aOk
            );
          } else {
            $this->aOptions["aTshirts"]["leaders"][$aData["user_id"]] = $aOk;
          }
        } else {
          if (isset($this->aOptions["aTshirts"]["participants"][$aData["email"]])) {
            $this->aOptions["aTshirts"]["participants"][$aData["email"]] = array_merge(
              $this->aOptions["aTshirts"]["participants"][$aData["email"]],
              $aOk
            );
          } else {
            $this->aOptions["aTshirts"]["participants"][$aData["email"]] = $aOk;
          }
        }
        $this->add_option_change("ajax__florp_tshirt_paid", "", $aData["email"], false);
        $this->save_options();
        $aData["message"] = "The flashmob participant '{$aData['participantEmail']}' was marked as having paid successfully";//." ".var_export($aData, true);
      }
    }
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_intf_tshirt_paid_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not mark the flashmob participant '{$aData['participantEmail']}' as having paid";
    if (!isset($this->aOptions["aTshirtsIntf"]) || empty($this->aOptions["aTshirtsIntf"]) || !isset($aData['year'])) {
      $aData["message"] = $strErrorMessage;
    } else {
      $iYear = $aData['year'];
      $iTimestampNow = (int) current_time( 'timestamp' );
      $aData["ok"] = true;
      $aData["removeRowOnSuccess"] = false;
      $aData["replaceButton"] = true;
      $strTitle = ' title="'.date( $this->strDateFormat, $iTimestampNow ).'"';
      $strPaymentWarningButtonID = str_replace( "-paid-", "-paymentWarning-", $aData['buttonId']);
      $strCancelOrderButtonID = str_replace( "-paid-", "-cancelOrder-", $aData['buttonId']);
      $aData["hideSelector"] = "tr[data-row-id={$aData['rowId']}] span[data-button-id={$strPaymentWarningButtonID}], tr[data-row-id={$aData['rowId']}] span[data-button-id={$strCancelOrderButtonID}]";
      $aData["replaceButtonHtml"] = '<span data-button-id="'.$aData['buttonId'].'" class="notice notice-success"'.$strTitle.'>'.$aData['textDefault'].'</span>';
      if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
        $aData["message"] = "The flashmob participant '{$aData['participantEmail']}' was marked as having paid successfully (NOT: FLORP_DEVEL is on!)";
      } else {
        $aOk = array(
          "paid" => true,
          "paid-timestamp" => $iTimestampNow,
        );
        if (isset($this->aOptions["aTshirtsIntf"][$iYear][$aData["email"]])) {
          $this->aOptions["aTshirtsIntf"][$iYear][$aData["email"]] = array_merge(
            $this->aOptions["aTshirtsIntf"][$iYear][$aData["email"]],
            $aOk
          );
        } else {
          $this->aOptions["aTshirtsIntf"][$iYear][$aData["email"]] = $aOk;
        }
        $this->add_option_change("ajax__florp_intf_tshirt_paid", "", $aData["email"], false);
        $this->save_options();
        $aData["message"] = "The flashmob participant '{$aData['participantEmail']}' was marked as having paid successfully";//." ".var_export($aData, true);
      }
    }
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_tshirt_delivered_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not mark successful tshirt delivery for the flashmob participant '{$aData['participantEmail']}'";
    if (!isset($this->aOptions["aTshirts"]) || empty($this->aOptions["aTshirts"])) {
      $aData["message"] = $strErrorMessage;
    } else {
      $iYear = $aData['year'];
      $iTimestampNow = (int) current_time( 'timestamp' );
      $aData["ok"] = true;
      $aData["removeRowOnSuccess"] = false;
      $aData["replaceButton"] = true;
      $strTitle = ' title="'.date( $this->strDateFormat, $iTimestampNow ).'"';
      $aData["replaceButtonHtml"] = '<span data-button-id="'.$aData['buttonId'].'" class="notice notice-success"'.$strTitle.'>'.$aData['textDefault'].'</span>';
      if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
        $aData["message"] = "The tshirt delivery for flashmob participant '{$aData['participantEmail']}' was marked successfully (NOT: FLORP_DEVEL is on!)";
      } else {
        $aOk = array(
          "is_delivered" => true,
          "delivered-timestamp" => $iTimestampNow,
        );
        if ($aData["is_leader"] === "1" || $aData["is_leader"] === 1 || $aData["is_leader"] === true) {
          if (isset($this->aOptions["aTshirts"]["leaders"][$aData["user_id"]])) {
            $this->aOptions["aTshirts"]["leaders"][$aData["user_id"]] = array_merge(
              $this->aOptions["aTshirts"]["leaders"][$aData["user_id"]],
              $aOk
            );
          } else {
            $this->aOptions["aTshirts"]["leaders"][$aData["user_id"]] = $aOk;
          }
        } else {
          if (isset($this->aOptions["aTshirts"]["participants"][$aData["email"]])) {
            $this->aOptions["aTshirts"]["participants"][$aData["email"]] = array_merge(
              $this->aOptions["aTshirts"]["participants"][$aData["email"]],
              $aOk
            );
          } else {
            $this->aOptions["aTshirts"]["participants"][$aData["email"]] = $aOk;
          }
        }
        $this->add_option_change("ajax__florp_tshirt_delivered", "", $aData["email"], false);
        $this->save_options();
        $aData["message"] = "The tshirt delivery for flashmob participant '{$aData['participantEmail']}' was marked successfully";//." ".var_export($aData, true);
      }
    }
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_intf_tshirt_delivered_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not mark successful tshirt delivery for the flashmob participant '{$aData['participantEmail']}'";
    if (!isset($this->aOptions["aTshirtsIntf"]) || empty($this->aOptions["aTshirtsIntf"]) || !isset($aData['year'])) {
      $aData["message"] = $strErrorMessage;
    } else {
      $iYear = $aData['year'];
      $iTimestampNow = (int) current_time( 'timestamp' );
      $aData["ok"] = true;
      $aData["removeRowOnSuccess"] = false;
      $aData["replaceButton"] = true;
      $strTitle = ' title="'.date( $this->strDateFormat, $iTimestampNow ).'"';
      $aData["replaceButtonHtml"] = '<span data-button-id="'.$aData['buttonId'].'" class="notice notice-success"'.$strTitle.'>'.$aData['textDefault'].'</span>';
      if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
        $aData["message"] = "The tshirt delivery for flashmob participant '{$aData['participantEmail']}' was marked successfully (NOT: FLORP_DEVEL is on!)";
      } else {
        $aOk = array(
          "is_delivered" => true,
          "delivered-timestamp" => $iTimestampNow,
        );
        if (isset($this->aOptions["aTshirtsIntf"][$iYear][$aData["email"]])) {
          $this->aOptions["aTshirtsIntf"][$iYear][$aData["email"]] = array_merge(
            $this->aOptions["aTshirtsIntf"][$iYear][$aData["email"]],
            $aOk
          );
        } else {
          $this->aOptions["aTshirtsIntf"][$iYear][$aData["email"]] = $aOk;
        }
        $this->add_option_change("ajax__florp_intf_tshirt_delivered", "", $aData["email"], false);
        $this->save_options();
        $aData["message"] = "The tshirt delivery for flashmob participant '{$aData['participantEmail']}' was marked successfully";//." ".var_export($aData, true);
      }
    }
    echo json_encode($aData);
    wp_die();
  }

  public function action__add_order_date_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not add order date";
    $strOkMessage = "Successfully added order date";
    $aOrderTypes = array('all','paid','unpaid');
    if (isset($aData['orderdate'],$aData['orderdate_timestamp'],$aData['ordertype']) && in_array($aData['ordertype'], $aOrderTypes) && intval($aData['orderdate_timestamp']) > 0) {
      $iTimestamp = intval($aData['orderdate_timestamp']);
      $iTimestampMax = 0;
      $bTest = false; // NOTE DEVEL TEST //
      if ($bTest) {
        $this->aOptions['aOrderDates'] = array();
      }
      if (!empty($this->aOptions['aOrderDates'])) {
        $iTimestampMax = max(array_keys($this->aOptions['aOrderDates']));
      }
      if ($iTimestamp > time()) {
        $aData['message'] = $strErrorMessage . ". Order date cannot be in future!";
      } elseif ($iTimestamp <= $iTimestampMax) {
        $aData['message'] = $strErrorMessage . ". Order date must be after last existing order date!";
      } elseif (isset($this->aOptions['aOrderDates'][$iTimestamp])) {
        $aData['message'] = $strErrorMessage . ". This order date exists already!";
      } else {
        $aOrders = $this->get_tshirt_orders_by_timestamp( $iTimestamp, $aData['ordertype'], true, false );
        $aOrderIDs = array();
        foreach ($aOrders as $aTshirtData) {
          $aOrderIDs[] = $aTshirtData['id'];
        }
        $aNewOrder = array(
          'type' => $aData['ordertype'],
          'datetime' => $aData['orderdate'],
          'orders' => $aOrderIDs,
        );
        if (empty($aNewOrder['orders'])) {
          $aData['message'] = $strErrorMessage . ". There are no tshirts for this order!";
        } else {
          $this->aOptions['aOrderDates'][$iTimestamp] = $aNewOrder;
          $this->add_option_change("ajax__add_order_date", "", $iTimestamp, false);
          $this->save_options();

          $aNewOrder['id'] = $iTimestamp;
          $strOrderRowHtml = $this->get_tshirt_order_dates_row( $iTimestamp );

          if (strlen($strOrderRowHtml) > 0) {
            $aData["insertAfterSelector"] = "table.florpTshirtOrderTable tr:last-of-type";
            $aData["insertHtml"] = $strOrderRowHtml;
          }
          $aData["clearInputNames"] = true;
          // $aData["tshirt_order_dates_row"] = $strOrderRowHtml;
          $aData['message'] = $strOkMessage;
          $aData['ok'] = true;
        }
      }
    } else {
      $aData['message'] = $strErrorMessage;
    }
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_tshirt_send_payment_warning_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not send payment warning to the flashmob participant '{$aData['email']}'";
    if (!isset($this->aOptions["aTshirts"]) || empty($this->aOptions["aTshirts"]) || !isset($this->aOptions['strTshirtPaymentWarningNotificationMsg'], $this->aOptions['strTshirtPaymentWarningNotificationSbj']) || empty($this->aOptions['strTshirtPaymentWarningNotificationMsg']) || empty($this->aOptions['strTshirtPaymentWarningNotificationSbj'])) {
      $aData["message"] = $strErrorMessage;
    } else {
      $iTimestampNow = (int) current_time( 'timestamp' );
      $aData["removeRowOnSuccess"] = false;
      $aData["replaceButton"] = true;
      $strTitle = ' title="'.date( $this->strDateFormat, $iTimestampNow ).'"';
      $aData["replaceButtonHtml"] = '<span data-button-id="'.$aData['buttonId'].'" class="notice notice-success"'.$strTitle.' data-text="'.$aData['textDefault'].'">Upozornený na neskorú platbu</span>';

      $strMessageContent = $this->aOptions['strTshirtPaymentWarningNotificationMsg'];
      $strMessageSubject = $this->aOptions['strTshirtPaymentWarningNotificationSbj'];
      $strBlogname = trim(wp_specialchars_decode(get_option('blogname'), ENT_QUOTES));
      $aHeaders = array('Content-Type: text/html; charset=UTF-8');
      $bSendResult = wp_mail($aData["email"], $strMessageSubject, $strMessageContent, $aHeaders);

      if ($bSendResult) {
        $aData["ok"] = true;
        if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
          $aData["message"] = "A payment warning was sent to the flashmob participant '{$aData['email']}' (the action was NOT saved: FLORP_DEVEL is on!)";//." ".var_export($aData, true);
        } else {
          $aOk = array(
            "payment_warning_sent" => true,
            "payment_warning_sent-timestamp" => $iTimestampNow,
          );
          if ($aData["is_leader"] === "1" || $aData["is_leader"] === 1 || $aData["is_leader"] === true) {
            if (isset($this->aOptions["aTshirts"]["leaders"][$aData["user_id"]])) {
              $this->aOptions["aTshirts"]["leaders"][$aData["user_id"]] = array_merge(
                $this->aOptions["aTshirts"]["leaders"][$aData["user_id"]],
                $aOk
              );
            } else {
              $this->aOptions["aTshirts"]["leaders"][$aData["user_id"]] = $aOk;
            }
          } else {
            if (isset($this->aOptions["aTshirts"]["participants"][$aData["email"]])) {
              $this->aOptions["aTshirts"]["participants"][$aData["email"]] = array_merge(
                $this->aOptions["aTshirts"]["participants"][$aData["email"]],
                $aOk
              );
            } else {
              $this->aOptions["aTshirts"]["participants"][$aData["email"]] = $aOk;
            }
          }
          $this->add_option_change("ajax__florp_tshirt_send_payment_warning", "", $aData["email"], false);
          $this->save_options();
          $aData["message"] = "A payment warning was sent to the flashmob participant '{$aData['email']}'";//." ".var_export($aData, true);
        }
      } else {
        $aData["message"] = $strErrorMessage;
      }
    }
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_intf_tshirt_send_payment_warning_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not send payment warning to the flashmob participant '{$aData['email']}'";
    if (!isset($this->aOptions["aTshirtsIntf"]) || empty($this->aOptions["aTshirtsIntf"])
          || !isset($this->aOptions['strIntfTshirtPaymentWarningNotificationMsg'], $this->aOptions['strIntfTshirtPaymentWarningNotificationSbj'])
          || empty($this->aOptions['strIntfTshirtPaymentWarningNotificationMsg']) || empty($this->aOptions['strIntfTshirtPaymentWarningNotificationSbj'])
          || !isset($aData['year'])) {
      $aData["message"] = $strErrorMessage;
    } else {
      $iYear = $aData['year'];
      $iTimestampNow = (int) current_time( 'timestamp' );
      $aData["removeRowOnSuccess"] = false;
      $aData["replaceButton"] = true;
      $strTitle = ' title="'.date( $this->strDateFormat, $iTimestampNow ).'"';
      $aData["replaceButtonHtml"] = '<span data-button-id="'.$aData['buttonId'].'" class="notice notice-success"'.$strTitle.' data-text="'.$aData['textDefault'].'">Upozornený na neskorú platbu</span>';

      $strMessageContent = $this->aOptions['strIntfTshirtPaymentWarningNotificationMsg'];
      $strMessageSubject = $this->aOptions['strIntfTshirtPaymentWarningNotificationSbj'];
      $strBlogname = trim(wp_specialchars_decode(get_option('blogname'), ENT_QUOTES));
      $aHeaders = array('Content-Type: text/html; charset=UTF-8');
      $bSendResult = wp_mail($aData["email"], $strMessageSubject, $strMessageContent, $aHeaders);

      if ($bSendResult) {
        $aData["ok"] = true;
        if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
          $aData["message"] = "A payment warning was sent to the flashmob participant '{$aData['email']}' (the action was NOT saved: FLORP_DEVEL is on!)";//." ".var_export($aData, true);
        } else {
          $aOk = array(
            "payment_warning_sent" => true,
            "payment_warning_sent-timestamp" => $iTimestampNow,
          );
          if (isset($this->aOptions["aTshirtsIntf"][$iYear][$aData["email"]])) {
            $this->aOptions["aTshirtsIntf"][$iYear][$aData["email"]] = array_merge(
              $this->aOptions["aTshirtsIntf"][$iYear][$aData["email"]],
              $aOk
            );
          } else {
            $this->aOptions["aTshirtsIntf"][$iYear][$aData["email"]] = $aOk;
          }
          $this->add_option_change("ajax__florp_intf_tshirt_send_payment_warning", "", $aData["email"], false);
          $this->save_options();
          $aData["message"] = "A payment warning was sent to the flashmob participant '{$aData['email']}'";//." ".var_export($aData, true);
        }
      } else {
        $aData["message"] = $strErrorMessage;
      }
    }
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_tshirt_cancel_order_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not cancel the tshirt order of flashmob participant '{$aData['email']}'";
    if (!isset($this->aOptions["aParticipants"]) || empty($this->aOptions["aParticipants"])) {
      $aData["message"] = $strErrorMessage;
    } else {
      if (isset($this->aOptions["aParticipants"][$aData["leader_id"]]) && isset($this->aOptions["aParticipants"][$aData["leader_id"]][$aData["email"]])) {
        $aPreferences = $this->aOptions["aParticipants"][$aData["leader_id"]][$aData["email"]]['preferences'];
        if (is_array($aPreferences) && ($iKey = array_search("flashmob_participant_tshirt", $aPreferences)) !== false) {
          $aData["removeRowOnSuccess"] = true;
          $aData["ok"] = true;
          if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
            $aData["message"] = "The tshirt order of flashmob participant '{$aData['email']}' was cancelled successfully (NOT: FLORP_DEVEL is on!)";
          } else {
            unset($this->aOptions["aParticipants"][$aData["leader_id"]][$aData["email"]]['preferences'][$iKey]);
            $this->aOptions["aParticipants"][$aData["leader_id"]][$aData["email"]]['tshirt_order_cancelled_timestamp'] = (int) current_time( 'timestamp' );
            $this->add_option_change("ajax__florp_tshirt_cancel_order", "", $aData["email"], false);
            $this->save_options();
            $aData["message"] = "The tshirt order of flashmob participant '{$aData['email']}' was cancelled successfully";
          }
        } else {
          $aData["message"] = $strErrorMessage . "<br/>\nThe participant didn't order a tshirt.";
        }
      } else {
        $aData["message"] = $strErrorMessage;
      }
    }
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_intf_tshirt_cancel_order_callback() {
    // wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not cancel the tshirt order of flashmob participant '{$aData['email']}'";
    if (!isset($this->aOptions["aIntfParticipants"]) || empty($this->aOptions["aIntfParticipants"]) || !isset($aData['year'])) {
      $aData["message"] = $strErrorMessage;
    } else {
      $iYear = $aData['year'];
      if (isset($this->aOptions["aIntfParticipants"][$iYear]) && isset($this->aOptions["aIntfParticipants"][$iYear][$aData["email"]])) {
        $aPreferences = $this->aOptions["aIntfParticipants"][$iYear][$aData["email"]]['preferences'];
        if (is_array($aPreferences) && ($iKey = array_search("flashmob_participant_tshirt", $aPreferences)) !== false) {
          $aData["removeRowOnSuccess"] = true;
          $aData["ok"] = true;
          if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_FAKE_ACTIONS') && FLORP_DEVEL_FAKE_ACTIONS === true) {
            $aData["message"] = "The tshirt order of flashmob participant '{$aData['email']}' was cancelled successfully (NOT: FLORP_DEVEL is on!)";
          } else {
            unset($this->aOptions["aIntfParticipants"][$iYear][$aData["email"]]['preferences'][$iKey]);
            $this->aOptions["aIntfParticipants"][$iYear][$aData["email"]]['tshirt_order_cancelled_timestamp'] = (int) current_time( 'timestamp' );
            $this->add_option_change("ajax__florp_intf_tshirt_cancel_order", "", $aData["email"], false);
            $this->save_options();
            $aData["message"] = "The tshirt order of flashmob participant '{$aData['email']}' was cancelled successfully";
          }
        } else {
          $aData["message"] = $strErrorMessage . "<br/>\nThe participant didn't order a tshirt.";
        }
      } else {
        $aData["message"] = $strErrorMessage;
      }
    }
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_create_subsite_callback() {
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not create subsite for subdomain '{$aData['subdomain']}'.";
    $oUser = wp_get_current_user();
    $iUserID = get_current_user_id();
    if (is_super_admin( $iUserID ) || current_user_can( 'manage_sites' )) {
      $strDomainEnding = "." . $this->get_root_domain();
      $strSlug = $aData["subdomain"];
      $strDomain = $strSlug . $strDomainEnding;
      $iSourceBlogID = $this->aOptions['iCloneSourceBlogID'];
      $strPath = '/';
      $aArgs = array(
        'slug' => $aData["subdomain"],
        'source' => $this->aOptions['iCloneSourceBlogID'],
        'email' => $oUser->user_email,
        'keep_users' => true,
      );
      if( class_exists( 'MUCD_Functions' ) ) {
        $strErrorMessage = "Could not clone subsite for subdomain '{$aData['subdomain']}'.";
        if (isset($aArgs['source']) && $aArgs['source'] > 0) {
          $bTest = false; // NOTE DEVEL TEST //
          if ($bTest) {
            $aData['ok'] = true;
            $aData['message'] = "ok message";
          } else {
            $aResult = $this->mucd_clone_site( $aArgs );
            $aData = array_merge( $aData, $aResult );
          }
        } else {
          $aData["message"] = $strErrorMessage . "<br/>Source subsite is not set!";
        }
      } else {
        $iID = wpmu_create_blog( $strDomain, $strPath, $aArgs['slug'], $iUserID );
        if (is_wp_error($iID)) {
          $aData["message"] = $strErrorMessage . "<br/>".$iID->get_error_message();
        } else {
          $aData["ok"] = true;
          $aData["message"] = "Successfully created subsite: '{$strDomain}'";
        }
      }
    } else {
      $aData["message"] = "You do not have sufficient rights to create a subsite!";
    }

    if ($aData['ok']) {
      $this->prevent_direct_media_downloads(true);
      $aData["removeRowOnSuccess"] = false;
      if ($aData["rowId"] === "florpRow-subsite-0") {
        $aData["insertAfterSelector"] = "table tr:last-of-type";
        $aData["insertHtml"] = "<tr><td>-</td><td>-</td><td>{$strDomain}</td></tr>";
        $aData["clearInputNames"] = true;
      } else {
        $aData["hideSelector"] = "tr[data-row-id={$aData['rowId']}] span[data-user_id={$aData['user_id']}], tr[data-row-id={$aData['rowId']}] .subsite br";
        $aData["replaceButton"] = true;
      }
      $aData["replaceButtonHtml"] = "<span data-button-id=\"{$aData['buttonId']}\">{$strDomain}</span>";
      $this->add_option_change("ajax__florp_create_subsite", "", $aData['subdomain']);
    }

    echo json_encode($aData);
    wp_die();
  }

  public function action__delete_nf_submission_callback() {
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $bTest = false; // NOTE DEVEL TEST //

    $aData = $_POST;
    $strErrorMessage = "Could not delete form #{$aData['formId']} submission #{$aData['submissionId']} of '{$aData['email']}'";
    $strOkMessage = "Successfully deleted form #{$aData['formId']} submission #{$aData['submissionId']} of '{$aData['email']}'";
    $aData["removeRowOnSuccess"] = true;

    $mixChangeBlogID = false;
    $iBlogID = intval($aData['blogId']);
    $iFormID = intval($aData['formId']);
    $iSubmissionID = intval($aData['submissionId']);

    if (!isset($this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID], $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['rows'][$iSubmissionID])) {
      $aData['message'] = $strErrorMessage;
      $aData['submissions_option'] = $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID];
    } else {
      if ($iBlogID !== intval(get_current_blog_id())) {
        $mixChangeBlogID = $iBlogID;
      }
      if (false !== $mixChangeBlogID) {
        switch_to_blog($mixChangeBlogID);
      }

      $oSubmission = Ninja_Forms()->form( $iFormID )->get_sub( $iSubmissionID );
      $strUserEmail = $oSubmission->get_field_value( 'user_email' );
      if (empty($strUserEmail)) {
        $aData['message'] = $strErrorMessage;
      }
      if (!$bTest) {
        $oSubmission->delete();
      }

      $oSubmission = Ninja_Forms()->form( $iFormID )->get_sub( $iSubmissionID );
      $strUserEmailN = $oSubmission->get_field_value( 'user_email' );
      if (!$bTest && $strUserEmail === $strUserEmailN) {
        $aData['message'] = $strErrorMessage;
      }

      if (false !== $mixChangeBlogID) {
        restore_current_blog();
      }

      if (!isset($aData['message'])) {
        if (isset($this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID], $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['rows'][$iSubmissionID])) {
          if ($bTest) {
            $aData['deleted'] = $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['rows'][$iSubmissionID];
            $aData['submissions_option_before'] = $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['rows'];
          }
          unset($this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['rows'][$iSubmissionID]);
          if ($bTest) {
            $aData['submissions_option_after'] = $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID]['rows'];
          }
          if (!$bTest) {
            $this->save_options();
          }
        } elseif ($bTest) {
          $aData['submissions_option'] = $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][$iFormID];
        }

        $aMissedSubmissions = $this->get_nf_submissions( $iBlogID );
        if ($bTest) {
          $aData['submissions'] = $aMissedSubmissions;
        }
        if (isset($aMissedSubmissions[$aData['email']])) {
          foreach ($aMissedSubmissions[$aData['email']] as $aSubmissionData) {
            if ($aSubmissionData['_form_id'] === $iFormID && $aSubmissionData['_submission_id'] === $iSubmissionID && $aSubmissionData['_blog_id'] === $iBlogID ) {
              $aData['message'] = $strErrorMessage;
              break;
            }
          }
          if (!isset($aData['message'])) {
            $aData['ok'] = true;
            $aData['message'] = $strOkMessage;
            if (!$bTest) {
              $this->add_option_change("ajax__delete_nf_submission", "", "form #{$iFormID} submission #{$iSubmissionID} of '{$aData['email']}'");
            }
          }
        } else {
          $aData['ok'] = true;
          $aData['message'] = $strOkMessage;
          if (!$bTest) {
            $this->add_option_change("ajax__delete_nf_submission", "", "form #{$iFormID} submission #{$iSubmissionID} of '{$aData['email']}'");
          }
        }
      }
    }

    echo json_encode($aData);
    wp_die();
  }

  public function action__import_flashmob_nf_submission_callback() {
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not import form #{$aData['formId']} submission #{$aData['submissionId']} of '{$aData['email']}'";
    $strOkMessage = "Successfully imported form #{$aData['formId']} submission #{$aData['submissionId']} of '{$aData['email']}'";
    $aData["removeRowOnSuccess"] = true;
    $aData["hideSelector"] = "tr.missedSubmissionRow[data-email='{$aData['email']}']";
    $aData['blogId'] = intval($aData['blogId']);

    if ($aData['blogId'] === $this->iFlashmobBlogID) {
      $aSubmission = $this->get_nf_submission($aData['blogId'], $aData['formId'], $aData['submissionId']);
      if ($aSubmission) {
        $oLeader = get_user_by( 'id', $aSubmission['leader_user_id'] );
        if (false === $oLeader) {
          // Leader doesn't exist (any more) //
          $aData['message'] = $strErrorMessage . "\nLeader doesn't exist";
        } elseif (in_array( $this->strUserRolePending, (array) $oLeader->roles )) {
          // Leader is pending //
          $aData['message'] = $strErrorMessage . "\nLeader is pending approval";
        } else {
          $aFields = array();
          $aSkipKeys = array('_submission_date', '_submission_date_wp_format', '_submission_timestamp', '_form_id', '_submission_id', '_blog_id', '_field_types');
          foreach ($aSubmission as $key => $val) {
            if (in_array($key, $aSkipKeys)) {
              continue;
            }
            if (!isset($aSubmission['_field_types'][$key])) {
              continue;
            }
            $aFields[] = array(
              'type'  => $aSubmission['_field_types'][$key],
              'key'   => $key,
              'value' => $val
            );
          }
          $aFormData = array(
            'form_id' => $this->iProfileFormNinjaFormIDFlashmob,
            'fields' => $aFields
          );
          $bIsFlashmobBlogBak =  $this->isFlashmobBlog;
          $bIsMainBlogBak =  $this->isMainBlog;
          $this->isFlashmobBlog = true;
          $this->isMainBlog = false;
          $res = $this->action__update_user_profile( $aFormData );
          $this->isFlashmobBlog = $bIsFlashmobBlogBak;
          $this->isMainBlog = $bIsMainBlogBak;
          // $aData['res'] = var_export($res, true); // NOTE DEVEL

          if (!$this->flashmob_participant_exists($aData['email'])) {
            // Participant wasn't imported //
            $aData['message'] = $strErrorMessage;
          } else {
            // Participant was imported //
            $aData['ok'] = true;
            $aData['message'] = $strOkMessage;
            $this->add_option_change("ajax__import_flashmob_nf_submission", "", "form #{$aData['formId']} submission #{$aData['submissionId']} of '{$aData['email']}'");
          }
        }
      } else {
        // Submission was not found //
        $aData['message'] = $strErrorMessage . "\nSubmission couldn't be found";
      }
    } else {
      $aData['message'] = "This button is only for flashmob submissions!";
      // $aData['iFlashmobBlogID'] = $this->iFlashmobBlogID;
    }

    echo json_encode($aData);
    wp_die();
  }

  public function action__cancel_flashmob_callback($bCancelFlashmob = true) {
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $bCancelFlashmob = !($bCancelFlashmob === false);
    if ($bCancelFlashmob) {
      $strErrorMessage = "Could not cancel flashmob";
      $strOkMessage = "Successfully cancelled flashmob";
    } else {
      $strErrorMessage = "Could not move participants";
      $strOkMessage = "Successfully moved participants";
    }

    $iUserID = $aData['userId'];
    if (isset($iUserID) && $iUserID !== "") {
      $iUserID = intval($iUserID);
      if ($iUserID > 0) {
        $strErrorMessage .= " of user #{$iUserID}";
        $strOkMessage .= " of user #{$iUserID}";
        if (isset($aData['florp_cancel_flashmob_reassign_participants-'.$iUserID]) && $aData['florp_cancel_flashmob_reassign_participants-'.$iUserID] !== "") {
          $iReassignTo = intval($aData['florp_cancel_flashmob_reassign_participants-'.$iUserID]);
        } else {
          $iReassignTo = 0;
        }
        $bHasParticipants = (isset($this->aOptions['aParticipants'][$iUserID]) && is_array($this->aOptions['aParticipants'][$iUserID]) && count($this->aOptions['aParticipants'][$iUserID]) > 0);
        if ($bHasParticipants) {
          if ($iReassignTo > 0) {
            if ($iReassignTo === $iUserID) {
              $aData['message'] = $strErrorMessage . ". You cannot reassign participants of a user to themselves!";
            } else {
              if ($bCancelFlashmob) {
                $strOkMessage .= " and moved their participants to user #{$iReassignTo}";
              } else {
                $strOkMessage .= " to user #{$iReassignTo}";
              }
              if (!isset($this->aOptions['aParticipants'][$iReassignTo]) || !is_array($this->aOptions['aParticipants'][$iReassignTo])) {
                $this->aOptions['aParticipants'][$iReassignTo] = array();
              }
              foreach ($this->aOptions['aParticipants'][$iUserID] as $strEmail => $aParticipantData) {
                $this->aOptions['aParticipants'][$iUserID][$strEmail]['moved_from_user_id'] = $iUserID;
              }
              $this->aOptions['aParticipants'][$iReassignTo] = array_merge($this->aOptions['aParticipants'][$iReassignTo], $this->aOptions['aParticipants'][$iUserID]);
              unset($this->aOptions['aParticipants'][$iUserID]);
            }
          } elseif ($iReassignTo === 0) {
            // Send notification to participants and remove them //
            if (strlen(trim($this->aOptions['strParticipantRemovedMessage'])) > 0 && $this->aOptions['strParticipantRemovedSubject']) {
              if ($bCancelFlashmob) {
                $strOkMessage .= ", removed their participants and notified them";
              } else {
                $strOkMessage = "Successfully removed participants of user #{$iUserID} and notified them";
              }
              foreach ($this->aOptions['aParticipants'][$iUserID] as $strEmail => $aParticipantData) {
                $strMessageContent = $this->aOptions['strParticipantRemovedMessage'];
                $strBlogname = trim(wp_specialchars_decode(get_option('blogname'), ENT_QUOTES));
                $aHeaders = array('Content-Type: text/html; charset=UTF-8');
                $this->new_user_notification( $strEmail, '', $strEmail, $strBlogname, $strMessageContent, $this->aOptions['strParticipantRemovedSubject'], $aHeaders );
              }
              unset($this->aOptions['aParticipants'][$iUserID]);
            } else {
              $aData['message'] = $strErrorMessage . ". No flashmob cancelling notification message is set";
            }
          } else {
            $aData['message'] = $strErrorMessage . ". Invalid user to reassign to";
          }
        } elseif ($bCancelFlashmob) {
          // No participants - OK, just cancel the flashmob //
        } elseif ($iReassignTo > 0) {
          // No participants and action was to move participants //
          $aData['message'] = $strErrorMessage . ". No participants to reassign";
        } else {
          // No participants and action was to remove participants //
          $aData['message'] = $strErrorMessage . ". No participants to remove";
        }

        if (!isset($aData['message'])) {
          $this->save_options();
          if ($bCancelFlashmob) {
            update_user_meta($iUserID, 'flashmob_organizer', '0');
          }
          $aData['ok'] = true;
          $strOkMessage .= ". <strong>Please wait for the page to reload</strong>";
          $aData['message'] = $strOkMessage;
          $aData['reload_page'] = true;
          $this->add_option_change("ajax__cancel_flashmob", "", $aData['message']);
        }
      } else {
        $aData['message'] = $strErrorMessage . ". Invalid user ID: {$_POST['userId']}";
      }
    } else {
      $aData['message'] = $strErrorMessage . ". Invalid user ID: {$_POST['userId']}";
    }

    echo json_encode($aData);
    wp_die();
  }

  public function action__move_flashmob_participants_callback() {
    $this->action__cancel_flashmob_callback(false);
  }

  private function mucd_clone_site( $assoc_args ) {
    /**
     * Duplicate a site in a multisite install.
     *
     * ## OPTIONS
     *
     * --slug=<slug>
     * : Path for the new site. Subdomain on subdomain installs, directory on subdirectory installs.
     *
     * --source=<site_id>
     * : ID of the site to duplicate.
     *
     * [--title=<title>]
     * : Title of the new site. Default: prettified slug.
     *
     * [--email=<email>]
     * : Email for Admin user. User will be created if none exists. Assignement to Super Admin if not included.
     *
     * [--network_id=<network-id>]
     * : Network to associate new site with. Defaults to current network (typically 1).
     *
     * [--private]
     * : If set, the new site will be non-public (not indexed)
     *
     * [--porcelain]
     * : If set, only the site id will be output on success.
     *
     * [--v]
     * : If set, print more details about the new site (Verbose mode). Do not work if --procelain is set.
     *
     * [--do_not_copy_files]
     * : If set, files of the duplicated site will not be copied.
     *
     * [--keep_users]
     * : If set, the new site will have the same users as the duplicated site.
     *
     * [--log=<dir_path>]
     * : If set, a log will be written in this directory (please check this directory is writable).
     *
     * @alias clone
     *
     * @synopsis --slug=<slug> --source=<site_id> [--title=<title>] [--email=<email>] [--network_id=<network-id>] [--private] [--porcelain] [--v] [--do_not_copy_files] [--keep_users] [--log=<dir_path>]
     */

    $aOutput = array(
      'ok' => false
    );
    if( !class_exists( 'MUCD_Functions' ) ) {
      $aOutput['message'] = "MUCD plugin is not active!";
      return $aOutput;
    }

    global $wpdb, $current_site;


    $base = $assoc_args['slug'];
    $title = isset( $assoc_args['title'] ) ? $assoc_args['title'] : ucfirst( $base );

    $email = empty( $assoc_args['email'] ) ? '' : $assoc_args['email'];

    // Network
    if ( !empty( $assoc_args['network_id'] ) ) {
        $network = MUCD_Functions::get_network( $assoc_args['network_id'] );
        if ( $network === false ) {
            $aOutput['message'] = sprintf( 'Network with id %d does not exist.', $assoc_args['network_id'] );
            return $aOutput;
        }
    }
    else {
        $network = $current_site;
    }
    $network_id = $network->id;

    $public = !isset( $assoc_args['private'] );

    // Sanitize
    if ( preg_match( '|^([a-zA-Z0-9-])+$|', $base ) ) {
        $base = strtolower( $base );
    }

    // If not a subdomain install, make sure the domain isn't a reserved word
    if ( !is_subdomain_install() ) {
        $subdirectory_reserved_names = apply_filters( 'subdirectory_reserved_names', array( 'page', 'comments', 'blog', 'files', 'feed' ) );
        if ( in_array( $base, $subdirectory_reserved_names ) ) {
            $aOutput['message'] =  'The following words are reserved and cannot be used as blog names: ' . implode( ', ', $subdirectory_reserved_names );
            return $aOutput;
        }
    }

    // Check for valid email, if not, use the first Super Admin found
    // Probably a more efficient way to do this so we dont query for the
    // User twice if super admin
    $email = sanitize_email( $email );
    if ( empty( $email ) || !is_email( $email ) ) {
        $super_admins = get_super_admins();
        $email = '';
        if ( !empty( $super_admins ) && is_array( $super_admins ) ) {
            // Just get the first one
            $super_login = $super_admins[0];
            $super_user = get_user_by( 'login', $super_login );
            if ( $super_user ) {
                $email = $super_user->user_email;
            }
        }
    }

    if ( is_subdomain_install() ) {
        $newdomain = $base.'.'.preg_replace( '|^www\.|', '', $network->domain );
        $path = $network->path;
    }
    else {
        $newdomain = $network->domain;
        $path = $network->path . $base . '/';
    }

    // Source ?
    $source = $assoc_args['source'];
    if(! intval($source) != 0) {
        $aOutput['message'] = $source . ' is not a valid site ID.';
        return $aOutput;
    }

    if (! MUCD_Functions::site_exists($source)) {
        $aOutput['message'] = 'There is no site with ID=' . $source . '. The site to duplicate must be an existing site of the network.';
        return $aOutput;
    }


    // Copy files ?
    $copy_files = isset( $assoc_args['do_not_copy_files'] ) ? 'no' : 'yes';

    // Keep users ?
    $keep_users = isset( $assoc_args['keep_users'] ) ? 'yes' : 'no';

    // Write log
    if(isset( $assoc_args['log'] )) {
        $log = 'yes';
        $log_path = $assoc_args['log'];
    }
    else {
        $log = 'no';
        $log_path = '';
    }

    $data = array (
        'source' => $source,
        'domain' => $base,
        'title' => $title,
        'email' => $email,
        'copy_files' => $copy_files,
        'keep_users' => $keep_users,
        'log' => $log,
        'log-path' => $log_path,
        'from_site_id' => $source,
        'newdomain' => $newdomain,
        'path' => $path,
        'public' => $public,
        'network_id' => $network_id,
    );

    $wpdb->hide_errors();
    $form_message = MUCD_Duplicate::duplicate_site($data);
    $wpdb->show_errors();

    if(isset($form_message['error']) ) {
      $aOutput['message'] = $form_message['error'];
    } else {
      $aOutput['ok'] = true;
      if ( isset( $assoc_args['porcelain'] ) ) {
        $aOutput['new_site_id'] = $form_message['site_id'];
      } else {
        switch_to_blog($form_message['site_id']);

        if(! isset( $assoc_args['v'] )) {
          $aOutput['message'] = 'Site ' . $form_message['site_id'] . ' created: ' . get_site_url();
          $aOutput['new_site_id'] = $form_message['site_id'];
        } else { // Verbose mode
          $aOutput['message'] = $form_message['msg'];
          $aOutput['new_site_id'] = $form_message['site_id'];
          $aOutput['new_site_title'] = get_bloginfo('name');
          $aOutput['new_site_front'] = get_site_url();
          $aOutput['new_site_dashboard'] = admin_url();
          $aOutput['new_site_customize'] = admin_url( 'customize.php' );
        }

        restore_current_blog();
      }
    }
    return $aOutput;
  }

  private function setup_new_city_subsite( $iSiteID ) {
    $aAdminArgs = array(
      'blog_id' => $this->iMainBlogID,
      'role'    => 'administrator'
    );
    $aAdmins = get_users( $aAdminArgs );
    if (empty($aAdmins) || (defined('FLORP_DEVEL') && FLORP_DEVEL === true)) {
      $aAdmins = array( wp_get_current_user() );
    }

    foreach ($aAdmins as $oAdmin) {
      if ($oAdmin->ID === get_current_user_id()) {
        continue;
      }
      add_user_to_blog( $iSiteID, $oAdmin->ID, 'administrator' );
    }
  }

  private function get_root_domain() {
    $aSites = wp_get_sites();
    foreach ($aSites as $i => $aSite) {
      if ($aSite['public'] != 1 || $aSite['deleted'] == 1 || $aSite['archived'] == 1) {
        continue;
      }
      $strDomain = $aSite['domain'];
      $iID = intval($aSite['blog_id']);
      if (is_main_site($iID)) {
        return $strDomain;
      }
    }
    return "salsarueda.dance";
  }

  private function get_options_page_vars() {
    $aReturn = array();

    $aReturn['optionNone'] = '<option value="0">Žiadny</option>';
    $aReturn['optionNoneF'] = '<option value="0">Žiadna</option>';

    $optionsFlashmobSite = '';
    $optionsMainSite = '';
    $optionsNewsletterSite = $optionNoneF;
    $optionsCloneSourceSite = $optionNoneF;
    $optionsIntfSite = '';
    $aSites = wp_get_sites();
    $strMainBlogDomain = '';
    $strFlashmobBlogDomain = '';
    $strIntfBlogDomain = '';
    foreach ( $aSites as $i => $aSite ) {
      if ($aSite['public'] != 1 || $aSite['deleted'] == 1 || $aSite['archived'] == 1) {
        continue;
      }
      $iID = $aSite['blog_id'];
      $strTitle = $aSite['domain'] . " (ID: {$iID})";
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
      if ($this->iIntfBlogID == $iID) {
        $strSelectedIntfSite = 'selected="selected"';
        $strIntfBlogDomain = $aSite['domain'];
      } else {
        $strSelectedIntfSite = '';
      }
      if ($this->aOptions['iNewsletterBlogID'] == $iID) {
        $strSelectedNewsletterSite = 'selected="selected"';
      } else {
        $strSelectedNewsletterSite = '';
      }
      if ($this->aOptions['iCloneSourceBlogID'] == $iID) {
        $strSelectedCloneSourceSite = 'selected="selected"';
      } else {
        $strSelectedCloneSourceSite = '';
      }
      $optionsFlashmobSite .= '<option value="'.$iID.'" '.$strSelectedFlashmobSite.'>'.$strTitle.'</option>';
      $optionsMainSite .= '<option value="'.$iID.'" '.$strSelectedMainSite.'>'.$strTitle.'</option>';
      $optionsNewsletterSite .= '<option value="'.$iID.'" '.$strSelectedNewsletterSite.'>'.$strTitle.'</option>';
      $optionsCloneSourceSite .= '<option value="'.$iID.'" '.$strSelectedCloneSourceSite.'>'.$strTitle.'</option>';
      $optionsIntfSite .= '<option value="'.$iID.'" '.$strSelectedIntfSite.'>'.$strTitle.'</option>';
    }
    $aReturn['optionsFlashmobSite'] = $optionsFlashmobSite;
    $aReturn['optionsMainSite'] = $optionsMainSite;
    $aReturn['optionsNewsletterSite'] = $optionsNewsletterSite;
    $aReturn['optionsCloneSourceSite'] = $optionsCloneSourceSite;
    $aReturn['optionsIntfSite'] = $optionsIntfSite;
    $aReturn['strIntfBlogDomain'] = $strIntfBlogDomain;
    $aReturn['strMainBlogDomain'] = $strMainBlogDomain;
    $aReturn['strFlashmobBlogDomain'] = $strFlashmobBlogDomain;

    $aBooleanOptionsChecked = array();
    foreach ($this->aBooleanOptions as $strOptionKey) {
      if ($this->aOptions[$strOptionKey] === true) {
        $aBooleanOptionsChecked[$strOptionKey] = 'checked="checked"';
      } else {
        $aBooleanOptionsChecked[$strOptionKey] = '';
      }
    }
    $aReturn['aBooleanOptionsChecked'] = $aBooleanOptionsChecked;

    return $aReturn;
  }

  public function options_page() {
    // echo "<h1>" . __("Flashmob Organizer Profile Options", "florp" ) . "</h1>";
    echo "<div class=\"wrap\"><h1>" . "Nastavenia profilu organizátora slovenského flashmobu" . "</h1>";

    if (isset($_POST['save-florp-options'])) {
      $this->save_option_page_options($_POST);
    }

    $aVariables = $this->get_options_page_vars();

    if (!$this->isMainBlog && strlen($aVariables['strMainBlogDomain']) > 0) {
      echo "<p>Spoločné nastavenia a nastavenia pre hlavnú stránku sú <a href=\"http://{$aVariables['strMainBlogDomain']}/wp-admin/admin.php?page=florp-main\">tu</a>.</p>";
    }
    if (!$this->isFlashmobBlog && strlen($aVariables['strFlashmobBlogDomain']) > 0) {
      echo "<p>Nastavenia pre flashmobovú stránku sú <a href=\"http://{$aVariables['strFlashmobBlogDomain']}/wp-admin/admin.php?page=florp-main\">tu</a>.</p>";
    }
    if (!$this->isMainBlog && !$this->isFlashmobBlog) {
      do_action('florp_options_page_notices');
      echo "</div><!-- .wrap -->";
      return;
    }

    if (defined('FLORP_DEVEL') && FLORP_DEVEL === true) {
      // echo "<pre>" .var_export($this->aOptions, true). "</pre>";
      // echo "<pre>" .var_export(array_merge($this->aOptions, array('aYearlyMapOptions' => 'removedForPreview', 'aParticipants' => 'removedForPreview')), true). "</pre>";
      // $aMapOptions = $this->get_flashmob_map_options_array(true, 0);
      // echo "<pre>" .var_export($aMapOptions, true). "</pre>";
      // echo "<pre>" .var_export($this->aOptions['aYearlyMapOptions'], true). "</pre>";
      // echo "<pre>" .var_export($this->getFlashmobSubscribers('subscriber_only'), true). "</pre>";
      // echo "<pre>" .var_export($this->getFlashmobSubscribers('flashmob_organizer'), true). "</pre>";
      // echo "<pre>" .var_export($this->getFlashmobSubscribers('teacher'), true). "</pre>";
      // echo "<pre>" .var_export($this->getFlashmobSubscribers('all'), true). "</pre>";
      // echo "<pre>" .var_export($this->get_flashmob_map_options_array_to_archive(), true). "</pre>";
      // $this->delete_logs();
      // echo "<pre>" .var_export($this->get_logs(), true). "</pre>";
      // foreach($this->aOptions['aParticipants'] as $i => $a) {foreach($a as $e => $ap) {$this->aOptions['aParticipants'][$i][$e]['leader_notified']=false;}}; $this->save_options();
      // echo "<pre>" .var_export($this->aOptions['aParticipants'], true). "</pre>";
      // echo "<pre>" .var_export(wp_get_sites(), true). "</pre>";
      // echo "<pre>" .var_export($this->findCityWebpage( "Bánovce nad Bebravou" ), true). "</pre>";
    }

    $aVariablesMain = array(
      'optionsMainSite' => $aVariables['optionsMainSite'],
      'optionNone' => $aVariables['optionNone'],
      'optionNoneF' => $aVariables['optionNoneF'],
      'aBooleanOptionsChecked' => $aVariables['aBooleanOptionsChecked'],
      'optionsCloneSourceSite' => $aVariables['optionsCloneSourceSite'],
    );
    $aVariablesFlashmob = array(
      'optionsFlashmobSite' => $aVariables['optionsFlashmobSite'],
      'optionNone' => $aVariables['optionNone'],
      'optionNoneF' => $aVariables['optionNoneF'],
      'aBooleanOptionsChecked' => $aVariables['aBooleanOptionsChecked'],
    );
    $aVariablesCommon = array(
      'aBooleanOptionsChecked' => $aVariables['aBooleanOptionsChecked'],
      'optionsNewsletterSite' => $aVariables['optionsNewsletterSite'],
    );

    $strSettingsHtmlMain = $this->options_page_main( $aVariablesMain );
    $strSettingsHtmlFlashmob = $this->options_page_flashmob( $aVariablesFlashmob );
    $strSettingsHtmlCommon = $this->options_page_common( $aVariablesCommon );

    do_action('florp_options_page_notices');

    echo str_replace(
      array( '%%optionsMainSite%%', '%%optionsFlashmobSite%%', '%%optionsCommon%%' ),
      array( $strSettingsHtmlMain, $strSettingsHtmlFlashmob, $strSettingsHtmlCommon ),
      file_get_contents( __DIR__ . "/view/options-svk.html" )
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
        $strTitle = $objForm->get_setting( 'title' ) . " (ID: {$iID})";
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
      // var_dump($aPopupsWPQuery);

      if ( $aPopupsWPQuery->have_posts() ) {
        while ( $aPopupsWPQuery->have_posts() ) :
          $aPopupsWPQuery->next_post();
          $iID = $aPopupsWPQuery->post->ID;
          $strTitle = $aPopupsWPQuery->post->post_title . " (ID: {$iID})";
          if ($this->iProfileFormPopupIDMain == $iID) {
            $strSelectedMain = 'selected="selected"';
          } else {
            $strSelectedMain = '';
          }
          $optionsPopupsMain .= '<option value="'.$iID.'" '.$strSelectedMain.'>'.$strTitle.'</option>';
        endwhile;
      }
    }

    $optionsPagesMain = $optionNoneF;
    $aPages = get_pages();
    foreach ($aPages as $oPage) {
      $iID = $oPage->ID;
      $strTitle = $oPage->post_title . " (ID: {$iID})";
      if (function_exists('pll_get_post_language')) {
        $strLang = pll_get_post_language( $iID, 'name' );
        $strTitle .= " [{$strLang}]";
      }
      if ($this->iProfileFormPageIDMain == $iID) {
        $strSelectedMain = 'selected="selected"';
      } else {
        $strSelectedMain = '';
      }
      $optionsPagesMain .= '<option value="'.$iID.'" '.$strSelectedMain.'>'.$strTitle.'</option>';
    }

    $strBeforeLoginFormHtmlMain = $this->get_wp_editor( $this->strBeforeLoginFormHtmlMain, 'florp_before_login_form_html_main' );
    $wpEditorPendingUserPageContentHTML = $this->get_wp_editor( $this->strPendingUserPageContentHTML, 'florp_pending_user_page_content_html' );
    $wpEditorUserApprovedMessage = $this->get_wp_editor( $this->strUserApprovedMessage, 'florp_user_approved_message' );
    $wpEditorLeaderParticipantListNotificationMsg = $this->get_wp_editor( $this->aOptions['strLeaderParticipantListNotificationMsg'], 'florp_leader_participant_list_notif_msg' );

    return str_replace(
      array( '%%reloadCheckedMain%%',
        '%%optionsNinjaFormsMain%%',
        '%%optionsPopupsMain%%',
        '%%optionsMainSite%%',
        '%%optionsPagesMain%%',
        '%%wpEditorBeforeLoginFormHtmlMain%%',
        '%%approveUsersAutomaticallyChecked%%', '%%wpEditorPendingUserPageContentHTML%%', '%%wpEditorUserApprovedMessage%%',
        '%%strRegistrationSuccessfulMessage%%', '%%strLoginSuccessfulMessage%%', '%%strUserApprovedSubject%%',
        '%%strNewsletterListsMain%%', '%%strLeaderParticipantListNotificationSbj%%', '%%wpEditorLeaderParticipantListNotificationMsg%%',
        '%%strLoginBarLabelLogin%%', '%%strLoginBarLabelLogout%%', '%%strLoginBarLabelProfile%%',
        '%%optionsCloneSourceSite%%',
        '%%bOnlyFlorpProfileNinjaFormMain%%' ),
      array( $aBooleanOptionsChecked['bReloadAfterSuccessfulSubmissionMain'],
        $optionsNinjaFormsMain,
        $optionsPopupsMain,
        $optionsMainSite,
        $optionsPagesMain,
        $strBeforeLoginFormHtmlMain,
        $aBooleanOptionsChecked['bApproveUsersAutomatically'], $wpEditorPendingUserPageContentHTML, $wpEditorUserApprovedMessage,
        $this->aOptions['strRegistrationSuccessfulMessage'], $this->aOptions['strLoginSuccessfulMessage'], $this->aOptions['strUserApprovedSubject'],
        $this->aOptions['strNewsletterListsMain'], $this->aOptions['strLeaderParticipantListNotificationSbj'], $wpEditorLeaderParticipantListNotificationMsg,
        $this->aOptions['strLoginBarLabelLogin'], $this->aOptions['strLoginBarLabelLogout'], $this->aOptions['strLoginBarLabelProfile'],
        $optionsCloneSourceSite,
        $aBooleanOptionsChecked['bOnlyFlorpProfileNinjaFormMain'] ),
      file_get_contents( __DIR__ . "/view/options-svk-main.html" )
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
        $strTitle = $objForm->get_setting( 'title' ) . " (ID: {$iID})";
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
      // var_dump($aPopupsWPQuery);

      if ( $aPopupsWPQuery->have_posts() ) {
        while ( $aPopupsWPQuery->have_posts() ) :
          $aPopupsWPQuery->next_post();
          $iID = $aPopupsWPQuery->post->ID;
          $strTitle = $aPopupsWPQuery->post->post_title . " (ID: {$iID})";
          if ($this->iProfileFormPopupIDFlashmob == $iID) {
            $strSelectedFlashmob = 'selected="selected"';
          } else {
            $strSelectedFlashmob = '';
          }
          $optionsPopupsFlashmob .= '<option value="'.$iID.'" '.$strSelectedFlashmob.'>'.$strTitle.'</option>';
        endwhile;
      }
    }

    $optionsPagesFlashmob = $optionNoneF;
    $aPages = get_pages();
    foreach ($aPages as $oPage) {
      $iID = $oPage->ID;
      $strTitle = $oPage->post_title . " (ID: {$iID})";
      if (function_exists('pll_get_post_language')) {
        $strLang = pll_get_post_language( $iID, 'name' );
        $strTitle .= " [{$strLang}]";
      }
      if ($this->iProfileFormPageIDFlashmob == $iID) {
        $strSelectedFlashmob = 'selected="selected"';
      } else {
        $strSelectedFlashmob = '';
      }
      $optionsPagesFlashmob .= '<option value="'.$iID.'" '.$strSelectedFlashmob.'>'.$strTitle.'</option>';
    }

    $strBeforeLoginFormHtmlFlashmob = $this->get_wp_editor( $this->strBeforeLoginFormHtmlFlashmob, 'florp_before_login_form_html_flashmob' );
    $strParticipantRegisteredMessage = $this->get_wp_editor( $this->aOptions['strParticipantRegisteredMessage'], 'florp_participant_registered_message' );
    $strParticipantRemovedMessage = $this->get_wp_editor( $this->aOptions['strParticipantRemovedMessage'], 'florp_participant_removed_message' );
    $wpEditorTshirtPaymentWarningNotificationMsg = $this->get_wp_editor( $this->aOptions['strTshirtPaymentWarningNotificationMsg'], 'florp_tshirt_payment_warning_notif_msg' );

    return str_replace(
      array( '%%reloadCheckedFlashmob%%',
        '%%useMapImageChecked%%',
        '%%optionsNinjaFormsFlashmob%%',
        '%%optionsPopupsFlashmob%%',
        '%%optionsFlashmobSite%%',
        '%%optionsPagesFlashmob%%',
        '%%wpEditorBeforeLoginFormHtmlFlashmob%%',
        '%%strNewsletterListsFlashmob%%',
        '%%wpEditorParticipantRegisteredMessage%%',
        '%%strParticipantRegisteredSubject%%',
        '%%strTshirtPaymentWarningNotificationSbj%%', '%%wpEditorTshirtPaymentWarningNotificationMsg%%',
        '%%wpEditorParticipantRemovedMessage%%',
        '%%strParticipantRemovedSubject%%',
        '%%tshirtOrderingDisabledChecked%%', '%%tshirtOrderingDisabledOnlyDisableChecked%%',
        '%%bOnlyFlorpProfileNinjaFormFlashmob%%',
        '%%iTshirtPaymentWarningDeadline%%', '%%iTshirtPaymentWarningDeadlineTime%%',
        '%%iTshirtPaymentWarningButtonDeadline%%', '%%iTshirtPaymentWarningButtonDeadlineTime%%',
        '%%iTshirtOrderDeliveredBeforeFlashmobDdl%%', '%%iTshirtOrderDeliveredBeforeFlashmobDdlTime%%' ),
      array( $aBooleanOptionsChecked['bReloadAfterSuccessfulSubmissionFlashmob'],
        $aBooleanOptionsChecked['bUseMapImage'],
        $optionsNinjaFormsFlashmob,
        $optionsPopupsFlashmob,
        $optionsFlashmobSite,
        $optionsPagesFlashmob,
        $strBeforeLoginFormHtmlFlashmob,
        $this->aOptions['strNewsletterListsFlashmob'],
        $strParticipantRegisteredMessage,
        $this->aOptions['strParticipantRegisteredSubject'],
        $this->aOptions['strTshirtPaymentWarningNotificationSbj'], $wpEditorTshirtPaymentWarningNotificationMsg,
        $strParticipantRemovedMessage,
        $this->aOptions['strParticipantRemovedSubject'],
        $aBooleanOptionsChecked['bTshirtOrderingDisabled'], $aBooleanOptionsChecked['bTshirtOrderingDisabledOnlyDisable'],
        $aBooleanOptionsChecked['bOnlyFlorpProfileNinjaFormFlashmob'],
        $this->aOptions['iTshirtPaymentWarningDeadline'], $this->iTshirtPaymentWarningDeadlineTime,
        $this->aOptions['iTshirtPaymentWarningButtonDeadline'], $this->iTshirtPaymentWarningButtonDeadlineTime,
        $this->aOptions['iTshirtOrderDeliveredBeforeFlashmobDdl'], $this->iTshirtOrderDeliveredBeforeFlashmobDdlTime ),
      file_get_contents( __DIR__ . "/view/options-svk-flashmob.html" )
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
      'optionsCoursesNumberEnabled' => array( 'start' => 0, 'end' => 3, 'leadingZero' => false, 'optionKey' => 'iCoursesNumberEnabled' ),
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

    $strMarkerInfoWindowTemplateOrganizer = $this->get_wp_editor( $this->aOptions['strMarkerInfoWindowTemplateOrganizer'], 'florp_infowindow_template_organizer' );
    $strMarkerInfoWindowTemplateTeacher = $this->get_wp_editor( $this->aOptions['strMarkerInfoWindowTemplateTeacher'], 'florp_infowindow_template_teacher' );

    $aInfoWindowLabelSlugs = array( 'organizer', 'teacher', 'signup', 'participant_count', 'year', 'dancers', 'school', 'note', 'web', 'facebook', /*'embed_code', 'courses_info'*/ );
    $strInfoWindowLabels = "";
    foreach ($aInfoWindowLabelSlugs as $strSlug) {
      $strElementID = 'florp_infowindow_label_'.$strSlug;
      $strOptionKey = 'strInfoWindowLabel_'.$strSlug;
      $strOptionValue = $this->aOptions[$strOptionKey];
      $strNote = "";
      // if ('web' === $strSlug) {
      //   $strNote = '<span style="width: 100%;">Táto položka sa zobrazí len ak nie je povolené zobrazovanie kurzov vo formulári alebo je prázdne meno školy.</span>';
      // }
      $strInfoWindowLabels .= '<th style="width: 47%; padding: 0 1%; text-align: right;">
                <label for="'.$strElementID.'">Nadpis pre položku "'.$strSlug.'"</label>
              </th>
              <td>
                <input id="'.$strElementID.'" name="'.$strElementID.'" type="text" value="'.$strOptionValue.'" style="width: 100%;" />'.$strNote.'
              </td>
            </tr>';
    }

    $strHideFlashmobFieldsForUsers = "";
    $strUnhideFlashmobFieldsForUsers = "";
    $aLeaders = $this->getFlashmobSubscribers( 'all', true );
    foreach ($aLeaders as $oLeader) {
      $iLeaderID = $oLeader->ID;
      $strCheckedHide = "";
      $strCheckedUnhide = "";
      if (in_array($iLeaderID, $this->aOptions['aHideFlashmobFieldsForUsers'])) {
        $strCheckedHide = ' checked="checked"';
      }
      if (in_array($iLeaderID, $this->aOptions['aUnhideFlashmobFieldsForUsers'])) {
        $strCheckedUnhide = ' checked="checked"';
      }
      $strHideFlashmobFieldsForUsers .= '<input id="florp_hide_flashmob_fields_individual-'.$iLeaderID.'" name="florp_hide_flashmob_fields_individual[]" type="checkbox" value="'.$iLeaderID.'"'.$strCheckedHide.'/> <label for="florp_hide_flashmob_fields_individual-'.$iLeaderID.'">'.$iLeaderID.': '.$oLeader->first_name.' '.$oLeader->last_name.'</label> ';
      $strUnhideFlashmobFieldsForUsers .= '<input id="florp_unhide_flashmob_fields_individual-'.$iLeaderID.'" name="florp_unhide_flashmob_fields_individual[]" type="checkbox" value="'.$iLeaderID.'"'.$strCheckedUnhide.'/> <label for="florp_unhide_flashmob_fields_individual-'.$iLeaderID.'">'.$iLeaderID.': '.$oLeader->first_name.' '.$oLeader->last_name.'</label> ';
    }

    return str_replace(
      array( '%%optionsNewsletterSite%%',
        '%%loadMapsAsyncChecked%%',
        '%%loadMapsLazyChecked%%',
        '%%loadVideosLazyChecked%%',
        '%%optionsYears%%', '%%optionsMonths%%', '%%optionsDays%%', '%%optionsHours%%', '%%optionsMinutes%%', '%%optionsCoursesNumberEnabled%%',
        '%%strGoogleMapsKey%%', '%%strGoogleMapsKeyStatic%%', '%%strFbAppID%%', '%%preventDirectMediaDownloadsChecked%%', '%%strNewsletterAPIKey%%',
        '%%strSignupLinkLabel%%', '%%strInfoWindowLabels%%',
        '%%wpEditorMarkerInfoWindowTemplateOrganizer%%', '%%wpEditorMarkerInfoWindowTemplateTeacher%%',
        '%%aHideFlashmobFieldsForUsers%%', '%%aUnhideFlashmobFieldsForUsers%%' ),
      array( $optionsNewsletterSite,
        $aBooleanOptionsChecked['bLoadMapsAsync'],
        $aBooleanOptionsChecked['bLoadMapsLazy'],
        $aBooleanOptionsChecked['bLoadVideosLazy'],
        $aNumOptions['optionsYears'], $optionsMonths, $aNumOptions['optionsDays'], $aNumOptions['optionsHours'], $aNumOptions['optionsMinutes'], $aNumOptions['optionsCoursesNumberEnabled'],
        $this->aOptions['strGoogleMapsKey'], $this->aOptions['strGoogleMapsKeyStatic'], $this->aOptions['strFbAppID'], $aBooleanOptionsChecked['bPreventDirectMediaDownloads'], $this->aOptions['strNewsletterAPIKey'],
        $this->aOptions['strSignupLinkLabel'], $strInfoWindowLabels,
        $strMarkerInfoWindowTemplateOrganizer, $strMarkerInfoWindowTemplateTeacher,
        $strHideFlashmobFieldsForUsers, $strUnhideFlashmobFieldsForUsers ),
      file_get_contents( __DIR__ . "/view/options-svk-common.html" )
    );
  }

  public function options_page_international() {
    echo "<div class=\"wrap\"><h1>" . "Medzinárodný Flashmob" . "</h1>";

    if (isset($_POST['save-florp-options'])) {
      $this->save_option_page_options($_POST, true);
    }

    if (defined('FLORP_DEVEL') && FLORP_DEVEL === true) {
      // echo "<pre>" .var_export( get_users( ['blog_id' => $this->iMainBlogID, 'role' => $this->strUserRoleApproved, 'fields' => 'ID'] ), true). "</pre>";
      // echo "<pre>" .var_export( $this->aOptions['aIntfCityPollUsers'], true). "</pre>";
      echo "<pre>" .var_export( $this->aOptions['aIntfParticipants'], true). "</pre>";
    }

    do_action('florp_options_page_notices');

    $aVariables = $this->get_options_page_vars();

    $aBooleanOptionsChecked = $aVariables['aBooleanOptionsChecked'];
    // $aVariablesToUse = array(
    //   'optionsIntfSite' => $aVariables['optionsIntfSite'],
    //   'optionNone' => $aVariables['optionNone'],
    //   'optionNoneF' => $aVariables['optionNoneF'],
    //   'aBooleanOptionsChecked' => $aVariables['aBooleanOptionsChecked'],
    // );

    if ($this->isIntfBlog) {
      $optionsNinjaFormsIntf = $aVariables['optionNone'];
      $optionsPopupsIntf = $aVariables['optionNone'];

      if (function_exists('Ninja_Forms')) {
        $aForms = Ninja_Forms()->form()->get_forms();
        foreach( $aForms as $objForm ){
          $iID = $objForm->get_id();
          $strTitle = $objForm->get_setting( 'title' ) . " (ID: {$iID})";
          if ($this->iProfileFormNinjaFormIDIntf == $iID) {
            $strSelectedIntf = 'selected="selected"';
          } else {
            $strSelectedIntf = '';
          }
          $optionsNinjaFormsIntf .= '<option value="'.$iID.'" '.$strSelectedIntf.'>'.$strTitle.'</option>';
        }
      }

      if (function_exists('get_all_popups')) {
        $aPopupsWPQuery = get_all_popups();
        // var_dump($aPopupsWPQuery);

        if ( $aPopupsWPQuery->have_posts() ) {
          while ( $aPopupsWPQuery->have_posts() ) :
            $aPopupsWPQuery->next_post();
            $iID = $aPopupsWPQuery->post->ID;
            $strTitle = $aPopupsWPQuery->post->post_title . " (ID: {$iID})";
            if ($this->iProfileFormPopupIDIntf == $iID) {
              $strSelectedIntf = 'selected="selected"';
            } else {
              $strSelectedIntf = '';
            }
            $optionsPopupsIntf .= '<option value="'.$iID.'" '.$strSelectedIntf.'>'.$strTitle.'</option>';
          endwhile;
        }
      }

      $optionsPagesIntf = $aVariables['optionNoneF'];
      $aPages = get_pages();
      foreach ($aPages as $oPage) {
        $iID = $oPage->ID;
        $strTitle = $oPage->post_title . " (ID: {$iID})";
        if (function_exists('pll_get_post_language')) {
          $strLang = pll_get_post_language( $iID, 'name' );
          $strTitle .= " [{$strLang}]";
        }
        if ($this->iProfileFormPageIDIntf == $iID) {
          $strSelectedIntf = 'selected="selected"';
        } else {
          $strSelectedIntf = '';
        }
        $optionsPagesIntf .= '<option value="'.$iID.'" '.$strSelectedIntf.'>'.$strTitle.'</option>';
      }

      $iFlashmobMonth = $this->aOptions["iIntfFlashmobMonth"];
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
        'optionsYears'    => array( 'start' => $iYearNow - 5, 'end' => $iYearNow + 5, 'leadingZero' => false, 'optionKey' => 'iIntfFlashmobYear' ),
        'optionsDays'     => array( 'start' => 1, 'end' => 31, 'leadingZero' => false, 'optionKey' => 'iIntfFlashmobDay' ),
        'optionsHours'    => array( 'start' => 0, 'end' => 23, 'leadingZero' => true, 'optionKey' => 'iIntfFlashmobHour' ),
        'optionsMinutes'  => array( 'start' => 0, 'end' => 59, 'leadingZero' => true, 'optionKey' => 'iIntfFlashmobMinute' ),
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

      // Get all flashmob cities (current and past) //
      $aIntfCityPollUsers = array();
      $aLeaders = $this->getFlashmobSubscribers( 'all', true );
      foreach ($aLeaders as $oLeader) {
        $iLeaderID = $oLeader->ID;
        $strFlashmobCity = get_user_meta( $oLeader->ID, 'flashmob_city', true );
        if (empty($strFlashmobCity)) {
          continue;
        }
        $strChecked = "";
        if (in_array($iLeaderID, $this->aOptions['aIntfCityPollUsers'])) {
          $strChecked = ' checked="checked"';
        }
        $aIntfCityPollUsers[$strFlashmobCity] = '<input id="florp_intf_city_poll_user-'.$iLeaderID.'" name="florp_intf_city_poll_users[]" type="checkbox" value="'.$iLeaderID.'"'.$strChecked.'/> <label for="florp_intf_city_poll_user-'.$iLeaderID.'">'.$strFlashmobCity.' ('.$iLeaderID.': '.$oLeader->first_name.' '.$oLeader->last_name.')</label>';
      }
      foreach ($this->aOptions['aYearlyMapOptions'] as $iYear => $aUsers) {
        foreach ($aUsers as $iUserID => $aSubmissionData) {
          if (!isset($aSubmissionData['flashmob_city'])) {
            continue;
          }
          $strFlashmobCity = $aSubmissionData['flashmob_city'];
          if (empty($strFlashmobCity)) {
            continue;
          }
          if (isset($aIntfCityPollUsers[$strFlashmobCity])) {
            continue;
          }
          $strChecked = "";
          if (in_array($strFlashmobCity, $this->aOptions['aIntfCityPollUsers'])) {
            $strChecked = ' checked="checked"';
          }
          $aIntfCityPollUsers[$strFlashmobCity] = '<input id="florp_intf_city_poll_nonuser-'.$strFlashmobCity.'" name="florp_intf_city_poll_users[]" type="checkbox" value="'.$strFlashmobCity.'"'.$strChecked.'/> <label for="florp_intf_city_poll_nonuser-'.$strFlashmobCity.'">'.$strFlashmobCity.' ('.$aSubmissionData['first_name'].' '.$aSubmissionData['last_name'].' [year '.$iYear.'])</label>';
        }
      }
      ksort($aIntfCityPollUsers);
      $strIntfCityPollUsers = implode("<br>", $aIntfCityPollUsers);

      $strBeforeLoginFormHtmlIntf = $this->get_wp_editor( $this->strBeforeLoginFormHtmlIntf, 'florp_before_login_form_html_intf' );
      $strParticipantRegisteredMessage = $this->get_wp_editor( $this->aOptions['strIntfParticipantRegisteredMessage'], 'florp_intf_participant_registered_message' );
      $wpEditorTshirtPaymentWarningNotificationMsg = $this->get_wp_editor( $this->aOptions['strIntfTshirtPaymentWarningNotificationMsg'], 'florp_intf_tshirt_payment_warning_notif_msg' );

      $strIntfOptions = str_replace(
        array(
          '%%optionsIntfSite%%',
          '%%optionsNinjaFormsIntf%%',
          '%%optionsPopupsIntf%%',
          '%%optionsPagesIntf%%',
          "%%iIntfTshirtOrderDeliveredBeforeFlashmobDdl%%",
          "%%iIntfTshirtOrderDeliveredBeforeFlashmobDdlTime%%",
          "%%iIntfTshirtPaymentWarningButtonDeadline%%",
          "%%iIntfTshirtPaymentWarningButtonDeadlineTime%%",
          "%%iIntfTshirtPaymentWarningDeadline%%",
          "%%iIntfTshirtPaymentWarningDeadlineTime%%",
          "%%strIntfParticipantRegisteredSubject%%",
          "%%strIntfTshirtPaymentWarningNotificationSbj%%",
          "%%strNewsletterListsIntf%%",
          "%%tshirtIntfOrderingDisabledChecked%%",
          "%%tshirtIntfOrderingDisabledOnlyDisableChecked%%",
          "%%wpEditorBeforeLoginFormHtmlIntf%%",
          "%%wpEditorIntfParticipantRegisteredMessage%%",
          "%%wpEditorIntfTshirtPaymentWarningNotificationMsg%%",
          '%%optionsYears%%', '%%optionsMonths%%', '%%optionsDays%%', '%%optionsHours%%', '%%optionsMinutes%%',
          "%%iIntfCityPollDeadline%%",
          "%%iIntfCityPollDdlTime%%",
          '%%aIntfCityPollUsers%%',
          '%%strIntfCityPollExtraCities%%',
        ),
        array(
          $aVariables['optionsIntfSite'],
          $optionsNinjaFormsIntf,
          $optionsPopupsIntf,
          $optionsPagesIntf,
          $this->aOptions["iIntfTshirtOrderDeliveredBeforeFlashmobDdl"],
          $this->iIntfTshirtOrderDeliveredBeforeFlashmobDdlTime,
          $this->aOptions["iIntfTshirtPaymentWarningButtonDeadline"],
          $this->iIntfTshirtPaymentWarningButtonDeadlineTime,
          $this->aOptions["iIntfTshirtPaymentWarningDeadline"],
          $this->iIntfTshirtPaymentWarningDeadlineTime,
          $this->aOptions["strIntfParticipantRegisteredSubject"],
          $this->aOptions["strIntfTshirtPaymentWarningNotificationSbj"],
          $this->aOptions["strNewsletterListsIntf"],
          $aBooleanOptionsChecked['bIntfTshirtOrderingDisabled'],
          $aBooleanOptionsChecked['bIntfTshirtOrderingDisabledOnlyDisable'],
          $strBeforeLoginFormHtmlIntf,
          $strParticipantRegisteredMessage,
          $wpEditorTshirtPaymentWarningNotificationMsg,
          $aNumOptions['optionsYears'], $optionsMonths, $aNumOptions['optionsDays'], $aNumOptions['optionsHours'], $aNumOptions['optionsMinutes'],
          $this->aOptions['iIntfCityPollDeadline'],
          $this->iIntfCityPollDdlTime,
          $strIntfCityPollUsers,
          $this->aOptions['strIntfCityPollExtraCities'],
        ),
        file_get_contents( __DIR__ . "/view/options-international-settings.html" )
      );
    } else {
      $strIntfOptions = '';
    }

    echo str_replace(
      array( '%%optionsIntfSite%%' ),
      array( $strIntfOptions ),
      file_get_contents( __DIR__ . "/view/options-international.html" )
    );
  }

  private function save_option_page_options( $aPostedOptions, $bInternational = false ) {
    if ($bInternational) {
      $aKeysToSave = $this->aOptionKeysByBlog['international'];
    } elseif ($this->isMainBlog) {
      $aKeysToSave = $this->aOptionKeysByBlog['main'];

      // Archive current flashmob year's data //
      if (!$this->bHideFlashmobFields) {
        // Trying to archive after the saved flashmob date //
        $iFlashmobYearCurrent = intval($this->aOptions['iFlashmobYear']);
        $iFlashmobYearNew = isset($aPostedOptions['florp_flashmob_year']) ? intval($aPostedOptions['florp_flashmob_year']) : $iFlashmobYearCurrent;
        if (isset($this->aOptions['aYearlyMapOptions'][$iFlashmobYearNew])) {
          // There is archived data for this flashmob year in the DB already //
          add_action( 'florp_options_page_notices', function() {
            echo '<div class="notice notice-warning"><p>Rok flashmobu možno nastaviť len na taký, pre ktorý ešte nie sú archívne dáta v DB!</p></div>'.PHP_EOL;
          });
          return false;
        } elseif ($iFlashmobYearNew != $iFlashmobYearCurrent) {
          // Flashmob year was changed //
          if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION') && FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION === true) {
            // NOT ARCHIVING //
            $GLOBALS["florpArchivedMapOptions"] = var_export($this->get_flashmob_map_options_array_to_archive(), true);
            add_action( 'florp_options_page_notices', function() {
              echo '<div class="notice notice-info"><p><code>(FLORP_DEVEL && FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION == true)</code> => nearchivujem flashmobové mapy.</p><p>Archivované dáta by však vyzerali nasledovne:</p><pre>' .$GLOBALS["florpArchivedMapOptions"]. '</pre></div>'.PHP_EOL;
            });
          } else {
            $this->archive_current_year_map_options();
            $GLOBALS['iFlorpFlashmobYearCurrent'] = $iFlashmobYearCurrent;
            add_action( 'florp_options_page_notices', function() {
              echo '<div class="notice notice-success"><p>Dáta flashmobu z roku '.$GLOBALS['iFlorpFlashmobYearCurrent'].' boli archivované.</p></div>'.PHP_EOL;
            });
          }
        }
      }

      // Migrate users from previously set main blog to newly selected main blog on change of Main blog //
      $iNewMainBlogID = intval($aPostedOptions['florp_main_blog_id']);
      if ($iNewMainBlogID !== $this->iMainBlogID) {
        $this->migrate_subscribers( $this->iMainBlogID, $iNewMainBlogID );
      }
    } elseif ($this->isFlashmobBlog) {
      $aKeysToSave = $this->aOptionKeysByBlog['flashmob'];
    } else {
      return;
    }

    $aOptionsOld = $this->aOptions;
    $aChangedOptions = array();

    foreach ($this->aBooleanOptions as $strOptionKey) {
      if (in_array( $strOptionKey, $aKeysToSave )) {
        $this->aOptions[$strOptionKey] = false;
        $strPostKey = array_search($strOptionKey, $this->aOptionFormKeys);
        if ($strPostKey !== false && !isset($aPostedOptions[$strPostKey]) && $aOptionsOld[$strOptionKey] !== $this->aOptions[$strOptionKey]) {
          $aChangedOptions[$strOptionKey] = array(
            'from'  => $aOptionsOld[$strOptionKey],
            'to'    => $this->aOptions[$strOptionKey]
          );
        }
      }
    }
    foreach ($this->aArrayOptions as $strOptionKey) {
      if (in_array( $strOptionKey, $aKeysToSave )) {
        $strPostKey = array_search($strOptionKey, $this->aOptionFormKeys);
        if ($strPostKey !== false && !isset($aPostedOptions[$strPostKey])) {
          $this->aOptions[$strOptionKey] = array();
          if ($aOptionsOld[$strOptionKey] !== $this->aOptions[$strOptionKey]) {
            $aChangedOptions[$strOptionKey] = array(
              'from'  => $aOptionsOld[$strOptionKey],
              'to'    => $this->aOptions[$strOptionKey]
            );
          }
        }
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
      } elseif (in_array( $strOptionKey, $this->aArrayOptions )) {
        $this->aOptions[$strOptionKey] = $val;
      } elseif (strpos($strOptionKey, 'i') === 0) {
        $this->aOptions[$strOptionKey] = intval($val);
      } else {
        $this->aOptions[$strOptionKey] = stripslashes($val);
      }
      if ($aOptionsOld[$strOptionKey] !== $this->aOptions[$strOptionKey]) {
        $aChangedOptions[$strOptionKey] = array(
          'from'  => $aOptionsOld[$strOptionKey],
          'to'    => $this->aOptions[$strOptionKey]
        );
      }
    }
    foreach ($this->aOptions['aUnhideFlashmobFieldsForUsers'] as $iKey => $iUserID) {
      $iFoundKey = array_search($iUserID, $this->aOptions['aHideFlashmobFieldsForUsers']);
      if (false !== $iFoundKey) {
        unset($this->aOptions['aHideFlashmobFieldsForUsers'][$iFoundKey]);
      }
    }

    if (!empty($aChangedOptions)) {
      $iCurrentUserID = get_current_user_id();
      $aChangedOptions['_user_id'] = $iCurrentUserID;
      $this->aOptions['aOptionChanges'][time()] = $aChangedOptions;
    }

    if (defined('FLORP_DEVEL_PURGE_PARTICIPANTS_ON_SAVE') && FLORP_DEVEL_PURGE_PARTICIPANTS_ON_SAVE === true ) {
      $this->aOptions['aParticipants'] = $this->aOptionDefaults["aParticipants"];
    }
    if (defined('FLORP_DEVEL_PURGE_TSHIRTS_ON_SAVE') && FLORP_DEVEL_PURGE_TSHIRTS_ON_SAVE === true ) {
      $this->aOptions['aTshirts'] = $this->aOptionDefaults["aTshirts"];
    }

    $this->save_options();

    $this->set_variables();

    if ($bInternational) {
      if ($this->iProfileFormNinjaFormIDIntf != 0) {
        $this->export_ninja_form($this->iProfileFormNinjaFormIDIntf, $this->strNinjaFormExportPathIntf);
      }
    } else {
      $this->export_ninja_form();
    }

    $this->prevent_direct_media_downloads();

    return true;
  }

  private function get_int_version() {
    $aVersionParts = explode('.', $this->strVersion);
    $aVersionParts = array_reverse($aVersionParts);
    $iVersion = 0;
    foreach ($aVersionParts as $iKey => $strNum) {
      $iVersion += intval($strNum) * pow( 1000, $iKey );
    }
    return $iVersion;
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
      } elseif ($iFormID !== $this->iProfileFormNinjaFormIDMain && false === $strExportPath) {
        // if no export path is given, only the saved form ID can be exported automatically //
        return;
      }
      if (false === $strExportPath) {
        $strExportPath = $this->strNinjaFormExportPathMain;
      }
    } elseif ($this->isFlashmobBlog) {
      if (false === $iFormID) {
        $iFormID = $this->iProfileFormNinjaFormIDFlashmob;
      } elseif ($iFormID !== $this->iProfileFormNinjaFormIDFlashmob && false === $strExportPath) {
        // if no export path is given, only the saved form ID can be exported automatically //
        return;
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
      add_action( 'florp_options_page_notices', function() {
        echo '<div class="notice notice-warning"><p>Couldn\'t find any form to export</p></div>'.PHP_EOL;
      });
      return;
    }
    if (file_exists($strExportPath)) {
      include_once $strExportPath;
      $aExportOld = ${$this->strExportVarName};
      if (isset($aExportOld) && is_array($aExportOld) && !empty($aExportOld)) {
        if (isset($aExportOld['version'])) {
          unset($aExportOld['version']);
        }
        if (isset($aExportOld['timestamp'])) {
          unset($aExportOld['timestamp']);
        }
      }
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

    $GLOBALS['aFlorpFormExportInfo'] = array(
      'title' => $aExport['form_settings']['title'],
      'id' => $iFormID,
    );

    // Compare the export to the old one (if it exists) //
    if (isset($aExportOld) && is_array($aExportOld) && !empty($aExportOld)) {
      $aDiff = array_diff($aExport, $aExportOld);
      if ($aExport === $aExportOld && (!is_array($aDiff) || empty($aDiff))) {
        add_action( 'florp_options_page_notices', function() {
          echo '<div class="notice notice-info"><p>Form "'.$GLOBALS['aFlorpFormExportInfo']['title'].'" (ID: '.$GLOBALS['aFlorpFormExportInfo']['id'].') didn\'t change => not exporting</p></div>'.PHP_EOL;
        });
        return;
      }
    }
    $aExport['version'] = $this->get_int_version();
    $aExport['timestamp'] = time();
    $strExportContent = '<?php if ( ! defined( \'ABSPATH\' ) ) exit;'.PHP_EOL.'$'.$this->strExportVarName.' = '.var_export($aExport, true).'; ?>';
    $mixRes = file_put_contents( $strExportPath, $strExportContent );
    if ($mixRes !== false) {
      add_action( 'florp_options_page_notices', function() {
        echo '<div class="notice notice-success"><p>Form "'.$GLOBALS['aFlorpFormExportInfo']['title'].'" (ID: '.$GLOBALS['aFlorpFormExportInfo']['id'].') was exported successfully</p></div>'.PHP_EOL;
      });
    } else {
      add_action( 'florp_options_page_notices', function() {
        echo '<div class="notice notice-error"><p>Form "'.$GLOBALS['aFlorpFormExportInfo']['title'].'" (ID: '.$GLOBALS['aFlorpFormExportInfo']['id'].') could not be exported!</p></div>'.PHP_EOL;
      });
    }
  }

  public function action__export_profile_form( $iFormID ) {
    if ($this->iProfileFormNinjaFormIDIntf == $iFormID) {
      $this->export_ninja_form($this->iProfileFormNinjaFormIDIntf, $this->strNinjaFormExportPathIntf);
    } else {
      $this->export_ninja_form( $iFormID, false );
    }
  }

  public function action__import_profile_form() {
    if (defined('FLORP_DEVEL') && FLORP_DEVEL === true) { return; }
    if ($this->isMainBlog) {
      $var_iProfileFormNinjaFormID = "iProfileFormNinjaFormIDMain";
      if ($this->$var_iProfileFormNinjaFormID != 0) {
        $var_iProfileFormNinjaFormImportVersion = "iProfileFormNinjaFormImportVersionMain";
        $strExportPath = $this->strNinjaFormExportPathMain;
        $this->import_ninja_form($strExportPath, $var_iProfileFormNinjaFormID, $var_iProfileFormNinjaFormImportVersion);
      }
    }
    if ($this->isFlashmobBlog) {
      $var_iProfileFormNinjaFormID = "iProfileFormNinjaFormIDFlashmob";
      if ($this->$var_iProfileFormNinjaFormID != 0) {
        $var_iProfileFormNinjaFormImportVersion = "iProfileFormNinjaFormImportVersionFlashmob";
        $strExportPath = $this->strNinjaFormExportPathFlashmob;
        $this->import_ninja_form($strExportPath, $var_iProfileFormNinjaFormID, $var_iProfileFormNinjaFormImportVersion);
      }
    }
    if ($this->isIntfBlog) {
      $var_iProfileFormNinjaFormID = "iProfileFormNinjaFormIDIntf";
      if ($this->$var_iProfileFormNinjaFormID != 0) {
        $var_iProfileFormNinjaFormImportVersion = "iProfileFormNinjaFormImportVersionIntf";
        $strExportPath = $this->strNinjaFormExportPathIntf;
        $this->import_ninja_form($strExportPath, $var_iProfileFormNinjaFormID, $var_iProfileFormNinjaFormImportVersion);
      }
    }
  }

  private function import_ninja_form($strExportPath, $var_iProfileFormNinjaFormID, $var_iProfileFormNinjaFormImportVersion) {
    $iCurrentVersion = $this->aOptions[$var_iProfileFormNinjaFormImportVersion];
    if (file_exists($strExportPath)) {
      include_once $strExportPath;
      $aImportedFormData = ${$this->strExportVarName};
      if (!is_array($aImportedFormData) || empty($aImportedFormData)) {
        return;
      }

      // Compare the version of the form to be imported and the current one //
      $iNewVersion = 0;
      if (isset($aImportedFormData['version'])) {
        $iNewVersion = $aImportedFormData['version'];
      }
      if ($iCurrentVersion === $iNewVersion) {
        return;
      }

      // Rename the old form if it matches the imported one's title //
      foreach (Ninja_Forms()->form()->get_forms() as $oFormModel) {
        // $iID = $oFormModel->get_id();
        $aFormSettings = $oFormModel->get_settings();
        if ($aFormSettings['title'] == $aImportedFormData['form_settings']['title']) {
          $oFormModel->update_setting( 'title', $aFormSettings['title'] . " OLD: " . date('Y-m-d H:i:s') )->save();
        }
      }

      // Create new form //
      $oFormModel = Ninja_Forms()->form()->get();
      $oFormModel->update_settings( $aImportedFormData['form_settings'] )->save();
      $iNewFormID = $oFormModel->get_id();
      // Add fields (with settings) //
      foreach ($aImportedFormData['field_settings'] as $aFieldSettings) {
        $oNewField = Ninja_Forms()->form( $iNewFormID )->field()->get();
        $oNewField->update_settings( $aFieldSettings )->save();
      }
      // Add actions (with settings) //
      foreach ($aImportedFormData['action_settings'] as $ActionSettings) {
        $oNewAction = Ninja_Forms()->form( $iNewFormID )->action()->get();
        $oNewAction->update_settings( $ActionSettings )->save();
      }
      $oFormModel->save();
      // Rename the export so it's not imported again (although version copes with that as well) //
      rename( $strExportPath, $strExportPath.'.'.$iCurrentVersion.'.imported-'.date('Ymd-His'));

      // Change the form id and version in aOptions to the new form's id //
      $this->$var_iProfileFormNinjaFormID = $iNewFormID;
      $this->aOptions[$var_iProfileFormNinjaFormID] = $this->$var_iProfileFormNinjaFormID;
      $this->aOptions[$var_iProfileFormNinjaFormImportVersion] = $iNewVersion;
      $this->save_options();
    }
  }

  public function action__remove_admin_bar() {
    if (!current_user_can('administrator') && !current_user_can($this->strUserRoleRegistrationAdminSvk) && !current_user_can($this->strUserRoleRegistrationAdminIntf) && !is_admin()) {
      show_admin_bar( false );
    }
  }

  public function action__reset_password_redirect() {
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

  public function action__get_markerInfoHTML_callback() {
    check_ajax_referer( 'srd-florp-security-string', 'security' );
    $aMarkerData = array_merge(
      $_POST['infoWindowData'],
      array(
        'mixMarkerKey'      => $_POST['mixMarkerKey'],
        'strMapType'        => $_POST['strMapType'],
        'iUserID'           => $_POST['iUserID'],
        'strDivID'          => $_POST['divID'],
        'iCurrentYear'      => $_POST['iCurrentYear'],
        'iYear'             => $_POST['iYear'],
        'iBeforeFlashmob'   => $_POST['iBeforeFlashmob'],
        'iIsPreview'        => $_POST['iIsPreview'],
        'iParticipantCount' => $this->get_flashmob_participant_count( $_POST['iUserID'] ),
    ));
    $strMarkerText = $this->getMarkerInfoWindowContent( $aMarkerData );
    $aRes = array(
      'contentHtml' => $strMarkerText,
      'data'        => $_POST
    );
    echo json_encode($aRes);
    wp_die();
  }

  public function action__get_leaderParticipantsTable_callback() {
    check_ajax_referer( 'srd-florp-security-string', 'security' );
    $aData = $_POST;
    $aData['tableHtml'] = $this->leader_participants_table_shortcode( array() );
    echo json_encode($aData);
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
      $strMapType = $_POST['strMapType'];
      $strVal = get_user_meta( $oUser->ID, $strMapType, true );
      if (!$strVal) {
        foreach ($this->aLocationFields[$strMapType] as $strFieldKey) {
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

  private function getInfoWindowLabel($strSlug) {
    $strOptionKey = 'strInfoWindowLabel_'.$strSlug;
    if (isset($this->aOptions[$strOptionKey]) && !empty($this->aOptions[$strOptionKey])) {
      return $this->aOptions[$strOptionKey] . ": ";
    }
    return "";
  }

  private function removeAccents($strString) {
    return strtr( $strString, array(
      'ľ' => 'l',
      'Ľ' => 'L',
      'ĺ' => 'l',
      'Ĺ' => 'L',
      'š' => 's',
      'Š' => 'S',
      'č' => 'c',
      'Č' => 'C',
      'ť' => 't',
      'Ť' => 'T',
      'ž' => 'z',
      'Ž' => 'Z',
      'ý' => 'y',
      'Ý' => 'Y',
      'á' => 'a',
      'Á' => 'A',
      'ä' => 'a',
      'Ä' => 'A',
      'í' => 'i',
      'Í' => 'I',
      'é' => 'e',
      'É' => 'E',
      'ú' => 'u',
      'Ú' => 'U',
      'ň' => 'n',
      'Ň' => 'N',
      'ô' => 'o',
      'Ô' => 'O',
      'ó' => 'o',
      'Ó' => 'O',
      'ř' => 'r',
      'Ř' => 'R',
      'ŕ' => 'r',
      'Ŕ' => 'R',
    ));
  }

  private function getCitySubdomainVariations( $strCity ) {
    $strCity = $this->removeAccents( strtolower($strCity) );

    // Check also other variations: with dash,underscore,"" instead of spaces; initials //
    $aVariations = array();
    $aWords = preg_split( "/\s+/", $strCity );
    if (is_array($aWords) && count($aWords) > 1) {
      foreach (array("", "-", "_") as $delimiter) {
        $aVariations[] = str_replace( " ", $delimiter, $strCity );
      }
      $strInitials = "";
      foreach ($aWords as $strWord) {
        $strInitials .= $strWord[0];
      }
      if (strlen($strInitials) > 1) {
        $aVariations[] = $strInitials;
      }
    } else {
      $aVariations[] = $strCity;
    }

    return $aVariations;
  }

  private function findCityWebpage( $strCity, $bWithProtocol = true ) {
    if ($strCity === "null") {
      return false;
    }
    $strProtocol = $bWithProtocol ? "http://" : "";
    $aSites = wp_get_sites();
    $strCity = $this->removeAccents( strtolower($strCity) );
    $aVariations = $this->getCitySubdomainVariations( $strCity );

    foreach ($aSites as $i => $aSite) {
      if ($aSite['public'] != 1 || $aSite['deleted'] == 1 || $aSite['archived'] == 1) {
        continue;
      }
      $strDomain = $aSite['domain'];
      $iID = $aSite['blog_id'];
      $aParts = explode( ".", $strDomain );
      if (!is_array($aParts) || count($aParts) !== 3) {
        continue;
      }
      $strSubDomain = $aParts[0];
      if (strpos($strCity, $strSubDomain) !== false) {
        return $strProtocol.$strDomain;
      }
      foreach ($aVariations as $strVariation) {
        if ($strVariation === $strSubDomain) {
          return $strProtocol.$strDomain;
        }
      }
    }
    return false;
  }

  private function get_leader_webpage($aData) {
    if (!isset($aData["bHideLeaderInfo"])) {
      $aData["bHideLeaderInfo"] = false;
    }
    if (!isset($aData["bInfoWindow"])) {
      $aData["bInfoWindow"] = false;
    }

    if (isset($aData["id"])) {
      $aAllMeta = array_map(
        array($this, 'get_value_maybe_fix_unserialize_array'),
        get_user_meta( $aData["id"] )
      );
      $aData = array_merge($aData, $aAllMeta);
    } elseif (isset($aData["webpage"])) {
      // OK //
    } else {
      // We need id or webpage //
      return "";
    }
    $aData["bReturnAnchor"] = (isset($aData["bReturnAnchor"]) && $aData["bReturnAnchor"] === true);
    $strWebpage = '';
    if (!empty($aData['webpage'])) {
      switch($aData['webpage']) {
        case "flashmob":
          $strWebpage = "http://flashmob.salsarueda.dance";
          break;
        case "vlastna":
          if (!empty($aData['custom_webpage']) && !$aData["bHideLeaderInfo"]) {
            $strWebpage = $aData['custom_webpage'];
          }
          break;
        case "vytvorit":
          $strSubDomainPage = $this->findCityWebpage( $aData['flashmob_city'] );
          if ($strSubDomainPage) {
            $strSchoolWebpage = $strSubDomainPage;
          } elseif (!$aData["bInfoWindow"]) {
            return "(vytvorit)";
          }
        default:
          break;
      }
    }
    $strWeb = ''; // In new maps - webpage and school name is not connected //
    if (!empty($strWebpage)) {
      if ($aData["bReturnAnchor"]) {
        $strWebLabel = preg_replace( '~^https?://(www\.)?|/$~', "", $strWebpage );
        $strWeb = '<a href="'.$strWebpage.'" target="_blank">'.$strWebLabel.'</a>';
        if ($aData["bInfoWindow"]) {
          $strWeb = $this->getInfoWindowLabel('web') . $strWeb;
        }
      } else {
        $strWeb = $strWebpage;
      }
    }
    if ($this->aOptions["iCoursesNumberEnabled"] == 0 || empty($aData['school_name'])) {
      if (!empty($strSchoolWebpage)) {
        if ($aData["bReturnAnchor"]) {
          $strSchoolWebpageLabel = preg_replace( '~^https?://(www\.)?|/$~', "", $strSchoolWebpage );
          $strWeb = '<a href="'.$strSchoolWebpage.'" target="_blank">'.$strSchoolWebpageLabel.'</a>';
          if ($aData["bInfoWindow"]) {
            $strWeb = $this->getInfoWindowLabel('web') . $strWeb;
          }
        } else {
          $strWeb = $strSchoolWebpage;
        }
      }
    }
    return $strWeb;
  }

  private function getMarkerInfoWindowContent( $aInfoWindowData ) {
    $bHideLeaderInfo = isset($aInfoWindowData['hide_leader_info']) && isset($aInfoWindowData['hide_leader_info']['value']) && $aInfoWindowData['hide_leader_info']['value'] == '1';
    $bIsBeforeFlashmob = ($aInfoWindowData['strMapType'] === 'flashmob_organizer' && ($aInfoWindowData['iCurrentYear'] == '1' || (isset($aInfoWindowData['iIsPreview']) && $aInfoWindowData['iIsPreview'] == '1')) && $aInfoWindowData['iBeforeFlashmob'] == '1');
    if (empty($aInfoWindowData['user_webpage']['value'])) {
      $strOrganizer = $this->getInfoWindowLabel('organizer').$aInfoWindowData['first_name']['value'] . " " . $aInfoWindowData['last_name']['value'];
    } else {
      $strOrganizer = $this->getInfoWindowLabel('organizer').'<a href="'.$aInfoWindowData['user_webpage']['value'].'" target="_blank">'.$aInfoWindowData['first_name']['value'] . " " . $aInfoWindowData['last_name']['value'].'</a>';
    }
    // $strOrganizer .= var_export($aInfoWindowData, true);

    $strTeacher = $this->getInfoWindowLabel('teacher').$aInfoWindowData['first_name']['value'] . " " . $aInfoWindowData['last_name']['value'];

    $strFacebook = '';
    if (!$bHideLeaderInfo && !empty($aInfoWindowData['facebook']['value'])) {
      $strFacebookLabel = preg_replace( '~^https?://(www\.)?|/$~', "", $aInfoWindowData['facebook']['value'] );
      $strFacebook = $this->getInfoWindowLabel('facebook') . '<a href="'.$aInfoWindowData['facebook']['value'].'" target="_blank">'.$strFacebookLabel.'</a>';
    }

    // BEGIN School webpage is only in case of archived map options //
    $strSchoolWebpage = '';
    if (!empty($aInfoWindowData['school_webpage']['value'])) {
      switch($aInfoWindowData['school_webpage']['value']) {
        case "flashmob":
          $strSchoolWebpage = "http://flashmob.salsarueda.dance";
          break;
        case "vlastna":
          if (!empty($aInfoWindowData['custom_school_webpage']['value']) && !$bHideLeaderInfo) {
            $strSchoolWebpage = $aInfoWindowData['custom_school_webpage']['value'];
          }
          break;
        case "vytvorit":
          $strSubDomainPage = $this->findCityWebpage( $aInfoWindowData['flashmob_city']['value'] );
          if ($strSubDomainPage) {
            $strSchoolWebpage = $strSubDomainPage;
          }
        default:
          break;
      }
    }
    // END End of school webpage [it's used in the next part though] //

    $aWebpageArgs = array(
      'webpage' => $aInfoWindowData['webpage']['value'],
      'custom_webpage' => $aInfoWindowData['custom_webpage']['value'],
      'user_city' => $aInfoWindowData['user_city']['value'],
      'flashmob_city' => $aInfoWindowData['flashmob_city']['value'],
      'school_name' => $aInfoWindowData['school_name']['value'],
      'bHideLeaderInfo' => $bHideLeaderInfo,
      'bReturnAnchor' => true,
      'bInfoWindow' => true,
    );
    $strWeb = $this->get_leader_webpage($aWebpageArgs);

    if (!empty($aInfoWindowData['webpage']['value']) && $aInfoWindowData['webpage']['value'] == "vytvorit") {
      $strSubDomainPage = $this->findCityWebpage( $aInfoWindowData['flashmob_city']['value'] );
      if ($strSubDomainPage) {
        $strSchoolWebpage = $strSubDomainPage;
      }
    }

    $strSchool = '';
    $bIsYearUpTo2017 = (isset($aInfoWindowData['iYear']) && !empty($aInfoWindowData['iYear']) && $aInfoWindowData['iYear'] <= 2017);
    if (($bIsYearUpTo2017 || $this->aOptions["iCoursesNumberEnabled"] > 0) && !empty($aInfoWindowData['school_name']['value'])) {
      $strSchool = $aInfoWindowData['school_name']['value'];
      if (!empty($strSchoolWebpage)) {
        $strSchool = '<a href="'.$strSchoolWebpage.'" target="_blank">'.$strSchool.'</a>';
      }
      $strSchool = $this->getInfoWindowLabel('school') . $strSchool;
      if (!empty($aInfoWindowData['courses_city']['value'])) {
        $strSchool .= " (".$aInfoWindowData['courses_city']['value'].")";
      }
    }

    $aVideoRegexes = array(
      "youtube"   => '~^https?://(www\.|m\.)?(youtube\.com/watch\?v=|youtu.be/)(.+)$~i',
      "facebook"  => '~^https?://(www.)?facebook.com/[a-zA-Z0-9]+/videos/[a-zA-Z0-9]+/?$~i',
      "vimeo"     => '~^https?://(www.)?vimeo.com/([0-9]+)/?$~i',
    );
    $aVideoRegexMatchesAll = array("other" => array());
    $strVideoLink = (isset($aInfoWindowData['video_link']) && isset($aInfoWindowData['video_link']['value'])) ? trim($aInfoWindowData['video_link']['value']) : "";
    $strVideoLinkType = "other";
    if (!empty($strVideoLink)) {
      foreach($aVideoRegexes as $strType => $strRegex) {
        $aVideoRegexMatchesAll[$strType] = array();
        if (preg_match( $strRegex, $strVideoLink, $aVideoRegexMatchesAll[$strType])) {
          $strVideoLinkType = $strType;
          break;
        }
      }
    }

    $aVideoRegexMatches = $aVideoRegexMatchesAll[$strVideoLinkType];
    if ($strVideoLinkType == "other") {
      $strEmbedCode = "";
    } elseif ($strVideoLinkType === "youtube") {
      if (!isset($aVideoRegexMatches[3]) || empty($aVideoRegexMatches[3])) {
        $strEmbedCode = "";
      } else {
        $strYoutubeVideoParams = $aVideoRegexMatches[3];
        // Try to explode by &amp; and if it's not present, explode by & //
        if ($aVideoRegexMatches[2] === 'youtu.be/') {
          $aYoutubeVideoParams = explode('?', $strYoutubeVideoParams);
          if (count($aYoutubeVideoParams) === 2) {
            $aYoutubeVideoParams2 = explode('&amp;', $aYoutubeVideoParams[1]);
            if (count($aYoutubeVideoParams2) === 1) {
              $aYoutubeVideoParams2 = explode('&', $aYoutubeVideoParams[1]);
            }
            if (count($aYoutubeVideoParams2) > 1) {
              unset($aYoutubeVideoParams[1]);
              $aYoutubeVideoParams = array_merge($aYoutubeVideoParams, $aYoutubeVideoParams2);
            }
          } elseif (count($aYoutubeVideoParams) > 2) {
            // NOT OK //
          }
        } else {
          $aYoutubeVideoParams = explode('&amp;', $strYoutubeVideoParams);
          if (count($aYoutubeVideoParams) === 1) {
            $aYoutubeVideoParams = explode('&', $strYoutubeVideoParams);
          }
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
          $strEmbedCode = "" . "$strVideoLink, $strYoutubeVideoParams";
        } else {
          $strEmbedCode = $this->getInfoWindowLabel('embed_code').'<iframe width="280" height="160" src="https://www.youtube.com/embed/'.$strEmbedSrc.'" frameborder="0" allowfullscreen=""></iframe>';
        }
      }
    } elseif ($strVideoLinkType === "facebook") {
      $strFacebookLink = htmlentities(urlencode($strVideoLink));
      $strEmbedCode = $this->getInfoWindowLabel('embed_code').'<iframe src="https://www.facebook.com/plugins/video.php?href='.$strFacebookLink.'&show_text=0&width=560" width="280" height="160" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>';//.'<pre>'.$strFacebookLink.'</pre>';
    } elseif ($strVideoLinkType === "vimeo") {
      if (!isset($aVideoRegexMatches[2]) || empty($aVideoRegexMatches[2])) {
        $strEmbedCode = "";
      } else {
        $strVimeoVideoID = $aVideoRegexMatches[2];
        $strEmbedCode = $this->getInfoWindowLabel('embed_code').'<iframe src="https://player.vimeo.com/video/'.$strVimeoVideoID.'" width="340" height="200" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';//.'<pre>'.$strVimeokLink.'</pre>';
      }
    } else {
      // Should not happen //
      $strEmbedCode = "";
    }
    if (empty($aInfoWindowData['flashmob_number_of_dancers']['value']) || !preg_match( '~^\d+$~', $aInfoWindowData['flashmob_number_of_dancers']['value'])) {
      $strDancers = "";
    } else {
      $strDancers = $this->getInfoWindowLabel('dancers').$aInfoWindowData['flashmob_number_of_dancers']['value'];
    }
    $mixMarkerKey = $aInfoWindowData['mixMarkerKey'];
    if ($bIsBeforeFlashmob) {
      $strLocation = trim($aInfoWindowData['flashmob_city']['value']);
      if ($strLocation === "null") {
        $strLocation = "";
      }
    } elseif (isset($mixMarkerKey) && !is_numeric($mixMarkerKey)) {
      $strLocation = trim($aInfoWindowData[$mixMarkerKey]['value']);
      if ($strLocation === "null") {
        $strLocation = "";
      }
    } else {
      $strLocation = trim($aInfoWindowData['flashmob_address']['value']);
      if (empty($strLocation)) {
        $strLocation = trim($aInfoWindowData['flashmob_city']['value']);
        if ($strLocation === "null") {
          $strLocation = "";
        }
      }
    }
    if (isset($aInfoWindowData['year']) && isset($aInfoWindowData['year']["value"])) {
      $strYear = $this->getInfoWindowLabel('year').$aInfoWindowData['year']["value"];
    } else {
      $strYear = "";
    }
    if (isset($aInfoWindowData['note']) && isset($aInfoWindowData['note']["value"])) {
      $strNote = $this->getInfoWindowLabel('note').stripslashes($aInfoWindowData['note']["value"]);
    } else {
      $strNote = "";
    }

    if ($bIsBeforeFlashmob) {
      // Before Flashmob //
      $strSignupLink = $this->getInfoWindowLabel('signup').'<span class="florp-click-trigger ' . $this->strClickTriggerClassFlashmob . ' pum-trigger" data-user-id="'.$aInfoWindowData['iUserID'].'" data-flashmob-city="'.$aInfoWindowData['flashmob_city']['value'].'" data-marker-key="'.$aInfoWindowData['mixMarkerKey'].'" data-div-id="'.$aInfoWindowData['strDivID'].'" style="cursor: pointer;">'.$this->aOptions['strSignupLinkLabel'].'</span><br/>';
      $strParticipantCount = $this->getInfoWindowLabel('participant_count').$aInfoWindowData['iParticipantCount'];

      $strDancers = "";
      $strEmbedCode = "";
    } else {
      // After Flashmob //
      $strSignupLink = "";
      $strParticipantCount = "";
    }

    // Separate optional placeholders by a line break //
    $aPlaceholdersToSeparate = array( 'organizer' => 'strOrganizer', 'teacher' => 'strTeacher', 'school' => 'strSchool', 'school_web' => 'strSchoolWeb', 'web' => 'strWeb', 'facebook' => 'strFacebook', 'dancers' => 'strDancers', 'year' => 'strYear', 'note' => 'strNote', 'signup' => 'strSignupLink', 'participant_count' => 'strParticipantCount' );
    $aPlaceholdersToSeparatePositions = array();
    foreach ($aPlaceholdersToSeparate as $strPlaceholder => $strVarName) {
      $mixPosition = strpos($this->aMarkerInfoWindowTemplates[$aInfoWindowData['strMapType']],'%%'.$strPlaceholder.'%%');
      if ($mixPosition !== false && ${$strVarName} !== "") {
        $aPlaceholdersToSeparatePositions[$strPlaceholder] = $mixPosition;
      }
    }
    $iPlaceholdersToSeparateMaxPosition = max($aPlaceholdersToSeparatePositions);
    foreach ($aPlaceholdersToSeparatePositions as $strPlaceholder => $iPosition) {
      if ($iPosition === $iPlaceholdersToSeparateMaxPosition) {
        continue;
      }
      $strVarName = $aPlaceholdersToSeparate[$strPlaceholder];
      ${$strVarName} .= "<br>";
    }

    $aSearch = array( 'flashmob_city', 'organizer', 'teacher', 'school', 'web', 'facebook', 'embed_code', 'dancers', 'year', 'note', 'courses_city' ,'courses_info', 'signup', 'participant_count' );
    foreach ($aSearch as $key => $value) {
      $aSearch[$key] = '%%'.$value.'%%';
    }
    switch ($mixMarkerKey) {
      case 'courses_city':
        $strCoursesInfo = $this->getInfoWindowLabel('courses_info') .trim($aInfoWindowData['courses_info']["value"]);
        break;
      case 'courses_city_2':
        $strCoursesInfo = $this->getInfoWindowLabel('courses_info') .trim($aInfoWindowData['courses_info_2']["value"]);
        break;
      case 'courses_city_3':
        $strCoursesInfo = $this->getInfoWindowLabel('courses_info') .trim($aInfoWindowData['courses_info_3']["value"]);
        break;
      default:
        $strCoursesInfo = "";
    }
    // $strCoursesInfo = wpautop( $strCoursesInfo ); // Not needed, since we're using rich text editors //

    if ($bHideLeaderInfo) {
      $strOrganizer = "";
      $strSchool = "";
    }
    // if ($aInfoWindowData['strMapType'] === "teacher") {
    //   // This is a tag only for the organizer info window //
    //   $strWeb = "";
    // }
    $aReplace = array( $strLocation, $strOrganizer, $strTeacher, $strSchool, $strWeb, $strFacebook, $strEmbedCode, $strDancers, $strYear, $strNote, $strLocation, $strCoursesInfo, $strSignupLink, $strParticipantCount );
    $strText = str_replace( $aSearch, $aReplace, $this->aMarkerInfoWindowTemplates[$aInfoWindowData['strMapType']] );
    return $strText;
    /*
     * Fields:
          'user_email', 'first_name', 'last_name', 'password', 'passwordconfirm', 'user_city',
          'school_name', 'fb_school_link', 'school_webpage',
          'flashmob_city', 'flashmob_number_of_dancers', 'video_link', 'flashmob_address',
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

  private function add_log( $strKey, $mixContent ) {
    if (!isset($this->aOptions['logs'][$strKey])) {
      $this->aOptions['logs'][$strKey] = array();
    }
    $this->aOptions['logs'][$strKey] = array_merge( $this->aOptions['logs'][$strKey], (array) $mixContent );
    $this->save_options();
  }

  private function get_log( $strKey ) {
    if (!isset($this->aOptions['logs'][$strKey])) {
      return array();
    } else {
      return $this->aOptions['logs'][$strKey];
    }
  }

  private function delete_log( $strKey ) {
    if (isset($this->aOptions['logs'][$strKey])) {
      unset($this->aOptions['logs'][$strKey]);
    }
    $this->save_options();
  }

  private function get_logs() {
    return $this->aOptions['logs'];
  }

  private function delete_logs() {
    $this->aOptions['logs'] = array();
    $this->save_options();
  }

  private function new_user_notification( $user_login, $password, $user_email, $blogname, $message = false, $subject = false, $mixHeaders = '' ){
    //Copied out of /wp-includes/pluggable.php

    if (class_exists('LoginWithAjax')) {
      // $this->add_log( 'new_user_notification_lwa', array( time() => array( $user_login, $password, $user_email, $blogname, $message, $subject, $mixHeaders ) ) );
      LoginWithAjax::new_user_notification( $user_login, $password, $user_email, $blogname, $message, $subject, $mixHeaders );
      return;
    }
    // $this->add_log( 'new_user_notification_this', array( time() => array( $user_login, $password, $user_email, $blogname, $message, $subject, $mixHeaders ) ) );
    if (!$message || !$subject) {
      return;
    }
    $message = str_replace('%USERNAME%', $user_login, $message);
    $message = str_replace('%PASSWORD%', $password, $message);
    $message = str_replace('%EMAIL%', $user_email, $message);
    $message = str_replace('%BLOGNAME%', $blogname, $message);
    $message = str_replace('%BLOGURL%', home_url(), $message);

    $subject = str_replace('%BLOGNAME%', $blogname, $subject);
    $subject = str_replace('%BLOGURL%', home_url(), $subject);

    wp_mail($user_email, $subject, $message, $mixHeaders);
  }

  public function action__update_user_profile( $aFormData ) {
    // Update the user's profile //
    // file_put_contents( __DIR__ . "/kk-debug-after-submission.log", var_export( $aFormData, true ) );

    $aFiles = array( 'ok', 'error', 'ok2', 'error2', 'check' );
    foreach ($aFiles as $strFile) {
      $strPath = __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-".$strFile.'.log';
      if (file_exists( $strPath )) {
        unlink($strPath);
      }
    }

    $iBlogID = get_current_blog_id();
    $this->aOptions['aNfSubmissions'][$iBlogID]['done'] = false;
    if (isset($this->aOptions['aNfSubmissions'][$iBlogID]['forms'][intval($aFormData['form_id'])])) {
      $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][intval($aFormData['form_id'])]['done'] = false;
    } else {
      $this->aOptions['aNfSubmissions'][$iBlogID]['forms'][intval($aFormData['form_id'])] = array(
        'done' => false,
        'rows' => array(),
      );
    }
    $this->aOptions['aNfFieldTypes'][$iBlogID]['done'] = false;
    $this->save_options();

    if ($this->isFlashmobBlog && intval($aFormData['form_id']) === $this->iProfileFormNinjaFormIDFlashmob) {
      // Get field values by keys //
      $aFieldData = array();
      $bSubmissionEditing = false;
      $aSkipFieldTypes = array( 'recaptcha_logged-out-only', 'recaptcha', 'submit', 'html', 'hr' );
      foreach ($aFormData["fields"] as $strKey => $aData) {
        if (in_array($aData['type'], $aSkipFieldTypes)) {
          continue;
        }
        if ($aData["key"] === 'submission_editing' && strpos($aData['value'], ',') !== false) {
          $bSubmissionEditing = true;
          $aHiddenFieldData = explode(',', $aData['value']);
          $strEmail = $aHiddenFieldData[2];
          $iLeaderID = $aHiddenFieldData[1];
        } else {
          $aFieldData[$aData["key"]] = $aData['value'];
        }
      }
      if ($bSubmissionEditing) {
        $aParticipantData = $this->aOptions['aParticipants'][$iLeaderID][$strEmail];
        $aChanged = array();
        $aChangedFrom = array();
        $aChangedTo = array();
        foreach ($aParticipantData as $sKey => $mixValue) {
          if (isset($aFieldData[$sKey]) && $aFieldData[$sKey] !== $mixValue) {
            if ($sKey === 'preferences') {
              // Changes to NL subscription are ignored //
              if (in_array('newsletter_subscribe', $mixValue) && !in_array('newsletter_subscribe', $aFieldData[$sKey])) {
                $aFieldData[$sKey][] = 'newsletter_subscribe';
              } elseif (!in_array('newsletter_subscribe', $mixValue) && in_array('newsletter_subscribe', $aFieldData[$sKey])) {
                if (in_array('flashmob_participant_tshirt', $aFieldData[$sKey])) {
                  $aFieldData[$sKey] = array();
                  $aFieldData[$sKey][] = 'flashmob_participant_tshirt';
                } else {
                  $aFieldData[$sKey] = array();
                }
              }
              if (count($aFieldData[$sKey]) === count($mixValue)) {
                continue;
              }
            }
            $this->aOptions['aParticipants'][$iLeaderID][$strEmail][$sKey] = $aFieldData[$sKey];
            $aChanged[$sKey] = array(
              $mixValue,
              $aFieldData[$sKey]
            );
            $aChangedFrom[$sKey] = is_array($mixValue) ? ('['.implode(',', $mixValue).']') : $mixValue;
            $aChangedTo[$sKey] = is_array($aFieldData[$sKey]) ? ('['.implode(',', $aFieldData[$sKey]).']') : $aFieldData[$sKey];
          }
        }
        if (count($aChanged) > 0) {
          $this->aOptions['aParticipants'][$iLeaderID][$strEmail]['updated_timestamp'] = $iTimestampNow = (int) current_time( 'timestamp' );
          $this->add_option_change("svk-participant-$iLeaderID-$strEmail", $aChangedFrom, $aChangedTo, false);
          $this->save_options();
        }
        // file_put_contents( __DIR__ . "/kk-debug-after-submission-editing-svk.log", var_export( $aChanged, true ) );
        return 6;
      }

      $aFieldData["registered"] = (int) current_time( 'timestamp' );
      $iUserID = $aFieldData['leader_user_id'];
      if (!isset($this->aOptions['aParticipants'][$iUserID])) {
        $this->aOptions['aParticipants'][$iUserID] = array();
      }

      if (!empty($aFieldData) && in_array('newsletter_subscribe', $aFieldData['preferences'])) {
        // Subscribe participant to newsletter via REST API //
        $strAction = 'subscribe';
        $aData = array(
          'email'       => $aFieldData['user_email'],
          'name'        => $aFieldData['first_name'],
          'surname'     => $aFieldData['last_name'],
          'send_emails' => true,
        );
        if ($aFieldData['gender'] === 'muz' || $aFieldData['gender'] === 'zena') {
          $aData['gender'] = $aFieldData['gender'] === 'muz' ? 'm' : 'f';
        }
        $aFieldData['newsletter_subscription_result'] = '';
        $bResult = $this->execute_newsletter_rest_api_call( $strAction, $aData );
        if ($strAction === 'subscribe' && !$bResult['ok'] && isset($bResult['issue']) && $bResult['issue'] === 'email-exists') {
          $strAction2 = 'subscribers/delete';
          $aData2 = array( 'email' => $aFieldData['user_email'] );
          $bResult2 = $this->execute_newsletter_rest_api_call( $strAction2, $aData2 );
          if ($bResult2['ok']) {
            $bResult = $this->execute_newsletter_rest_api_call( $strAction, $aData );
            if (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
              file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-ok2.log", var_export( $bResult2, true ) );
            }
          } else {
            $aFieldData['newsletter_subscription_result'] = 'error: '.var_export( $bResult2, true ).PHP_EOL;
            if (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
              file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-error2.log", var_export( $bResult2, true ) );
            }
          }
        }
        if (!$bResult['ok']) {
          $aFieldData['newsletter_subscription_result'] .= 'error: '.var_export( $bResult, true );
          if (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
            file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-error.log", var_export( $bResult, true ) );
          }
        } else {
          $aFieldData['newsletter_subscription_result'] = 'ok';
          if (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
            file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-ok.log", var_export( $bResult, true ) );
          }
        }
      }

      $this->aOptions['aParticipants'][$iUserID] = array_merge($this->aOptions['aParticipants'][$iUserID], array(
        $aFieldData['user_email'] => $aFieldData,
      ));
      $this->save_options();

      if (strlen(trim($this->aOptions['strParticipantRegisteredMessage'])) > 0) {
        $strMessageContent = $this->aOptions['strParticipantRegisteredMessage'];
        $strBlogname = trim(wp_specialchars_decode(get_option('blogname'), ENT_QUOTES));
        $aHeaders = array('Content-Type: text/html; charset=UTF-8');
        $this->new_user_notification( $aFieldData['user_email'], '', $aFieldData['user_email'], $strBlogname, $strMessageContent, $this->aOptions['strParticipantRegisteredSubject'], $aHeaders );
      }
      return 1;
    }

    if ($this->isIntfBlog && intval($aFormData['form_id']) === $this->iProfileFormNinjaFormIDIntf) {
      // Get field values by keys //
      $aFieldData = array();
      $bSubmissionEditing = false;
      $aSkipFieldTypes = array( 'recaptcha_logged-out-only', 'recaptcha', 'submit', 'html', 'hr' );
      foreach ($aFormData["fields"] as $strKey => $aData) {
        if (in_array($aData['type'], $aSkipFieldTypes)) {
          continue;
        }
        if ($aData["key"] === 'submission_editing' && strpos($aData['value'], ',') !== false) {
          $bSubmissionEditing = true;
          $aHiddenFieldData = explode(',', $aData['value']);
          $strEmail = $aHiddenFieldData[2];
          $iYear = $aHiddenFieldData[1];
        } else {
          $aFieldData[$aData["key"]] = $aData['value'];
        }
      }
      if ($bSubmissionEditing) {
        $aParticipantData = $this->aOptions['aIntfParticipants'][$iYear][$strEmail];
        $aChanged = array();
        $aChangedFrom = array();
        $aChangedTo = array();
        foreach ($aParticipantData as $sKey => $mixValue) {
          if (isset($aFieldData[$sKey]) && $aFieldData[$sKey] !== $mixValue) {
            if ($sKey === 'preferences') {
              // Changes to NL subscription are ignored //
              if (in_array('newsletter_subscribe', $mixValue) && !in_array('newsletter_subscribe', $aFieldData[$sKey])) {
                $aFieldData[$sKey][] = 'newsletter_subscribe';
              } elseif (!in_array('newsletter_subscribe', $mixValue) && in_array('newsletter_subscribe', $aFieldData[$sKey])) {
                if (in_array('flashmob_participant_tshirt', $aFieldData[$sKey])) {
                  $aFieldData[$sKey] = array();
                  $aFieldData[$sKey][] = 'flashmob_participant_tshirt';
                } else {
                  $aFieldData[$sKey] = array();
                }
              }
              if (count($aFieldData[$sKey]) === count($mixValue)) {
                continue;
              }
            }
            $this->aOptions['aIntfParticipants'][$iYear][$strEmail][$sKey] = $aFieldData[$sKey];
            $aChanged[$sKey] = array(
              $mixValue,
              $aFieldData[$sKey]
            );
            $aChangedFrom[$sKey] = is_array($mixValue) ? ('['.implode(',', $mixValue).']') : $mixValue;
            $aChangedTo[$sKey] = is_array($aFieldData[$sKey]) ? ('['.implode(',', $aFieldData[$sKey]).']') : $aFieldData[$sKey];
          }
        }
        if (count($aChanged) > 0) {
          $this->aOptions['aIntfParticipants'][$iYear][$strEmail]['updated_timestamp'] = $iTimestampNow = (int) current_time( 'timestamp' );
          $this->add_option_change("intf-participant-$iYear-$strEmail", $aChangedFrom, $aChangedTo, false);
          $this->save_options();
        }
        // file_put_contents( __DIR__ . "/kk-debug-after-submission-editing-intf.log", var_export( $aChanged, true ) );
        return 7;
      }

      $aFieldData["registered"] = (int) current_time( 'timestamp' );
      if (!isset($this->aOptions['aIntfParticipants'][$this->aOptions['iIntfFlashmobYear']])) {
        $this->aOptions['aIntfParticipants'][$this->aOptions['iIntfFlashmobYear']] = array();
      }

      if (!empty($aFieldData) && in_array('newsletter_subscribe', $aFieldData['preferences'])) {
        // Subscribe participant to newsletter via REST API //
        $strAction = 'subscribe';
        $aData = array(
          'email'       => $aFieldData['user_email'],
          'name'        => $aFieldData['first_name'],
          'surname'     => $aFieldData['last_name'],
          'send_emails' => true,
        );
        if ($aFieldData['gender'] === 'muz' || $aFieldData['gender'] === 'zena') {
          $aData['gender'] = $aFieldData['gender'] === 'muz' ? 'm' : 'f';
        }
        $aFieldData['newsletter_subscription_result'] = '';
        $bResult = $this->execute_newsletter_rest_api_call( $strAction, $aData );
        if ($strAction === 'subscribe' && !$bResult['ok'] && isset($bResult['issue']) && $bResult['issue'] === 'email-exists') {
          $strAction2 = 'subscribers/delete';
          $aData2 = array( 'email' => $aFieldData['user_email'] );
          $bResult2 = $this->execute_newsletter_rest_api_call( $strAction2, $aData2 );
          if ($bResult2['ok']) {
            $bResult = $this->execute_newsletter_rest_api_call( $strAction, $aData );
            if (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
              file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-ok2.log", var_export( $bResult2, true ) );
            }
          } else {
            $aFieldData['newsletter_subscription_result'] = 'error: '.var_export( $bResult2, true ).PHP_EOL;
            if (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
              file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-error2.log", var_export( $bResult2, true ) );
            }
          }
        }
        if (!$bResult['ok']) {
          $aFieldData['newsletter_subscription_result'] .= 'error: '.var_export( $bResult, true );
          if (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
            file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-error.log", var_export( $bResult, true ) );
          }
        } else {
          $aFieldData['newsletter_subscription_result'] = 'ok';
          if (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
            file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-ok.log", var_export( $bResult, true ) );
          }
        }
      }

      $this->aOptions['aIntfParticipants'][$this->aOptions['iIntfFlashmobYear']] = array_merge($this->aOptions['aIntfParticipants'][$this->aOptions['iIntfFlashmobYear']], array(
        $aFieldData['user_email'] => $aFieldData,
      ));
      $this->save_options();

      if (strlen(trim($this->aOptions['strIntfParticipantRegisteredMessage'])) > 0) {
        $strMessageContent = $this->aOptions['strIntfParticipantRegisteredMessage'];
        $strBlogname = trim(wp_specialchars_decode(get_option('blogname'), ENT_QUOTES));
        $aHeaders = array('Content-Type: text/html; charset=UTF-8');
        $this->new_user_notification( $aFieldData['user_email'], '', $aFieldData['user_email'], $strBlogname, $strMessageContent, $this->aOptions['strIntfParticipantRegisteredSubject'], $aHeaders );
      }
      return 5;
    }

    if (!$this->isMainBlog || intval($aFormData['form_id']) !== $this->iProfileFormNinjaFormIDMain) {
      // Not the profile form (or the main site at all) //
      return 2;
    }

    if (is_user_logged_in()) {
      $iUserID = get_current_user_id();
    } else {
      // REGISTRATION //
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
        return 3;
      } else {
        // Success
        $iUserID = $mixResult;
        if (is_multisite()) {
          add_user_to_blog( $this->iMainBlogID, $iUserID, $this->get_registration_user_role() );
        }
        $strBlogname = trim(wp_specialchars_decode(get_option('blogname'), ENT_QUOTES));
        $this->new_user_notification( $strUsername, $aFieldData['user_pass'], $aFieldData['user_email'], $strBlogname );

        // New user notification to admins //
        $message  = sprintf(__('New user registration on your site %s:'), $strBlogname) . "\n\n";
        $message .= sprintf(__('Username: %s'), $strUsername ) . "\n\n";
        $message .= sprintf(__('E-mail: %s'), $aFieldData['user_email'] ) . "\n";
        if (!$this->aOptions['bApproveUsersAutomatically']) {
          $strUserListUrl = admin_url( 'users.php' );
          $message .= "\n".sprintf(__('Approval needed - go to the user list: %s'), $strUserListUrl ) . "\n";
        }
        $aAdminArgs = array(
          'blog_id' => get_current_blog_id(),
          'role'    => 'administrator'
        );
        $aAdmins = get_users( $aAdminArgs );
        if (empty($aAdmins) || (defined('FLORP_DEVEL') && FLORP_DEVEL === true)) {
          $strSubjectRaw = '[%s] New User Registration';
          if (!$this->aOptions['bApproveUsersAutomatically']) {
            $strSubjectRaw .= ". Approval needed";
          }

          @wp_mail(get_option('admin_email'), sprintf(__($strSubjectRaw), $strBlogname), $message);
        } else {
          foreach ($aAdmins as $iKey => $oAdmin) {
            @wp_mail($oAdmin->user_email, sprintf(__('[%s] New User Registration'), $strBlogname), $message);
          }
        }
      }
    }

    $strNewsletterSubscribeKey = 'preference_newsletter';
    $bNewsletterSubscribeOld = get_user_meta( $iUserID, $strNewsletterSubscribeKey, true ) == '1' ? 1 : 0;

    $strFlashmobOrganizerKey = 'flashmob_organizer';
    $bIsFlashmobOrganizerOld = get_user_meta( $iUserID, $strFlashmobOrganizerKey, true ) == '1' ? 1 : 0;

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
      add_filter( 'send_password_change_email', '__return_false' );
      add_filter( 'send_email_change_email', '__return_false' );
      $mixRes = wp_update_user( $aUserData );
    }
    $aSavedMeta = array();
    if (!empty($aMetaData)) {
      foreach ($aMetaData as $strKey => $mixValue) {
        if (in_array($strKey, array("flashmob_city", "user_city", "courses_city", "courses_city_2", "courses_city_3")) && $mixValue === "null") {
          delete_user_meta( $iUserID, $strKey );
        } else {
          $mixValue .= ''; // casting to string because of int values //
          update_user_meta( $iUserID, $strKey, $mixValue );
        }
        $aSavedMeta[$strKey] = get_user_meta( $iUserID, $strKey, true );
      }

      // file_put_contents( __DIR__ . "/kk-debug-after-submission-metadata-".$iUserID.".log", var_export( $aMetaData, true ) . "\n=======================\n" . var_export($aSavedMeta, true) );
      // Remove participants of organizer if they decide not to organize a flashmob //
      if (isset($aMetaData[$strFlashmobOrganizerKey])) {
        $bIsFlashmobOrganizerNew = $aMetaData[$strFlashmobOrganizerKey]; // int //
      } else {
        $bIsFlashmobOrganizerNew = 0;
      }
      if ($bIsFlashmobOrganizerNew !== $bIsFlashmobOrganizerOld && !$bIsFlashmobOrganizerNew && $this->get_flashmob_participant_count( $iUserID ) > 0) {
        // Send notification to participants //
        foreach ($this->aOptions['aParticipants'][$iUserID] as $strEmail => $aParticipantData) {
          if (strlen(trim($this->aOptions['strParticipantRemovedMessage'])) > 0) {
            $strMessageContent = $this->aOptions['strParticipantRemovedMessage'];
            $strBlogname = trim(wp_specialchars_decode(get_option('blogname'), ENT_QUOTES));
            $aHeaders = array('Content-Type: text/html; charset=UTF-8');
            $this->new_user_notification( $strEmail, '', $strEmail, $strBlogname, $strMessageContent, $this->aOptions['strParticipantRemovedSubject'], $aHeaders );
          }
        }

        // Remove participants //
        $this->aOptions['aParticipants'][$iUserID] = array();
        $this->save_options();
      }

      // Subscribe or unsubscribe to/from newsletter via REST API //
      if (isset($aMetaData[$strNewsletterSubscribeKey])) {
        $bNewsletterSubscribeNew = $aMetaData[$strNewsletterSubscribeKey]; // array //
        if (is_array($bNewsletterSubscribeNew)) {
          $bNewsletterSubscribeNew = in_array("newsletter_subscribe", $bNewsletterSubscribeNew) ? 1 : 0;
        } elseif ($bNewsletterSubscribeNew !== 0 && $bNewsletterSubscribeNew !== 1) {
          $bNewsletterSubscribeNew = 0;
        }
      } else {
        $bNewsletterSubscribeNew = 0;
      }
      update_user_meta( $iUserID, $strNewsletterSubscribeKey, $bNewsletterSubscribeNew ); // To rewrite by the simplified non-array int value //

      if ($bNewsletterSubscribeNew !== $bNewsletterSubscribeOld) {
        if ($bNewsletterSubscribeNew) {
          $strAction = 'subscribe';
          $aData = array(
            'email'       => $aUserData['user_email'],
            'name'        => $aUserData['first_name'],
            'surname'     => $aUserData['last_name'],
            'send_emails' => true,
          );
        } else {
          $strAction = 'unsubscribe';
          $aData = array(
            'email' => $aUserData['user_email'],
          );
        }
        $bResult = $this->execute_newsletter_rest_api_call( $strAction, $aData );
        if ($strAction === 'subscribe' && !$bResult['ok'] && isset($bResult['issue']) && $bResult['issue'] === 'email-exists') {
          $strAction2 = 'subscribers/delete';
          $aData2 = array( 'email' => $aUserData['user_email'] );
          $bResult2 = $this->execute_newsletter_rest_api_call( $strAction2, $aData2 );
          if ($bResult2['ok']) {
            $bResult = $this->execute_newsletter_rest_api_call( $strAction, $aData );
            if (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
              file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-ok2.log", var_export( $bResult2, true ) );
            }
          } elseif (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
            file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-error2.log", var_export( $bResult2, true ) );
          }
        }
        if (!$bResult['ok']) {
          if (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
            file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-error.log", var_export( $bResult, true ) );
          }
          update_user_meta( $iUserID, $strNewsletterSubscribeKey, $bNewsletterSubscribeOld );
        } elseif (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
          file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-ok.log", var_export(
            array(
              $bResult,
              array(
                'old' => $bNewsletterSubscribeOld,
                'new' => $bNewsletterSubscribeNew,
                'new-userdata' => $aUserData,
                'new-metadata' => $aMetaData,
              )
            ), true ));
        }
      }
      if (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
        file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-check.log", var_export( array(
          'old' => $bNewsletterSubscribeOld,
          'new' => $bNewsletterSubscribeNew,
          'new-userdata' => $aUserData,
          'new-metadata' => $aMetaData,
        ), true ) );
      }
    }
    setcookie('florp-form-saved', "1", time() + (1 * 24 * 60 * 60), '/');
    return 4;
  }

  public function action__set_user_role( $iUserID, $strNewRole, $aOldRoles ) {
    if (!in_array($this->strUserRolePending, $aOldRoles)) {
      return;
    }

    $strBlogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    $oUser = get_user_by( 'id', $iUserID );
    // User approval notification to approved user //
    if (strlen(trim($this->strUserApprovedMessage)) > 0) {
      $strProfilePageUrl = '';
      if ( $this->iProfileFormPageIDMain > 0 ) {
        $strProfilePageUrl = get_permalink( $this->iProfileFormPageIDMain );
      }
      $strMessageContent = str_replace( '%PROFILE_URL%', $strProfilePageUrl, $this->strUserApprovedMessage );
      $aHeaders = array('Content-Type: text/html; charset=UTF-8');
      $this->new_user_notification( $oUser->user_email, '', $oUser->user_email, $strBlogname, $strMessageContent, $this->aOptions['strUserApprovedSubject'], $aHeaders );
    }

    // User approval notification to admins //
    $message  = sprintf(__('A user was approved on your site %s:'), $strBlogname) . "\n\n";
    $message .= sprintf(__('Username: %s'), $oUser->user_login ) . "\n\n";
    $message .= sprintf(__('E-mail: %s'), $oUser->user_email ) . "\n";
    $aAdminArgs = array(
      'blog_id' => get_current_blog_id(),
      'role'    => 'administrator'
    );
    $aAdmins = get_users( $aAdminArgs );
    if (empty($aAdmins) || (defined('FLORP_DEVEL') && FLORP_DEVEL === true)) {
      @wp_mail(get_option('admin_email'), sprintf(__('[%s] User Approval'), $strBlogname), $message);
    } else {
      foreach ($aAdmins as $iKey => $oAdmin) {
        @wp_mail($oAdmin->user_email, sprintf(__('[%s] User Approval'), $strBlogname), $message);
      }
    }
  }

  public function action__lwa_before_login_form( $aLwaData ) {
    if ($this->isMainBlog) {
      echo $this->strBeforeLoginFormHtmlMain;
    }
    if ($this->isFlashmobBlog) {
      echo $this->strBeforeLoginFormHtmlFlashmob;
    }
    if ($this->isIntfBlog) {
      echo $this->strBeforeLoginFormHtmlIntf;
    }
  }

  private function get_wp_editor( $strContent, $strEditorID, $aSettings = array() ) {
    $aDefaultsSettings = array(
      'media_buttons' => false,
      'textarea_rows' => 4,
      'wpautop'       => false,
    );
    $aSettings = array_merge( $aDefaultsSettings, $aSettings );

    ob_start();
    wp_editor( $strContent, $strEditorID, $aSettings );
    return ob_get_clean();
  }

  public function get_profile_form_id_main() {
    return $this->iProfileFormNinjaFormIDMain;
  }

  public function get_profile_form_id_flashmob() {
    return $this->iProfileFormNinjaFormIDFlashmob;
  }

  public function get_profile_form_id_intf() {
    return $this->iProfileFormNinjaFormIDIntf;
  }

  public function is_main_blog() {
    return $this->isMainBlog;
  }

  public function is_flashmob_blog() {
    return $this->isFlashmobBlog;
  }

  public function is_intf_blog() {
    return $this->isIntfBlog;
  }

  public function is_tshirt_ordering_disabled() {
    return $this->aOptions['bTshirtOrderingDisabled'];
  }

  public function is_intf_tshirt_ordering_disabled() {
    return $this->aOptions['bIntfTshirtOrderingDisabled'];
  }

  public function has_main_only_florp_profile_ninja_form() {
    return $this->aOptions['bOnlyFlorpProfileNinjaFormMain'];
  }

  public function has_flashmob_only_florp_profile_ninja_form() {
    return $this->aOptions['bOnlyFlorpProfileNinjaFormFlashmob'];
  }

  public function is_intf_city_poll_disabled() {
    return $this->bIntfCityPollDisabled;
  }

  public function get_message( $strKey = false, $strDefault = "" ) {
    $aMessages = array(
      'login_success' => $this->aOptions['strLoginSuccessfulMessage'],
      'registration_success' => $this->aOptions['strRegistrationSuccessfulMessage'],
      'login_error' => $this->aOptions['strLoginErrorMessage'],
      'registration_error' => $this->aOptions['strRegistrationErrorMessage'],
    );

    if ($strKey) {
      if (isset($aMessages[$strKey]) && !empty($aMessages[$strKey])) {
        return $aMessages[$strKey];
      } else {
        return $strDefault;
      }
    } else {
      return $aMessages;
    }
  }

  public function flashmob_participant_exists( $strEmail ) {
    if (empty($this->aOptions['aParticipants'])) {
      return false;
    }
    foreach ($this->aOptions['aParticipants'] as $iUserID => $aParticipants) {
      if (isset($aParticipants[$strEmail])) {
        return true;
      }
    }
    return false;
  }

  public function intf_participant_exists( $strEmail ) {
    if (empty($this->aOptions['aIntfParticipants'])) {
      return false;
    }
    foreach ($this->aOptions['aIntfParticipants'] as $iYear => $aParticipants) {
      if (isset($aParticipants[$strEmail])) {
        return true;
      }
    }
    return false;
  }

  public function fakepage_intf_participant_form( $aPosts ) {
    $bLoggedIn = is_user_logged_in();
    if (!$bLoggedIn || !current_user_can( $this->strUserRoleRegistrationAdminIntf || !$this->isIntfBlog)) {
      return $aPosts;
    }
    $strContent = "[florp-form international=1]";
    if (!$_REQUEST['year'] || !$_REQUEST['email'] || !$this->aOptions['aIntfParticipants'][$_REQUEST['year']] || !$this->aOptions['aIntfParticipants'][$_REQUEST['year']][$_REQUEST['email']]) {
      $strContent = "No such registration!";
    }

    return $this->fakepage( $aPosts, "edit-intf-participant-submission", "Edit international flashmob participant's submission", $strContent, 'florp-intf-participant-form-edit' );
  }

  public function fakepage_svk_participant_form( $aPosts ) {
    $bLoggedIn = is_user_logged_in();
    if (!$bLoggedIn || !current_user_can( $this->strUserRoleRegistrationAdminSvk ) || !$this->isFlashmobBlog) {
      return $aPosts;
    }
    $strContent = "[florp-form]";
    if (!$_REQUEST['leader_id'] || !$_REQUEST['email'] || !$this->aOptions['aParticipants'][$_REQUEST['leader_id']] || !$this->aOptions['aParticipants'][$_REQUEST['leader_id']][$_REQUEST['email']]) {
      $strContent = "No such registration!";
    }

    return $this->fakepage( $aPosts, "edit-svk-participant-submission", "Edit Slovak flashmob participant's submission", $strContent, 'florp-svk-participant-form-edit' );
  }

  private function fakepage( $aPosts, $sUrl, $sTitle, $sContent, $sGlobalsKey ) {
      global $wp;
      global $wp_query;

      if ( !$GLOBALS['florp-fakepage-'.$sUrl] && (strtolower($wp->request) === $sUrl || $wp->query_vars['page_id'] === $sUrl) ) {
        // stop interferring with other $aPosts arrays on this page (only works if the sidebar is rendered *after* the main page)
        $GLOBALS['florp-fakepage-'.$sUrl] = true;

        $GLOBALS[$sGlobalsKey] = true;

        // create a fake virtual page
        $oPost = new stdClass;
        $oPost->post_author = 1;
        $oPost->post_name = $sUrl;
        $oPost->guid = get_bloginfo('wpurl') . '/' . $sUrl;
        $oPost->post_title = $sTitle;
        $oPost->post_content = $sContent;
        $oPost->ID = -1;
        $oPost->post_type = 'page';
        $oPost->post_status = 'static';
        $oPost->comment_status = 'closed';
        $oPost->ping_status = 'open';
        $oPost->comment_count = 0;
        $oPost->post_date = current_time('mysql');
        $oPost->post_date_gmt = current_time('mysql', 1);
        $aPosts = NULL;
        $aPosts[] = $oPost;

        // make wpQuery believe this is a real page too
        $wp_query->is_page = true;
        $wp_query->is_singular = true;
        $wp_query->is_home = false;
        $wp_query->is_archive = false;
        $wp_query->is_category = false;
        $wp_query->is_attachment = false;
        unset($wp_query->query["error"]);
        $wp_query->query_vars["error"] = "";
        $wp_query->is_404 = false;
      }

      return $aPosts;
  }

  public function activate() {
    if (!is_multisite()) {
      deactivate_plugins( plugin_basename( __FILE__ ) );
      wp_die( 'This plugin requires a multisite WP installation.  Sorry about that.' );
    }
    $this->maybe_add_crons();
  }

  public function deactivate() {
    // Clean up roles and capabilities //
    if (get_role($this->strUserRolePending)) {
      remove_role($this->strUserRolePending);
    }
    if (get_role($this->strUserRoleRegistrationAdmin)) {
      remove_role($this->strUserRoleRegistrationAdmin);
    }
    if (get_role($this->strUserRoleRegistrationAdminSvk)) {
      remove_role($this->strUserRoleRegistrationAdminSvk);
    }
    if (get_role($this->strUserRoleRegistrationAdminIntf)) {
      remove_role($this->strUserRoleRegistrationAdminIntf);
    }
    foreach ($GLOBALS['wp_roles']->role_objects as $key => $oRole) {
      if ($oRole->has_cap($this->strUserRoleRegistrationAdminSvk)) {
        $oRole->remove_cap($this->strUserRoleRegistrationAdminSvk);
      }
      if ($oRole->has_cap($this->strUserRoleRegistrationAdminIntf)) {
        $oRole->remove_cap($this->strUserRoleRegistrationAdminIntf);
      }
    }

    // Clean up cron jobs //
    $this->remove_crons();
  }

  private function maybe_add_crons() {
    if ($this->isMainBlog) {
      $iNow = time();
      $iTimestamp = strtotime('today 10am');
      $iTimeZoneOffset = get_option( 'gmt_offset', 0 );
      if ($iTimestamp < $iNow) {
        $iTimestamp = strtotime('tomorrow '.(10-$iTimeZoneOffset).'am');
      }
      if ( !wp_next_scheduled( 'florp_notify_leaders_about_participants_cron' ) ) {
        wp_schedule_event( $iTimestamp, 'daily', 'florp_notify_leaders_about_participants_cron');
      }
    } elseif (wp_next_scheduled( 'florp_notify_leaders_about_participants_cron' )) {
      wp_clear_scheduled_hook('florp_notify_leaders_about_participants_cron');
    }
  }

  private function remove_crons() {
    if (wp_next_scheduled( 'florp_notify_leaders_about_participants_cron' )) {
      wp_clear_scheduled_hook('florp_notify_leaders_about_participants_cron');
    }
  }


}

$FLORP = new FLORP();

register_activation_hook(__FILE__, 'florp_activate');
register_deactivation_hook(__FILE__, 'florp_deactivate');
function florp_activate() {
  global $FLORP;
  if (is_object($FLORP) && has_method($FLORP, 'activate')) {
    $FLORP->activate();
  }
}
function florp_deactivate() {
  global $FLORP;
  if (is_object($FLORP) && has_method($FLORP, 'deactivate')) {
    $FLORP->deactivate();
  }
}

function florp_profile_form( $aAttributes = array() ) {
  global $FLORP;
  echo $FLORP->profile_form( $aAttributes );
}
function florp_get_profile_form_id_main() {
  global $FLORP;
  return $FLORP->get_profile_form_id_main();
}
function florp_get_profile_form_id_flashmob() {
  global $FLORP;
  return $FLORP->get_profile_form_id_flashmob();
}
function florp_get_profile_form_id_intf() {
  global $FLORP;
  return $FLORP->get_profile_form_id_intf();
}
function florp_is_main_blog() {
  global $FLORP;
  return $FLORP->is_main_blog();
}
function florp_is_flashmob_blog() {
  global $FLORP;
  return $FLORP->is_flashmob_blog();
}
function florp_is_intf_blog() {
  global $FLORP;
  return $FLORP->is_intf_blog();
}
function florp_is_tshirt_ordering_disabled() {
  global $FLORP;
  return $FLORP->is_tshirt_ordering_disabled();
}
function florp_is_intf_tshirt_ordering_disabled() {
  global $FLORP;
  return $FLORP->is_intf_tshirt_ordering_disabled();
}
function florp_has_main_only_florp_profile_ninja_form() {
  global $FLORP;
  return $FLORP->has_main_only_florp_profile_ninja_form();
}
function florp_has_flashmob_only_florp_profile_ninja_form() {
  global $FLORP;
  return $FLORP->has_flashmob_only_florp_profile_ninja_form();
}
function florp_is_intf_city_poll_disabled() {
  global $FLORP;
  return $FLORP->is_intf_city_poll_disabled();
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
function florp_get_message( $strKey = false, $strDefault = "" ) {
  global $FLORP;
  return $FLORP->get_message( $strKey, $strDefault );
}
function florp_flashmob_participant_exists( $strEmail ) {
  global $FLORP;
  return $FLORP->flashmob_participant_exists( $strEmail );
}
function florp_intf_participant_exists( $strEmail ) {
  global $FLORP;
  return $FLORP->intf_participant_exists( $strEmail );
}