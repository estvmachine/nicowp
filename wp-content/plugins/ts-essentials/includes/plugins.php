<?php
// since version 1.0

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// load a few "plugins"
ts_essentials_load_file( 'includes/plugins/twitter/twitter' );
ts_essentials_load_file( 'includes/plugins/multiple-sidebars' );

/*
if(defined('ICL_SITEPRESS_VERSION')) :
    ts_essentials_load_template( 'includes/plugins/wpml' );
endif;
*/
