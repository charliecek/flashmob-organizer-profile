<?php
/**
 * Plugin Name: Flashmob Organizer Profile (with login/registration page)
 * Plugin URI: https://github.com/charliecek/flashmob-organizer-profile
 * Description: Creates shortcodes for flashmob organizer login / registration / profile editing form and for maps showing cities with videos of flashmobs for each year
 * Author: charliecek
 * Author URI: http://charliecek.eu/
 * Version: 4.5.3
 */

class FLORP{

  private $strVersion = '4.5.3';
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
  private $aSubscriberTypes = array("flashmob_organizer", "teacher");

  public function __construct() {
    $this->aOptions = get_site_option( $this->strOptionKey, array() );
    $this->aOptionDefaults = array(
      'bReloadAfterSuccessfulSubmissionMain'      => false,
      'bReloadAfterSuccessfulSubmissionFlashmob'  => false,
      'strLeaderParticipantsTableClass'           => "florp-leader-participants-table",
      'aYearlyMapOptions'                         => array(),
      'iFlashmobYear'                             => isset($this->aOptions['iCurrentFlashmobYear']) ? $this->aOptions['iCurrentFlashmobYear'] : intval(date( 'Y' )),
      'iFlashmobMonth'                            => 1,
      'iFlashmobDay'                              => 1,
      'iFlashmobHour'                             => 0,
      'iFlashmobMinute'                           => 0,
      'iFlashmobBlogID'                           => 6,
      'iMainBlogID'                               => 1,
      'iNewsletterBlogID'                         => 0,
      'iCloneSourceBlogID'                        => 0,
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
      'aTshirts'                                  => array( "leaders" => array(), "participants" => array() ),
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
<p>%%signup%% <strong>Organizátor</strong>: %%organizer%% %%year%% %%school%% %%facebook%% %%web%% %%dancers%% %%note%%</p>
%%embed_code%%</div>',
      'strMarkerInfoWindowTemplateTeacher'        => '<div class="florp-marker-infowindow-wrapper">
<h5 class="florp-course-location">%%courses_city%%</h5>
<p><strong>Líder</strong>: %%organizer%% %%school%%</p>
<div class="florp-course-info">%%courses_info%%</div>
</div>',
      'strSignupLinkLabel'                        => 'Prihlásiť na Flashmob',
      'strInfoWindowLabel_organizer'              => '<strong>Organizátor</strong>',
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
      'bCoursesInfoDisabled'                      => true,
      'strTshirtPaymentWarningNotificationSbj'    => 'Chýba nám platba za objednané tričko',
      'strTshirtPaymentWarningNotificationMsg'    => '<p>Prosíme, pošlite platbu za objednané tričko.</p><p>Váš SalsaRueda.Dance team</p>',
      'bTshirtOrderingDisabled'                   => false,
      'bTshirtOrderingDisabledOnlyDisable'        => false,
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
      'florp_clone_source_blog_id'                => 'iCloneSourceBlogID',
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
      'florp_infowindow_template_organizer'       => 'strMarkerInfoWindowTemplateOrganizer',
      'florp_infowindow_template_teacher'         => 'strMarkerInfoWindowTemplateTeacher',
      'florp_signup_link_label'                   => 'strSignupLinkLabel',
      'florp_infowindow_label_organizer'          => 'strInfoWindowLabel_organizer',
      'florp_infowindow_label_signup'             => 'strInfoWindowLabel_signup',
      'florp_infowindow_label_participant_count'  => 'strInfoWindowLabel_participant_count',
      'florp_infowindow_label_year'               => 'strInfoWindowLabel_year',
      'florp_infowindow_label_dancers'            => 'strInfoWindowLabel_dancers',
      'florp_infowindow_label_school'             => 'strInfoWindowLabel_school',
      'florp_infowindow_label_web'                => 'strInfoWindowLabel_web',
      'florp_infowindow_label_facebook'           => 'strInfoWindowLabel_facebook',
      'florp_infowindow_label_note'               => 'strInfoWindowLabel_note',
      'florp_infowindow_label_embed_code'         => 'strInfoWindowLabel_embed_code',
      'florp_infowindow_label_courses_info'       => 'strInfoWindowLabel_courses_info',
      'florp_courses_info_disabled'               => 'bCoursesInfoDisabled',
      'florp_tshirt_payment_warning_notif_sbj'    => 'strTshirtPaymentWarningNotificationSbj',
      'florp_tshirt_payment_warning_notif_msg'    => 'strTshirtPaymentWarningNotificationMsg',
      'florp_tshirt_ordering_disabled'            => 'bTshirtOrderingDisabled',
      'florp_tshirt_ordering_only_disable'        => 'bTshirtOrderingDisabledOnlyDisable',
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
      'bCoursesInfoDisabled',
      'bTshirtOrderingDisabled',
      'bTshirtOrderingDisabledOnlyDisable',
    );
    $this->aOptionKeysByBlog = array(
      'main'      => array(
        'aYearlyMapOptions',
        'aParticipants',
        'aTshirts',
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
        'bCoursesInfoDisabled',
        'strTshirtPaymentWarningNotificationSbj',
        'strTshirtPaymentWarningNotificationMsg',
        'bTshirtOrderingDisabled',
        'bTshirtOrderingDisabledOnlyDisable',
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

    // BEGIN archived yearly map options until 2016 //
    $aYearlyMapOptionsUntil2016 = array(
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
      $this->aOptions['aYearlyMapOptions'] = $aYearlyMapOptionsUntil2016;
      update_site_option( $this->strOptionKey, $this->aOptions, true );
    }
//     // NOTE DEVEL TEMP
//     for ($i = 2013; $i <= 2016; $i++) {
//       $this->aOptions['aYearlyMapOptions'][$i] = $aYearlyMapOptionsUntil2016[$i];
//     }
//     update_site_option( $this->strOptionKey, $this->aOptions, true );
    // END archived yearly map options until 2016 //

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
    add_action( 'wp_ajax_get_leaderParticipantsTable', array( $this, 'action__get_leaderParticipantsTable_callback' ));
    add_action( 'wp_ajax_nopriv_get_leaderParticipantsTable', array( $this, 'action__get_leaderParticipantsTable_callback' ));
    add_action( 'wp_ajax_get_mapUserInfo', array( $this, 'action__get_mapUserInfo_callback' ));
    add_action( 'wp_ajax_nopriv_get_mapUserInfo', array( $this, 'action__get_mapUserInfo_callback' ));
    add_action( 'wp_ajax_delete_florp_participant', array( $this, 'action__delete_florp_participant_callback' ));
    add_action( 'wp_ajax_florp_tshirt_paid', array( $this, 'action__florp_tshirt_paid_callback' ));
    add_action( 'wp_ajax_florp_tshirt_send_payment_warning', array( $this, 'action__florp_tshirt_send_payment_warning_callback' ));
    add_action( 'wp_ajax_florp_tshirt_cancel_order', array( $this, 'action__florp_tshirt_cancel_order_callback' ));
    add_action( 'wp_ajax_florp_create_subsite', array( $this, 'action__florp_create_subsite_callback' ));
    add_action( 'admin_menu', array( $this, "action__remove_admin_menu_items" ), 9999 );
    add_action( 'admin_menu', array( $this, "action__add_options_page" ));
    add_action( 'wp_enqueue_scripts', array( $this, 'action__wp_enqueue_scripts' ), 9999 );
    add_action( 'admin_enqueue_scripts', array( $this, 'action__admin_enqueue_scripts' ));
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

//     // NOTE DEVEL TEMP
//     $this->aOptions['aYearlyMapOptions'][2013][22] = array (
//       'first_name' => 'Jaroslav',
//       'last_name' => 'Hluch a team',
//       'flashmob_city' => 'Bratislava',
//       'flashmob_number_of_dancers' => '16',
//       'video_link_type' => 'youtube',
//       'youtube_link' => 'https://www.youtube.com/watch?v=y_aSUdDk3Cw',
//       'flashmob_address' => 'Nákupné centrum Polus, Bratislava',
//       'longitude' => '17.138409',
//       'latitude' => '48.168235',
//       'webpage' => 'http://example.com',
//       'school_webpage' => 'http://norika.sk',
//       'note' => 'za video ďakujeme Michalovi Hrabovcovi (a teamu).',
//     );

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
      update_site_option( $this->strOptionKey, $this->aOptions, true );
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
      update_site_option( $this->strOptionKey, $this->aOptions, true );
    }

    $strOldExportPath = __DIR__ . '/nf-export/export.php';
    if (file_exists($strOldExportPath)) {
      rename($strOldExportPath, $this->strNinjaFormExportPathFlashmob);
    }
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
    // TODO: check also LIST //
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
    if (is_admin() && current_user_can( 'activate_plugins' ) && defined('FLORP_DEVEL_PURGE_TSHIRTS_ON_SAVE') && FLORP_DEVEL_PURGE_TSHIRTS_ON_SAVE === true) {
      add_action( 'admin_notices', array( $this, 'action__admin_notices__florp_devel_purge_tshirts_save_is_on' ));
    }

    if (isset($_POST['florp-download-tshirt-csv'])) {
      $this->serveTshirtCSV();
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

      // Set default value of tshirt preference to unchecked and disabled if ordering is disabled //
      if ($this->aOptions['bTshirtOrderingDisabled'] && $aField['settings']['type'] === 'listcheckbox' && $aField['settings']['key'] === 'preferences') {
        foreach ($aField['settings']['options'] as $iKey => $aOption) {
          if ($aOption['value'] === 'flashmob_participant_tshirt') {
            $aField['settings']['options'][$iKey]['selected'] = 0;
            break;
          }
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
          function( $a ){
            if (is_array($a) && count($a) === 1) {
              return $a[0];
            } else {
              return $a;
            }
          },
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

    $aTshirtImages = array();
    $strPluginDirPath = WP_CONTENT_DIR . '/plugins/flashmob-organizer-profile';
    $strImagePath = $strPluginDirPath."/img/";
    $strImagePathEscaped = preg_quote($strImagePath, "~");
    $aTshirtImageCouples = array();
    $aTshirtFullImages = array( 'white' => array(), 'black' => array() );
    foreach ( glob($strImagePath . "t-shirt-*.png") as $strImgName) {
      $aMatches = array();
      $mixType = false;
      if (preg_match( '~^('.$strImagePathEscaped.')?t-shirt-chest-white-([a-zA-Z0-9_-]+).png$~', $strImgName, $aMatches )) {
        $strTshirtCitySlug = $aMatches[2];
        $strType = "white";
      } elseif (preg_match( '~^('.$strImagePathEscaped.')?t-shirt-chest-black-([a-zA-Z0-9_-]+).png$~', $strImgName, $aMatches )) {
        $strTshirtCitySlug = $aMatches[2];
        $strType = "black";
      } elseif (preg_match( '~^('.$strImagePathEscaped.')?t-shirt-white-([a-zA-Z0-9_-]+).png$~', $strImgName, $aMatches )) {
        $strTshirtCitySlug = $aMatches[2];
        $aTshirtFullImages['white'][$strTshirtCitySlug] = 1;
        continue;
      } elseif (preg_match( '~^('.$strImagePathEscaped.')?t-shirt-black-([a-zA-Z0-9_-]+).png$~', $strImgName, $aMatches )) {
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
      'flashmob_city'                 => get_user_meta( $iUserID, 'flashmob_city', true ),
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
      'img_path'                      => plugins_url( 'flashmob-organizer-profile/img/' ),
      'tshirt_imgs_couples'           => $aTshirtImages,
      'tshirt_imgs_full'              => $aTshirtFullImages,
      'courses_info_disabled'         => $this->aOptions['bCoursesInfoDisabled'] ? 1 : 0,
      'tshirt_ordering_disabled'      => $this->aOptions['bTshirtOrderingDisabled'] ? 1 : 0,
      'tshirt_ordering_only_disable'  => $this->aOptions['bTshirtOrderingDisabledOnlyDisable'] ? 1 : 0,
//       'all_imgs'                      => glob($strImagePath . "t-shirt-*.png"),
    );
    if (is_user_logged_in()) {
      $aJS['user_id'] = $iUserID;
      $aJS['leader_participant_table_class'] = $this->aOptions['strLeaderParticipantsTableClass'];
      $aJS['get_leaderParticipantsTable_action'] = 'get_leaderParticipantsTable';
    }
    wp_localize_script( 'florp_form_js', 'florp', $aJS );

    wp_enqueue_style( 'florp_form_css', plugins_url('css/florp-form.css', __FILE__), false, $this->strVersion, 'all');
  }

  public function action__admin_enqueue_scripts( $strHook ) {
    $aPermittedHooks = array(
//       'toplevel_page_florp-main',
//       'profil-organizatora-svk-flashmobu_page_florp-leaders',
      'profil-organizatora-svk-flashmobu_page_florp-participants',
      'profil-organizatora-svk-flashmobu_page_florp-tshirts',
      'profil-organizatora-svk-flashmobu_page_florp-subsites',
//       'profil-organizatora-svk-flashmobu_page_florp-lwa',
    );
    if (in_array($strHook, $aPermittedHooks)) {
      wp_enqueue_script('florp_admin_js', plugins_url('js/florp-admin.js', __FILE__), array('jquery'), $this->strVersion, true);

      wp_register_style( 'florp_admin_css', plugins_url('css/florp-admin.css', __FILE__), false, $this->strVersion );
      wp_enqueue_style( 'florp_admin_css' );
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
      $page = add_submenu_page(
        'florp-main',
        'Tričká',
        'Tričká',
        'manage_options',
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
    }
  }

  public function leaders_table_admin() {
    echo "<div class=\"wrap\"><h1>" . "Zoznam lídrov" . "</h1>";
    $aUsers = $this->getFlashmobSubscribers( 'all', true );
    $strEcho = '<table class="widefat striped"><th>Meno</th><th>Email</th><th>Mesto</th><th>Preferencie</th><th>Profil</th><th>Účastníci</th>';
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
      $strButtons = "";
      $strEcho .= '<tr>';
      $strEcho .=   '<td>'.$oUser->first_name.' '.$oUser->last_name.$strIsPending.$strButtons.'</td>';
      $strEcho .=   '<td><a name="'.$oUser->ID.'">'.$oUser->user_email.'</a></td>';
      $strEcho .=   '<td>'.$aAllMeta['flashmob_city'].'</td>';
      $strEcho .=   '<td>';
      foreach( $this->aSubscriberTypes as $strSubscriberType) {
        if ($this->aOptions['bCoursesInfoDisabled'] && in_array($strSubscriberType, $this->aMetaFieldsTeacher)) {
          continue;
        }
        $bChecked = isset($aAllMeta[$strSubscriberType]) && $aAllMeta[$strSubscriberType];
        $strValue = $bChecked ? '<input type="checkbox" disabled checked />' : '<input type="checkbox" disabled />';
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

        if ($this->aOptions['bCoursesInfoDisabled'] && in_array($strMetaKey, $this->aMetaFieldsTeacher)) {
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
          $strEcho .= '<a href="'.$strValue.'" target="_blank">'.$strFieldName.'</a><br>';
        } else {
          $strEcho .= '<strong>' . $strFieldName . '</strong>: ' . $strValue.'<br>';
        }
      }
      $strEcho .=   '</td>';
      $strEcho .=   '<td>';
      $aParticipants = $this->get_flashmob_participants( $oUser->ID, false, true );
      if (!empty($aParticipants)) {
        $aParticipantsOfUser = $aParticipants[$oUser->ID];
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
    echo '</div><!-- .wrap -->';
  }

  public function participants_table_admin() {
    echo "<div class=\"wrap\"><h1>" . "Zoznam účastníkov" . "</h1>";
    $strEcho = '<table class="widefat striped"><th>Meno</th><th>Email</th><th>Mesto</th><th>Líder</th>';
//     $strEcho .= '<th>Pohlavie</th><th>Tanečná úroveň</th>';
    $strEcho .= '<th>Profil</th>';
    $aParticipants = $this->get_flashmob_participants( 0, false, true );
//     echo "<pre>";var_dump($aParticipants);echo "</pre>";
    $aReplacements = array(
      'gender' => array(
        'from'  => array( 'muz', 'zena', 'par' ),
        'to'    => array( 'muž', 'žena', 'pár' )
      ),
      'dance_level' => array(
        'from'  => array( 'zaciatocnik', 'pokrocily', 'ucitel' ),
        'to'    => array( 'začiatočník', 'pokročilý', 'učiteľ' )
      ),
      'preferences' => array(
        'from'  => array( 'flashmob_participant_tshirt', 'newsletter_subscribe' ),
        'to'    => array( 'Chcem pamätné Flashmob tričko', 'Chcem dostávať newsletter' )
      )
    );
    foreach ($aParticipants as $iLeaderID => $aParticipantsOfLeader) {
      foreach ($aParticipantsOfLeader as $strEmail => $aParticipantData) {
        foreach ($aReplacements as $strKey => $aReplacementArr) {
          $aParticipantData[$strKey] = str_replace( $aReplacementArr['from'], $aReplacementArr['to'], $aParticipantData[$strKey]);
        }
        $strButtonLabelDelete = "Zmazať";
        $strDoubleCheckQuestion = "Ste si istý?";
        $strRowID = "florpRow-".$iLeaderID."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
        $strButtonID = "florpButton-".$iLeaderID."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail);
        $strButtons = '<br/><span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabelDelete.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'" data-leader-id="'.$iLeaderID.'" data-participant-email="'.$strEmail.'" data-sure="0" data-action="delete_florp_participant" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabelDelete.'</span>';
        $strEcho .= '<tr class="row" data-row-id="'.$strRowID.'">';
        $strEcho .=   '<td>'.$aParticipantData['first_name'].' '.$aParticipantData['last_name'].$strButtons.'</td>';
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
//         $strEcho .=   '<td>'.$aParticipantData['gender'].'</td>';
//         $strEcho .=   '<td>'.$aParticipantData['dance_level'].'</td>';
        $strEcho .=   '<td>';
        $aTimestamps = array( 'registered', 'tshirt_order_cancelled_timestamp' );
        $aSkip = array( 'first_name', 'last_name', 'user_email', 'flashmob_city', 'leader_user_id'/*, 'dance_level', 'gender'*/ );
        if (!isset($aParticipantData['leader_notified'])) {
          $aParticipantData['leader_notified'] = false;
        }
        foreach ($aParticipantData as $strKey => $mixValue) {
          if (!isset($mixValue) || (!is_bool($mixValue) && !is_numeric($mixValue) && empty($mixValue)) || $mixValue === 'null' || in_array( $strKey, $aSkip )) {
            continue;
          }
          if (in_array($strKey, $aTimestamps)) {
            $strKey = str_replace("_timestamp", "", $strKey);
            $strValue = date( get_option('date_format')." ".get_option('time_format'), $mixValue );
          } elseif (is_array($mixValue)) {
            $strValue = implode( ', ', $mixValue);
          } elseif (is_bool($mixValue)) {
            $strValue = $mixValue ? '<input type="checkbox" disabled checked />' : '<input type="checkbox" disabled />';
          } else {
            $strValue = $mixValue;
          }
          $strFieldName = ucfirst( str_replace( '_', ' ', $strKey ) );
          $strEcho .= '<strong>' . $strFieldName . '</strong>: ' . $strValue.'<br>';
        }
        $strEcho .=   '</td>';
        $strEcho .= '</tr>';
      }
    }
    $strEcho .= '</table>';
    echo $strEcho;
    echo '</div><!-- .wrap -->';
  }

  private function get_tshirts($iPaidFlag = 0, $bCSV = false) { // -1: unpaid, 1: paid, 0: all
    $aLeaders = $this->getFlashmobSubscribers( 'flashmob_organizer' );
    $aTshirtsOption = $this->aOptions["aTshirts"];
//     echo "<pre>";var_dump($aTshirtsOption);echo "</pre>";
    $aTshirts = array();
    foreach ($aLeaders as $oUser) {
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
      $aTshirts[] = array(
        "id" => "leader-".$oUser->ID,
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
//     echo "<pre>";var_dump($aParticipants);echo "</pre>";
    foreach ($aParticipants as $iLeaderID => $aParticipantsOfLeader) {
      foreach ($aParticipantsOfLeader as $strEmail => $aParticipantData) {
        if (!in_array("flashmob_participant_tshirt", $aParticipantData["preferences"])) {
//           echo "<pre>";var_dump($aParticipantData);echo "</pre>";
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
        $aTshirts[] = array_merge(array(
          "id" => "participant-".$iLeaderID."-".preg_replace('~[^a-zA-Z0-9_-]~', "_", $strEmail),
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
          ),
        ), $aToMerge );
      }
    }
    foreach ($aTshirts as $key => $aTshirtData) {
      $bPaid = false;
      if ($aTshirtData["is_leader"]) {
        $bPaid = true;
//         $bPaid = (isset($aTshirtsOption["leaders"][$aTshirtData["user_id"]]) && isset($aTshirtsOption["leaders"][$aTshirtData["user_id"]]["paid"]) && $aTshirtsOption["leaders"][$aTshirtData["user_id"]]["paid"] === true);
      } else {
        $bPaid = (isset($aTshirtsOption["participants"][$aTshirtData["email"]]) && isset($aTshirtsOption["participants"][$aTshirtData["email"]]["paid"]) && $aTshirtsOption["participants"][$aTshirtData["email"]]["paid"] === true);
        if ($bPaid) {
          $aTshirts[$key]["paid_timestamp"] = $aTshirtsOption["participants"][$aTshirtData["email"]]['paid-timestamp'];
        }
        $bPaymentWarningSent = (isset($aTshirtsOption["participants"][$aTshirtData["email"]]) && isset($aTshirtsOption["participants"][$aTshirtData["email"]]["payment_warning_sent"]) && $aTshirtsOption["participants"][$aTshirtData["email"]]["payment_warning_sent"] === true);
        $aTshirts[$key]["payment_warning_sent"] = $bPaymentWarningSent;
        if ($bPaymentWarningSent) {
          $aTshirts[$key]["payment_warning_sent_timestamp"] = $aTshirtsOption["participants"][$aTshirtData["email"]]['payment_warning_sent-timestamp'];
        }
      }
      $aTshirts[$key]["is_paid"] = $bPaid;
      if ($iPaidFlag === -1 && $bPaid) {
        unset($aTshirts[$key]);
      } elseif ($iPaidFlag === 1 && !$bPaid) {
        unset($aTshirts[$key]);
      }
    }
//     echo "<pre>";var_dump($aTshirts);echo "</pre>";
    if ($bCSV) {
      if (empty($aTshirts)) {
        return array();
      }
      $aReturn = array();
      $aReturn[] = array("Meno", "Email", "Mesto", "Typ", "Líder", "Webstránka", "Veľkosť trička", "Typ trička", "Farba trička", "Čas registrácie (účastník)", "Zaplatil", "Čas označenia za zaplatené", "Upozornenie na platbu", "Čas upozornenia na platbu");
      foreach ($aTshirts as $aTshirtData) {
        $aReturn[] = array(
          $aTshirtData["name"],
          $aTshirtData["email"],
          $aTshirtData["flashmob_city"],
          $aTshirtData["type"],
          $aTshirtData["leader"],
          $aTshirtData["properties"]["webpage"],
          $aTshirtData["properties"]["tshirt_size"],
          $aTshirtData["properties"]["tshirt_gender"],
          $aTshirtData["properties"]["tshirt_color"],
          $aTshirtData["is_leader"] ? "-" : (isset($aTshirtData["registered_timestamp"]) && $aTshirtData["registered_timestamp"] > 0 ? date('Y-m-d H:i:s', $aTshirtData["registered_timestamp"] ) : "-"),
          $aTshirtData["is_leader"] ? "-" : ($aTshirtData["is_paid"] ? "1" : "0"),
          $aTshirtData["is_leader"] ? "-" : ($aTshirtData["is_paid"] && $aTshirtData["paid_timestamp"] ? date('Y-m-d H:i:s', $aTshirtData["paid_timestamp"] ) : "-"),
          $aTshirtData["is_leader"] ? "-" : ($aTshirtData["payment_warning_sent"] ? "1" : "0"),
          $aTshirtData["is_leader"] ? "-" : ($aTshirtData["payment_warning_sent"] && $aTshirtData["payment_warning_sent_timestamp"] ? date('Y-m-d H:i:s', $aTshirtData["payment_warning_sent_timestamp"] ) : "-"),
        );
      }
      return $aReturn;
    }
    return $aTshirts;
  }

  private function serveTshirtCSV() {
    $bPassed = check_ajax_referer( 'srd-florp-admin-security-string', 'security', false );
    if (!$bPassed) {
      add_action( 'admin_notices', function() {
        echo '<div class="notice notice-error"><p>Request validation failed</p></div>'.PHP_EOL;
      });
      return;
    }
    if (!isset($_POST["florp-download-tshirt-csv-all"]) && !isset($_POST["florp-download-tshirt-csv-unpaid"]) && !isset($_POST["florp-download-tshirt-csv-paid"])) {
      add_action( 'admin_notices', function() {
        echo '<div class="notice notice-error"><p>Invalid request - unknown button was clicked</p></div>'.PHP_EOL;
      });
      return;
    }

    $strFileName = "tshirts-";
    if (isset($_POST["florp-download-tshirt-csv-all"])) {
      $aTshirts = $this->get_tshirts(0, true);
      $strFileName .= "all";
    } elseif (isset($_POST["florp-download-tshirt-csv-unpaid"])) {
      $aTshirts = $this->get_tshirts(-1, true);
      $strFileName .= "unpaid";
    } elseif (isset($_POST["florp-download-tshirt-csv-paid"])) {
      $aTshirts = $this->get_tshirts(1, true);
      $strFileName .= "paid";
    }
    if (empty($aTshirts)) {
      add_action( 'admin_notices', function() {
        echo '<div class="notice notice-warning"><p>No thirts to build CSV from</p></div>'.PHP_EOL;
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

  public function tshirts_table_admin() {
    echo "<div class=\"wrap\">\n<h1>" . "Tričká" . "</h1>\n";

    $aTshirts = $this->get_tshirts();
    if (empty($aTshirts)) {
      echo "<p>Nie sú objednané žiadne tričká.</p>\n</div><!-- .wrap -->";
      return;
    }

    $strEcho = '<table class="widefat striped"><th>Meno</th><th>Email</th><th>Mesto</th><th>Typ</th><th>Líder</th><th>Vlastnosti</th>';

//     echo "<pre>";var_dump($this->aOptions['aTshirts']);echo "</pre>";
//     echo "<pre>";var_dump($aTshirts);echo "</pre>";
    $iUnpaid = 0;
    $iPaid = 0;
    foreach ($aTshirts as $aTshirtData) {
      $strButtons = "";
      $strDoubleCheckQuestion = "Ste si istý?";
      $strButtonLabelPaid = "Zaplatil";
      $strButtonLabelPaymentWarning = "Upozorniť na neskorú platbu";
      $strButtonLabelCancelOrder = "Zrušiť objednávku";
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
        $strData .= " data-{$strKey}='{$strValue}'";
      }
      foreach ($aTshirtData['properties'] as $strKey => $strValue) {
        $strData .= " data-{$strKey}='{$strValue}'";
      }
      $strRowID = "florpRow-".$aTshirtData["id"];
      $strPaidButtonID = "florpButton-paid-".$aTshirtData["id"];
      $strPaymentWarningButtonID = "florpButton-paymentWarning-".$aTshirtData["id"];
      $strCancelOrderButtonID = "florpButton-cancelOrder-".$aTshirtData["id"];

      $strButtons = '<br/>';
      if ($aTshirtData["is_leader"]) {
        // no button
        $strButtons = "";
        $iPaid++;
      } elseif ($aTshirtData["is_paid"]) {
        $strTitle = "";
        if (isset($aTshirtData["paid_timestamp"])) {
          $strTitle = ' title="'.date( get_option('date_format')." ".get_option('time_format'), $aTshirtData["paid_timestamp"] ).'"';
        }
        $strButtons .= '<span data-button-id="'.$strPaidButtonID.'" class="notice notice-success"'.$strTitle.'>Zaplatené</span>';
        $iPaid++;
      } else {
        $iUnpaid++;

        // Paid button //
        $strButtons .= '<span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabelPaid.'" data-button-id="'.$strPaidButtonID.'" data-row-id="'.$strRowID.'" '.$strData.' data-action="florp_tshirt_paid" data-sure="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabelPaid.'</span>';

        // Cancel button //
        $strButtons .= '<br/><span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabelCancelOrder.'" data-button-id="'.$strCancelOrderButtonID.'" data-row-id="'.$strRowID.'" '.$strData.' data-action="florp_tshirt_cancel_order" data-sure="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabelCancelOrder.'</span>';

        // Warning button //
        if (isset($this->aOptions['strTshirtPaymentWarningNotificationMsg'], $this->aOptions['strTshirtPaymentWarningNotificationSbj']) && !empty($this->aOptions['strTshirtPaymentWarningNotificationMsg']) && !empty($this->aOptions['strTshirtPaymentWarningNotificationSbj'])) {
          $strWarningClass = "";
          $bShow = true;
          if (isset($aTshirtData["registered_timestamp"]) && $aTshirtData["registered_timestamp"] > 0) {
            $iTimestampNow = (int) current_time( 'timestamp' );
            if ($iTimestampNow - $aTshirtData["registered_timestamp"] > (7*24*3600)) {
              $strWarningClass = " button-warning";
            } else {
              $bShow = false;
            }
          }
          if ($bShow) {
            $strButtons .= '<br/>';
            if ($aTshirtData["payment_warning_sent"]) {
              $strTitle = "";
              if (isset($aTshirtData["payment_warning_sent_timestamp"])) {
                $strTitle = ' title="'.date( get_option('date_format')." ".get_option('time_format'), $aTshirtData["payment_warning_sent_timestamp"] ).'"';
              }
              $strButtons .= '<span data-button-id="'.$strPaymentWarningButtonID.'" class="notice notice-success"'.$strTitle.'>Upozornený na neskorú platbu</span>';
            } else {
              $strButtons .= '<span class="button double-check'.$strWarningClass.'" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabelPaymentWarning.'" data-button-id="'.$strPaymentWarningButtonID.'" data-row-id="'.$strRowID.'" '.$strData.' data-action="florp_tshirt_send_payment_warning" data-sure="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabelPaymentWarning.'</span>';
            }
          }
        }
      }
      $strEcho .= '<tr class="row" data-row-id="'.$strRowID.'">';
//       $strEcho .= '<tr>';
      $strEcho .=   '<td>'.$aTshirtData['name'].$strButtons.'</td>';
      $strEcho .=   '<td><a name="'.$aTshirtData['email'].'">'.$aTshirtData['email'].'</a></td>';

      $strWarning = "";
      if (isset($aTshirtData['flashmob_city_at_registration'])) {
        $strTitle = " title=\"Pozor: pri registrácii účastníka mal líder nastavené mesto flashmobu na  {$aTshirtData['flashmob_city_at_registration']}!\"";
        $strWarning = ' <span '.$strTitle.' class="dashicons dashicons-warning"></span>';
      }
      $strEcho .=   '<td>'.$aTshirtData['flashmob_city'].$strWarning.'</td>';
      $strEcho .=   '<td>'.$aTshirtData['type'].'</td>';
      $strEcho .=   '<td>'.$aTshirtData['leader'].'</td>';
      $strEcho .=   '<td>';
      foreach ($aTshirtData['properties'] as $strKey => $strValue) {
        $strFieldName = ucfirst( str_replace( '_', ' ', $strKey ) );
        $strEcho .= '<strong>' . $strFieldName . '</strong>: ' . $strValue.'<br>';
      }
      $strEcho .=   '</td>';
      $strEcho .= '</tr>';
    }
    $strEcho .= '</table>';
    $strEcho .= '<form action="" method="post">';
    $strEcho .= '<input type="hidden" name="security" value="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">';
    $strEcho .= '<input type="hidden" name="florp-download-tshirt-csv" value="1">';
    $strEcho .= '<input id="florp-download-tshirt-csv-all" class="button button-primary button-large" name="florp-download-tshirt-csv-all" type="submit" value="Stiahni CSV - všetko" />';
    if ($iUnpaid > 0 && $iPaid > 0) {
      $strEcho .= '<input id="florp-download-tshirt-csv-unpaid" class="button button-primary button-large" name="florp-download-tshirt-csv-unpaid" type="submit" value="Stiahni CSV - nezaplatené" />';
      $strEcho .= '<input id="florp-download-tshirt-csv-paid" class="button button-primary button-large" name="florp-download-tshirt-csv-paid" type="submit" value="Stiahni CSV - zaplatené" />';
    }
    $strEcho .= '</form>';

    echo $strEcho;
    echo '</div><!-- .wrap -->';
  }

  public function action__delete_florp_participant_callback() {
//     wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not remove the flashmob participant '{$aData['participantEmail']}'";
    if (!isset($this->aOptions["aParticipants"]) || empty($this->aOptions["aParticipants"])) {
      $aData["message"] = $strErrorMessage;
    } else {
      if (isset($this->aOptions["aParticipants"][$aData["leaderId"]]) && isset($this->aOptions["aParticipants"][$aData["leaderId"]][$aData["participantEmail"]])) {
        $aData["removeRowOnSuccess"] = true;
        $aData["ok"] = true;
        if (defined('FLORP_DEVEL') && FLORP_DEVEL === true) {
          $aData["message"] = "The flashmob participant '{$aData['participantEmail']}' was deleted successfully (NOT: FLORP_DEVEL is on!)";
        } else {
          unset($this->aOptions["aParticipants"][$aData["leaderId"]][$aData["participantEmail"]]);
          update_site_option( $this->strOptionKey, $this->aOptions, true );
          $aData["message"] = "The flashmob participant '{$aData['participantEmail']}' was deleted successfully";
        }
      } else {
        $aData["message"] = $strErrorMessage;
      }
    }
//     sleep(3);
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_tshirt_paid_callback() {
//     wp_die();
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
      $strTitle = ' title="'.date( get_option('date_format')." ".get_option('time_format'), $iTimestampNow ).'"';
      $strPaymentWarningButtonID = str_replace( "-paid-", "-paymentWarning-", $aData['buttonId']);
      $strCancelOrderButtonID = str_replace( "-paid-", "-cancelOrder-", $aData['buttonId']);
      $aData["hideSelector"] = "tr[data-row-id={$aData['rowId']}] span[data-button-id={$strPaymentWarningButtonID}], tr[data-row-id={$aData['rowId']}] span[data-button-id={$strCancelOrderButtonID}]";
      $aData["replaceButtonHtml"] = '<span data-button-id="'.$aData['buttonId'].'" class="notice notice-success"'.$strTitle.'>Zaplatené</span>';
      if (false && defined('FLORP_DEVEL') && FLORP_DEVEL === true) {
        // NOTE No use for this yet //
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
        update_site_option( $this->strOptionKey, $this->aOptions, true );
        $aData["message"] = "The flashmob participant '{$aData['participantEmail']}' was marked as having paid successfully";//." ".var_export($aData, true);
      }
    }
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_tshirt_send_payment_warning_callback() {
//     wp_die();
    check_ajax_referer( 'srd-florp-admin-security-string', 'security' );

    $aData = $_POST;
    $strErrorMessage = "Could not send payment warning to the flashmob participant '{$aData['email']}'";
    if (!isset($this->aOptions["aTshirts"]) || empty($this->aOptions["aTshirts"]) || !isset($this->aOptions['strTshirtPaymentWarningNotificationMsg'], $this->aOptions['strTshirtPaymentWarningNotificationSbj']) || empty($this->aOptions['strTshirtPaymentWarningNotificationMsg']) || empty($this->aOptions['strTshirtPaymentWarningNotificationSbj'])) {
      $aData["message"] = $strErrorMessage;
    } else {
      $iTimestampNow = (int) current_time( 'timestamp' );
      $aData["removeRowOnSuccess"] = false;
      $aData["replaceButton"] = true;
      $strTitle = ' title="'.date( get_option('date_format')." ".get_option('time_format'), $iTimestampNow ).'"';
      $aData["replaceButtonHtml"] = '<span data-button-id="'.$aData['buttonId'].'" class="notice notice-success"'.$strTitle.'>Upozornený na neskorú platbu</span>';

      $strMessageContent = $this->aOptions['strTshirtPaymentWarningNotificationMsg'];
      $strMessageSubject = $this->aOptions['strTshirtPaymentWarningNotificationSbj'];
      $strBlogname = trim(wp_specialchars_decode(get_option('blogname'), ENT_QUOTES));
      $aHeaders = array('Content-Type: text/html; charset=UTF-8');
      $bSendResult = wp_mail($aData["email"], $strMessageSubject, $strMessageContent, $aHeaders);

      if ($bSendResult) {
        $aData["ok"] = true;

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
        update_site_option( $this->strOptionKey, $this->aOptions, true );
        $aData["message"] = "A payment warning was sent to the flashmob participant '{$aData['email']}'";//." ".var_export($aData, true);
      } else {
        $aData["message"] = $strErrorMessage;
      }
    }
    echo json_encode($aData);
    wp_die();
  }

  public function action__florp_tshirt_cancel_order_callback() {
//     wp_die();
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
          if (false && defined('FLORP_DEVEL') && FLORP_DEVEL === true) {
            $aData["message"] = "The tshirt order of flashmob participant '{$aData['email']}' was cancelled successfully (NOT: FLORP_DEVEL is on!)";
          } else {
            unset($this->aOptions["aParticipants"][$aData["leader_id"]][$aData["email"]]['preferences'][$iKey]);
            $this->aOptions["aParticipants"][$aData["leader_id"]][$aData["email"]]['tshirt_order_cancelled_timestamp'] = (int) current_time( 'timestamp' );
            update_site_option( $this->strOptionKey, $this->aOptions, true );
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
          $bTest = false; // TODO DEVEL TEST //
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
    }

    echo json_encode($aData);
    wp_die();
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
            $strSubsite .= '<br><span class="button double-check" data-text-double-check="'.$strDoubleCheckQuestion.'" data-text-default="'.$strButtonLabel.'" data-button-id="'.$strButtonID.'" data-row-id="'.$strRowID.'"'.$strData.' data-action="'.$strAction.'" data-sure="0" data-security="'.wp_create_nonce( 'srd-florp-admin-security-string' ).'">'.$strButtonLabel.'</span>';
          }

//           $strSubsite = implode( ", ", $aVariations );
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
//       var_dump($iID, $this->aOptions['iFlashmobBlogID']);
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
    $optionsCloneSourceSite = $optionNoneF;
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
      if ($this->aOptions['iCloneSourceBlogID'] == $iID) {
        $strSelectedCloneSourceSite = 'selected="selected"';
      } else {
        $strSelectedCloneSourceSite = '';
      }
      $optionsFlashmobSite .= '<option value="'.$iID.'" '.$strSelectedFlashmobSite.'>'.$strTitle.'</option>';
      $optionsMainSite .= '<option value="'.$iID.'" '.$strSelectedMainSite.'>'.$strTitle.'</option>';
      $optionsNewsletterSite .= '<option value="'.$iID.'" '.$strSelectedNewsletterSite.'>'.$strTitle.'</option>';
      $optionsCloneSourceSite .= '<option value="'.$iID.'" '.$strSelectedCloneSourceSite.'>'.$strTitle.'</option>';
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
      // foreach($this->aOptions['aParticipants'] as $i => $a) {foreach($a as $e => $ap) {$this->aOptions['aParticipants'][$i][$e]['leader_notified']=false;}}; update_site_option( $this->strOptionKey, $this->aOptions, true );
      // echo "<pre>" .var_export($this->aOptions['aParticipants'], true). "</pre>";
      // echo "<pre>" .var_export(wp_get_sites(), true). "</pre>";
      // echo "<pre>" .var_export($this->findCityWebpage( "Bánovce nad Bebravou" ), true). "</pre>";
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
      'optionsCloneSourceSite' => $optionsCloneSourceSite
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
    $wpEditorTshirtPaymentWarningNotificationMsg = $this->get_wp_editor( $this->aOptions['strTshirtPaymentWarningNotificationMsg'], 'florp_tshirt_payment_warning_notif_msg' );

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
        '%%strTshirtPaymentWarningNotificationSbj%%', '%%wpEditorTshirtPaymentWarningNotificationMsg%%',
        '%%optionsCloneSourceSite%%',
        '%%tshirtOrderingDisabledChecked%%', '%%tshirtOrderingDisabledOnlyDisableChecked%%' ),
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
        $this->aOptions['strTshirtPaymentWarningNotificationSbj'], $wpEditorTshirtPaymentWarningNotificationMsg,
        $optionsCloneSourceSite,
        $aBooleanOptionsChecked['bTshirtOrderingDisabled'], $aBooleanOptionsChecked['bTshirtOrderingDisabledOnlyDisable'] ),
        // BEGIN replace template //
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
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                Predmet upozornenia na platbu za tričko
              </th>
              <td style="border-top: 1px lightgray dashed;">
                <input id="florp_tshirt_payment_warning_notif_sbj" name="florp_tshirt_payment_warning_notif_sbj" type="text" value="%%strTshirtPaymentWarningNotificationSbj%%" style="width: 100%;" />
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Text upozornenia na platbu za tričko
              </th>
              <td style="border-top: 1px lightgray dashed;">
                %%wpEditorTshirtPaymentWarningNotificationMsg%%
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;"><label for="florp_clone_source_blog_id">Podstránka, ktorá sa má klonovať</label></th>
              <td style="border-top: 1px lightgray dashed;">
                <select id="florp_clone_source_blog_id" name="florp_clone_source_blog_id" style="width: 100%;">%%optionsCloneSourceSite%%</select>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                <label for="florp_tshirt_ordering_disabled">Vypnúť objednávanie tričiek na formulári pre účastníkov?</label>
              </th>
              <td style="border-top: 1px lightgray dashed;">
                <input id="florp_tshirt_ordering_disabled" name="florp_tshirt_ordering_disabled" type="checkbox" %%tshirtOrderingDisabledChecked%% value="1"/>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                <label for="florp_tshirt_ordering_only_disable">Pri vypnutom objednávaní tričiek na formulári pre účastníkov ponechať checkbox viditeľný (ale neklikateľný)?</label>
              </th>
              <td>
                <input id="florp_tshirt_ordering_only_disable" name="florp_tshirt_ordering_only_disable" type="checkbox" %%tshirtOrderingDisabledOnlyDisableChecked%% value="1"/>
              </td>
            </tr>
      '
      // END replace template //
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
        // BEGIN replace template //
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
          // END replace template //
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
    
    $strMarkerInfoWindowTemplateOrganizer = $this->get_wp_editor( $this->aOptions['strMarkerInfoWindowTemplateOrganizer'], 'florp_infowindow_template_organizer' );
    $strMarkerInfoWindowTemplateTeacher = $this->get_wp_editor( $this->aOptions['strMarkerInfoWindowTemplateTeacher'], 'florp_infowindow_template_teacher' );

    $aInfoWindowLabelSlugs = array( 'organizer', 'signup', 'participant_count', 'year', 'dancers', 'school', 'note', 'web', 'facebook', /*'embed_code', 'courses_info'*/ );
    $strInfoWindowLabels = "";
    foreach ($aInfoWindowLabelSlugs as $strSlug) {
      $strElementID = 'florp_infowindow_label_'.$strSlug;
      $strOptionKey = 'strInfoWindowLabel_'.$strSlug;
      $strOptionValue = $this->aOptions[$strOptionKey];
      $strNote = "";
//       if ('web' === $strSlug) {
//         $strNote = '<span style="width: 100%;">Táto položka sa zobrazí len ak nie je povolené zobrazovanie kurzov vo formulári alebo je prázdne meno školy.</span>';
//       }
      $strInfoWindowLabels .= '<th style="width: 47%; padding: 0 1%; text-align: right;">
                Nadpis pre položku "'.$strSlug.'"
              </th>
              <td>
                <input id="'.$strElementID.'" name="'.$strElementID.'" type="text" value="'.$strOptionValue.'" style="width: 100%;" />'.$strNote.'
              </td>
            </tr>';
    }

    return str_replace(
      array( '%%optionsNewsletterSite%%',
        '%%loadMapsAsyncChecked%%',
        '%%loadMapsLazyChecked%%',
        '%%loadVideosLazyChecked%%',
        '%%bCoursesInfoDisabled%%',
        '%%optionsYears%%', '%%optionsMonths%%', '%%optionsDays%%', '%%optionsHours%%', '%%optionsMinutes%%',
        '%%strGoogleMapsKey%%', '%%strGoogleMapsKeyStatic%%', '%%strFbAppID%%', '%%preventDirectMediaDownloadsChecked%%', '%%strNewsletterAPIKey%%',
        '%%strSignupLinkLabel%%', '%%strInfoWindowLabels%%',
        '%%wpEditorMarkerInfoWindowTemplateOrganizer%%', '%%wpEditorMarkerInfoWindowTemplateTeacher%%' ),
      array( $optionsNewsletterSite,
        $aBooleanOptionsChecked['bLoadMapsAsync'],
        $aBooleanOptionsChecked['bLoadMapsLazy'],
        $aBooleanOptionsChecked['bLoadVideosLazy'],
        $aBooleanOptionsChecked['bCoursesInfoDisabled'],
        $aNumOptions['optionsYears'], $optionsMonths, $aNumOptions['optionsDays'], $aNumOptions['optionsHours'], $aNumOptions['optionsMinutes'],
        $this->aOptions['strGoogleMapsKey'], $this->aOptions['strGoogleMapsKeyStatic'], $this->aOptions['strFbAppID'], $aBooleanOptionsChecked['bPreventDirectMediaDownloads'], $this->aOptions['strNewsletterAPIKey'],
        $this->aOptions['strSignupLinkLabel'], $strInfoWindowLabels,
        $strMarkerInfoWindowTemplateOrganizer, $strMarkerInfoWindowTemplateTeacher ),
        // BEGIN replace template //
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
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                Text linky na prihlásenie na Flashmob
              </th>
              <td style="border-top: 1px lightgray dashed;">
                <input id="florp_signup_link_label" name="florp_signup_link_label" type="text" value="%%strSignupLinkLabel%%" style="width: 100%;" />
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                <label for="florp_courses_info_disabled">Vypnúť zobrazovanie položiek o kurzoch vo formulári?</label>
              </th>
              <td>
                <input id="florp_courses_info_disabled" name="florp_courses_info_disabled" type="checkbox" %%bCoursesInfoDisabled%% value="1"/>
              </td>
            </tr>
            %%strInfoWindowLabels%%
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right;">
                Info okno leadra ako organizátora flashmobu na mape
              </th>
              <td>
                %%wpEditorMarkerInfoWindowTemplateOrganizer%%
                <span style="width: 100%;">Placeholdre: <code>%%flashmob_city%%</code>, <code>%%organizer%%</code>*, <code>%%signup%%</code>*, <code>%%participant_count%%</code>*, <code>%%year%%</code>*, <code>%%school%%</code>*, <code>%%web%%</code>*, <code>%%flashmob%%</code>*, <code>%%dancers%%</code>*, <code>%%note%%</code>*, <code>%%embed_code%%</code></span><br>
                <span style="width: 100%;">*Pozor: nepridavaj zalomenie riadkov (&lt;br&gt;, &lt;br /&gt;) pred a za placeholdre s hviezdickou - ak sa zamenia za prazdny text, ostane po nich prazdny riadok!</span><br>
              </td>
            </tr>
            <tr style="width: 98%; padding:  5px 1%;">
              <th style="width: 47%; padding: 0 1%; text-align: right; border-top: 1px lightgray dashed;">
                Info okno kurzov leadra na mape
              </th>
              <td style="border-top: 1px lightgray dashed;">
                %%wpEditorMarkerInfoWindowTemplateTeacher%%
                <span style="width: 100%;">Placeholdre: <code>%%courses_city%%</code>, <code>%%organizer%%</code>*, <code>%%school%%</code>*, <code>%%courses_info%%</code></span><br>
                <span style="width: 100%;">*Pozor: nepridavaj zalomenie riadkov (&lt;br&gt;, &lt;br /&gt;) pred a za placeholdre s hviezdickou - ak sa zamenia za prazdny text, ostane po nich prazdny riadok!
              </td>
            </tr>
      '
        // END replace template //
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
    if (defined('FLORP_DEVEL_PURGE_PARTICIPANTS_ON_SAVE') && FLORP_DEVEL_PURGE_PARTICIPANTS_ON_SAVE === true ) {
      $this->aOptions['aParticipants'] = $this->aOptionDefaults["aParticipants"];
    }
    if (defined('FLORP_DEVEL_PURGE_TSHIRTS_ON_SAVE') && FLORP_DEVEL_PURGE_TSHIRTS_ON_SAVE === true ) {
      $this->aOptions['aTshirts'] = $this->aOptionDefaults["aTshirts"];
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
    if ($this->aOptions["bCoursesInfoDisabled"] || empty($aData['school_name'])) {
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
    if (empty($aInfoWindowData['user_webpage']['value'])) {
      $strOrganizer = $this->getInfoWindowLabel('organizer').$aInfoWindowData['first_name']['value'] . " " . $aInfoWindowData['last_name']['value'];
    } else {
      $strOrganizer = $this->getInfoWindowLabel('organizer').'<a href="'.$aInfoWindowData['user_webpage']['value'].'" target="_blank">'.$aInfoWindowData['first_name']['value'] . " " . $aInfoWindowData['last_name']['value'].'</a>';
    }

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
    if (!$this->aOptions["bCoursesInfoDisabled"] && !empty($aInfoWindowData['school_name']['value'])) {
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
      "youtube"   => '~^https?://(www\.|m\.)?youtube\.com/watch\?v=(.+)$~i',
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
      if (!isset($aVideoRegexMatches[2]) || empty($aVideoRegexMatches[2])) {
        $strEmbedCode = "";
      } else {
        $strYoutubeVideoParams = $aVideoRegexMatches[2];
        // Try to explode by &amp; and if it's not present, explode by & //
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
    if (empty($aInfoWindowData['flashmob_number_of_dancers']['value'])) {
      $strDancers = "";
    } else {
      $strDancers = $this->getInfoWindowLabel('dancers').$aInfoWindowData['flashmob_number_of_dancers']['value'];
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

    if ($aInfoWindowData['strMapType'] === 'flashmob_organizer' && ($aInfoWindowData['iCurrentYear'] == '1' || (isset($aInfoWindowData['iIsPreview']) && $aInfoWindowData['iIsPreview'] == '1')) && $aInfoWindowData['iBeforeFlashmob'] == '1') {
      $strSignupLink = $this->getInfoWindowLabel('signup').'<span class="florp-click-trigger florp-click-participant-trigger pum-trigger" data-user-id="'.$aInfoWindowData['iUserID'].'" data-flashmob-city="'.$aInfoWindowData['flashmob_city']['value'].'" data-marker-key="'.$aInfoWindowData['mixMarkerKey'].'" data-div-id="'.$aInfoWindowData['strDivID'].'" style="cursor: pointer;">'.$this->aOptions['strSignupLinkLabel'].'</span>';
      $strParticipantCount = $this->getInfoWindowLabel('participant_count').$aInfoWindowData['iParticipantCount'];
    } else {
      $strSignupLink = "";
      $strParticipantCount = "";
    }

    // Separate optional placeholders by a line break //
    $aPlaceholdersToSeparate = array( 'organizer' => 'strOrganizer', 'school' => 'strSchool', 'school_web' => 'strSchoolWeb', 'web' => 'strWeb', 'facebook' => 'strFacebook', 'dancers' => 'strDancers', 'year' => 'strYear', 'note' => 'strNote', 'signup' => 'strSignupLink', 'participant_count' => 'strParticipantCount' );
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

    $aSearch = array( 'flashmob_city', 'organizer', 'school', 'web', 'facebook', 'embed_code', 'dancers', 'year', 'note', 'courses_city' ,'courses_info', 'signup', 'participant_count' );
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
//     if ($aInfoWindowData['strMapType'] === "teacher") {
//       // This is a tag only for the organizer info window //
//       $strWeb = "";
//     }
    $aReplace = array( $strLocation, $strOrganizer, $strSchool, $strWeb, $strFacebook, $strEmbedCode, $strDancers, $strYear, $strNote, $strLocation, $strCoursesInfo, $strSignupLink, $strParticipantCount );
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
        update_site_option( $this->strOptionKey, $this->aOptions, true );
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

  public function is_main_blog() {
    return $this->isMainBlog;
  }

  public function is_flashmob_blog() {
    return $this->isFlashmobBlog;
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
    if (!is_multisite()) {
      deactivate_plugins( plugin_basename( __FILE__ ) );
      wp_die( 'This plugin requires a multisite WP installation.  Sorry about that.' );
    }
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
function florp_is_main_blog() {
  global $FLORP;
  return $FLORP->is_main_blog();
}
function florp_is_flashmob_blog() {
  global $FLORP;
  return $FLORP->is_flashmob_blog();
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
