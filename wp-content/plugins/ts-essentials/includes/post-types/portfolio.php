<?php
/**
 * Plugin Name: TS Portfolio
 * Description: Basic postfolio capabilities. Adds a new "Portfolio" post type for users to showcase their work.
 * Author:      ThemeStockyard
 * Author URI:  http://themestockyard.com
 * Version:     1.0
 */

if(!ts_essentials_posttype_supported('portfolio')) return;

define('TS_PORTFOLIO_DIR', trailingslashit(dirname(__FILE__)));

class TS_Portfolio {
    
    static function add_hooks() {
        add_action('init', 'TS_Portfolio::register_portfolio_post_type');		
        add_filter('template_include', 'TS_Portfolio::template_loader', 99 ); 
        add_filter('manage_portfolio_posts_columns', 'TS_Portfolio::edit_columns');
        add_action('manage_portfolio_posts_custom_column',  'TS_Portfolio::custom_columns');
    }
    
    static function register_portfolio_post_type() {
    
        $permalinks = get_option( 'ts_essentials_portfolio_permalinks' );
        $permalinks = (is_array($permalinks)) ? $permalinks : array();
		$portfolio_post_permalink = (!isset($permalinks['portfolio_base']) || empty( $permalinks['portfolio_base'] )) ? 'work' : $permalinks['portfolio_base'];
    
        register_post_type('portfolio', array(
            'labels' => array(
                'name' => __('Portfolio', 'ThemeStockyard'),
                'singular_name' => __('Portfolio Post', 'ThemeStockyard'),
                'menu_name' => __('Portfolio', 'ThemeStockyard'),
                'all_items' => __('All Portfolio Posts', 'ThemeStockyard'),
                'add_new_item' => __('Add New Portfolio Post', 'ThemeStockyard'),
                'edit_item' => __('Edit Portfolio Post', 'ThemeStockyard'),
                'new_item' => __('New Portfolio Post', 'ThemeStockyard'),
                'view_item' => __('View Portfolio Post', 'ThemeStockyard'),
                'search_items' => __('Search Portfolio', 'ThemeStockyard'),
                'not_found' => __('No portfolio posts found', 'ThemeStockyard'),
                'not_found_in_trash' => __('No portfolio posts found in trash', 'ThemeStockyard'),
            ),
            'description' => __('A post type used to manage/showcase your portfolio', 'ThemeStockyard'),
            'public'            => true,
            'has_archive'        => true,
            'show_ui'               => true,
            'show_in_menu'      => true,
            'show_in_nav_menus' => false,
            'menu_position'     => 30,
            'capability_type'    => 'post',
            'hierarchical'       => false,
            'supports'           => array('title','editor','thumbnail'),
            'query_var'          => true,
            'publicly_queryable' => true,
            'rewrite'            => array("slug" => untrailingslashit($portfolio_post_permalink)),
        ));
        
        register_taxonomy(
            "portfolio-category", array("portfolio"), array(
                "hierarchical"   => true,
                "label"          => __('Portfolio Categories', 'ThemeStockyard'), 
                "labels"         => array(
                                        'menu_name'          => __('Categories', 'ThemeStockyard'),
                                    ),
                "singular_label" => __('Portfolio Category', 'ThemeStockyard'), 
                "rewrite"        => true)
        );
        
        register_taxonomy_for_object_type('portfolio-category', 'portfolio');
    }
    
    


    static function template_loader( $template ) {

        $find = array();
        $file = '';

        if ( is_single() && get_post_type() == 'portfolio' ) {

            $file 	= 'single-portfolio.php';
            $find[] = $file;

        } elseif ( is_tax( 'portfolio-category' )) {

            $file 		= 'taxonomy-portfolio.php';
            $find[] 	= $file;

        } elseif ( is_post_type_archive( 'portfolio' )) {

            $file 	= 'archive-portfolio.php';
            $find[] = $file;

        }

        if ( $file ) {
            $template = locate_template( $find );
        }

        return $template;
    }




         
    static function edit_columns($columns) {  
        $columns = array(  
            "cb"            => "<input type=\"checkbox\" />",  
            "title"         => __('Project', 'ThemeStockyard'),  
            "description"   => __('Description' , 'ThemeStockyard'),   
            "type"          => __('Categories', 'ThemeStockyard'),  
            "photo"         => __('Image', 'ThemeStockyard'),
            "date"          => __('Date', 'ThemeStockyard'), 
        );    
        return $columns;  
    }    
      


       
    static function custom_columns($column) {  
        global $post;  
        switch ($column) {  

            case "type":  
                echo get_the_term_list($post->ID, 'portfolio-category', '', ', ','');  
                break; 
                
            case "description":  
                ts_essentials_max_charlength(150);  
                break;  
                
            case "photo":  
                echo get_the_post_thumbnail($post->ID, 'thumbnail');
                break;  
        }  
    } 
}
TS_Portfolio::add_hooks();



/**
 * Adds settings to the permalinks admin settings page.
 *
 */

if ( ! class_exists( 'TS_Portfolio_Permalink_Settings' ) ) :

/**
 * TS_Protfolio_Permalink_Settings Class
 */
class TS_Portfolio_Permalink_Settings {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		add_action( 'admin_init',array( $this, 'settings_init' ) );
		add_action( 'admin_init',array( $this, 'settings_save' ) );
	}

	/**
	 * Init our settings.
	 */
	public function settings_init() {
		// Add a section to the permalinks page
		if(function_exists('add_settings_section')) :
            add_settings_section( 'ts-essentials-permalink', __( 'Portfolio Post permalink base (ThemeStockyard Essentials)', 'ThemeStockyard' ), array( $this, 'settings' ) , 'permalink' );
		endif;
	}

	/**
	 * Show the settings.
	 */
	 
	public function settings() {
	
		echo wpautop( __( 'These settings control the permalinks used for portfolio posts. These settings only apply when <strong>not using "default" permalinks above</strong>.', 'ThemeStockyard' ) );

		$permalinks = get_option( 'ts_essentials_portfolio_permalinks' );
		
		$portfolio_permalink = (is_array($permalinks) && isset($permalinks['portfolio_base'])) ? $permalinks['portfolio_base'] : '';

		$portfolio_base   = 'work';

		$structures = array(
			0 => '',
			1 => '/' . trailingslashit( $portfolio_base )
		);
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label><input name="ts_essentials_portfolio_permalink" type="radio" value="<?php echo esc_attr($structures[0]); ?>" class="tstog" <?php checked( $structures[0], $portfolio_permalink ); ?> /> <?php _e( 'Default', 'ThemeStockyard' ); ?></label></th>
					<td><code><?php echo home_url(); ?>/?portfolio=sample-portfolio-post</code></td>
				</tr>
				<tr>
					<th><label><input name="ts_essentials_portfolio_permalink" type="radio" value="<?php echo esc_attr($structures[1]); ?>" class="tstog" <?php checked( $structures[1], $portfolio_permalink ); ?> /> /work/</label></th>
					<td><code><?php echo home_url(); ?>/work/sample-portfolio-post/</code></td>
				</tr>
				<tr>
					<th><label><input name="ts_essentials_portfolio_permalink" id="ts_essentials_custom_selection" type="radio" value="custom" class="tog" <?php checked( in_array( $portfolio_permalink, $structures ), false ); ?> />
						<?php _e( 'Custom Base', 'ThemeStockyard' ); ?></label></th>
					<td>
						<input name="ts_essentials_portfolio_permalink_structure" id="ts_essentials_permalink_structure" type="text" value="<?php echo esc_attr( $portfolio_permalink ); ?>" class="regular-text code"> <span class="description"><?php _e( 'Enter a custom base to use.', 'ThemeStockyard');?><br/><span style="background-color:#fffdc5;padding:5px;margin-top:10px;display:inline-block;"><?php _e('It is best if you <strong>do not</strong> use an existing page or post slug.', 'ThemeStockyard' ); ?></span></span>
					</td>
				</tr>
			</tbody>
		</table>
		<script type="text/javascript">
			jQuery( function() {
				jQuery('input.tstog').change(function() {
					jQuery('#ts_essentials_permalink_structure').val( jQuery( this ).val() );
				});

				jQuery('#ts_essentials_permalink_structure').focus( function(){
					jQuery('#ts_essentials_custom_selection').click();
				} );
			} );
		</script>
		<?php
	}

	/**
	 * Save the settings.
	 */
	 
	public function settings_save() {

		if ( ! is_admin() ) {
			return;
		}

		// We need to save the options ourselves; settings api does not trigger save for the permalinks page
		if ( isset( $_POST['permalink_structure'] ) || isset( $_POST['category_base'] ) && isset( $_POST['ts_essentials_portfolio_permalink'] ) ) {

			$permalinks = get_option( 'ts_essentials_portfolio_permalinks' );

			if ( ! $permalinks ) {
				$permalinks = array();
			}

			// Portfolio base
			$portfolio_permalink = sanitize_text_field( $_POST['ts_essentials_portfolio_permalink'] );

			if ( $portfolio_permalink == 'custom' ) {
				// Get permalink without slashes
				$portfolio_permalink = trim( sanitize_text_field( $_POST['ts_essentials_portfolio_permalink_structure'] ), '/' );

				// Prepending slash
				$portfolio_permalink = '/' . $portfolio_permalink;
			} elseif ( empty( $portfolio_permalink ) ) {
				$portfolio_permalink = false;
			}

			$permalinks['portfolio_base'] = untrailingslashit( $portfolio_permalink );

			update_option( 'ts_essentials_portfolio_permalinks', $permalinks );
		}
	}
}

endif;

return new TS_Portfolio_Permalink_Settings();

