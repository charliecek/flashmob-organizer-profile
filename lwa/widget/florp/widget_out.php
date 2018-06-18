<?php 
/*
 * This is the page users will see logged out. 
 * You can edit this, but for upgrade safety you should copy and modify this file into your template folder.
 * The location from within your template folder is plugins/login-with-ajax/ (create these directories if they don't exist)
*/
?>
<div class="lwa lwa-default" data-id-prefix="" >
  <?php do_action( 'lwa_before_login_form', $lwa_data ); ?>
  <span class="lwa-status"></span>
  <form class="lwa-form" action="<?php echo esc_attr(LoginWithAjax::$url_login); ?>" method="post">
    <div class="lwa-username">
      <?php $msg = "Prihlasovacie meno alebo e-mailová adresa"; ?>
      <label for="lwa_user_login"><?php esc_html_e( $msg, 'login-with-ajax' ); ?></label>
      <input type="text" name="log" id="lwa_user_login" class="input"  value="<?php echo esc_attr($msg); ?>" onfocus="if(this.value == '<?php echo esc_attr($msg); ?>'){this.value = '';}" onblur="if(this.value == ''){this.value = '<?php echo esc_attr($msg); ?>'}" />
    </div>

    <div class="lwa-password">
      <?php $msg = "Heslo"; ?>
      <label for="lwa_user_pass"><?php esc_html_e( $msg, 'login-with-ajax' ); ?></label>
      <input type="password" name="pwd" id="lwa_user_pass" class="input"  value="<?php echo esc_attr($msg); ?>" onfocus="if(this.value == '<?php echo esc_attr($msg); ?>'){this.value = '';}" onblur="if(this.value == ''){this.value = '<?php echo esc_attr($msg); ?>'}" />
    </div>
    <div class="lwa-links">
      <input id="lwa_rememberme" name="rememberme" type="checkbox" class="lwa-rememberme" value="forever" />
      <label for="lwa_rememberme">Zapamätať</label><br />
    </div>

    <div class="lwa-login_form">
      <?php do_action('login_form'); ?>
    </div>

    <div class="lwa-submit-button">
      <input type="submit" name="wp-submit" id="lwa_wp-submit" value="Prihlásiť sa" tabindex="100" />
      <input type="hidden" name="lwa_profile_link" value="<?php echo esc_attr($lwa_data['profile_link']); ?>" />
      <input type="hidden" name="login-with-ajax" value="login" />
      <?php if( !empty($lwa_data['redirect']) ): ?>
      <input type="hidden" name="redirect_to" value="<?php echo esc_url($lwa_data['redirect']); ?>" />
      <?php endif; ?>
    </div>
    
    <div class="lwa-links">
      
      <?php if( !empty($lwa_data['remember']) ): ?>
        <a class="lwa-links-remember button" href="<?php echo esc_attr(LoginWithAjax::$url_remember); ?>" title="<?php esc_attr_e('Password Lost and Found','login-with-ajax') ?>">Zabudli ste heslo?</a>
      <?php endif; ?>
      <?php if ( get_option('users_can_register') && !empty($lwa_data['registration']) ) : ?>
        <a href="<?php echo esc_attr(LoginWithAjax::$url_register); ?>" class="lwa-links-register-inline button">Registrovať sa</a>
      <?php endif; ?>
    </div>
  </form>
  <?php if( !empty($lwa_data['remember']) && $lwa_data['remember'] == 1 ): ?>
    <form class="lwa-remember" action="<?php echo esc_attr(LoginWithAjax::$url_remember); ?>" method="post" style="display:none;">
      <p><strong>Prosím, zadajte svoje používateľské meno alebo e-mailovú adresu. Obdržíte odkaz pre vytvorenie nového hesla cez e-mail.</strong></p>
      <div class="lwa-remember-email">  
        <?php $msg = "Prihlasovacie meno alebo e-mailová adresa"; ?>
        <input type="text" name="user_login" id="lwa_user_remember" value="<?php echo esc_attr($msg); ?>" onfocus="if(this.value == '<?php echo esc_attr($msg); ?>'){this.value = '';}" onblur="if(this.value == ''){this.value = '<?php echo esc_attr($msg); ?>'}" />
        <?php do_action('lostpassword_form'); ?>
      </div>
      <div class="lwa-submit-button">
        <input type="submit" value="Získať nové heslo" />
        <a href="#" class="lwa-links-remember-cancel button">Zrušiť</a>
        <input type="hidden" name="login-with-ajax" value="remember" />
      </div>
    </form>
  <?php endif; ?>
  <?php if ( get_option('users_can_register') && !empty($lwa_data['registration']) && $lwa_data['registration'] == 1 ) : ?>
    <div class="lwa-register" style="display:none;" >
      <?php
        florp_profile_form();
      ?>
      <a href="#" class="lwa-links-register-inline-cancel button">Zrušiť</a>
    </div>
  <?php endif; ?>
  <?php do_action( 'lwa_after_login_form', $lwa_data ); ?>
</div>
