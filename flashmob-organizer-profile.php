<?php
/**
 * Plugin Name: Flashmob Organizer Profile (with login/registration page)
 * Plugin URI: https://github.com/charliecek/flashmob-organizer-profile
 * Description: Creates shortcodes for flashmob organizer login / registration / profile editing form and for maps showing cities with videos of flashmobs for each year
 * Author: charliecek
 * Author URI: http://charliecek.eu/
 * Version: 4.0.2
 */

class FLORP{

  private $strVersion = '4.0.2';
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
  private $aMetaFieldsFlashmobToArchive;
  private $aFlashmobMetaFieldsToClean;
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
  private $iProfileFormPageIDMain;
  private $iProfileFormPageIDFlashmob;
  private $strUserRolePending = 'florp-pending';
  private $strUserRoleApproved = 'subscriber';
  private $strUserRolePendingName = "Čaká na schválenie";
  private $strPendingUserPageContentHTML;
  private $strUserApprovedMessage;
  private $strBeforeLoginFormHtmlMain;
  private $strBeforeLoginFormHtmlFlashmob;
  private $iFlashmobTimestamp = 0;
  private $bHideFlashmobFields;

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
      'iNewsletterBlogID'                         => 0,
      'iProfileFormNinjaFormIDMain'               => 0,
      'iProfileFormPopupIDMain'                   => 0,
      'iProfileFormNinjaFormIDFlashmob'           => 0,
      'iProfileFormPopupIDFlashmob'               => 0,
      'bLoadMapsLazy'                             => true,
      'bLoadMapsAsync'                            => true,
      'bLoadVideosLazy'                           => true,
      'bUseMapImage'                              => true,
      'strVersion'                                => '0',
      'iProfileFormPageIDMain'                    => 0,
      'iProfileFormPageIDFlashmob'                => 0,
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
      'strGoogleMapsKeyStatic'                    => 'AIzaSyC_g9bY9qgW7mA0L1EupZ4SDYrBQWWi-V0',
      'strGoogleMapsKey'                          => 'AIzaSyBaPowbVdIBpJqo_yhEfLn1v60EWbow6ZY',
      'strFbAppID'                                => '768253436664320',
      'strRegistrationSuccessfulMessage'          => "Prihlasujeme Vás... Prosíme, počkajte, kým sa stránka znovu načíta.",
      'strLoginSuccessfulMessage'                 => "Prihlásenie prebehlo úspešne, prosíme, počkajte, kým sa stránka znovu načíta.",
      'bPreventDirectMediaDownloads'              => false,
      'strNewsletterAPIKey'                       => '',
      'strNewsletterListsMain'                    => '',
      'strNewsletterListsFlashmob'                => '',
      'aParticipants'                             => array(),
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
      'florp_newsletter_blog_id'                  => 'iNewsletterBlogID',
      'florp_profile_form_ninja_form_id_main'     => 'iProfileFormNinjaFormIDMain',
      'florp_profile_form_popup_id_main'          => 'iProfileFormPopupIDMain',
      'florp_profile_form_ninja_form_id_flashmob' => 'iProfileFormNinjaFormIDFlashmob',
      'florp_profile_form_popup_id_flashmob'      => 'iProfileFormPopupIDFlashmob',
      'florp_load_maps_lazy'                      => 'bLoadMapsLazy',
      'florp_load_maps_async'                     => 'bLoadMapsAsync',
      'florp_load_videos_lazy'                    => 'bLoadVideosLazy',
      'florp_use_map_image'                       => 'bUseMapImage',
      'florp_profile_form_page_id_main'           => 'iProfileFormPageIDMain',
      'florp_profile_form_page_id_flashmob'       => 'iProfileFormPageIDFlashmob',
      'florp_pending_user_page_content_html'      => 'strPendingUserPageContentHTML',
      'florp_user_approved_message'               => 'strUserApprovedMessage',
      'florp_user_approved_subject'               => 'strUserApprovedSubject',
      'florp_approve_users_automatically'         => 'bApproveUsersAutomatically',
      'florp_before_login_form_html_main'         => 'strBeforeLoginFormHtmlMain',
      'florp_before_login_form_html_flashmob'     => 'strBeforeLoginFormHtmlFlashmob',
      'florp_google_maps_key'                     => 'strGoogleMapsKey',
      'florp_google_maps_key_static'              => 'strGoogleMapsKeyStatic',
      'florp_fb_app_id'                           => 'strFbAppID',
      'florp_registration_successful_message'     => 'strRegistrationSuccessfulMessage',
      'florp_login_successful_message'            => 'strLoginSuccessfulMessage',
      'florp_prevent_direct_media_downloads'      => 'bPreventDirectMediaDownloads',
      'florp_newsletter_api_key'                  => 'strNewsletterAPIKey',
      'florp_newsletter_lists_main'               => 'strNewsletterListsMain',
      'florp_newsletter_lists_flashmob'           => 'strNewsletterListsFlashmob',
      'florp_participant_registered_subject'      => 'strParticipantRegisteredSubject',
      'florp_participant_registered_message'      => 'strParticipantRegisteredMessage',
      'florp_participant_removed_subject'         => 'strParticipantRemovedSubject',
      'florp_participant_removed_message'         => 'strParticipantRemovedMessage',
      'florp_leader_participant_list_notif_msg'   => 'strLeaderParticipantListNotificationMsg',
      'florp_leader_participant_list_notif_sbj'   => 'strLeaderParticipantListNotificationSbj',
      'florp_login_bar_label_login'               => 'strLoginBarLabelLogin',
      'florp_login_bar_label_logout'              => 'strLoginBarLabelLogout',
      'florp_login_bar_label_profile'             => 'strLoginBarLabelProfile',
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
    );
    $this->aBooleanOptions = array(
      'bReloadAfterSuccessfulSubmissionMain', 'bReloadAfterSuccessfulSubmissionFlashmob',
      'bLoadMapsAsync', 'bLoadMapsLazy', 'bLoadVideosLazy', 'bUseMapImage',
      'bApproveUsersAutomatically',
      'bPreventDirectMediaDownloads',
    );
    $this->aOptionKeysByBlog = array(
      'main'      => array(
        'aYearlyMapOptions',
        'aParticipants',
        'bReloadAfterSuccessfulSubmissionMain',
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

    $this->set_variables();

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
    add_shortcode( 'florp-map', array( $this, 'map_flashmob' ));
    add_shortcode( 'florp-map-teachers', array( $this, 'map_teachers' ));
    add_shortcode( 'florp-registered-count', array( $this, 'getRegisteredUserCount' ));
    add_shortcode( 'florp-registered-counter-impreza', array( $this, 'registeredUserImprezaCounter' ));
    add_shortcode( 'florp-popup-links', array( $this, 'popupLinks' )); // DEPRECATED //
    add_shortcode( 'florp-profile', array( $this, 'main_blog_profile' ));
    add_shortcode( 'florp-leader-participant-list', array( $this, 'leader_participants_table_shortcode' ));

    // FILTERS //
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

    // ACTIONS //
    add_action( 'ninja_forms_register_actions', array( $this, 'action__register_nf_florp_action' ));
    add_action( 'ninja_forms_after_submission', array( $this, 'action__update_user_profile' ));
    add_action( 'after_setup_theme', array( $this, 'action__remove_admin_bar' ));
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
    add_action( 'set_user_role', array( $this, 'action__set_user_role' ), 10, 3 );
    add_action( 'lwa_before_login_form', array( $this, 'action__lwa_before_login_form' ));
    add_action( 'florp_notify_leaders_about_participants_cron', array( $this, 'notify_leaders_about_participants' ) );

    $this->aMarkerInfoWindowTemplates = array(
      'flashmob_organizer' =>
        '        <div class="florp-marker-infowindow-wrapper">
          <h5 class="florp-flashmob-location">%%flashmob_city%%</h5>
          <p>
            <strong>Organizátor</strong>: %%organizer%%
            %%signup%%
            %%participant_count%%
            %%year%%
            %%school%%
            %%dancers%%
            %%note%%
          </p>
          %%embed_code%%
        </div>',
      'teacher' =>
        '        <div class="florp-marker-infowindow-wrapper">
          <h5 class="florp-course-location">%%courses_city%%</h5>
          <p>
            <strong>Líder</strong>: %%organizer%%
            %%school%%
          </p>
          <div class="florp-course-info">%%courses_info%%</div>
        </div>',
    );
    $this->aUserFields = array( 'user_email', 'first_name', 'last_name', 'user_pass' );
    $this->aUserFieldsMap = array( 'first_name', 'last_name' );
    $this->aMetaFieldsFlashmobToArchive = array( 'webpage', 'school_name', 'school_webpage', 'school_city',
                          'flashmob_number_of_dancers', 'video_link_type', 'youtube_link', 'facebook_link', 'vimeo_link', 'embed_code', 'flashmob_address', 'longitude', 'latitude' );
    $this->aMetaFields = array_merge( $this->aMetaFieldsFlashmobToArchive, array(
                          'subscriber_type', 'preferences', 'flashmob_leader_tshirt_size', 'flashmob_leader_tshirt_gender',
                          'courses_city', 'courses_city_2', 'courses_city_3', 'courses_info', 'courses_info_2', 'courses_info_3', 'courses_in_city_2', 'courses_in_city_3' ) );
    $this->aFlashmobMetaFieldsToClean = array(
                          'subscriber_type:flashmob_organizer', 'flashmob_number_of_dancers', 'video_link_type', 'youtube_link', 'facebook_link', 'vimeo_link', 'embed_code', 'flashmob_address', 'longitude', 'latitude',
                          'preferences:flashmob_leader_tshirt', 'flashmob_leader_tshirt_size', 'flashmob_leader_tshirt_gender' );
    $this->aLocationFields = array(
      'flashmob_organizer'  => array( "school_city", "flashmob_address", "longitude", "latitude" ),
      'teacher'             => array( "school_city", "courses_city", "courses_city_2", "courses_city_3" ),
    );
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
        'height'       => 590,
        'disable_zoom' => 1,
      ),
      'og_map'    => array(
        'zoom'      => 7,
        'maptype'   => 'roadmap',
        'center'    => '48.72,19.7',
        'size'      => '640x320',
        'key'       => $this->aOptions['strGoogleMapsKeyStatic'],
      ),
      'og_map_image_alt'  => "Mapka registrovaných organizátorov rueda flashmobu na Slovensku",
      'fb_app_id'         => $this->aOptions['strFbAppID'],
    );
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

  private function set_variables() {
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
    $this->iFlashmobTimestamp = intval(mktime( $this->aOptions['iFlashmobHour'] - $iTimeZoneOffset, $this->aOptions['iFlashmobMinute'], 0, $this->aOptions['iFlashmobMonth'], $this->aOptions['iFlashmobDay'], $this->aOptions['iFlashmobYear'] ));

    $iNow = time();
    if ($this->iFlashmobTimestamp < $iNow) {
      $this->bHideFlashmobFields = false;
    } else {
      $this->bHideFlashmobFields = true;
    }

    $this->set_variables_per_subsite();
  }

  private function set_variables_per_subsite() {
    $iCurrentBlogID = get_current_blog_id();
    $this->isMainBlog = ($iCurrentBlogID == $this->iMainBlogID);
    $this->isFlashmobBlog = ($iCurrentBlogID == $this->iFlashmobBlogID);
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
        $aNotices[] = array( 'warning' => 'Could not re-enable media files download: could not remove HTACCESS file.');
        break;
      case 'htaccess_revert_failed':
        $aNotices[] = array( 'warning' => 'Could not re-enable media files download: could not rename old HTACCESS file to <code>.htaccess</code>.');
        break;
      case 'htaccess_rename_failed':
        $aNotices[] = array( 'warning' => 'Could not prevent media files download: could not rename HTACCESS file.');
        break;
      case 'htaccess_save_failed':
        $aNotices[] = array( 'warning' => 'Could not prevent media files download: could not save HTACCESS file.');
        break;
      case 'florp_devel_is_on':
        $aNotices[] = array( 'warning' => 'FLORP_DEVEL constant is on. Contact your site admin if you think this is not right!' );
        if (defined('FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION') && FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION === true) {
          $aNotices[] = array( 'warning' => 'Flashmob organizer map archivation is off!' );
        }
        break;
      case 'florp_devel_purge_participants_save_is_on':
        $aNotices[] = array( 'warning' => 'FLORP_DEVEL_PURGE_PARTICIPANTS_ON_SAVE constant is on. Contact your site admin if you think this is not right!' );
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

  private function prevent_direct_media_downloads() {
    if (!current_user_can('administrator') || !is_admin()) {
      return;
    }

    $strHtaccessPath = WP_CONTENT_DIR . "/.htaccess";
    if (!$this->aOptions['bPreventDirectMediaDownloads']) {
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

    $strComment = '# FLORP: Prevent direct download of media files';
    if (file_exists($strHtaccessPath)) {
      $strContents = file_get_contents( $strHtaccessPath );
      if (false !== strpos( $strContents, $strComment )) {
        // OK //
        return;
      } else {
        $bRes = rename( $strHtaccessPath, $strHtaccessPath.'.old-'.date('Ymd-His'));
        if (!$bRes) {
          // Show error message
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
    $aSites = wp_get_sites();
    $strProtocol = is_ssl() ? 'https' : 'http';
    foreach ( $aSites as $i => $aSite ) {
      if ($aSite['public'] != 1 || $aSite['deleted'] == 1 || $aSite['archived'] == 1) {
        continue;
      }
      $aMediaDlPreventionRuleLines[] = "  RewriteCond %{HTTP_REFERER} !^{$strProtocol}://{$aSite['domain']}$ [NC]";
      $aMediaDlPreventionRuleLines[] = "  RewriteCond %{HTTP_REFERER} !^{$strProtocol}://{$aSite['domain']}/.*$ [NC]";
    }
    $aMediaDlPreventionRuleLines = array_merge($aMediaDlPreventionRuleLines, array(
      "  RewriteRule ^.* - [F,L]",
      "</IfModule>",
    ));
    $strMediaDlPreventionRules = implode( PHP_EOL, $aMediaDlPreventionRuleLines );

    $bRes = file_put_contents( $strHtaccessPath, $strMediaDlPreventionRules );
    if (false === $bRes || !file_exists($strHtaccessPath)) {
      // Show error message
      add_action( 'admin_notices', array( $this, 'action__admin_notices__htaccess_save_failed' ));
      return;
    }

    return;
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

    $aRequestArgs = array(
      'method' => 'POST',
      'timeout' => 15,
//       'redirection' => 5,
//       'httpversion' => '1.0',
//       'blocking' => true,
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
    if (is_admin() && current_user_can( 'activate_plugins' ) && defined('FLORP_DEVEL_PURGE_PARTICIPANTS_ON_SAVE') && FLORP_DEVEL_PURGE_PARTICIPANTS_ON_SAVE === true) {
      add_action( 'admin_notices', array( $this, 'action__admin_notices__florp_devel_purge_participants_save_is_on' ));
    }
  }

  public function action__admin_notices__lwa_is_active() {
    echo $this->get_admin_notices('lwa_is_active');
  }

  public function action__admin_notices__florp_devel_is_on() {
    echo $this->get_admin_notices('florp_devel_is_on');
  }

  public function action__admin_notices__florp_devel_purge_participants_save_is_on() {
    echo $this->get_admin_notices('florp_devel_purge_participants_save_is_on');
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

    if ($this->isMainBlog) {
      // Settings specific to the NF on the Flashmob Blog //

      // Replace flashmob date/time in preference['flashmob_organizer] checkbox //
      if ('listcheckbox' === $aField['settings']['type'] && 'subscriber_type' === $aField['settings']['key']) {
        $aPatterns = array(
          '~{flashmob_date(\[[^\]]*\])?}~' => get_option('date_format'),
          '~{flashmob_time(\[[^\]]*\])?}~' => get_option('time_format'),
        );
        foreach ($aField['settings']['options'] as $key => $aOptions) {
          if ($aOptions['value'] !== 'flashmob_organizer') {
            continue;
          }
          foreach ($aPatterns as $strPattern => $strDefaultFormat) {
            $aMatches = array();
            if (preg_match_all( $strPattern, $aOptions['label'], $aMatches )) {
              foreach ($aMatches[0] as $iKey => $strMatchFull) {
                if (empty($aMatches[1][$iKey])) {
                  $strFormat = $strDefaultFormat;
                } else {
                  $strFormat = trim($aMatches[1][$iKey], "[]");
                }
                $strTimeOrDate = date( $strFormat, $this->iFlashmobTimestamp );
                $aField['settings']['options'][$key]['label'] = str_replace( $strMatchFull, $strTimeOrDate, $aField['settings']['options'][$key]['label'] );
              }
            }
          }
        }
      }

      if ($bLoggedIn) {
        $iUserID = get_current_user_id();
        $aSubscriberTypesOfUser = (array) get_user_meta( $iUserID, 'subscriber_type', true );
        $aPreferencesOfUser = (array) get_user_meta( $iUserID, 'preferences', true );

        if ('listcheckbox' === $aField['settings']['type'] && 'subscriber_type' === $aField['settings']['key']) {
          foreach ($aField['settings']['options'] as $iOptionKey => $aOption) {
            $strValue = $aOption['value'];
            if (in_array($strValue, $aSubscriberTypesOfUser)) {
              $aField['settings']['options'][$iOptionKey]['selected'] = 1;
            }
          }
        } elseif ('listcheckbox' === $aField['settings']['type'] && 'preferences' === $aField['settings']['key']) {
          foreach ($aField['settings']['options'] as $iOptionKey => $aOption) {
            $strValue = $aOption['value'];
            if (in_array($strValue, $aPreferencesOfUser)) {
              $aField['settings']['options'][$iOptionKey]['selected'] = 1;
            }
          }
        }

        // Set checked as default value on checkboxes saved as checked //
        if ($aField['settings']['type'] === 'checkbox') {
          $strValue = get_user_meta( $iUserID, $aField['settings']['key'], true );
          $aField['settings']['default_value'] = ($strValue == '1') ? 'checked' : 'unchecked';
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
          if (count($aSubscriberTypesOfUser) === 2 && stripos($aField['settings']['container_class'], 'florp-togglable-field_all') !== false) {
            $bHide = false;
          } elseif (stripos($aField['settings']['container_class'], 'florp-registration-field') !== false
                  || stripos($aField['settings']['container_class'], 'florp-profile-field') !== false) {
            $bHide = false;
          } else {
            // Go through subscriber types of user and leave field unhidden if matched //
            foreach ($aSubscriberTypesOfUser as $strSubscriberType) {
              if (stripos($aField['settings']['container_class'], 'florp-togglable-field_'.$strSubscriberType) !== false
                  || stripos($aField['settings']['container_class'], 'florp-togglable-field_any') !== false) {
                $bHide = false;
                break;
              }
            }
          }
          // Go through prefereneces of user and leave field unhidden if matched //
          foreach ($aPreferencesOfUser as $strPreference) {
            if (stripos($aField['settings']['container_class'], 'florp-preference-field_'.$strPreference) !== false) {
              $bHide = false;
              break;
            }
          }
          if ($bHide) {
            $aField['settings']['container_class'] .= " hidden";
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
      // Hide fields //
      $bHide = true;
      if (stripos($aField['settings']['container_class'], 'florp-registration-field') !== false
            || stripos($aField['settings']['container_class'], 'florp-profile-field') !== false) {
        $bHide = false;
      }
      if ($bHide) {
        $aField['settings']['container_class'] .= " hidden";
      }
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
        $aNewSettingsByType['profile'] = array(
          'text' => $bUserLoggedIn ? $this->aOptions['strLoginBarLabelProfile'] : $this->aOptions['strLoginBarLabelLogin'],
          'link' => get_permalink( $this->iProfileFormPageIDMain ),
          'el_class' => 'florp_profile_link_profile',
        );
      }
    }

    if ($bUserLoggedIn) {
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
    if ($this->isMainBlog) {
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

    $iUserID = get_current_user_id();
    $aSubscriberTypesOfUser = (array) get_user_meta( $iUserID, 'subscriber_type', true );
    if (!is_array($aSubscriberTypesOfUser) || !in_array( 'flashmob_organizer', $aSubscriberTypesOfUser )) {
      return '<p>Neorganizujete flashmob ' .  date( 'j.n.Y', $this->iFlashmobTimestamp ) . '.</p>';
    }
    $aParticipants = $this->get_flashmob_participants( $iUserID, false );
    if (empty($aParticipants)) {
      return '<p>Zatiaľ nemáte prihlásených účastníkov.</p>';
    }
    $aParticipantsOfUser = $aParticipants[$iUserID];
    if (empty($aParticipantsOfUser)) {
      return '<p>Zatiaľ nemáte prihlásených účastníkov.</p>';
    }

    return $this->get_leader_participants_table( $aParticipantsOfUser, false );
  }

  public function popup_anchor( $aAttributes ) {
    return '<a name="'.$this->strClickTriggerAnchor.'"></a>';
  }

  private function getFlashmobSubscribers( $strType, $bPending = false ) {
    if ($bPending) {
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
    if ($bPending) {
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
        update_site_option( $this->strOptionKey, $this->aOptions, true );
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
    update_site_option( $this->strOptionKey, $this->aOptions, true );
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
      $sTblAtt = ' class="florp-leader-participants-table"';
      $sThAtt = ' class="florp-leader-participants-hcell"';
      $sTdAtt = ' class="florp-leader-participants-cell"';
    }
    $aReplacements = array(
      'gender' => array(
        'from'  => array( 'muz', 'zena', 'par' ),
        'to'    => array( 'muž', 'žena', 'pár' )
      ),
      'dance_level' => array(
        'from'  => array( 'zaciatocnik', 'pokrocily', 'ucitel' ),
        'to'    => array( 'začiatočník', 'pokročilý', 'učiteľ' )
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
      $aMapOptionsArray = $this->get_flashmob_map_options_array($iIsCurrentYear === 1, $mixYear);
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
//       $aMapOptionsArray['info'] = "byYear";
    } else {
      $aMapOptionsArray = array();
//       $aMapOptionsArray['info'] = "empty";
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
    $this->aOptions['aParticipants'] = array();
    update_site_option( $this->strOptionKey, $this->aOptions, true );

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
      $strBlogType = 'main';
    } elseif ($this->isFlashmobBlog) {
      $strBlogType = 'flashmob';
    } else {
      $strBlogType = 'other';
    }

    if ($this->isMainBlog && is_user_logged_in() && $this->get_flashmob_participant_count( get_current_user_id() ) > 0) {
      $iHasParticipants = 1;
    } else {
      $iHasParticipants = 0;
    }

    $aJS = array(
      'hide_flashmob_fields'          => $this->bHideFlashmobFields ? 1 : 0,
      'reload_ok_submission'          => $bReloadAfterSuccessfulSubmission ? 1 : 0,
      'using_og_map_image'            => $this->aOptions['bUseMapImage'] ? 1 : 0,
      'blog_type'                     => $strBlogType,
      'reload_ok_cookie'              => 'florp-form-saved',
      'florp_trigger_anchor'          => $this->strClickTriggerAnchor,
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
      'logging_in_msg'                => $this->aOptions['strRegistrationSuccessfulMessage'],
      'popup_id'                      => $iPopupID,
      'load_maps_lazy'                => $this->aOptions['bLoadMapsLazy'] ? 1 : 0,
      'load_maps_async'               => $this->aOptions['bLoadMapsAsync'] ? 1 : 0,
      'load_videos_lazy'              => $this->aOptions['bLoadVideosLazy'] ? 1 : 0,
      'has_participants'              => $iHasParticipants,
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
    if ($this->isMainBlog) {
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
    }
  }

  public function leaders_table_admin() {
    echo "<div class=\"wrap\"><h1>" . "Zoznam lídrov" . "</h1>";
    $aUsers = $this->getFlashmobSubscribers( 'all', true );
    $aEcho = '<table class="widefat striped"><th>Meno</th><th>Email</th><th>Mesto</th><th>Preferencie</th><th>Profil</th><th>Účastníci</th>';
    foreach ($aUsers as $oUser) {
      $aAllMeta = array_map(
        function( $a ){
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
        },
        get_user_meta( $oUser->ID )
      );
      $strIsPending = "";
      if (in_array( $this->strUserRolePending, (array) $oUser->roles )) {
        $strIsPending = " ({$this->strUserRolePendingName})";
      }
      $aEcho .= '<tr>';
      $aEcho .=   '<td>'.$oUser->first_name.' '.$oUser->last_name.$strIsPending.'</td>';
      $aEcho .=   '<td><a name="'.$oUser->ID.'">'.$oUser->user_email.'</a></td>';
      $aEcho .=   '<td>'.$aAllMeta['school_city'].'</td>';
      $aEcho .=   '<td>';
      if (is_array($aAllMeta['subscriber_type'])) {
        foreach ($aAllMeta['subscriber_type'] as $strSubscriberType) {
          $aEcho .= str_replace(
            array('flashmob_organizer', 'teacher'),
            array('Zorganizuje Flashmob', 'Učí kurzy'),
            $strSubscriberType
          ).'<br>';
        }
      }
      $aEcho .=   '</td>';
      $aEcho .=   '<td>';
      $aCoursesInfoKeys = array( 'courses_info', 'courses_info_2', 'courses_info_3' );
      $aSingleCheckboxes = array( 'courses_in_city_2', 'courses_in_city_3' );
      foreach ($this->aMetaFields as $strMetaKey) {
        if (!isset($aAllMeta[$strMetaKey]) || (!is_bool($aAllMeta[$strMetaKey]) && !is_numeric($aAllMeta[$strMetaKey]) && empty($aAllMeta[$strMetaKey])) || $aAllMeta[$strMetaKey] === 'null' || $strMetaKey === 'subscriber_type') {
          continue;
        }

        if (in_array( $strMetaKey, $aCoursesInfoKeys )) {
          continue;
        }

        if (is_array($aAllMeta[$strMetaKey])) {
          $strValue = implode( ', ', $aAllMeta[$strMetaKey]);
        } elseif (in_array($strMetaKey, $aSingleCheckboxes) || is_bool($aAllMeta[$strMetaKey])) {
          $strValue = $aAllMeta[$strMetaKey] ? '<input type="checkbox" disabled checked />' : '<input type="checkbox" disabled />';
        } else {
          $strValue = $aAllMeta[$strMetaKey];
        }
        $strFieldName = ucfirst( str_replace( '_', ' ', $strMetaKey ) );
        if (stripos( $strValue, 'https://' ) === 0 || stripos( $strValue, 'http://' ) === 0) {
          $aEcho .= '<a href="'.$strValue.'" target="_blank">'.$strFieldName.'</a><br>';
        } else {
          $aEcho .= '<strong>' . $strFieldName . '</strong>: ' . $strValue.'<br>';
        }
      }
      $aEcho .=   '</td>';
      $aEcho .=   '<td>';
      $aParticipants = $this->get_flashmob_participants( $oUser->ID, false, true );
      if (!empty($aParticipants)) {
        $aParticipantsOfUser = $aParticipants[$oUser->ID];
        if (!empty($aParticipantsOfUser)) {
          foreach ($aParticipantsOfUser as $strEmail => $aParticipantData) {
            $aEcho .= "<a href=\"".admin_url('admin.php?page=florp-participants')."#{$aParticipantData['user_email']}\">{$aParticipantData['first_name']} {$aParticipantData['last_name']}</a><br>";
          }
        }
      }
      $aEcho .=   '</td>';
      $aEcho .= '</tr>';
    }
    $aEcho .= '</table>';
    echo $aEcho;
    echo '</div><!-- .wrap -->';
  }

  public function participants_table_admin() {
    echo "<div class=\"wrap\"><h1>" . "Zoznam účastníkov" . "</h1>";
    $aEcho = '<table class="widefat striped"><th>Meno</th><th>Email</th><th>Mesto</th><th>Líder</th><th>Pohlavie</th><th>Tanečná úroveň</th><th>Profil</th>';
    $aParticipants = $this->get_flashmob_participants( 0, false, true );
    $aReplacements = array(
      'gender' => array(
        'from'  => array( 'muz', 'zena', 'par' ),
        'to'    => array( 'muž', 'žena', 'pár' )
      ),
      'dance_level' => array(
        'from'  => array( 'zaciatocnik', 'pokrocily', 'ucitel' ),
        'to'    => array( 'začiatočník', 'pokročilý', 'učiteľ' )
      )
    );
    foreach ($aParticipants as $iLeaderID => $aParticipantsOfLeader) {
      foreach ($aParticipantsOfLeader as $strEmail => $aParticipantData) {
        foreach ($aReplacements as $strKey => $aReplacementArr) {
          $aParticipantData[$strKey] = str_replace( $aReplacementArr['from'], $aReplacementArr['to'], $aParticipantData[$strKey]);
        }
        $aEcho .= '<tr>';
        $aEcho .=   '<td>'.$aParticipantData['first_name'].' '.$aParticipantData['last_name'].'</td>';
        $aEcho .=   '<td><a name="'.$aParticipantData['user_email'].'">'.$aParticipantData['user_email'].'</a></td>';
        $aEcho .=   '<td>'.$aParticipantData['flashmob_city'].'</td>';
        $oLeader = get_user_by( 'id', $iLeaderID );
        $strIsPending = "";
        if (in_array( $this->strUserRolePending, (array) $oLeader->roles )) {
          $strIsPending = " ({$this->strUserRolePendingName})";
        }
        $aEcho .=   '<td><a href="'.admin_url('admin.php?page=florp-leaders')."#{$iLeaderID}\">{$oLeader->first_name} {$oLeader->last_name}</a>{$strIsPending}</td>";
        $aEcho .=   '<td>'.$aParticipantData['gender'].'</td>';
        $aEcho .=   '<td>'.$aParticipantData['dance_level'].'</td>';
        $aEcho .=   '<td>';
        $aSkip = array( 'first_name', 'last_name', 'user_email', 'flashmob_city', 'leader_user_id', 'dance_level', 'gender' );
        if (!isset($aParticipantData['leader_notified'])) {
          $aParticipantData['leader_notified'] = false;
        }
        foreach ($aParticipantData as $strKey => $mixValue) {
          if (!isset($mixValue) || (!is_bool($mixValue) && !is_numeric($mixValue) && empty($mixValue)) || $mixValue === 'null' || in_array( $strKey, $aSkip )) {
            continue;
          }
          if (is_array($mixValue)) {
            $strValue = implode( ', ', $mixValue);
          } elseif (is_bool($mixValue)) {
            $strValue = $mixValue ? '<input type="checkbox" disabled checked />' : '<input type="checkbox" disabled />';
          } else {
            $strValue = $mixValue;
          }
          $strFieldName = ucfirst( str_replace( '_', ' ', $strKey ) );
          $aEcho .= '<strong>' . $strFieldName . '</strong>: ' . $strValue.'<br>';
        }
        $aEcho .=   '</td>';
        $aEcho .= '</tr>';
      }
    }
    $aEcho .= '</table>';
    echo $aEcho;
    echo '</div><!-- .wrap -->';
  }

  public function options_page() {
    // echo "<h1>" . __("Flashmob Organizer Profile Options", "florp" ) . "</h1>";
    echo "<div class=\"wrap\"><h1>" . "Nastavenia profilu organizátora slovenského flashmobu" . "</h1>";

    if (isset($_POST['save-florp-options'])) {
      $this->save_option_page_options($_POST);
    }

    $optionNone = '<option value="0">Žiadny</option>';
    $optionNoneF = '<option value="0">Žiadna</option>';

    $optionsFlashmobSite = '';
    $optionsMainSite = '';
    $optionsNewsletterSite = $optionNoneF;
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
      if ($this->aOptions['iNewsletterBlogID'] == $iID) {
        $strSelectedNewsletterSite = 'selected="selected"';
      } else {
        $strSelectedNewsletterSite = '';
      }
      $optionsFlashmobSite .= '<option value="'.$iID.'" '.$strSelectedFlashmobSite.'>'.$strTitle.'</option>';
      $optionsMainSite .= '<option value="'.$iID.'" '.$strSelectedMainSite.'>'.$strTitle.'</option>';
      $optionsNewsletterSite .= '<option value="'.$iID.'" '.$strSelectedNewsletterSite.'>'.$strTitle.'</option>';
    }

    if (!$this->isMainBlog && strlen($strMainBlogDomain) > 0) {
      echo "<p>Spoločné nastavenia a nastavenia pre hlavnú stránku sú <a href=\"http://{$strMainBlogDomain}/wp-admin/admin.php?page=florp-main\">tu</a>.</p>";
    }
    if (!$this->isFlashmobBlog && strlen($strFlashmobBlogDomain) > 0) {
      echo "<p>Nastavenia pre flashmobovú stránku sú <a href=\"http://{$strFlashmobBlogDomain}/wp-admin/admin.php?page=florp-main\">tu</a>.</p>";
    }
    if (!$this->isMainBlog && !$this->isFlashmobBlog) {
      echo "</div><!-- .wrap -->";
      return;
    }

    if (defined('FLORP_DEVEL') && FLORP_DEVEL === true) {
      // echo "<pre>" .var_export($this->aOptions, true). "</pre>";
      // echo "<pre>" .var_export(array_merge($this->aOptions, array('aYearlyMapOptions' => 'removedForPreview', 'aParticipants' => 'removedForPreview')), true). "</pre>";
      // $aMapOptions = $this->get_flashmob_map_options_array(false, 0);
      // echo "<pre>" .var_export($aMapOptions, true). "</pre>";
      // echo "<pre>" .var_export($this->getFlashmobSubscribers('subscriber_only'), true). "</pre>";
      // echo "<pre>" .var_export($this->getFlashmobSubscribers('flashmob_organizer'), true). "</pre>";
      // echo "<pre>" .var_export($this->getFlashmobSubscribers('teacher'), true). "</pre>";
      // echo "<pre>" .var_export($this->getFlashmobSubscribers('all'), true). "</pre>";
      // echo "<pre>" .var_export($this->get_flashmob_map_options_array_to_archive(), true). "</pre>";
      // $this->delete_logs();
      // echo "<pre>" .var_export($this->get_logs(), true). "</pre>";
      // foreach($this->aOptions['aParticipants'] as $i => $a) {foreach($a as $e => $ap) {$this->aOptions['aParticipants'][$i][$e]['leader_notified']=false;}}; update_site_option( $this->strOptionKey, $this->aOptions, true );
      // echo "<pre>" .var_export($this->aOptions['aParticipants'], true). "</pre>";
    }

    $aBooleanOptionsChecked = array();
    foreach ($this->aBooleanOptions as $strOptionKey) {
      if ($this->aOptions[$strOptionKey] === true) {
        $aBooleanOptionsChecked[$strOptionKey] = 'checked="checked"';
      } else {
        $aBooleanOptionsChecked[$strOptionKey] = '';
      }
    }

    $aVariablesMain = array(
      'optionsMainSite' => $optionsMainSite,
      'optionNone' => $optionNone,
      'optionNoneF' => $optionNoneF,
      'aBooleanOptionsChecked' => $aBooleanOptionsChecked,
    );
    $aVariablesFlashmob = array(
      'optionsFlashmobSite' => $optionsFlashmobSite,
      'optionNone' => $optionNone,
      'optionNoneF' => $optionNoneF,
      'aBooleanOptionsChecked' => $aBooleanOptionsChecked,
    );
    $aVariablesCommon = array(
      'aBooleanOptionsChecked' => $aBooleanOptionsChecked,
      'optionsNewsletterSite' => $optionsNewsletterSite,
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

    $optionsPagesMain = $optionNoneF;
    $aPages = get_pages();
    foreach ($aPages as $oPage) {
      $iID = $oPage->ID;
      $strTitle = $oPage->post_title;
      if (function_exists('pll_get_post_language')) {
        $strLang = pll_get_post_language( $iID, 'name' );
        $strTitle .= " ({$strLang})";
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
        '%%strLoginBarLabelLogin%%', '%%strLoginBarLabelLogout%%', '%%strLoginBarLabelProfile%%' ),
      array( $aBooleanOptionsChecked['bReloadAfterSuccessfulSubmissionMain'],
        $optionsNinjaFormsMain,
        $optionsPopupsMain,
        $optionsMainSite,
        $optionsPagesMain,
        $strBeforeLoginFormHtmlMain,
        $aBooleanOptionsChecked['bApproveUsersAutomatically'], $wpEditorPendingUserPageContentHTML, $wpEditorUserApprovedMessage,
        $this->aOptions['strRegistrationSuccessfulMessage'], $this->aOptions['strLoginSuccessfulMessage'], $this->aOptions['strUserApprovedSubject'],
        $this->aOptions['strNewsletterListsMain'], $this->aOptions['strLeaderParticipantListNotificationSbj'], $wpEditorLeaderParticipantListNotificationMsg,
        $this->aOptions['strLoginBarLabelLogin'], $this->aOptions['strLoginBarLabelLogout'], $this->aOptions['strLoginBarLabelProfile'] ),
      '
            <tr style="width: 98%; padding:  5px 1%;">
              <th colspan="2"><h3>Hlavná stránka</h3></th>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_main_blog_id">Podstránka</label></th>
              <td>
                <select id="florp_main_blog_id" name="florp_main_blog_id" style="width: 100%;">%%optionsMainSite%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_profile_form_ninja_form_id_main">Registračný / profilový formulár (spomedzi Ninja Form formulárov)</label></th>
              <td>
                <select id="florp_profile_form_ninja_form_id_main" name="florp_profile_form_ninja_form_id_main" style="width: 100%;">%%optionsNinjaFormsMain%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_profile_form_page_id_main">Dedikovaná profilová stránka (v ktorej je registračný / profilový formulár)</label></th>
              <td>
                <select id="florp_profile_form_page_id_main" name="florp_profile_form_page_id_main" style="width: 100%;">%%optionsPagesMain%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_profile_form_popup_id_main">PUM Popup, v ktorom je registračný / profilový formulár</label></th>
              <td>
                <select id="florp_profile_form_popup_id_main" name="florp_profile_form_popup_id_main" style="width: 100%;">%%optionsPopupsMain%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th colspan="2">
                <span style="font-size: smaller;">Ak je na stránke s PUM Popup-om element <code>#florp-popup-scroll</code>, pri zatvorení PUM Popup-u sa stránka scrollne na tento element.</span>
              </th>
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
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                HTML text zobrazený nad prihlasovacím (resp. registračným) formulárom
              </th>
              <td style="border-top: 1px lightgray dashed;">
                %%wpEditorBeforeLoginFormHtmlMain%%
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                Správa zobrazená po úspešnej registrácii (pred prihlásením)
              </th>
              <td style="border-top: 1px lightgray dashed;">
                <input id="florp_registration_successful_message" name="florp_registration_successful_message" type="text" value="%%strRegistrationSuccessfulMessage%%" style="width: 100%;" />
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Správa zobrazená po úspešnom prihlásení
              </th>
              <td>
                <input id="florp_login_successful_message" name="florp_login_successful_message" type="text" value="%%strLoginSuccessfulMessage%%" style="width: 100%;" />
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                <label for="florp_approve_users_automatically">Schváliť registrovaných používateľov automaticky?</label>
              </th>
              <td style="border-top: 1px lightgray dashed;">
                <input id="florp_approve_users_automatically" name="florp_approve_users_automatically" type="checkbox" %%approveUsersAutomaticallyChecked%% value="1"/>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Správa zobrazená prihláseným užívateľom, čakajúcim na schválenie
              </th>
              <td style="border-top: 1px lightgray dashed;">
                %%wpEditorPendingUserPageContentHTML%%
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Predmet správy poslanej užívateľom po schválení
              </th>
              <td style="border-top: 1px lightgray dashed;">
                <input id="florp_user_approved_subject" name="florp_user_approved_subject" type="text" value="%%strUserApprovedSubject%%" style="width: 100%;" />
                <span style="width: 100%;">Placeholdre: <code>%BLOGNAME%</code>, <code>%BLOGURL%</code></span>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Správa poslaná užívateľom po schválení
              </th>
              <td style="border-top: 1px lightgray dashed;">
                %%wpEditorUserApprovedMessage%%
                <span style="width: 100%;">Placeholdre: <code>%BLOGNAME%</code>, <code>%BLOGURL%</code>, <code>%USERNAME%</code>, <code>%EMAIL%</code>, <code>%PROFILE_URL%</code></span>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                Newsletter zoznamy (oddelené čiarkou)
              </th>
              <td style="border-top: 1px lightgray dashed;">
                <input id="florp_newsletter_lists_main" name="florp_newsletter_lists_main" type="text" value="%%strNewsletterListsMain%%" style="width: 100%;" />
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                Predmet správy poslanej lídrom raz za deň o prihlásených účastníkoch flashmobu
              </th>
              <td style="border-top: 1px lightgray dashed;">
                <input id="florp_leader_participant_list_notif_sbj" name="florp_leader_participant_list_notif_sbj" type="text" value="%%strLeaderParticipantListNotificationSbj%%" style="width: 100%;" />
                <span style="width: 100%;">Placeholdre: <code>%BLOGNAME%</code>, <code>%BLOGURL%</code></span>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Správa poslaná lídrom raz za deň o prihlásených účastníkoch flashmobu
              </th>
              <td style="border-top: 1px lightgray dashed;">
                %%wpEditorLeaderParticipantListNotificationMsg%%
                <span style="width: 100%;">Placeholdre: <strong><code>%PARTICIPANT_LIST%</code></strong>, <code>%BLOGNAME%</code>, <code>%BLOGURL%</code>, <code>%USERNAME%</code>, <code>%EMAIL%</code>, <code>%PROFILE_URL%</code></span>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                Text linky prihlasovacieho formulára
              </th>
              <td style="border-top: 1px lightgray dashed;">
                <input id="florp_login_bar_label_login" name="florp_login_bar_label_login" type="text" value="%%strLoginBarLabelLogin%%" style="width: 100%;" />
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Text linky na odhlásenie
              </th>
              <td>
                <input id="florp_login_bar_label_logout" name="florp_login_bar_label_logout" type="text" value="%%strLoginBarLabelLogout%%" style="width: 100%;" />
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Text linky profilu (keď je líder prihlásený)
              </th>
              <td>
                <input id="florp_login_bar_label_profile" name="florp_login_bar_label_profile" type="text" value="%%strLoginBarLabelProfile%%" style="width: 100%;" />
              </td>
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

    $optionsPagesFlashmob = $optionNoneF;
    $aPages = get_pages();
    foreach ($aPages as $oPage) {
      $iID = $oPage->ID;
      $strTitle = $oPage->post_title;
      if (function_exists('pll_get_post_language')) {
        $strLang = pll_get_post_language( $iID, 'name' );
        $strTitle .= " ({$strLang})";
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
        '%%wpEditorParticipantRemovedMessage%%',
        '%%strParticipantRemovedSubject%%' ),
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
        $strParticipantRemovedMessage,
        $this->aOptions['strParticipantRemovedSubject'] ),
      '
            <tr style="width: 98%; padding:  5px 1%;">
              <th colspan="2"><h3>Flashmobová podstránka</h3></th>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_flashmob_blog_id">Podstránka</label></th>
              <td>
                <select id="florp_flashmob_blog_id" name="florp_flashmob_blog_id" style="width: 100%;">%%optionsFlashmobSite%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_profile_form_ninja_form_id_flashmob">Registračný / profilový formulár (spomedzi Ninja Form formulárov)</label></th>
              <td>
                <select id="florp_profile_form_ninja_form_id_flashmob" name="florp_profile_form_ninja_form_id_flashmob" style="width: 100%;">%%optionsNinjaFormsFlashmob%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_profile_form_page_id_flashmob">Dedikovaná profilová stránka (v ktorej je registračný / profilový formulár)</label></th>
              <td>
                <select id="florp_profile_form_page_id_flashmob" name="florp_profile_form_page_id_flashmob" style="width: 100%;">%%optionsPagesFlashmob%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_profile_form_popup_id_flashmob">PUM Popup, v ktorom je registračný / profilový formulár</label></th>
              <td>
                <select id="florp_profile_form_popup_id_flashmob" name="florp_profile_form_popup_id_flashmob" style="width: 100%;">%%optionsPopupsFlashmob%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th colspan="2">
                <span style="font-size: smaller;">Ak je na stránke s PUM Popup-om element <code>#florp-popup-scroll</code>, pri zatvorení PUM Popup-u sa stránka scrollne na tento element.</span>
              </th>
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
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                HTML text zobrazený nad prihlasovacím (resp. registračným) formulárom
              </th>
              <td style="border-top: 1px lightgray dashed;">
                %%wpEditorBeforeLoginFormHtmlFlashmob%%
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                Newsletter zoznamy (oddelené čiarkou)
              </th>
              <td style="border-top: 1px lightgray dashed;">
                <input id="florp_newsletter_lists_flashmob" name="florp_newsletter_lists_flashmob" type="text" value="%%strNewsletterListsFlashmob%%" style="width: 100%;" />
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                Predmet správy poslanej prihláseným účastníkom flashmobu
              </th>
              <td style="border-top: 1px lightgray dashed;">
                <input id="florp_participant_registered_subject" name="florp_participant_registered_subject" type="text" value="%%strParticipantRegisteredSubject%%" style="width: 100%;" />
                <span style="width: 100%;">Placeholdre: <code>%BLOGNAME%</code>, <code>%BLOGURL%</code></span>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Správa poslaná prihláseným účastníkom flashmobu
              </th>
              <td style="border-top: 1px lightgray dashed;">
                %%wpEditorParticipantRegisteredMessage%%
                <span style="width: 100%;">Placeholdre: <code>%BLOGNAME%</code>, <code>%BLOGURL%</code>, <code>%USERNAME%</code>, <code>%EMAIL%</code></span>
              </td>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                Predmet správy poslanej odstráneným účastníkom flashmobu
              </th>
              <td style="border-top: 1px lightgray dashed;">
                <input id="florp_participant_removed_subject" name="florp_participant_removed_subject" type="text" value="%%strParticipantRemovedSubject%%" style="width: 100%;" />
                <span style="width: 100%;">Placeholdre: <code>%BLOGNAME%</code>, <code>%BLOGURL%</code></span>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Správa poslaná odstráneným účastníkom flashmobu
              </th>
              <td style="border-top: 1px lightgray dashed;">
                %%wpEditorParticipantRemovedMessage%%
                <span style="width: 100%;">Placeholdre: <code>%BLOGNAME%</code>, <code>%BLOGURL%</code>, <code>%USERNAME%</code>, <code>%EMAIL%</code></span>
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
      array( '%%optionsNewsletterSite%%',
        '%%loadMapsAsyncChecked%%',
        '%%loadMapsLazyChecked%%',
        '%%loadVideosLazyChecked%%',
        '%%optionsYears%%', '%%optionsMonths%%', '%%optionsDays%%', '%%optionsHours%%', '%%optionsMinutes%%',
        '%%strGoogleMapsKey%%', '%%strGoogleMapsKeyStatic%%', '%%strFbAppID%%', '%%preventDirectMediaDownloadsChecked%%', '%%strNewsletterAPIKey%%' ),
      array( $optionsNewsletterSite,
        $aBooleanOptionsChecked['bLoadMapsAsync'],
        $aBooleanOptionsChecked['bLoadMapsLazy'],
        $aBooleanOptionsChecked['bLoadVideosLazy'],
        $aNumOptions['optionsYears'], $optionsMonths, $aNumOptions['optionsDays'], $aNumOptions['optionsHours'], $aNumOptions['optionsMinutes'],
        $this->aOptions['strGoogleMapsKey'], $this->aOptions['strGoogleMapsKeyStatic'], $this->aOptions['strFbAppID'], $aBooleanOptionsChecked['bPreventDirectMediaDownloads'], $this->aOptions['strNewsletterAPIKey'] ),
      '
            <tr style="width: 98%; padding:  5px 1%;">
              <th colspan="2"><h3>Spoločné nastavenia</h3></th>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;"><label for="florp_newsletter_blog_id">Podstránka, ktorá obsahuje newsletter</label></th>
              <td>
                <select id="florp_newsletter_blog_id" name="florp_newsletter_blog_id" style="width: 100%;">%%optionsNewsletterSite%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Newsletter API kľúč
              </th>
              <td>
                <input id="florp_newsletter_api_key" name="florp_newsletter_api_key" type="text" value="%%strNewsletterAPIKey%%" style="width: 100%;" />
              </td>
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
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Google Maps API Key
              </th>
              <td>
                <input id="florp_google_maps_key" name="florp_google_maps_key" type="text" value="%%strGoogleMapsKey%%" style="width: 100%;" />
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Google Maps Static API Key
              </th>
              <td>
                <input id="florp_google_maps_key_static" name="florp_google_maps_key_static" type="text" value="%%strGoogleMapsKeyStatic%%" style="width: 100%;" />
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Facebook app ID
              </th>
              <td>
                <input id="florp_fb_app_id" name="florp_fb_app_id" type="text" value="%%strFbAppID%%" style="width: 100%;" />
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                <label for="florp_prevent_direct_media_downloads">Zakázať priame stiahnutie mediálnych súborov (pomocou <code>.htaccess</code>)?</label>
              </th>
              <td>
                <input id="florp_prevent_direct_media_downloads" name="florp_prevent_direct_media_downloads" type="checkbox" %%preventDirectMediaDownloadsChecked%% value="1"/>
              </td>
            </tr>
      '
    );
  }

  private function save_option_page_options( $aPostedOptions ) {
    if ($this->isMainBlog) {
      $aKeysToSave = $this->aOptionKeysByBlog['main'];

      // Archive current flashmob year's data //
      if (!$this->bHideFlashmobFields) {
        // Trying to archive after the saved flashmob date //
        $iFlashmobYearCurrent = intval($this->aOptions['iFlashmobYear']);
        $iFlashmobYearNew = isset($aPostedOptions['florp_flashmob_year']) ? intval($aPostedOptions['florp_flashmob_year']) : $iFlashmobYearCurrent;
        if (isset($this->aOptions['aYearlyMapOptions'][$iFlashmobYearNew])) {
          // There is archived data for this flashmob year in the DB already //
          echo '<div class="notice notice-warning"><p>Rok flashmobu možno nastaviť len na taký, pre ktorý ešte nie sú archívne dáta v DB!</p></div>';
          return false;
        } elseif ($iFlashmobYearNew != $iFlashmobYearCurrent) {
          // Flashmob year was changed //
          if (defined('FLORP_DEVEL') && FLORP_DEVEL === true && defined('FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION') && FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION === true) {
            // NOT ARCHIVING //
            echo '<div class="notice notice-info"><p><code>(FLORP_DEVEL && FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION == true)</code> => nearchivujem flashmobové mapy.</p></div>';
          } else {
            $this->archive_current_year_map_options();
            echo '<div class="notice notice-info"><p>Dáta flashmobu z roku '.$iFlashmobYearCurrent.' boli archivované.</p></div>';
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
      } elseif (strpos($key, 'i') === 0) {
        $this->aOptions[$strOptionKey] = $val;
      } else {
        $this->aOptions[$strOptionKey] = stripslashes($val);
      }
    }
    if (defined('FLORP_DEVEL_PURGE_PARTICIPANTS_ON_SAVE') || FLORP_DEVEL_PURGE_PARTICIPANTS_ON_SAVE === true ) {
      $this->aOptions['aParticipants'] = array();
    }
    update_site_option( $this->strOptionKey, $this->aOptions, true );

    $this->set_variables();

    $this->export_ninja_form();

    $this->prevent_direct_media_downloads();

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
        'iBeforeFlashmob'   => $_POST['iBeforeFlashmob'],
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
      $strMapType = $_POST['strMapType'];
      if (!is_array($aSubscriberTypesOfUser) || !in_array( $strMapType, $aSubscriberTypesOfUser )) {
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
    if (empty($aInfoWindowData['flashmob_number_of_dancers']['value'])) {
      $strDancers = "";
    } else {
      $strDancers = "<br>Počet tancujúcich: ".$aInfoWindowData['flashmob_number_of_dancers']['value'];
    }
    $mixMarkerKey = $aInfoWindowData['mixMarkerKey'];
    if (isset($mixMarkerKey) && !is_numeric($mixMarkerKey)) {
      $strLocation = trim($aInfoWindowData[$mixMarkerKey]['value']);
      if ($strLocation === "null") {
        $strLocation = "";
      }
    } else {
      $strLocation = trim($aInfoWindowData['flashmob_address']['value']);
      if (empty($strLocation)) {
        $strLocation = trim($aInfoWindowData['school_city']['value']);
        if ($strLocation === "null") {
          $strLocation = "";
        }
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

    if ($aInfoWindowData['strMapType'] === 'flashmob_organizer' && $aInfoWindowData['iCurrentYear'] == '1' && $aInfoWindowData['iBeforeFlashmob'] == '1') {
      $strSignupLink = '<br><span class="florp-click-trigger florp-click-participant-trigger pum-trigger" data-user-id="'.$aInfoWindowData['iUserID'].'" data-flashmob-city="'.$aInfoWindowData['school_city']['value'].'" data-marker-key="'.$aInfoWindowData['mixMarkerKey'].'" data-div-id="'.$aInfoWindowData['strDivID'].'" style="cursor: pointer;">Chcem sa prihlásiť na tento flashmob!</span>';
      $strParticipantCount = '<br>Prihlásených účastníkov: '.$aInfoWindowData['iParticipantCount'];
    } else {
      $strSignupLink = "";
      $strParticipantCount = "";
    }

    $aSearch = array( 'flashmob_city', 'organizer', 'school', 'embed_code', 'dancers', 'year', 'note', 'courses_city' ,'courses_info', 'signup', 'participant_count' );
    foreach ($aSearch as $key => $value) {
      $aSearch[$key] = '%%'.$value.'%%';
    }
    switch ($mixMarkerKey) {
      case 'school_city':
      case 'courses_city':
        $strCoursesInfo = trim($aInfoWindowData['courses_info']["value"]);
        break;
      case 'courses_city_2':
        $strCoursesInfo = trim($aInfoWindowData['courses_info_2']["value"]);
        break;
      case 'courses_city_3':
        $strCoursesInfo = trim($aInfoWindowData['courses_info_3']["value"]);
        break;
      default:
        $strCoursesInfo = "";
    }
    // $strCoursesInfo = wpautop( $strCoursesInfo ); // Not needed, since we're using rich text editors //
    $aReplace = array( $strLocation, $strOrganizer, $strSchool, $strEmbedCode, $strDancers, $strYear, $strNote, $strLocation, $strCoursesInfo, $strSignupLink, $strParticipantCount );
    $strText = str_replace( $aSearch, $aReplace, $this->aMarkerInfoWindowTemplates[$aInfoWindowData['strMapType']] );
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

  private function add_log( $strKey, $mixContent ) {
    if (!isset($this->aOptions['logs'][$strKey])) {
      $this->aOptions['logs'][$strKey] = array();
    }
    $this->aOptions['logs'][$strKey] = array_merge( $this->aOptions['logs'][$strKey], (array) $mixContent );
    update_site_option( $this->strOptionKey, $this->aOptions, true );
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
    update_site_option( $this->strOptionKey, $this->aOptions, true );
  }

  private function get_logs() {
    return $this->aOptions['logs'];
  }

  private function delete_logs() {
    $this->aOptions['logs'] = array();
    update_site_option( $this->strOptionKey, $this->aOptions, true );
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

    if ($this->isFlashmobBlog && intval($aFormData['form_id']) === $this->iProfileFormNinjaFormIDFlashmob) {
      // Get field values by keys //
      $aFieldData = array();
      $aSkipFieldTypes = array( 'recaptcha_logged-out-only', 'recaptcha', 'submit', 'html', 'hr' );
      foreach ($aFormData["fields"] as $strKey => $aData) {
        if (in_array($aData['type'], $aSkipFieldTypes)) {
          continue;
        }
        $aFieldData[$aData["key"]] = $aData['value'];
      }
      $iUserID = $aFieldData['leader_user_id'];
      if (!isset($this->aOptions['aParticipants'][$iUserID])) {
        $this->aOptions['aParticipants'][$iUserID] = array();
      }
      if (!isset($aFieldData) || empty($aFieldData) || !in_array('flashmob_participant_tshirt', $aFieldData['preferences'])) {
        if (isset($aFieldData['flashmob_participant_tshirt_size'])) {
          unset($aFieldData['flashmob_participant_tshirt_size']);
        }
        if (isset($aFieldData['flashmob_participant_tshirt_gender'])) {
          unset($aFieldData['flashmob_participant_tshirt_gender']);
        }
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
      update_site_option( $this->strOptionKey, $this->aOptions, true );

      if (strlen(trim($this->aOptions['strParticipantRegisteredMessage'])) > 0) {
        $strMessageContent = $this->aOptions['strParticipantRegisteredMessage'];
        $strBlogname = trim(wp_specialchars_decode(get_option('blogname'), ENT_QUOTES));
        $aHeaders = array('Content-Type: text/html; charset=UTF-8');
        $this->new_user_notification( $aFieldData['user_email'], '', $aFieldData['user_email'], $strBlogname, $strMessageContent, $this->aOptions['strParticipantRegisteredSubject'], $aHeaders );
      }
      return;
    }

    if (!$this->isMainBlog || intval($aFormData['form_id']) !== $this->iProfileFormNinjaFormIDMain) {
      // Not the profile form (or the main site at all) //
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

    $strPreferencesKey = 'preferences';
    $strNewsletterSubscribePreferenceKey = 'newsletter_subscribe';
    $aPreferencesOfUser = (array) get_user_meta( $iUserID, $strPreferencesKey, true );
    $bNewsletterSubscribeOld = in_array( $strNewsletterSubscribePreferenceKey, $aPreferencesOfUser );

    $strSubscriberTypeKey = 'subscriber_type';
    $strFlashmobOrganizerKey = 'flashmob_organizer';
    $aSubscriberTypesOfUser = (array) get_user_meta( $iUserID, $strSubscriberTypeKey, true );
    $bIsFlashmobOrganizerOld = in_array( $strFlashmobOrganizerKey, $aSubscriberTypesOfUser );

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

      // Remove participants of organizer if they decide not to organize a flashmob //
      if (isset($aMetaData[$strSubscriberTypeKey])) {
        $bIsFlashmobOrganizerNew = in_array( $strFlashmobOrganizerKey, (array) $aMetaData[$strSubscriberTypeKey] );
      } else {
        $bIsFlashmobOrganizerNew = false;
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
        update_site_option( $this->strOptionKey, $this->aOptions, true );
      }

      // Subscribe or unsubscribe to/from newsletter via REST API //
      if (isset($aMetaData[$strPreferencesKey])) {
        $bNewsletterSubscribeNew = in_array( $strNewsletterSubscribePreferenceKey, (array) $aMetaData[$strPreferencesKey] );
      } else {
        $bNewsletterSubscribeNew = false;
      }
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
          $aRevertedPreferences = $aMetaData[$strPreferencesKey];
          if ($bNewsletterSubscribeNew) {
            $iKey = array_search( $strNewsletterSubscribePreferenceKey, $aRevertedPreferences );
            unset( $aRevertedPreferences[$iKey] );
          } else {
            $aRevertedPreferences[] = $strNewsletterSubscribePreferenceKey;
          }
          update_user_meta( $iUserID, $strPreferencesKey, $aRevertedPreferences );
        } elseif (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
          file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-ok.log", var_export( $bResult, true ) );
        }
      } elseif (defined('FLORP_DEVEL_REST_API_DEBUG') && FLORP_DEVEL_REST_API_DEBUG === true) {
        file_put_contents( __DIR__ . "/kk-debug-after-submission-newsletter-rest-api-check.log", var_export( array(
          'old' => $aPreferencesOfUser,
          'new-userdata' => $aUserData,
          'new-metadata' => $aMetaData,
        ), true ) );
      }
    }
    setcookie('florp-form-saved', "1", time() + (1 * 24 * 60 * 60), '/');
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
    } elseif ($this->isFlashmobBlog) {
      echo $this->strBeforeLoginFormHtmlFlashmob;
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

  public function get_message( $strKey = false, $strDefault = "" ) {
    $aMessages = array(
      'login_success' => $this->aOptions['strLoginSuccessfulMessage'],
      'registration_success' => $this->aOptions['strRegistrationSuccessfulMessage'],
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

  public function activate() {
    $this->maybe_add_crons();
  }

  public function deactivate() {
    if (get_role($this->strUserRolePending)) {
      remove_role($this->strUserRolePending);
    }
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
