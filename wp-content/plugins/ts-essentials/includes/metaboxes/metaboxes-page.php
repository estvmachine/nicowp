<?php
/*-----------------------------------------------------------------------------------*/
/* PAGE METABOX */
/*-----------------------------------------------------------------------------------*/

add_filter ('cmb_meta_boxes', 'cmb_page_metaboxes', 505);
function cmb_page_metaboxes(array $meta_boxes) 
{
    global $wpdb;
    
    /*** begin: helper variables ***/
    $cmb_slider_count = array();
    for($i = 1; $i <= 10; $i++) {
        $cmb_slider_count[] = array('name'=>$i, 'value'=>$i);
    }        
    
    $ts_cmb_categories 		= array(); 
    $ts_cmb_categories_obj 	= get_categories('hide_empty=0');
    foreach ($ts_cmb_categories_obj as $cmb_cat) {
        $ts_cmb_categories[$cmb_cat->term_id] = $cmb_cat->cat_name;
    }        
    
    $cmb_bg_repeat      = array(
                            array("name"=>"repeat", "value"=>"repeat"),
                            array("name"=>"no-repeat", "value"=>"no-repeat"),
                            array("name"=>"repeat-x", "value"=>"repeat-x"),
                            array("name"=>"repeat-y", "value"=>"repeat-y"),
                        );
                            
    $cmb_bg_pos 		= array(
                            array("name"=>"top left", "value"=>"top left"),
                            array("name"=>"top center", "value"=>"top center"),
                            array("name"=>"top right", "value"=>"top right"),
                            array("name"=>"center left", "value"=>"center left"),
                            array("name"=>"center center", "value"=>"center center"),
                            array("name"=>"center right", "value"=>"center right"),
                            array("name"=>"bottom left", "value"=>"bottom left"),
                            array("name"=>"bottom center", "value"=>"bottom center"),
                            array("name"=>"bottom right", "value"=>"bottom right"),
                        );
    
    /*** end: helper variables ***/
    
    
    $prefix = '_page_';

    $meta_boxes[] = array(
        'id'         => 'page_metabox',
        'title'      => __('General Page Settings', 'ThemeStockyard'),
        'pages'      => array( 'page' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true,
        'fields'     => array(

            array(
                'name'    => __('Title Bar Caption', 'ThemeStockyard'),
                'id'      => $prefix . 'titlebar_caption',
                'type'    => 'text',
                "std"     => ''
            ),

        ),
    );

    $meta_boxes[] = array(
        'id'         => 'page_metabox2',
        'title'      => __('Custom CSS', 'ThemeStockyard'),
        'pages'      => array( 'page' ),
        'context'    => 'normal',
        'priority'   => 'low',
        'show_names' => true,
        'fields'     => array(

            array(
                'desc'    => __('Type or paste your page-specific CSS here.', 'ThemeStockyard'),
                'id'      => $prefix . 'css',
                'type'    => 'textarea_code',
                "std"     => ''
            ),
             
        ),
    );

    return $meta_boxes;
}