<?php
/**
 * Plugin name: Change Case
 * Author: Michael Aronoff
 * Version: 1.5
 * Description: Adds Change Case adds buttons to change text case in the WordPress visual editor.
 * */

if ( !class_exists( "change_case" ) ):

  /**
   * Change Case
   */
  class change_case {

  function __construct() {
    define( "CC_URL", WP_PLUGIN_URL.'/'.str_replace( basename( __FILE__ ), "", plugin_basename( __FILE__ ) ) );
    define( "CC_PLUGIN_DIR", "change-case-for-tinymce" );
    define( "CC_PLUGIN_URL", get_bloginfo( 'url' )."/wp-content/plugins/" . CC_PLUGIN_DIR );
    register_activation_hook( __FILE__, array( __CLASS__, "register" ) );
    add_action( 'init', array( __CLASS__, 'add_button' ) );
    add_filter( 'tiny_mce_version', array( __CLASS__, 'refresh_mce' ) );
    add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
  }

  /* TINY MCE */

  function register() {
    $values= array( "ac"=>1, "nc"=>1, "tc"=>1, "sc"=>1 );
    if ( get_option( "CC_HR_OPTIONS" ) ) {
      $current = get_option( "CC_HR_OPTIONS" );
      if ( is_serialized( $current ) ) {
        $current = unserialize( $current );
      }
      $values = array_merge( $values, $current );
      update_option( "CC_HR_OPTIONS", $values );
    }
    else {
      add_option( "CC_HR_OPTIONS", $values );
    }
  }

  function add_button() {
    if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) )
      return;
    if ( get_user_option( 'rich_editing' ) == 'true' ) {
      add_filter( 'mce_external_plugins', array( __CLASS__, 'add_tinymce_plugin' ) );
      add_filter( 'mce_buttons', array( __CLASS__, 'register_button' ) );
    }
  }

  function register_button( $buttons ) {
    $current = get_option( "CC_HR_OPTIONS" );
    if ( is_serialized( $current ) ) {$current = unserialize( $current );}
    array_push( $buttons, "|" );
    if ( $current['ac'] == 1 ) {
      array_push( $buttons,  "allcaps" );
    }
    if ( $current['nc'] == 1 ) {
      array_push( $buttons,  "nocaps" );
    }
	if ( $current['sc'] == 1 ) {
      array_push( $buttons,  "sentencecase" );
    }
    if ( $current['tc'] == 1 ) {
      array_push( $buttons,  "titlecase" );
    }
    return $buttons;
  }

  function add_tinymce_plugin( $plugin_array ) {
    $current = get_option( "CC_HR_OPTIONS" );
    if ( is_serialized( $current ) ) {
      $current = unserialize( $current );
    }
    if ( $current['ac'] == 1 ) {
      $plugin_array['allcaps'] = CC_PLUGIN_URL . '/cc.js';
    }
    if ( $current['nc'] == 1 ) {
      $plugin_array['nocaps'] = CC_PLUGIN_URL . '/cc.js';
    }
	if ( $current['sc'] == 1 ) {
      $plugin_array['sentencecase'] = CC_PLUGIN_URL . '/cc.js';
    }
    if ( $current['tc'] == 1 ) {
      $plugin_array['titlecase'] = CC_PLUGIN_URL . '/cc.js';
    }
    return $plugin_array;
  }

  function refresh_mce( $ver ) {
    $ver += 7;
    return $ver;
  }

  function menu() {
    add_submenu_page( 'options-general.php', 'Change Case', 'Change Case', 'edit_posts', 'change-case', array( __CLASS__, 'options' ) );
  }

  function options() {
    $current = get_option( "CC_HR_OPTIONS" );
    if ( is_serialized( $current ) ) {$current = unserialize( $current );}
?>
    <div class='wrap'>
      <div style='float:left;'>
        <h1>Change Case provided by Michael Aronoff of <a href="http://www.ciic.com" target="_blank">CIIC</a></h1>
        <p class="description">The options below are to choose which buttons are added to the tinyMCE editor.</p>
        <form method="post" action="options.php">
          <?php wp_nonce_field( 'update-options' ); ?>
          <table class="form-table">
            <tr valign="top">
              <th scope="row"><label for="CC_HR_OPTIONS['ac']">All Caps: </label></th>
              <td><input type="checkbox" name="CC_HR_OPTIONS[ac]" id="CC_HR_OPTIONS['ac']" value='1' <?php if ( $current['ac']==1 ) {echo "checked='checked'";}?> /></td>
            </tr>
            <tr valign="top">
              <th scope="row"><label for="CC_HR_OPTIONS['nc']">No Caps: </label></th>
              <td><input type="checkbox" name="CC_HR_OPTIONS[nc]" id="CC_HR_OPTIONS['nc']" value='1' <?php if ( $current['nc']==1 ) {echo "checked='checked'";}?> /></td>
            </tr>
            <tr valign="top">
              <th scope="row"><label for="CC_HR_OPTIONS['sc']">Sentence Case: </label></th>
              <td><input type="checkbox" name="CC_HR_OPTIONS[sc]" id="CC_HR_OPTIONS['sc']" value='1' <?php if ( $current['sc']==1 ) {echo "checked='checked'";}?> /></td>
            </tr>
            <tr valign="top">
              <th scope="row"><label for="CC_HR_OPTIONS['tc']">Title Case: </label></th>
              <td><input type="checkbox" name="CC_HR_OPTIONS[tc]" id="CC_HR_OPTIONS['tc']" value='1' <?php if ( $current['tc']==1 ) {echo "checked='checked'";}?> /></td>
            </tr>
          </table>
          <input type="hidden" name="action" value="update" />
          <input type="hidden" name="page_options" value="CC_HR_OPTIONS" />
          <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" />
          </p>
        </form>
      </div>
    </div>
<?php
  }
}

$change_case = new change_case();
endif;
?>