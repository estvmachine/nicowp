<?php
/**
 * Plugin Name: TS Mega Menu
 * Description: Basic Mega Menu functionality. Adds a new "Mega Menu" post type and allows users to create and edit (similar to pages/posts), then add to top level of navigation menu tree.
 * Author:      ThemeStockyard
 * Author URI:  http://themestockyard.com
 * Version:     1.0
 */

if(!ts_essentials_posttype_supported('megamenu')) return;

define('TS_MEGA_MENUS_DIR', trailingslashit(dirname(__FILE__)));

class TS_Mega_Menus {
    
    static function add_hooks() {
        add_action('init', 'TS_Mega_Menus::register_mega_menu_post_type');
		
		// used to add additional meta boxes to mega menu post type
        //add_filter('cmb_meta_boxes', 'TS_Mega_Menus::megamenu_metaboxes');
        
        // used during page build
        add_filter('walker_nav_menu_start_el', 'TS_Mega_Menus::display_mega_menu_contents', 100, 4);
        
        // used during menu build
        add_filter('wp_setup_nav_menu_item', 'TS_Mega_Menus::setup_nav_menu_item', 100);
    }
    
    static function register_mega_menu_post_type() {
        register_post_type('ts_mega_menu', array(
            'labels' => array(
                'name' => __('Mega Menus', 'ThemeStockyard'),
                'singular_name' => __('Mega Menu', 'ThemeStockyard'),
                'menu_name' => __('Mega Menus', 'ThemeStockyard'),
                'all_items' => __('All Mega Menus', 'ThemeStockyard'),
                'add_new_item' => __('Add New Mega Menu', 'ThemeStockyard'),
                'edit_item' => __('Edit Mega Menu', 'ThemeStockyard'),
                'new_item' => __('New Mega Menu', 'ThemeStockyard'),
                'view_item' => __('View Mega Menu', 'ThemeStockyard'),
                'search_items' => __('Search Mega Menus', 'ThemeStockyard'),
                'not_found' => __('No mega menus found', 'ThemeStockyard'),
                'not_found_in_trash' => __('No mega menus found in trash', 'ThemeStockyard'),
            ),
            'description' => __('A utility post type used to control contents within mega menu dropdowns', 'ThemeStockyard'),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'menu_position' => 30,
            'hierarchical' => true,
            'supports' => array(
                'title',
                'editor',
            )
        ));
    }
    
    static function display_mega_menu_contents($output, $item, $depth, $args) {
        $item = (array) $item;
        $args = (array) $args;
        if (empty($args['hide_mega_menu']) && $depth == 0 && $item['object'] == 'ts_mega_menu' && $args['theme_location'] == 'main_nav') {
            $mega_menu_id = $item['object_id'];
            //echo '<pre>'.esc_html(print_r($item, true)).'</pre>'; // debug
            if (!empty($mega_menu_id) && ($mega_menu = get_post($mega_menu_id)) && !is_wp_error($mega_menu)) {
                // We have a mega menu to display.
                $wrapper_classes = apply_filters('ts-mega-menu-classes', array('ts-mega-menu'), $item, $depth, $args);
                global $post;
                $old_post = $post;
                $post = $mega_menu;
                setup_postdata($mega_menu);
                ob_start();
                the_content();
                $contents = ob_get_clean();
                wp_reset_postdata();
                if (!empty($contents)) {
                    $output .= '<ul class="sub-menu ' . esc_attr(implode(' ', $wrapper_classes)) . "\">\n";
                    $output .= '<li class="menu-item ts-mega-menu-wrap">'."\n";
                    $output .= $contents;
                    $output .= '</li>'."\n";
                    $output .= "</ul>\n";
                }
                $post = $old_post;
                if(!is_404()) setup_postdata($post);
            }
        }
        return $output;
    }
    
    static function setup_nav_menu_item($menu_item) {
        if (!$menu_item->menu_item_parent && $menu_item->object == 'ts_mega_menu') {
            $menu_item->classes[] = 'menu-item-has-children';
            $menu_item->classes[] = 'ts-has-mega-menu';
            $menu_item->url = get_post_meta($menu_item->object_id, '_megamenu_url', true);
            $menu_item->url = (isset($menu_item->url) && is_string($menu_item->url) && trim($menu_item->url)) ? $menu_item->url : 'javascript:void(0)';
            if($menu_item->url == ts_essentials_full_url()) {
                $menu_item->classes[] = 'current-menu-item';
            }
            $layout = get_post_meta($menu_item->object_id, '_megamenu_layout', true);
            $layout = (in_array($layout, array('standard', 'custom', 'full', 'wide', 'standardx2', 'standardx3'))) ? $layout : 'standard';
            $layout = 'ts-has-'.$layout.'-width-megamenu';
            $menu_item->classes[] = $layout;
        }
        return $menu_item;
    }
    
}
TS_Mega_Menus::add_hooks();
