<?php
/*------------------------------------------------------------
Add your child theme custom functions below.
This file does not replace the parent theme's function file.
It is loaded in addition to the parent theme's functions file.
------------------------------------------------------------*/



function matador_child_widgets_init(){

  register_sidebar( array(
    'name'          => __('Form Widget Area', 'ThemeStockyard'),
    'description'   => __('Area con formulario.', 'ThemeStockyard'),
    'id'            => 'form-widget-area',
    'before_widget' => '<aside>',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>'
  ));
}
add_action('widgets_init', 'matador_child_widgets_init');


function matador_child_register_menu(){
  register_nav_menu('new-menu', __('Nuevo Menu'));

}

add_action('init', 'matador_child_register_menu');



/********Agregando variables para detectar por wordpress***********/

function add_query_vars_filter( $vars ){
  $vars[] = "id_pregunta";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );
