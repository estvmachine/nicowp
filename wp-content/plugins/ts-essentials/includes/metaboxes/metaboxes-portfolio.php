<?php
/*-----------------------------------------------------------------------------------*/
/*  PORTFOLIO METABOX */
/*-----------------------------------------------------------------------------------*/

if(!ts_essentials_posttype_supported('portfolio')) return;

add_filter ('cmb_meta_boxes', 'cmb_portfolio_metaboxes', 502);
function cmb_portfolio_metaboxes(array $metaboxes)
{
    $prefix = '_portfolio_';

    $meta_boxes[] = array(
        'id'         => 'portfolio_metaboxes',
        'title'      => __('Portfolio Settings' , 'ThemeStockyard'),
        'pages'      => array('portfolio'),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true,
        'fields'     => array(
            
            array(
                'name' => __('General Settings' , 'ThemeStockyard'), 
                'desc' => '',
                'type' => 'title',
                'id'   => $prefix . 'title_general_setting'
            ),
                    
            array(
                'name'    => __('Project Content Type:' , 'ThemeStockyard'),
                'desc'    => '',
                'id'      => $prefix . 'project_type',
                'type'    => 'select',
                'options' => array(
                    array('name' => __('Single Image', 'ThemeStockyard'), 'value' => 'image'),
                    array('name' => __('Gallery', 'ThemeStockyard'), 'value' => 'gallery'),
                    array('name' => 'Youtube', 'value' => 'youtube'),
                    array('name' => 'Vimeo', 'value' => 'vimeo'),
                    array('name' => __('Self-hosted video', 'ThemeStockyard'), 'value' => 'self_hosted_video')                
                )
            ),
                        
            array(
                'name' => __('Gallery Settings' , 'ThemeStockyard'),
                'desc' => '',
                'type' => 'title',
                'id'   => $prefix . 'title_image_slider_project'
            ),
            
            array(
                'name'    => __('Image 1' , 'ThemeStockyard'),
                'id'      => $prefix . 'image_1',
                'type'    => 'file',
                'save_id' => true,
                'allow'   => array( 'attachment' )
            ),
            
            array(
                'name'    => __('Image 2' , 'ThemeStockyard'),
                'id'      => $prefix . 'image_2',
                'type'    => 'file',
                'save_id' => true,
                'allow'   => array( 'attachment' )
            ),
            
            array(
                'name'    => __('Image 3' , 'ThemeStockyard'),
                'id'      => $prefix . 'image_3',
                'type'    => 'file',
                'save_id' => true,
                'allow'   => array( 'attachment' )
            ),
            
            array(
                'name'    => __('Image 4' , 'ThemeStockyard'),
                'id'      => $prefix . 'image_4',
                'type'    => 'file',
                'save_id' => true,
                'allow'   => array( 'attachment' )
            ),
            
            array(
                'name'    => __('Image 5' , 'ThemeStockyard'),
                'id'      => $prefix . 'image_5',
                'type'    => 'file',
                'save_id' => true,
                'allow'   => array( 'attachment' )
            ),
            
            array(
                'name'    => __('Image 6' , 'ThemeStockyard'),
                'id'      => $prefix . 'image_6',
                'type'    => 'file',
                'save_id' => true,
                'allow'   => array( 'attachment' )
            ),
            
            array(
                'name'    => __('Image 7' , 'ThemeStockyard'),
                'id'      => $prefix . 'image_7',
                'type'    => 'file',
                'save_id' => true,
                'allow'   => array( 'attachment' )
            ),
            
            array(
                'name'    => __('Image 8' , 'ThemeStockyard'),
                'id'      => $prefix . 'image_8',
                'type'    => 'file',
                'save_id' => true,
                'allow'   => array( 'attachment' )
            ),
            
            array(
                'name'    => __('Image 9' , 'ThemeStockyard'),
                'id'      => $prefix . 'image_9',
                'type'    => 'file',
                'save_id' => true,
                'allow'   => array( 'attachment' )
            ),
            
            array(
                'name'    => __('Image 10' , 'ThemeStockyard'),
                'id'      => $prefix . 'image_10',
                'type'    => 'file',
                'save_id' => true,
                'allow'   => array( 'attachment' )
            ),
            
            array(
                'name' => __('Video Settings', 'ThemeStockyard'),
                'desc' => '',
                'type' => 'title',
                'id'   => $prefix . 'title_video_project'
            ),
            
            array(
                'name' => __('Youtube URL/ID:' , 'ThemeStockyard'),
                'desc' => '',
                'id'   => $prefix . 'youtube_id',
                'type' => 'text'
            ),
            
            array(
                'name' => __('Vimeo URL/ID:' , 'ThemeStockyard'),
                'desc' => '',
                'id'   => $prefix . 'vimeo_id',
                'type' => 'text'
            ),

            array(
                'name' => __('Self-hosted Video', 'ThemeStockyard'),
                'type' => 'file',
                'id'   => $prefix . 'self_hosted_video',
            ),
            
        ),
    );
    
    $meta_boxes[] = array(
        'id'         => 'portfolio_metabox2',
        'title'      => __('Custom CSS', 'ThemeStockyard'),
        'pages'      => array( 'portfolio' ),
        'context'    => 'normal',
        'priority'   => 'low',
        'show_names' => true,
        'fields'     => array(
        
            array(
                'desc'    => __('Type or paste your portfolio post specific CSS here.', 'ThemeStockyard'),
                'id'      => $prefix . 'css',
                'type'    => 'textarea_code',
                "std"     => ''
            ),

        ),
    );

    return $meta_boxes;
}