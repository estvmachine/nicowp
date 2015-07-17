<?php
/* Plugin Name: Preguntas Enpelootas
Plugin URI: [Enter your website URL]
Description: Plugin admin para editar preguntas de Enpelootas
Version: 0.0.1
Author: Stevmachine
Author URI: [Enter your website URL]
*/



add_action('admin_menu', 'plugin_admin_add_page');
function plugin_admin_add_page() {
  //http://codex.wordpress.org/Function_Reference/add_menu_page
  add_menu_page( 'Preguntas Enpelootas Editor', 'Preguntas', 'manage_options', 'preguntas-semana/page_preguntas_semana.php');
}

function my_enqueue($hook) {
  //only for our special plugin admin page
  if( 'preguntas-semana/page_preguntas_semana.php' != $hook )
    return;

  //wp_register_style('dbexplorer', plugins_url('dbexplorer/pluginpage.css'));
//  wp_enqueue_style('dbexplorer');

//  wp_enqueue_script('pluginscript', plugins_url('pluginpage.js', __FILE__ ), array('jquery'));
}

  add_action( 'admin_enqueue_scripts', 'my_enqueue' );
?>
