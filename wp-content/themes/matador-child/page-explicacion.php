<?php
/**
*Template Name: Page con header-explicacion
**/

global $smof_data, $ts_previous_posts, $ts_page_id, $ts_show_top_ticker;
global $wpdb;


$ts_page_object = get_queried_object();
$ts_page_id     = (is_single()) ? $post->ID : get_queried_object_id();
$ts_custom_css  = get_post_meta($ts_page_id, '_page_css', true);

$ts_show_top_ticker_option = (ts_option_vs_default('show_page_top_ticker', 0) == 1) ? 'yes' : 'no';
$ts_show_top_ticker = ts_postmeta_vs_default($ts_page_id, '_page_top_ticker', $ts_show_top_ticker_option);

$ts_show_sidebar_option = (ts_option_vs_default('show_page_sidebar', 1) != 1) ? 'no' : 'yes';
$ts_show_sidebar = ts_postmeta_vs_default($ts_page_id, '_page_sidebar', $ts_show_sidebar_option);
$ts_show_sidebar_class = ($ts_show_sidebar == 'yes') ? 'has-sidebar' : 'no-sidebar';

$ts_sidebar_position_option = ts_option_vs_default('page_sidebar_position', 'right');
$ts_sidebar_position = ts_postmeta_vs_default($ts_page_id, '_page_sidebar_position', $ts_sidebar_position_option);

$ts_page_comments = (ts_option_vs_default('page_comments',0) == 1) ? true : false;

get_header();
get_template_part('top-sin-header');
get_template_part('title-page-explicacion');
get_template_part('slider');

$featured_media_vars = array('media_width'=>1040,'media_height'=>340,'is_single'=>1);
$featured_media = ts_get_featured_media($featured_media_vars);
$main_container_wrap_class = '';

if(isset($featured_media) && trim($featured_media)) :
    $ts_sidebar_position = 'content-'.$ts_sidebar_position;
    //$main_container_wrap_class = 'no-top-padding';
endif;
?>

        <div id="main-container-wrap" class="<?php echo esc_attr(ts_main_container_wrap_class('page')).' '.esc_attr($main_container_wrap_class);?>">

          <div class='dropdown'>qwq
              <a class='dropdown-toggle' data-hover='dropdown' data-toggle='dropdown' href='#'>

                <i class='fa fa-angle-down'></i>
              </a>
              <ul class='dropdown-menu'>

             <?php $results = $GLOBALS['wpdb']->get_results( 'SELECT * FROM `wp_pregunta_semana`', ARRAY_A   );
               for ($i = 0; $i < count($results); ++$i) {
                        echo "<li><a href=''>". print_r($results[$i]). "</a></li>";
                     }
              ?>
              </ul>
          </div>

            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
            ?>

                <div id="main-container" class="container clearfix">
                    <div id="main" class="<?php echo esc_attr(ts_main_div_class());?> clearfix">
                        <div class="entry single-entry clearfix">
                            <div id="ts-post-content-sidebar-wrap" class="clearfix">
                                <div id="ts-post-wrap">

                                    <div id="ts-post" <?php post_class('post clearfix'); ?>>
                                        <div id="ts-post-the-content-wrap">
                                            <div id="ts-post-the-content">

                                                <?php
                                                the_content();

                                                wp_link_pages('before=<div class="page-links">'.__('Pages: ', 'ThemeStockyard').'<span class="wp-link-pages">&after=</span></div>&link_before=<span>&link_after=</span>');
                                                ?>

                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if($ts_page_comments) :
                                    ?>

                                    <div id="ts-comments-wrap-wrap" class="clearfix">
                                        <?php
                                        if(get_comments_number() < 1) :
                                            echo '<div id="comments">';
                                            echo do_shortcode('[divider height="0"]');
                                            echo '</div>';
                                        endif;
                                        ?>
                                        <div id="ts-comments-wrap">
                                            <?php comments_template(); ?>
                                        </div>
                                    </div>

                                    <?php
                                    endif;
                                    ?>

                                </div>
                                <?php ts_get_content_sidebar(); ?>
                            </div>




                        </div>
                    </div>

<?php if(!post_password_required()) ts_get_sidebar(); ?>

                </div><!-- #main-container -->

            <?php
                endwhile;
            else :
            ?>
            <div id="main-container" class="container clearfix">
                    <div id="main" class="<?php echo esc_attr($ts_show_sidebar_class);?> clearfix">
                        <div class="entry single-entry clearfix">
                            <div class="post"><p><?php _e('Sorry, the post you are looking for does not exist.', 'ThemeStockyard');?></p></div>
                        </div>
                    </div>
                </div>
            <?php
            endif;
            ?>
            </div><!-- #main-container-wrap -->

<?php get_footer(); ?>
