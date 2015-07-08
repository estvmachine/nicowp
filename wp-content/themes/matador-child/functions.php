<?php
/*------------------------------------------------------------
Add your child theme custom functions below.
This file does not replace the parent theme's function file.
It is loaded in addition to the parent theme's functions file.
------------------------------------------------------------*/



function matador_child_widgets_init(){

  register_sidebar( array(
    'name'          => __('Form sidebar', 'ThemeStockyard'),
    'description'   => __('Sidebar con formulario.', 'ThemeStockyard'),
    'id'            => 'form-sidebar',
    'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
    'after_widget'  => '</div>',
    'before_title'  => '<div class="page-title clearfix"><h5 class="mimic-small uppercase subtle-text-color"><span>',
    'after_title'   => '</span></h5></div>'
  ));
}

add_action('widgets_init', 'matador_child_widgets_init');


function matador_child_register_menu(){
  register_nav_menu('new-menu', __('Nuevo Menu'));

}

add_action('init', 'matador_child_register_menu');
