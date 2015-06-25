<?php
/*************************************************
 * This file should serve as an example only
 * If your theme supports the 'ThemeStockyard Essentials' plugin,
 * it should have it's own options that will overwrite these.
 *
 * @since 1.0
 *************************************************/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if (!function_exists('of_options'))
{
	function of_options()
	{
        $data = of_get_options();
        
        global $ts_all_fonts;
        
        if(defined('TS_ALL_FONTS')) {
            $ts_all_fonts = TS_ALL_FONTS;
        }
        elseif(function_exists('ts_essentials_all_fonts')) {
            $ts_all_fonts = ts_essentials_all_fonts(true);
        }
        elseif(function_exists('ts_all_fonts')) {
            $ts_all_fonts = ts_all_fonts(true);
        }
        else {
            $ts_all_fonts = array();
        }
        
        //Access the WordPress Categories via an Array
        $of_categories 		= array();  
        $of_categories_obj 	= get_categories('hide_empty=0');
        foreach ($of_categories_obj as $of_cat) {
            $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
        }
        $_of_categories     = $of_categories;
        $categories_tmp 	= array_unshift($of_categories, __("Select a category:", 'ThemeStockyard'));    
           
        //Access the WordPress Pages via an Array
        $of_pages 			= array();
        $of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
        foreach ($of_pages_obj as $of_page) {
            $of_pages[$of_page->ID] = $of_page->post_name; 
        }
        $of_pages_tmp 		= array_unshift($of_pages, __("Select a page:", 'ThemeStockyard'));       
    
        //Testing 
        $of_options_select 	= array("one","two","three","four","five"); 
        $of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
        
        //Sample Homepage blocks for the layout manager (sorter)
        $of_options_homepage_blocks = array
        ( 
            "disabled" => array (
                "placebo" 		=> "placebo", //REQUIRED!
                "block_one"		=> "Block One",
                "block_two"		=> "Block Two",
                "block_three"	=> "Block Three",
            ), 
            "enabled" => array (
                "placebo" 		=> "placebo", //REQUIRED!
                "block_four"	=> "Block Four",
            ),
        );


        //Background Images Reader
        $bg_images_path =  get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
        $bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
        $bg_images = array();
        
        if ( is_dir($bg_images_path) ) {
            if ($bg_images_dir = opendir($bg_images_path) ) { 
                while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
                    if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
                        $bg_images[] = $bg_images_url . $bg_images_file;
                    }
                }    
            }
        }
        

        /*-----------------------------------------------------------------------------------*/
        /* TO DO: Add options/functions that use these */
        /*-----------------------------------------------------------------------------------*/
        
        //More Options
        $uploads_arr 		= wp_upload_dir();
        $all_uploads_path 	= $uploads_arr['path'];
        $all_uploads 		= get_option('of_uploads');
        $other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20");
        $body_attachment	= array("scroll","fixed");
        $body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
        $body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
        $css_shadow_entries = array('min'=>'-10','max'=>'10');
        
        // Image Alignment radio box
        $of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
        
        // Image Links to Options
        $of_options_image_link_to = array("image" => "The Image","post" => "The Post");


        /*-----------------------------------------------------------------------------------*/
        /* The Options Array */
        /*-----------------------------------------------------------------------------------*/

        // Set the Options Array
        global $of_options;
        $of_options = array();

        /***
        General Settings
        ***/
        $of_options[] = array( 	"name" 		=> __("Example Section", 'ThemeStockyard'),
                                "type" 		=> "heading"
                        );
        		
        $of_options[] = array( 	"name" 		=> __("Example Information Area", 'ThemeStockyard'),
                                "desc" 		=> __('This is a place to put more details describing the following options.', 'ThemeStockyard'),
                                "id" 		=> "example_information_area",
                                "type" 		=> "info"
                        );
        
        $of_options[] = array( "name"       => __('Example Switch Option"', 'ThemeStockyard'),
                                "desc"      => __("Easy to toggle", 'ThemeStockyard'),
                                "id"        => "example_switch",
                                "std"       => 1,
                                "type"      => "switch"
                        );

        $of_options[] = array( 	"name" 		=> __("Example Upload", 'ThemeStockyard'),
                                "desc" 		=> __("Upload a file here", 'ThemeStockyard'),
                                "id" 		=> "example_upload",
                                "std" 		=> "",
                                "type" 		=> "upload"
                        ); 
                        
        $of_options[] = array(  "name"      => __("Example Media", 'ThemeStockyard'),
                                "desc"      => __("Upload a file here", 'ThemeStockyard'),
                                "id"        => "example_media",
                                "std"       => '',
                                "type"      => "media"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Example Textarea", 'ThemeStockyard'),
                                "desc" 		=> __("Add content here", 'ThemeStockyard'),
                                "id" 		=> "example_textarea",
                                "std" 		=> "",
                                "type" 		=> "textarea",
                                "options"   => array(
                                    "rows"  => '5'
                                )
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Example Text Box", 'ThemeStockyard'),
                                "desc" 		=> __("Add content here", 'ThemeStockyard'),
                                "id" 		=> "example_text_box",
                                "std" 		=> "",
                                "type" 		=> "text"
                        );	

        $of_options[] = array( 	"name" 		=> __("Example Small Text", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "example_small_text",
                                "std" 		=> "320",
                                "type"      => "text",
                                'class'     => 'small-text'
                        );
                        
        
        $of_options[] = array( "name"       => __('Example Select', 'ThemeStockyard'),
                                "desc"      => '',
                                "id"        => "example_select",
                                "std"       => 'yes',
                                "type"      => "select",
                                "options"   => array(
                                        'yes'       => __('Yes', 'ThemeStockyard'),
                                        'social'    => __('Only the social icons', 'ThemeStockyard'),
                                        'no'        => __('No', 'ThemeStockyard'),
                                    )
                        );
                        

        $url =  (defined('TS_ESSENTIALS_ADMIN_URI')) ? TS_ESSENTIALS_ADMIN_URI . 'assets/images/' : '/path_to_images/';
        $of_options[] = array( 	"name" 		=> __("Example Images", 'ThemeStockyard'),
                                "id" 		=> "example_images",
                                "std" 		=> "footer2",
                                "type" 		=> "images",
                                "options" 	=> array(
                                    'footer1' 	    => $url . 'footer-1.png',
                                    'footer2' 	    => $url . 'footer-2.png',
                                    'footer3' 	    => $url . 'footer-3.png',
                                    'footer4' 	    => $url . 'footer-4.png',
                                    'footer5' 	    => $url . 'footer-5.png',
                                    'footer6' 	    => $url . 'footer-6.png',
                                    'footer7' 	    => $url . 'footer-7.png',
                                    'footer8' 	    => $url . 'footer-8.png'
                                )
                        );


        $of_options[] = array( "name"       => __("Example Checkbox", 'ThemeStockyard'),
                                "desc"      => '',
                                "id"        => "example_checkbox",
                                "std"       => 1,
                                "type"      => "checkbox",
                        );

        $of_options[] = array( "name"       => __("Example Radio", 'ThemeStockyard'),
                                "desc"      => '',
                                "id"        => "example_radio",
                                "std"       => 'no',
                                "type"      => "radio",
                                "options"   => array(
                                        'yes'       => __('Yes', 'ThemeStockyard'),
                                        'no'        => __('No', 'ThemeStockyard'),
                                    ),
                            );

        $of_options[] = array( 	"name" 		=> __('Example Multi-select', 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "example_multiselect",
                                "std" 		=> "",
                                "type"      => "multiselect",
                                'options'   => $_of_categories
                        );	
                        
        $of_options[] = array( 	"name" 		=> __("Example Multi-check", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "example_multicheck",
                                "std" 		=> array(
                                    'option1',
                                    'option2',
                                    'option3',
                                ),
                                "type" 		=> "multicheck",
                                'keyAsValue' => true,
                                "options"   => array(
                                    'option1' => __('Option 1', 'ThemeStockyard'),
                                    'option2' => __('Option 2', 'ThemeStockyard'),
                                    'option3' => __('Option 3', 'ThemeStockyard'),
                                ),
                        );	
        

        $of_options[] = array( 	"name" 		=> __('Example Slider UI', 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "example_slider_ui",
                                "std" 		=> "95",
                                "min" 		=> "1",
                                "step"		=> "1",
                                "max" 		=> "100",
                                "type" 		=> "sliderui" 
                        );


        // Typography
        $of_options[] = array(  "name"      => __("Typography", 'ThemeStockyard'),
                                "type"      => "heading",
                                "class"     => "mt10",
                                );

        $of_options[] = array( 	"name" 		=> __("Example Google Fonts", 'ThemeStockyard'),
                                "desc"      => '',
                                "id" 		=> "example_fonts",
                                "std" 		=> "Libre Baskerville",
                                "type" 		=> "select_google_font",
                                "options"   => $ts_all_fonts,
                                "preview"   => array("text"=>'0123456789 Grumpy wizards make toxic brew for the evil Queen and Jack.', "size"=>'30px'),
                        );

        $of_options[] = array( 	"name" 		=> __("Example Font Style", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "example_font_style",
                                "std" 		=> array('size' => '36px','style' => 'normal'),
                                "type" 		=> "typography",
                                "class"     => "w345"
                        );
                            



        // Colors
        
        $of_options[] = array(  "name"      => __("Colors", 'ThemeStockyard'),
                                "type"      => "heading",
                                );
  
                                           
        $of_options[] = array( 	"name" 		=> __("Example color", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "example_color",
                                "std" 		=> "#000",
                                "type" 		=> "color"
                        );
                        
          





        // Backup Options
        $of_options[] = array( 	"name" 		=> __("Backup Options", 'ThemeStockyard'),
                                "type" 		=> "heading",
                                "class"     => "mt10"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Backup and Restore Options", 'ThemeStockyard'),
                                "id" 		=> "of_backup",
                                "std" 		=> "",
                                "type" 		=> "backup",
                                "desc" 		=> __('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'ThemeStockyard'),
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Transfer Theme Options Data", 'ThemeStockyard'),
                                "id" 		=> "of_transfer",
                                "std" 		=> "",
                                "type" 		=> "transfer",
                                "desc" 		=> __('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".', 'ThemeStockyard'),
                        );
				
	}//End function: of_options()
}//End check if function exists: of_options()