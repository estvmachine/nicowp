<?php
/*
Title		: SMOF
Description	: Slightly Modified Options Framework
Version	    : 1.4.4-mod
Author		: Syamil MJ
Author URI	: http://aquagraphite.com
License		: GPLv3 - http://www.gnu.org/copyleft/gpl.html
Credits		: Thematic Options Panel - http://wptheming.com/2010/11/thematic-options-panel-v2/
		 	  KIA Thematic Options Panel - https://github.com/helgatheviking/thematic-options-KIA
		 	  Woo Themes - http://woothemes.com/
		 	  Option Tree - http://wordpress.org/extend/plugins/option-tree/
		 	  
		 	  
		 	  And slightly modified yet again by...
		 	  ThemeStockyard - http://themestockyard.com
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Definitions
 *
 * @since 1.0
 */
	    
if( is_child_theme() ) {
    $temp_obj = wp_get_theme();
    $theme_obj = wp_get_theme( $temp_obj->get('Template') );
} else {
    $theme_obj = wp_get_theme();    
}

$theme_version = $theme_obj->get('Version');
$theme_name = $theme_obj->get('Name');
$theme_uri = $theme_obj->get('ThemeURI');
$author_uri = $theme_obj->get('AuthorURI');


define( 'SMOF_VERSION', '1.4.4' );
define( 'OF_THEMENAME', $theme_name );
/* Theme version, uri, and the author uri are not completely necessary, but may be helpful in adding functionality */
define( 'OF_THEMEVERSION', $theme_version );
define( 'OF_THEMEURI', $theme_uri );
define( 'OF_THEMEAUTHORURI', $author_uri );

define( 'OF_OPTIONS', $theme_name.'_options' );
define( 'OF_BACKUPS',$theme_name.'_backups' );

/**
 * Required action filters
 *
 * @uses add_action()
 *
 * @since 1.0.0
 */
global $pagenow;
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) add_action('admin_head','of_option_setup');
add_action('admin_head', 'optionsframework_admin_message');
add_action('admin_init','optionsframework_admin_init');
add_action('admin_menu', 'optionsframework_add_admin');
add_action( 'init', 'optionsframework_mlu_init');

/**
 * Required Files
 *
 * @since 1.0.0
 */ 
ts_essentials_load_file( 'admin/functions/functions.load' );
ts_essentials_load_file( 'admin/classes/class.options_machine' );

/**
 * AJAX Saving Options
 *
 * @since 1.0.0
 */
add_action('wp_ajax_of_ajax_post_action', 'of_ajax_callback');

/**
 * Add "Theme Options" link to admin bar
 *
 * @since 1.0
 */
add_action( 'wp_before_admin_bar_render', 'optionsframework_add_admin_bar' );

