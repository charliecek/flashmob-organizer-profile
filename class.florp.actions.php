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
      if ($form_id != 2) {
        return $data;
      }
      setcookie('florp-form-saved', "0", time() + (1 * 24 * 60 * 60), '/');
      $aPwdCheck = array();
      $aVideoTypes= array(
        'youtube_link'  => array( 'name' => 'Youtube', 'regex' => '~^https?://(www\.|m\.)?youtube\.com/watch\?v=(.+)$~i'),
        'facebook_link' => array( 'name' => 'Facebook', 'regex' => '~^https?://(www.)?facebook.com/[a-zA-Z0-9]+/videos/[a-zA-Z0-9]+/?$~i'),
        'vimeo_link'    => array( 'name' => 'Vimeo', 'regex' => '~^https?://(www.)?vimeo.com/([0-9]+)/?$~i'),
      );
      foreach ($data['fields'] as $field_id => $field_value ) {
        $strKey = $field_value['key'];
        $strValue = $field_value['value'];
        switch( $strKey ) {
          case "user_email":
            $strValue = trim( $strValue );
            $aCurUserInfo = get_currentuserinfo();
            if( email_exists( $strValue ) && $aCurUserInfo->user_email != $strValue ) {
              $data[ 'errors' ][ 'form' ][$strKey] = 'Zadaný e-mail už je zaregistrovaný'; //__( 'The submitted email is in use already', 'florp' ); // Zadaný e-mail už je zaregistrovaný
            }
            break;
          case "webpage":
          case "school_webpage":
          case "facebook_link":
          case "youtube_link":
          case "vimeo_link":
            if (!empty($strValue)) {
              $strRegex = '/^https?\:\/\/([a-z0-9][a-z0-9_-]*\.)+[a-z0-9_-]*(\/.*)?$/i';
              $mixCheckRes = preg_match( $strRegex, $strValue );
              if (!$mixCheckRes) {
                $data[ 'errors' ][ 'form' ][$strKey] = 'Zadaná hodnota "'.$strValue.'" nie je validný link webovej stránky!';
              } else if (isset($aVideoTypes[$strKey]) && !preg_match( $aVideoTypes[$strKey]['regex'], $strValue )) {
                $data[ 'errors' ][ 'form' ][$strKey] = 'Zadaná hodnota "'.$strValue.'" nie je validný link videa typu '.$aVideoTypes[$strKey]['name'].'. Ak typ videa, ktoré pridávate, nie je medzi možnosťami, prosíme, vyberte možnosť "Iné" a vložte úplný embedovací kód.';
              }
            }
            break;
          case "user_pass":
          case "passwordconfirm":
            if (!empty($strValue)) {
              $aPwdCheck[$strKey] = $strValue;
            }
            break;
          case "school_city":
            if ($strValue === "null") {
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
              $data[ 'errors' ][ 'form' ][$strKey] = "V databáze už existuje používateľ s mestom pôsobenia nastaveným na '$strValue'!";
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
        }
      }
//       $data[ 'errors' ][ 'form' ][] = 'DEVEL STOP';
      return $data;
      //$data[ 'errors' ][ 'form' ] = $errors;
        
        /*
    $aFields = array();
    $bError = false;
    $all_fields = $ninja_forms_processing->get_all_fields();
    foreach( $all_fields as $field_id => $user_value ) {
        //var_dump( $field_id, $ninja_forms_processing->get_field_settings( $field_id ) );
        $aData = $ninja_forms_processing->get_field_settings( $field_id )['data'];
        if( isset( $aData['admin_label'] ) ) {
          $strKey = $aData['admin_label'];
          //email,uname,pwd,titul,fname,lname,rok-ukoncenia,status,mesto,okres,
          //pracujem,telefon,pracovisko,preferovani-klienti,preferovani-klienti-ine,
          //dalsie-vzdelavanie,preposielanie,spolupraca,
          //podmienky-pouzivania
          switch( $strKey ) {
              case "email":
                $aFields['email'] = $user_value;
                if( email_exists( $user_value )) {
                    $ninja_forms_processing->add_error( 'error_email', 'Zadaný e-mail už je zaregistrovaný.' );
                    $bError = true;
                }
                break;
              case "uname":
                $aFields['uname'] = $user_value;
                if( username_exists( $user_value )) {
                    $ninja_forms_processing->add_error( 'error_username', 'Zadané používateľské meno už je zaregistrované.' );
                    $bError = true;
                }
                break;
              case "podmienky-pouzivania":
                $aFields['podmienky-pouzivania'] = $user_value;
                if( 'checked' !== $user_value ) {
                    $ninja_forms_processing->add_error( 'error_username', 'K registrácii je nutné súhlasiť s podmienkami používania.' );
                    $bError = true;
                }
              default:
          }
        }
    }
    $objWPError = wpmu_validate_user_signup( $aFields['uname'], $aFields['email'] );
    if( is_wp_error( $objWPError ) ) {
      $aCodes = $objWPError->get_error_codes();
      foreach( $aCodes as $code ) {
        $ninja_forms_processing->add_error( $code, $objWPError->get_error_messages($code) );
      }
    } elseif( !$bError ) {
      //echo "no error";
    }
        */
        return $data;
    }
}