<?php
/**
 * Plugin Name: ThemeStockyard Essentials
 * Plugin URI: http://themestockyard.com/plugins/essentials
 * Description: This plugin is required for all themes created by ThemeStockyard after May 25, 2015. Includes: widgets, custom post types (portfolio, mega menus, etc), theme options, metaboxes, and various functions.
 * Version: 1.0.3
 * Author: ThemeStockyard
 * Author URI: http://themestockyard.com/
 *
 * @since     1.0
 * @copyright Copyright (c) 2015, ThemeStockyard
 * @author    ThemeStockyard
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// ThemeStockyard Essentials activated?
if ( ! defined( 'TS_ESSENTIALS_PLUGIN_VERSION' ) ) {

	/* Plugin version */
	define( 'TS_ESSENTIALS_PLUGIN_VERSION', '1.0' );

	/* Sets the custom db table name. We're not using this just yet, but down the road... */
	define( 'TS_ESSENTIALS_DB_TABLE', 'ts_essentials' );

	/* Defines constants used by the plugin. */
	add_action( 'plugins_loaded', 'ts_essentials_constants', 1 );

	/* Internationalize the text strings used. */
	add_action( 'plugins_loaded', 'ts_essentials_i18n', 2 );

	/* Internationalize the text strings used. */
	add_action( 'plugins_loaded', 'ts_essentials_widgets', 3 );

	/* Loads libraries. */
	add_action( 'init', 'ts_essentials_includes_libraries', 3 );

	/**
	 * Defines constants.
	 *
	 * @since 1.0
	 */
	function ts_essentials_constants() {

		/* Sets the path to the plugin directory. */
		define( 'TS_ESSENTIALS_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		/* Sets the path to the plugin directory URI. */
		define( 'TS_ESSENTIALS_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		/* Sets the path to the `admin` directory. */
		define( 'TS_ESSENTIALS_ADMIN', TS_ESSENTIALS_DIR . trailingslashit( 'admin' ) );

		/* Sets the path to the `admin` directory UIR. */
		define( 'TS_ESSENTIALS_ADMIN_URI', TS_ESSENTIALS_URI . trailingslashit( 'admin' ) );

		/* Sets the path to the `includes` directory. */
		define( 'TS_ESSENTIALS_INCLUDES', TS_ESSENTIALS_DIR . trailingslashit( 'includes' ) );

		/* Sets the path to the `assets` directory. */
		define( 'TS_ESSENTIALS_ASSETS', TS_ESSENTIALS_URI . trailingslashit( 'assets' ) );	

		/* Sets plugin base 'directory/file.php' */
		define( 'TS_ESSENTIALS_PLUGIN_BASE', plugin_basename(__FILE__) );

	}

	/**
	 * Internationalize the text strings used.
	 *
	 * @since 1.0
	 */
	function ts_essentials_i18n() {
		load_plugin_textdomain( 'ThemeStockyard', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Loads the initial files needed by the plugin.
	 *
	 * @since 1.0
	 */
	function ts_essentials_includes_libraries() {

		/* Loads the necessary functions. */	
		require_once( TS_ESSENTIALS_INCLUDES . 'functions.php' );

		/* Loads the shortcodes. */	
		require_once( TS_ESSENTIALS_INCLUDES . 'shortcodes.php' );

		/* Loads the admin functions. */
		require_once( TS_ESSENTIALS_ADMIN . 'index.php' );

		/* Loads the post-types. */
		require_once( TS_ESSENTIALS_INCLUDES . 'post-types.php' );

		/* Loads the meta boxes. */
		require_once( TS_ESSENTIALS_INCLUDES . 'metaboxes.php' );

		/* Loads the plugins. */
		require_once( TS_ESSENTIALS_INCLUDES . 'plugins.php' );

	}
    
    function ts_essentials_get_file_path($file)
    {
        $located = '';
        
        $file_slug = rtrim( $file, '.php' );
        $file = $file_slug . '.php';
        
        $this_plugin_dir = WP_PLUGIN_DIR.'/'.str_replace( basename( __FILE__), "", plugin_basename(__FILE__) );
        
        if ( $file ) {
            if ( file_exists(get_stylesheet_directory() . '/ts-essentials/' . $file)) {
                $located = get_stylesheet_directory() . '/ts-essentials/' . $file;
            } else if ( file_exists(get_template_directory() . '/ts-essentials/' . $file) ) {
                $located = get_template_directory() . '/ts-essentials/' . $file;
            } else if ( file_exists( $this_plugin_dir .  $file) ) {
                $located =  $this_plugin_dir . $file;
            }
        }
        
        return $located;
    }
	
	function ts_essentials_locate_plugin_file( $file, $load = false, $require_once = true )
    {
        $located = ts_essentials_get_file_path($file);
        
        if ( $load && '' != $located )
            load_template( $located, $require_once );
        
        return $located;
    }
	
	function ts_essentials_load_file( $file )
    {
        // For our own themes, this is also a way to remove 
        // support for certain features on a theme by theme basis.
        // Simply upload an empty version of the appropriate file
        // to the theme and it will overwrite the default functions.
        return ts_essentials_locate_plugin_file($file, true);
    }
    
    function ts_essentials_widgets()
    {        
        $widgets = array(
            'includes/widgets/ad-space.php',
            'includes/widgets/blog-author.php',
            'includes/widgets/blog-mini.php',
            'includes/widgets/blog-slider.php',	
            'includes/widgets/contact.php',		
            'includes/widgets/custom-menu.php',
            'includes/widgets/facebook-like.php',	
            'includes/widgets/facebook-twitter.php',	
            'includes/widgets/flickr.php',	
            'includes/widgets/follow-rss.php',	
            'includes/widgets/google-map.php',	
            'includes/widgets/info-box.php',
            'includes/widgets/popular-post.php',
            'includes/widgets/portfolio-mini.php',		
            'includes/widgets/recent-portfolio.php',	
            'includes/widgets/recent-post.php',	
            'includes/widgets/social-buttons.php',	
            'includes/widgets/social-icons.php',	
            'includes/widgets/tab.php',
            'includes/widgets/twitter.php',	
            'includes/widgets/video.php',
        );
        
        foreach($widgets AS $widget)
        {
            if($path = ts_essentials_locate_plugin_file($widget))
                require_once($path);
        } 
    }
    
    function ts_essentials_posttype_supported($posttype = '')
    {
        // first, let's see if 'TS_ESSENTIALS_SUPPORTED_POSTTYPES' is defined
        if(defined('TS_ESSENTIALS_SUPPORTED_POSTTYPES'))
        {
            // if so, remove whitespace and convert to array
            $supported_posttypes = TS_ESSENTIALS_SUPPORTED_POSTTYPES;
            $supported_posttypes = str_replace(' ', '', $supported_posttypes);
            $supported_posttypes = explode(',', $supported_posttypes);
            $supported_posttypes = (is_array($supported_posttypes)) ? $supported_posttypes : array();
            
            return (in_array($posttype, $supported_posttypes)) ? true : false;
        }
        elseif(function_exists('current_theme_supports') && current_theme_supports('ts-essentials'))
        {
            // assume all features are supported
            return true;
        }
        
        return false;
    }
}