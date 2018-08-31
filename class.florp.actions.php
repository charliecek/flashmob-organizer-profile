<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Actions_Florp
 * Adds NF username / email validation
 */
final class NF_Actions_Florp extends NF_Abstracts_Action
{
    /**
     * @var string
     */
    protected $_name  = 'florp';

    /**
     * @var array
     */
    protected $_tags = array();

    /**
     * @var string
     */
    protected $_timing = 'early';

    /**
     * @var int
     */
    protected $_priority = 10;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'FestSRD: Organizer profile validation', 'ninja-forms' );

        $settings = array();
//         $settings = Ninja_Forms::config( 'ActionFlorpSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );
    }

    /*
    * PUBLIC METHODS
    */

    public function save( $action_settings )
    {

    }

    public function process( $action_settings, $form_id, $data )
    {
//       file_put_contents(
//         __dir__ . "/kk-florp-nf-debug.log",
//         '==== $action_settings ===='.PHP_EOL.var_export( $action_settings, true ).PHP_EOL
//           .'==== $form_id ===='.PHP_EOL.var_export( $form_id, true ).PHP_EOL
//           .'==== $data ===='.PHP_EOL.var_export( $data, true ).PHP_EOL
//         //, FILE_APPEND | LOCK_EX
//       );
      if ($form_id == florp_get_profile_form_id_main()) {
        setcookie('florp-form-saved', "0", time() + (1 * 24 * 60 * 60), '/');
        $aPwdCheck = array();
        $aVideoTypes= array(
          'youtube_link'  => array( 'name' => 'Youtube', 'regex' => '~^https?://(www\.|m\.)?youtube\.com/watch\?v=(.+)$~i'),
          'facebook_link' => array( 'name' => 'Facebook', 'regex' => '~^https?://(www.)?facebook.com/[a-zA-Z0-9]+/videos/[a-zA-Z0-9]+/?$~i'),
          'vimeo_link'    => array( 'name' => 'Vimeo', 'regex' => '~^https?://(www.)?vimeo.com/([0-9]+)/?$~i'),
        );
        $bUserIsLoggedIn = is_user_logged_in();
        if ($bUserIsLoggedIn) {
          $aCurUserInfo = get_currentuserinfo();
        }
        $aKeyToValue = array();
        $aKeyToLabel = array();
        foreach ($data['fields'] as $field_id => $field_value ) {
          $strKey = $field_value['key'];
          $strValue = $field_value['value'];
          $aKeyToValue[$strKey] = $strValue;
          $aKeyToLabel[$strKey] = "";
          if (!empty($field_value['label'])) {
            $aKeyToLabel[$strKey] = $field_value['label'];
          }
        }
        foreach ($data['fields'] as $field_id => $field_value ) {
          $strKey = $field_value['key'];
          $strValue = $field_value['value'];
          if ($strKey == 'subscriber_type') { // old way //
            $aSubscriberType = $strValue;
            break;
          } elseif ($strKey == 'flashmob_organizer' || $strKey == 'teacher') { // new way //
            if (!isset($aSubscriberType)) {
              $aSubscriberType = array();
            }
            $aSubscriberType[] = $strKey;
          }
        }
        foreach ($data['fields'] as $field_id => $field_value ) {
          $strKey = $field_value['key'];
          $strValue = $field_value['value'];
          $strLabel = "";
          if (!empty($field_value['label'])) {
            $strLabel = $field_value['label'].": ";
          }
          switch( $strKey ) {
            case "user_email":
              $strValue = trim( $strValue );
              if ($bUserIsLoggedIn && email_exists( $strValue ) && $aCurUserInfo->user_email != $strValue) {
                $data[ 'errors' ][ 'form' ][$strKey] = $strLabel.'Zadaný e-mail už je zaregistrovaný'; //__( 'The submitted email is in use already', 'florp' ); // Zadaný e-mail už je zaregistrovaný
              } elseif (!$bUserIsLoggedIn && email_exists( $strValue )) {
                $data[ 'errors' ][ 'form' ][$strKey] = $strLabel.'Zadaný e-mail už je zaregistrovaný'; //__( 'The submitted email is in use already', 'florp' ); // Zadaný e-mail už je zaregistrovaný
              }
              break;
            case "facebook":
            case "custom_webpage":
            case "video_link":
              if (!empty($strValue)) {
                $strRegex = '/^https?\:\/\/([a-z0-9][a-z0-9_-]*\.)+[a-z0-9_-]*(\/.*)?$/i';
                $mixCheckRes = preg_match( $strRegex, $strValue );
                if (!$mixCheckRes) {
                  $data[ 'errors' ][ 'form' ][$strKey] = $strLabel.'Zadaná hodnota "'.$strValue.'" nie je validným linkom webovej stránky!';
                } elseif ($strKey === "video_link") {
                  $strVideoLinkType = false;
                  foreach($aVideoTypes as $strType => $strRegex) {
                    if (preg_match( $strRegex, $strValue )) {
                      $strVideoLinkType = $strType;
                      break;
                    }
                  }
                  if (!$strVideoLinkType) {
                    $data[ 'errors' ][ 'form' ][$strKey] = $strLabel.'Zadaná hodnota "'.$strValue.'" nie je validným linkom videa (povolené typy: facebook, vimeo, youtube). Ak by ste chceli pridať iný typ videa, napíšte nám.';
                  }
                } elseif ($strKey === "facebook") {
                  $strRegex = '/^https?\:\/\/(www\.)?facebook\.com\/.+$/i';
                  if (!preg_match( $strRegex, $strValue )) {
                    $data[ 'errors' ][ 'form' ][$strKey] = $strLabel.'Zadaná hodnota "'.$strValue.'" nie je validným facebook linkom!';
                  }
                }
              }
              break;
            case "user_pass":
            case "passwordconfirm":
              if (!empty($strValue)) {
                $aPwdCheck[$strKey] = $strValue;
              }
              break;
            case "flashmob_city":
              if ($strValue === "null") {
                if (in_array("flashmob_organizer", $aSubscriberType)) {
                  $data[ 'errors' ][ 'form' ][$strKey] = $strLabel."Zaškrtli ste, že zorganizujete flashmob, takže toto pole je povinné!";
                }
                break;
              }
              if (!in_array("flashmob_organizer", $aSubscriberType)) {
                break;
              }
              global $wpdb;
              $iUserID = get_current_user_id();
              $strQuery = 'SELECT *
                FROM ' . $wpdb->usermeta . '
                WHERE
                  user_id != ' . $iUserID . '
                  AND meta_key = "'.$strKey.'"
                  AND trim(lower(meta_value)) = "' . trim(strtolower($strValue)) . '"';
              $results = $wpdb->get_results(
                $strQuery,
                ARRAY_N
              );
              if (!empty($results)) {
                $data[ 'errors' ][ 'form' ][$strKey] = $strLabel."V databáze už existuje líder, ktorý organizuje flashmob v meste '$strValue'!";
              }
              break;
            default:
          }
        }
        if (!empty($aPwdCheck)) {
          if (!empty($aPwdCheck['user_pass']) && empty($aPwdCheck['passwordconfirm'])) {
            $data[ 'errors' ][ 'form' ]['user_pass'] = 'Nezadali ste heslo na potvrdenie';
          } elseif ($aPwdCheck['user_pass'] !== $aPwdCheck['passwordconfirm']) {
            $data[ 'errors' ][ 'form' ]['user_pass'] = 'Heslá sa nezhodujú';
          } elseif (strlen($aPwdCheck['user_pass']) < 7) {
            $data[ 'errors' ][ 'form' ]['user_pass'] = 'Heslo je príliš krátke (aspoň 7 znakov)';
          }
        }
        if ($aKeyToValue["school_webpage"] === "vlastna" && empty($aKeyToValue["custom_school_webpage"])) {
          $data[ 'errors' ][ 'form' ][] = $aKeyToLabel['custom_school_webpage'].' je povinné pole!';
        }
//         if (empty($data[ 'errors' ][ 'form' ])) {
//           $data[ 'errors' ][ 'form' ][] = 'DEVEL STOP';
//           $data[ 'errors' ][ 'form' ][] = '<pre>'.var_export($aKeyToValue, true).'</pre>';
//         }
  //       if ($bUserIsLoggedIn) {
  //         $data[ 'errors' ][ 'form' ][] = 'DEVEL STOP';
  //       }
  //       if (!$bUserIsLoggedIn) {
  //         $data[ 'errors' ][ 'form' ][] = 'DEVEL STOP';
  //         $data[ 'errors' ][ 'form' ][] = '<pre>'.var_export($data['fields'], true).'</pre>';
  //       }
  //       $data[ 'errors' ][ 'form' ][] = 'DEVEL STOP';
      } elseif ($form_id == florp_get_profile_form_id_flashmob()) {
        $bGenderOK = false;
        foreach ($data['fields'] as $field_id => $field_value ) {
          $strKey = $field_value['key'];
          $strValue = $field_value['value'];
          $strType = $field_value['type'];
          switch( $strKey ) {
            case "user_email":
              $strValue = trim( $strValue );
              if (email_exists( $strValue ) || florp_flashmob_participant_exists( $strValue )) {
                $data[ 'errors' ][ 'form' ][$strKey] = 'Zadaný e-mail už je zaregistrovaný'; //__( 'The submitted email is in use already', 'florp' ); // Zadaný e-mail už je zaregistrovaný
              }
              break;
            case "gender":
              $bGenderOK = in_array($strValue, array("muz", "zena"));
          }
          if ($strType === 'listselect' && $field_value['required'] == 1 && $strValue === 'null') {
            $data[ 'errors' ][ 'form' ][$strKey] = '"'.$field_value['label'].'" je povinné pole';
          } elseif ($strType === 'listradio' && $field_value['required'] == 1 && !$strValue) {
            $data[ 'errors' ][ 'form' ][$strKey] = '"'.$field_value['label'].'" je povinné pole';
          }
//           $data[ 'errors' ][ 'form' ][] = '<pre>'.var_export($data['fields'], true).'</pre>';
//           $data[ 'errors' ][ 'form' ][] = 'DEVEL STOP';
        }
        if (empty($data[ 'errors' ][ 'form' ]) && !$bGenderOK) {
          $data[ 'errors' ][ 'form' ][$strKey] = '"Pohlavie" je povinné pole!';
        }
      }
      return $data;
    }
}
