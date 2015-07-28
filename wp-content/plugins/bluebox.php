<?php
/* Plugin Name: EnPelootas-BlueBox
Description: Caja azul con contenido para EnPelootas
Version: v0.0.1
Author: stevmachine
*/


class BlueBox extends WP_Widget {
          function BlueBox() {
                    $widget_ops = array(
                    'classname' => 'BlueBox',
                    'description' => 'Agrega una caja azul con info'
          );

          $this->WP_Widget(
                    'BlueBox',
                    'BlueBox',
                    $widget_ops
          );
}

          function widget($args, $instance) { // widget sidebar output
                    global $wpdb;
                    $wp_session = WP_Session::get_instance();
                    $id_pregunta= $wp_session['id_pregunta'];
                    $response= $wpdb->get_results("SELECT * FROM `wp_pregunta_semana` "
                                      ."WHERE  id_pregunta='".$id_pregunta."'");

                    extract($args, EXTR_SKIP);
                    echo $before_widget; // pre-widget code from theme

?>
   <div class="container-large"
        align="left"
        style="background-color:hsla(202, 89%, 56%, 0.77); <?php if(!$response) echo 'display:none;' ?>" >
     <span>
     <h2 style="color:white;"> <?php  print_r( $response[0]->contenido_pregunta);  ?></h2>
     <p>
     <font color="white">

       <?php

               print_r( $response[0]->sidebar_content);
       ?>
    </font>

     </span>
   </div>

<?php
                    echo $after_widget; // post-widget code from theme
          }
}

add_action(
          'widgets_init',
          create_function('','return register_widget("BlueBox");')
);
?>
