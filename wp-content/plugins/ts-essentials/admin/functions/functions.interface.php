<?php 
/**
 * SMOF Interface
 *
 * @since       1.0
 * @author      Original credit goes to Syamil MJ
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
 
/**
 * Admin Init
 *
 * @uses wp_verify_nonce()
 * @uses header()
 *
 * @since 1.0.0
 */
function optionsframework_admin_init() 
{
	// Rev up the Options Machine
	global $of_options, $options_machine;
	//$options_machine = new Options_Machine($of_options);
}



/**
 * Add "Theme Options" link to admin bar
 *
 * @since 1.0
 */
function optionsframework_add_admin_bar() 
{
	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array(
		'parent'    => 'site-name', // use 'false' for a root menu, or pass the ID of the parent menu
		'id'        => 'smof_options', // link ID, defaults to a sanitized title value
		'title'     => __('Theme Options', 'ThemeStockyard'), // link title
		'href'      => admin_url( 'themes.php?page=optionsframework'), // name of file
		'meta'      => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
	));
}

/**
 * Create Options page
 *
 * @uses add_theme_page()
 * @uses add_action()
 *
 * @since 1.0.0
 */
function optionsframework_add_admin() {
	
    $of_page = add_theme_page( OF_THEMENAME, 'Theme Options', 'edit_theme_options', 'optionsframework', 'optionsframework_options_page');

	// Add framework functionaily to the head individually
	add_action("admin_print_scripts-$of_page", 'of_load_only');
	add_action("admin_print_styles-$of_page",'of_style_only');
	add_action( "admin_print_styles-$of_page", 'optionsframework_mlu_css', 0 );
	add_action( "admin_print_scripts-$of_page", 'optionsframework_mlu_js', 0 );	
	
}


/**
 * Build Options page
 *
 * @since 1.0.0
 */
function optionsframework_options_page(){
	
	global $of_options, $options_machine;
	
	/*
	//for debugging

	$smof_data = of_get_options();
	print_r($smof_data);

	*/
	
	of_options();
	
	$options_machine = new Options_Machine($of_options);	
	
	ts_essentials_load_file( 'admin/front-end/options' );

}

/**
 * Create Options page
 *
 * @uses wp_enqueue_style()
 *
 * @since 1.0.0
 */
function of_style_only(){
	wp_enqueue_style('admin-style', TS_ESSENTIALS_ADMIN_URI . 'assets/css/admin-style.css?20130530');
	wp_enqueue_style('color-picker', TS_ESSENTIALS_ADMIN_URI . 'assets/css/colorpicker.css');
	wp_enqueue_style('jquery-ui-custom-admin', TS_ESSENTIALS_ADMIN_URI .'assets/css/jquery-ui-custom.css');
}	

/**
 * Create Options page
 *
 * @uses add_action()
 * @uses wp_enqueue_script()
 *
 * @since 1.0.0
 */
function of_load_only() 
{
	add_action('admin_head', 'of_admin_head');
	
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('jquery-input-mask', TS_ESSENTIALS_ADMIN_URI .'assets/js/jquery.maskedinput-1.2.2.js', array( 'jquery' ));
	wp_enqueue_script('tipsy', TS_ESSENTIALS_ADMIN_URI .'assets/js/jquery.tipsy.js', array( 'jquery' ));
	wp_enqueue_script('color-picker', TS_ESSENTIALS_ADMIN_URI .'assets/js/colorpicker.js', array('jquery'));
	wp_enqueue_script('ajaxupload', TS_ESSENTIALS_ADMIN_URI .'assets/js/ajaxupload.js', array('jquery'));
	wp_enqueue_script('cookie', TS_ESSENTIALS_ADMIN_URI . 'assets/js/cookie.js', 'jquery');
	wp_enqueue_script('smof', TS_ESSENTIALS_ADMIN_URI .'assets/js/smof.js', array( 'jquery' ));
}

/**
 * Front end inline jquery scripts
 *
 * @since 1.0.0
 */
function of_admin_head() { ?>
		
	<script type="text/javascript" language="javascript">

	jQuery.noConflict();
	jQuery(document).ready(function($){
	
		// COLOR Picker			
		$('.colorSelector').each(function(){
			var Othis = this; //cache a copy of the this variable for use inside nested function
				
			$(this).ColorPicker({
					color: '<?php if(isset($color)) echo esc_js($color); ?>',
					onShow: function (colpkr) {
						$(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						$(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						$(Othis).children('div').css('backgroundColor', '#' + hex);
						$(Othis).next('input').attr('value','#' + hex);
						
					}
			});
				  
		}); //end color picker
		
	}); //end doc ready
	
	</script>
	
<?php }

/**
 * Ajax Save Options
 *
 * @uses get_option()
 *
 * @since 1.0.0
 */
function of_ajax_callback() 
{
	global $of_options, $options_machine;

	$nonce=$_POST['security'];
	
	if (! wp_verify_nonce($nonce, 'of_ajax_nonce') ) die('-1'); 
			
	//get options array from db
	$all = of_get_options();
	
	$save_type = $_POST['type'];
	
	//Uploads
	if($save_type == 'upload')
	{
		
		$clickedID = $_POST['data']; // Acts as the name
		$filename = $_FILES[$clickedID];
       	$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']); 
		
		$override['test_form'] = false;
		$override['action'] = 'wp_handle_upload';    
		$uploaded_file = wp_handle_upload($filename,$override);
		 
			$upload_tracking[] = $clickedID;
				
			//update $options array w/ image URL			  
			$upload_image = $all; //preserve current data
			
			$upload_image[$clickedID] = $uploaded_file['url'];
			
			of_save_options($upload_image);
		
				
		 if(!empty($uploaded_file['error'])) {echo 'Upload Error: ' . esc_js($uploaded_file['error']); }	
		 else { echo esc_attr($uploaded_file['url']); } // Is the Response
		 
	}
	elseif($save_type == 'image_reset')
	{
			
			$id = $_POST['data']; // Acts as the name
			
			$delete_image = $all; //preserve rest of data
			$delete_image[$id] = ''; //update array key with empty value	 
			of_save_options($delete_image ) ;
	
	}
	elseif($save_type == 'backup_options')
	{
			
		$backup = $all;
		$backup['backup_log'] = date('r');
		
		of_save_options($backup, OF_BACKUPS) ;
			
		die('1'); 
	}
	elseif($save_type == 'restore_options')
	{
			
		$smof_data = get_option(OF_BACKUPS);

		update_option(OF_OPTIONS, $smof_data);

		of_save_options($smof_data);
		
		die('1'); 
	}
	elseif($save_type == 'import_options')
	{

        $smof_data = $_POST['data'];
		$smof_data = unserialize(base64_decode($smof_data)); //100% safe - ignore theme check nag
		of_save_options($smof_data);

		
		die('1'); 
	}
	elseif ($save_type == 'save')
	{

		wp_parse_str(stripslashes($_POST['data']), $smof_data);
		unset($smof_data['security']);
		unset($smof_data['of_save']);
		of_save_options($smof_data);
		
		
		die('1');
	}
	elseif ($save_type == 'reset')
	{
        of_options();
        
        $options_machine = new Options_Machine($of_options);
        
		of_save_options($options_machine->Defaults());
		
        die('1'); //options reset
	}

  	die();
}