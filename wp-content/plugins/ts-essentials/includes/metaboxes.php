<?php
// since version 1.0

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// initial setup
ts_essentials_load_file( 'includes/metaboxes/init' );

// metaboxes for various post types
ts_essentials_load_file( 'includes/metaboxes/metaboxes-megamenu' );
ts_essentials_load_file( 'includes/metaboxes/metaboxes-page' );
ts_essentials_load_file( 'includes/metaboxes/metaboxes-portfolio' );
ts_essentials_load_file( 'includes/metaboxes/metaboxes-post' );