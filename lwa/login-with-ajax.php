<?php
if (defined('LOGIN_WITH_AJAX_VERSION')) {
  die();
}
/*
Original plugin: Login With Ajax [http://wordpress.org/extend/plugins/login-with-ajax/] by Marcus Sykes [http://msyk.es]

Copyright (C) 2016 NetWebLogic LLC

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

Changes compared to original plugin:
  - Changed JS file to non-minimized one
  - Commented out lines 58-60 in /widget/login-with-ajax.source.js
  - Replaced register function
  - Replaced register_new_user with wp_create_user
*/

define('LOGIN_WITH_AJAX_VERSION', '3.1.7');
class LoginWithAjax {

	/**
	 * If logged in upon instantiation, it is a user object.
	 * @var WP_User
	 */
	public static  $current_user;
	/**
	 * List of templates available in the plugin dir and theme (populated in init())
	 * @var array
	 */
	public static $templates = array();
	/**
	 * Name of selected template (if selected)
	 * @var string
	 */
	public static $template;
	/**
	 * lwa_data option
	 * @var array
	 */
	public static $data;
	/**
	 * Location of footer file if one is found when generating a widget, for use in loading template footers.
	 * @var string
	 */
	public static $footer_loc;
	/**
	 * URL for the AJAX Login procedure in templates (including callback and template parameters)
	 * @var string
	 */
	public static $url_login;
	/**
	 * URL for the AJAX Remember Password procedure in templates (including callback and template parameters)
	 * @var string
	 */
	public static $url_remember;
	/**
	 * URL for the AJAX Registration procedure in templates (including callback and template parameters)
	 * @var string
	 */
	public static $url_register;

	// Actions to take upon initial action hook
	public static function init(){
		//Load LWA options
		self::$data = get_option('lwa_data');
		//Remember the current user, in case there is a logout
		self::$current_user = wp_get_current_user();

		//Get Templates from theme and default by checking for folders - we assume a template works if a folder exists!
		//Note that duplicate template names are overwritten in this order of precedence (highest to lowest) - Child Theme > Parent Theme > Plugin Defaults
		//First are the defaults in the plugin directory
		self::find_templates( path_join( WP_PLUGIN_DIR . "/flashmob-organizer-profile", basename( dirname( __FILE__ ) ). "/widget/") );
		//Now, the parent theme (if exists)
		if( get_stylesheet_directory() != get_template_directory() ){
			self::find_templates( get_template_directory().'/plugins/login-with-ajax/' );
		}
		//Finally, the child theme
		self::find_templates( get_stylesheet_directory().'/plugins/login-with-ajax/' );

		//Generate URLs for login, remember, and register
		self::$url_login = self::template_link(site_url('wp-login.php', 'login_post'));
		self::$url_register = self::template_link(self::getRegisterLink());
		self::$url_remember = self::template_link(site_url('wp-login.php?action=lostpassword', 'login_post'));

		//Make decision on what to display
		if ( !empty($_REQUEST["lwa"]) ) { //AJAX Request
		    self::ajax();
		}elseif ( isset($_REQUEST["login-with-ajax-widget"]) ) { //Widget Request via AJAX
			$instance = ( !empty($_REQUEST["template"]) ) ? array('template' => $_REQUEST["template"]) : array();
			$instance['profile_link'] = ( !empty($_REQUEST["lwa_profile_link"]) ) ? $_REQUEST['lwa_profile_link']:0;
			self::widget( $instance );
			exit();
		}else{
			//Enqueue scripts - Only one script enqueued here.... theme JS takes priority, then default JS
			if( !is_admin() ) {
			    //$js_url = defined('WP_DEBUG') && WP_DEBUG ? 'login-with-ajax.source.js':'login-with-ajax.js';
			    $js_url = 'login-with-ajax.source.js';
				wp_enqueue_script( "login-with-ajax", self::locate_template_url($js_url), array( 'jquery' ), LOGIN_WITH_AJAX_VERSION );
				wp_enqueue_style( "login-with-ajax", self::locate_template_url('widget.css'), array(), LOGIN_WITH_AJAX_VERSION );
        		$schema = is_ssl() ? 'https':'http';
        		$js_vars = array('ajaxurl' => admin_url('admin-ajax.php', $schema));
        		//calendar translations
        		wp_localize_script('login-with-ajax', 'LWA', apply_filters('lwa_js_vars', $js_vars));
			}

			//Add logout/in redirection
			add_action('wp_logout', 'LoginWithAjax::logoutRedirect');
			add_filter('logout_url', 'LoginWithAjax::logoutUrl');
			add_filter('login_redirect', 'LoginWithAjax::loginRedirect', 1, 3);
			add_shortcode('login-with-ajax', 'LoginWithAjax::shortcode');
			add_shortcode('lwa', 'LoginWithAjax::shortcode');
		}
	}

	public static function widgets_init(){
		//Include and register widget
		include_once('login-with-ajax-widget.php');
		register_widget("LoginWithAjaxWidget");
	}

	/*
	 * LOGIN OPERATIONS
	 */

	// Decides what action to take from the ajax request
	public static function ajax(){
		$return = array('result'=>false, 'error'=>'Unknown command requested');
		switch ( $_REQUEST["login-with-ajax"] ) {
			case 'login': //A login has been requested
        $return = self::login();
				break;
			case 'remember': //Remember the password
				$return = self::remember();
				break;
			case 'register': //Remember the password
			default: // backwards-compatible with templates where lwa = registration
			    $return = self::register();
			    break;
		}
// 		@header( 'Content-Type: application/javascript; charset=UTF-8', true ); //add this for HTTP -> HTTPS requests which assume it's a cross-site request
		echo self::json_encode(apply_filters('lwa_ajax_'.$_REQUEST["login-with-ajax"], $return));
		exit();
	}

	// Reads ajax login creds via POSt, calls the login script and interprets the result
	public static function login(){
		$return = array(); //What we send back
		if( !empty($_REQUEST['log']) && !empty($_REQUEST['pwd']) && trim($_REQUEST['log']) != '' && trim($_REQUEST['pwd'] != '') ){
			$credentials = array(
        'user_login'    => $_REQUEST['log'],
        'user_password' => $_REQUEST['pwd'],
        'remember'      => isset($_REQUEST['rememberme']) && !empty($_REQUEST['rememberme'])
      );
			if (class_exists('NSUR')) {
        $NSUR_instance = NSUR::get_instance();
        remove_action( 'wp_login', array( $NSUR_instance, 'nsur_add_subsite_to_logged_in_user' ) );
			}
			$loginResult = wp_signon($credentials, false);
			if (class_exists('NSUR')) {
        add_action( 'wp_login', array( $NSUR_instance, 'nsur_add_subsite_to_logged_in_user' ) );
			}
			$user_role = 'null';
			if ( is_wp_error($loginResult) ) {
        $return['result'] = false;
        $return['error'] = florp_get_message('login_error', __( '<strong>ERROR</strong>: Invalid username or password.' )); // $loginResult->get_error_message();
			} elseif ( strtolower(get_class($loginResult)) == 'wp_user' ) {
				//User login successful
				self::$current_user = $loginResult;
				/* @var $loginResult WP_User */
				$return['result'] = true;
				// $return['message'] = __("Login Successful, redirecting...",'login-with-ajax');
				$return['message'] = florp_get_message('login_success', __("Login Successful, redirecting...",'login-with-ajax'));
				//Do a redirect if necessary
				$redirect = self::getLoginRedirect(self::$current_user);
				if( !empty($_REQUEST['redirect_to']) ) $redirect= wp_sanitize_redirect($_REQUEST['redirect_to']);
				if( $redirect != '' ){
					$return['redirect'] = $redirect;
				}
				//If the widget should just update with ajax, then supply the URL here.
				if( !empty(self::$data['no_login_refresh']) && self::$data['no_login_refresh'] == 1 ){
					//Is this coming from a template?
					$query_vars = ( !empty($_REQUEST['template']) ) ? "&template={$_REQUEST['template']}" : '';
					$query_vars .= ( !empty($_REQUEST['lwa_profile_link']) ) ? "&lwa_profile_link=1" : '';
					$return['widget'] = get_bloginfo('wpurl')."?login-with-ajax-widget=1$query_vars";
					$return['message'] = __("Login successful, updating...",'login-with-ajax');
				}
			} elseif ( strtolower(get_class($loginResult)) == 'wp_error' ) {
				//User login failed
				/* @var WP_Error $loginResult */
				$return['result'] = false;
				$return['error'] = $loginResult->get_error_message();
			} else {
				//Undefined Error
				$return['result'] = false;
				$return['error'] = __('An undefined error has ocurred', 'login-with-ajax');
			}
		}else{
			$return['result'] = false;
			$return['error'] = __('Please supply your username and password.', 'login-with-ajax');
		}
		$return['action'] = 'login';
		//Return the result array with errors etc.
		return $return;
	}

	/**
	 * Checks post data and registers user, then exits
	 * @return string
	 */
  public static function register(){
    $return = array();
    if (get_option('users_can_register')) {
      $_REQUEST['user_login'] = trim($_REQUEST['user_login']);
      $_REQUEST['user_email'] = trim($_REQUEST['user_email']);
//       $_REQUEST['user_password'] = trim($_REQUEST['user_password']);
      if (!isset($_REQUEST['is_leader']) || $_REQUEST['is_leader'] !== 'true') {
        $return['result'] = false;
        $return['error'] = "Táto registrácia je pre organizátorov rueda flashmob-u. Ak nie ste organizátor, prosíme, neregistrujte sa, kontaktujte svojho Rueda inštruktora vo Vašom meste alebo najbližšom meste, aby sa zaregistroval a zorganizoval Flashmob. Ďakujeme za porozumenie.";
      } elseif (empty($_REQUEST['user_login'])) {
        $return['result'] = false;
        $return['error'] = "Užívateľské meno nie je vyplnené"; //__('Username is a required field!','login-with-ajax');
      } elseif (strlen($_REQUEST['user_login']) < 3 || preg_match("/[^a-zA-Z0-9_-]/", $_REQUEST['user_login']) || !preg_match("/^[a-zA-Z]/", $_REQUEST['user_login'])) {
        $return['result'] = false;
        $return['error'] = "Užívateľské meno "; //__('The selected username is invalid! Usernames must be without spaces, at least 3 characters long, may contain only characters a-z, A-Z, 0-9, _, -, and must start with a letter (a-z, A-Z).','login-with-ajax');
      } elseif (empty($_REQUEST['user_email'])) {
        $return['result'] = false;
        $return['error'] = "Email nie je vyplnený"; //__('Email is a required field!','login-with-ajax');
      } elseif (!preg_match("/[a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]+\.[a-zA-Z0-9_-]+/", $_REQUEST['user_email'])) {
        $return['result'] = false;
        $return['error'] = "Email je nesprávny"; //__('The selected email is invalid!','login-with-ajax');
      } elseif (strlen($_REQUEST['user_password']) < 7) {
        $return['result'] = false;
        $return['error'] = "Heslo je príliš krátke (aspoň 7 znakov)"; //__('The selected password is too short (must be at least 7 characters long)!','login-with-ajax');
      } else {
        $iUserID = username_exists( $_REQUEST['user_login'] );
        if (!$iUserID && !email_exists($_REQUEST['user_email'])) {
          $mixResult = wp_create_user( $_REQUEST['user_login'], $_REQUEST['user_password'], $_REQUEST['user_email'] );
          if ( !is_wp_error($mixResult) ) {
            // Success
            $iUserID = $mixResult;
            $return['result'] = true;
            $return['message'] = "Registrácia úspešne dokončená"; //__('Registration complete.','login-with-ajax');
            $return['loggingInMsg'] = "Prihlasujeme Vás... Prosíme, počkajte, kým sa stránka znovu načíta."; //__('Logging you in... Please wait until the page is reloaded.','login-with-ajax');
            $return['username'] = $_REQUEST['user_login'];
            $return['password'] = $_REQUEST['user_password'];
            // add user to blog if multisite //
            if (is_multisite()) {
              add_user_to_blog(get_current_blog_id(), $iUserID, get_option('default_role'));
            }
            // get blogname and send welcome mail //
            $strBlogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
            self::new_user_notification( $_REQUEST['user_login'], $_REQUEST['user_password'], $_REQUEST['user_email'], $strBlogname );

            // New user notification to admins //
            $message  = sprintf(__('New user registration on your site %s:'), $strBlogname) . "\n\n";
            $message .= sprintf(__('Username: %s'), $_REQUEST['user_login'] ) . "\n\n";
            $message .= sprintf(__('E-mail: %s'), $_REQUEST['user_email'] ) . "\n";
            $aAdminArgs = array(
              'blog_id' => get_current_blog_id(),
              'role'    => 'administrator'
            );
            $aAdmins = get_users( $aAdminArgs );
            if (empty($aAdmins)) {
              @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $strBlogname), $message);
            } else {
              foreach ($aAdmins as $iKey => $oAdmin) {
                @wp_mail($oAdmin->user_email, sprintf(__('[%s] New User Registration'), $strBlogname), $message);
              }
            }
          } else {
            // Something's wrong
            $return['result'] = false;
            $return['error'] = $mixResult->get_error_message();
          }
        } else {
          $return['result'] = false;
          if (email_exists($_REQUEST['user_email'])) {
            $return['error'] = "Zadaný email je už registrovaný."; //__('A user with the provided e-mail address already exists!','login-with-ajax');
          } else {
            $return['error'] = "Zadané užívateľské meno je už registrované."; //__('Username already exists!','login-with-ajax');
          }
        }
      }
      $return['action'] = 'register';
    } else {
      $return['result'] = false;
      $return['error'] = "Registrácia je zakázaná."; //__('Registration has been disabled.','login-with-ajax');
    }
    return $return;
  }
	public static function register_bak(){
	    $return = array();
	    if( get_option('users_can_register') ){
			$errors = register_new_user($_REQUEST['user_login'], $_REQUEST['user_email']);
			if ( !is_wp_error($errors) ) {
				//Success
				$return['result'] = true;
				$return['message'] = __('Registration complete. Please check your e-mail.','login-with-ajax');
				//add user to blog if multisite
				if( is_multisite() ){
				    add_user_to_blog(get_current_blog_id(), $errors, get_option('default_role'));
				}
			}else{
				//Something's wrong
				$return['result'] = false;
				$return['error'] = $errors->get_error_message();
			}
			$return['action'] = 'register';
	    }else{
	    	$return['result'] = false;
			$return['error'] = __('Registration has been disabled.','login-with-ajax');
	    }
		return $return;
	}

	// Reads ajax login creds via POST, calls the login script and interprets the result
	public static function remember(){
		$return = array(); //What we send back
		//if we're not on wp-login.php, we need to load it since retrieve_password() is located there
		if( !function_exists('retrieve_password') ){
		    ob_start();
		    include_once(ABSPATH.'wp-login.php');
		    ob_clean();
		}
		$result = retrieve_password();
		if ( $result === true ) {
			//Password correctly remembered
			$return['result'] = true;
			$return['message'] = __("We have sent you an email", 'login-with-ajax');
		} elseif ( strtolower(get_class($result)) == 'wp_error' ) {
			//Something went wrong
			/* @var $result WP_Error */
			$return['result'] = false;
			$return['error'] = $result->get_error_message();
		} else {
			//Undefined Error
			$return['result'] = false;
			$return['error'] = __('An undefined error has ocurred', 'login-with-ajax');
		}
		$return['action'] = 'remember';
		//Return the result array with errors etc.
		return $return;
	}

	//Added fix for WPML
	public static function logoutUrl( $logout_url ){
		//Add ICL if necessary
		if( defined('ICL_LANGUAGE_CODE') ){
			$logout_url .= ( strstr($logout_url,'?') !== false ) ? '&amp;':'?';
			$logout_url .= 'lang='.ICL_LANGUAGE_CODE;
		}
		return $logout_url;
	}

	public static function getRegisterLink(){
	    $register_link = false;
	    if ( function_exists('bp_get_signup_page') && (empty($_REQUEST['action']) || ($_REQUEST['action'] != 'deactivate' && $_REQUEST['action'] != 'deactivate-selected')) ) { //Buddypress
	    	$register_link = bp_get_signup_page();
	    }elseif ( is_multisite() ) { //MS
	    	$register_link = site_url('wp-signup.php', 'login');
	    } else {
	    	$register_link = site_url('wp-login.php?action=register', 'login');
	    }
	    return $register_link;
	}

	/*
	 * Redirect Functions
	 */

	public static function logoutRedirect(){
		$redirect = self::getLogoutRedirect();
		if($redirect != ''){
			wp_redirect($redirect);
			exit();
		}
	}

	public static function getLogoutRedirect(){
		$data = self::$data;
		//Global redirect
		$redirect = '';
		if( !empty($data['logout_redirect']) ){
			$redirect = $data['logout_redirect'];
		}
		//WPML global redirect
		$lang = !empty($_REQUEST['lang']) ? $_REQUEST['lang']:'';
		$lang = apply_filters('lwa_lang', $lang);
		if( !empty($lang) ){
			if( isset($data["logout_redirect_".$lang]) ){
				$redirect = $data["logout_redirect_".$lang];
			}
		}
		//Role based redirect
		if( strtolower(get_class(self::$current_user)) == "wp_user" ){
			//Do a redirect if necessary
			$data = self::$data;
			$user_role = array_shift(self::$current_user->roles); //Checking for role-based redirects
			if( !empty($data["role_logout"]) && is_array($data["role_logout"]) && isset($data["role_logout"][$user_role]) ){
				$redirect = $data["role_logout"][$user_role];
			}
			//Check for language redirects based on roles
			if( !empty($lang) ){
				if( isset($data["role_logout"][$user_role."_".$lang]) ){
					$redirect = $data["role_logout"][$user_role."_".$lang];
				}
			}
		}
		//final replaces
		if( !empty($redirect) ){
			$redirect = str_replace("%LASTURL%", $_SERVER['HTTP_REFERER'], $redirect);
			if( !empty($lang) ){
				$redirect = str_replace("%LANG%", $lang.'/', $redirect);
			}
		}
		return esc_url_raw($redirect);
	}

	public static function loginRedirect( $redirect, $redirect_notsurewhatthisis, $user ){
		$data = self::$data;
		if( is_object($user) ){
			$lwa_redirect = self::getLoginRedirect($user);
			if( $lwa_redirect != '' ){
				$redirect = $lwa_redirect;
			}
		}
		return $redirect;
	}

	public static function getLoginRedirect($user){
		$data = self::$data;
		//Global redirect
		$redirect = false;
		if( !empty($data['login_redirect']) ){
			$redirect = $data["login_redirect"];
		}
		//WPML global redirect
		$lang = !empty($_REQUEST['lang']) ? $_REQUEST['lang']:'';
		$lang = apply_filters('lwa_lang', $lang);
		if( !empty($lang) && isset($data["login_redirect_".$lang]) ){
			$redirect = $data["login_redirect_".$lang];
		}
		//Role based redirects
		if( strtolower(get_class($user)) == "wp_user" ){
			$user_role = array_shift($user->roles); //Checking for role-based redirects
			if( isset($data["role_login"][$user_role]) ){
				$redirect = $data["role_login"][$user_role];
			}
			//Check for language redirects based on roles
			if( !empty($lang) && isset($data["role_login"][$user_role."_".$lang]) ){
				$redirect = $data["role_login"][$user_role."_".$lang];
			}
			//Do user string replacements
			$redirect = str_replace('%USERNAME%', $user->user_login, $redirect);
		}
		//Do string replacements
		$redirect = str_replace("%LASTURL%", wp_get_referer(), $redirect);
		if( !empty($lang) ){
			$redirect = str_replace("%LANG%", $lang.'/', $redirect);
		}
		return esc_url_raw($redirect);
	}

	/*
	 * WIDGET OPERATIONS
	 */

	public static function widget($instance = array() ){
		//Extract widget arguments
		//Merge instance options with global default options
		$lwa_data = wp_parse_args($instance, self::$data);
		//Deal with specific variables
		$is_widget = false; //backwards-comatibility for overriden themes, this is now done within the WP_Widget class
		$lwa_data['profile_link'] = ( !empty($lwa_data['profile_link']) && $lwa_data['profile_link'] != "false" );
		$lwa_data['hide_info_box'] = ( !empty($lwa_data['hide_info_box']) && $lwa_data['hide_info_box'] != "false" );
		//Add template logic
		$defaultTemplate = array_key_exists( 'florp', self::$templates ) ? 'florp' : 'default';
		self::$template = ( !empty($lwa_data['template']) && array_key_exists($lwa_data['template'], self::$templates) ) ? $lwa_data['template'] : $defaultTemplate;
		//Choose the widget content to display.
		// echo "<pre>".var_export($lwa_data, true)."</pre>";
		$bRegistrationFormOnly = $lwa_data['registration-form-only'] !== false && ($lwa_data['registration-form-only'] === "1" || $lwa_data['registration-form-only'] === 1 || strtolower($lwa_data['registration-form-only']) === "true");
    $bLoginOnly = $lwa_data['login-form-only'] !== false && ($lwa_data['login-form-only'] === "1" || $lwa_data['login-form-only'] === 1 || strtolower($lwa_data['login-form-only']) === "true");
		if (is_user_logged_in()) {
      if ($bLoginOnly) {
        // nothing to show //
        return;
      }
      //Firstly check for template in theme with no template folder (legacy)
      $template_loc = locate_template( array('plugins/login-with-ajax/widget_in.php') );
      //Then check for custom templates or theme template default
      $template_loc = ($template_loc == '' && self::$template) ? self::$templates[self::$template].'/widget_in.php':$template_loc;
      include ( $template_loc != '' && file_exists($template_loc) ) ? $template_loc : 'widget/'.$defaultTemplate.'/widget_in.php';
    } elseif ($bRegistrationFormOnly) {
      $template_loc = locate_template( array('plugins/login-with-ajax/widget_out_registration_only.php') );
      //Then check for custom templates or theme template default
      $template_loc = ($template_loc == '' && self::$template) ? self::$templates[self::$template].'/widget_out_registration_only.php':$template_loc;
      include ( $template_loc != '' && file_exists($template_loc) ) ? $template_loc : 'widget/'.$defaultTemplate.'/widget_out_registration_only.php';
//     } elseif ($bLoggedInFormOnly) {
//       if (is_user_logged_in()) {
//         //Firstly check for template in theme with no template folder (legacy)
//         $template_loc = locate_template( array('plugins/login-with-ajax/widget_in.php') );
//         //Then check for custom templates or theme template default
//         $template_loc = ($template_loc == '' && self::$template) ? self::$templates[self::$template].'/widget_in.php':$template_loc;
//         include ( $template_loc != '' && file_exists($template_loc) ) ? $template_loc : 'widget/default/widget_in.php';
//       } else {
//         echo '<span class="warning">You have to be logged in to continue.</span>';
//       }
		} else {
      if ($bLoginOnly) {
        $lwa_data['registration'] = false;
      }
      //quick/easy WPML fix, should eventually go into a seperate file
      if(  defined('ICL_LANGUAGE_CODE') ){
          if( !function_exists('lwa_wpml_input_var') ){
                  function lwa_wpml_input_var(){ echo '<input type="hidden" name="lang" value="'.esc_attr(ICL_LANGUAGE_CODE).'" />'; }
          }
          foreach( array('login_form','lwa_register_form', 'lostpassword_form') as $action ) add_action($action, 'lwa_wpml_input_var');
      }
			//Firstly check for template in theme with no template folder (legacy)
			$template_loc = locate_template( array('plugins/login-with-ajax/widget_out.php') );
			//First check for custom templates or theme template default
			$template_loc = ($template_loc == '' && self::$template) ? self::$templates[self::$template].'/widget_out.php' : $template_loc;
			include ( $template_loc != '' && file_exists($template_loc) ) ? $template_loc : 'widget/'.$defaultTemplate.'/widget_out.php';
			//quick/easy WPML fix, should eventually go into a seperate file
			if(  defined('ICL_LANGUAGE_CODE') ){
			    foreach( array('login_form','lwa_register_form', 'lostpassword_form') as $action ) remove_action($action, 'lwa_wpml_input_var');
			}
		}
	}

	public static function shortcode($atts){
    $lwa_data = get_option('lwa_data');
    if (!empty($lwa_data['template']) && array_key_exists( $lwa_data['template'], self::$templates )) {
      $strTemplate = $lwa_data['template'];
    } elseif (array_key_exists( 'florp', self::$templates )) {
      $strTemplate = 'florp';
    } else {
      $strTemplate = 'default';
    }
		ob_start();
		$defaults = array(
			'profile_link' => true,
			'template' => $strTemplate,
			'registration' => true,
			'redirect' => false,
			'remember' => true,
			'registration-form-only' => false,
      'login-form-only' => false,
      'logged-in-form-only' => false,
      'hide_info_box' => false,
		);
		self::widget(shortcode_atts($defaults, $atts));
		return ob_get_clean();
	}

	public static function new_user_notification($user_login, $password, $user_email, $blogname, $message = false, $subject = false, $mixHeaders = '', $attachments = array() ){
		//Copied out of /wp-includes/pluggable.php
		if (!$message) {
      $message = self::$data['notification_message'];
		}
		$message = str_replace('%USERNAME%', $user_login, $message);
		$message = str_replace('%PASSWORD%', $password, $message);
		$message = str_replace('%EMAIL%', $user_email, $message);
		$message = str_replace('%BLOGNAME%', $blogname, $message);
		$message = str_replace('%BLOGURL%', home_url(), $message);

		if (!$subject) {
      $subject = self::$data['notification_subject'];
		}
		$subject = str_replace('%BLOGNAME%', $blogname, $subject);
		$subject = str_replace('%BLOGURL%', home_url(), $subject);

		wp_mail($user_email, $subject, $message, $mixHeaders, $attachments);
	}

	/*
	 * Auxillary Functions
	 */

	/**
	 * Returns the URL for a relative filepath which would be located in either a child, parent or plugin folder in order of priority.
	 *
	 * This would search for $template_path within:
	 * /wp-content/themes/your-child-theme/plugins/login-with-ajax/...
	 * /wp-content/themes/your-parent-theme/plugins/login-with-ajax/...
	 * /wp-content/plugins/login-with-ajax/widget/...
	 *
	 * It is assumed that the file always exists within the core plugin folder if the others aren't found.
	 *
	 * @param string $template_path
	 * @return string
	 */
	public static function locate_template_url($template_path){
	    if( file_exists(get_stylesheet_directory().'/plugins/login-with-ajax/'.$template_path) ){ //Child Theme (or just theme)
	    	return trailingslashit(get_stylesheet_directory_uri())."plugins/login-with-ajax/$template_path";
	    }else if( file_exists(get_template_directory().'/plugins/login-with-ajax/'.$template_path) ){ //Parent Theme (if parent exists)
	    	return trailingslashit(get_template_directory_uri())."plugins/login-with-ajax/$template_path";
	    }
	    //Default file in plugin folder
	    return trailingslashit(plugin_dir_url(__FILE__))."widget/$template_path";
	}

	//Checks a directory for folders and populates the template file
	public static function find_templates($dir){
		if (is_dir($dir)) {
		    if ($dh = opendir($dir)) {
		        while (($file = readdir($dh)) !== false) {
		            if(is_dir($dir . $file) && $file != '.' && $file != '..' && $file != '.svn'){
		            	//Template dir found, add it to the template array
		            	self::$templates[$file] = path_join($dir, $file);
		            }
		        }
		        closedir($dh);
		    }
		}
	}

	/**
	 * Add template link and JSON callback var to the URL
	 * @param string $content
	 * @return string
	 */
	public static function template_link( $content ){
		return add_query_arg(array('template'=>self::$template), $content);
	}

	/**
	 * Returns a sanitized JSONP response from an array
	 * @param array $array
	 * @return string
	 */
	public static function json_encode($array){
		$return = json_encode($array);
		if( isset($_REQUEST['callback']) && preg_match("/^jQuery[_a-zA-Z0-9]+$/", $_REQUEST['callback']) ){
			$return = $_REQUEST['callback']."($return)";
		}
		return $return;
	}
}
//Set when to init this class
add_action( 'init', 'LoginWithAjax::init' );
add_action( 'widgets_init', 'LoginWithAjax::widgets_init' );

//Installation and Updates
$lwa_data = get_option('lwa_data');
if( version_compare( get_option('lwa_version',0), LOGIN_WITH_AJAX_VERSION, '<' ) ){
    include_once('lwa-install.php');
}

//Add translation
function lwa_load_plugin_textdomain(){
	load_plugin_textdomain('login-with-ajax', false, "login-with-ajax/langs");
}
add_action('plugins_loaded','lwa_load_plugin_textdomain');

//Include admin file if needed
if(is_admin()){
	include_once('login-with-ajax-admin.php');
}

//Include pluggable functions file if user specifies in settings
if( !empty($lwa_data['notification_override']) ){
	include_once('pluggable.php');
}

//Template Tag
function login_with_ajax($atts = ''){
    if( !array($atts) ) $atts = shortcode_parse_atts($atts);
	echo LoginWithAjax::shortcode($atts);
}
