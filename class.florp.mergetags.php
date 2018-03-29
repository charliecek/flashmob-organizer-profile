<?php
class FlorpMergeTags extends NF_Abstracts_MergeTags
{
  /*
   * The $id property should match the array key where the class is registered.
   */
  protected $id = 'florp_merge_tags';
  
  public function __construct() {
    parent::__construct();
    
    /* Translatable display name for the group. */
    $this->title = __( 'Flashmob Organizer Profile Merge Tags', 'florp' );
    
    /* Individual tag registration. */
    $this->merge_tags = array(
      'usermeta' => array(
        'id' => 'usermeta',
        'tag' => '{usermeta:KEY}', // The tag to be  used.
        'label' => __( 'Usermeta', 'florp' ), // Translatable label for tag selection.
        'callback' => null // Class method for processing the tag. See below.
      )
    );
    
    /*
     * Use the `init` and `admin_init` hooks for any necessary data setup that relies on WordPress.
     * See: https://codex.wordpress.org/Plugin_API/Action_Reference
     */
    add_action( 'init', array( $this, 'init' ) );
    add_action( 'admin_init', array( $this, 'admin_init' ) );
  }
  
  public function init(){ /* This section intentionally left blank. */ }
  public function admin_init(){ /* This section intentionally left blank. */ }
  
  /**
   * The callback method for the {my:foo} merge tag.
   * @return string
   */
  public function foo() {
    // Do stuff here.
    return 'bar';
  }
  
  public function replace( $subject ) {
    /*
      * If we are dealing with a usermeta merge tag, we need to overwrite the parent replace() method.
      *
      * Otherwise, we use the parent's method.
      */

    /**
      * {usermeta:foo} --> meta key is 'foo'
      */
    if (is_string($subject)) {
      preg_match_all("/{usermeta:(.*?)}/", $subject, $matches );
    }

    // If not matching merge tags are found, then return early.
    if (empty( $matches[0] )) {
      return parent::replace( $subject );
    }
    
    // Recursively replace merge tags.
    if (is_array( $subject )) {
      foreach( $subject as $i => $s ){
        $subject[ $i ] = $this->replace( $s );
      }
      return $subject;
    }

    /**
      * $matches[0][$i]  merge tag match     {usermeta:foo}
      * $matches[1][$i]  captured meta key   foo
      */
    $iUserID = get_current_user_id();
    foreach ($matches[0] as $i => $search) {
      $meta_key = $matches[1][$i];
      if ($meta_key === 'user_login') {
        if (is_user_logged_in()) {
          $objUser = wp_get_current_user();
          $meta_val = $objUser->user_login;
        } else {
          $meta_val = "";
        }
      } else {
        $meta_val = get_user_meta( $iUserID, $meta_key, true );
      }
      $subject = str_replace( $search, $meta_val, $subject );
    }

    return parent::replace( $subject );
  }
} 
