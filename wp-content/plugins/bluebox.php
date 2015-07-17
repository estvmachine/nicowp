<?php
/* Plugin Name: BlueBox
Plugin URI: [Enter your website URL]
Description: Despliega una ventana de color azul con informacion
Version: 0.0.1
Author: Stevmachine
Author URI: [Enter your website URL]
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
                    extract($args, EXTR_SKIP);
                    echo $before_widget; // pre-widget code from theme
print <<<EOM


   <div class="container-large" align="left" style="background-color:hsla(202, 89%, 56%, 0.77);">
     <span>
     <h2 style="color:white;">Esta semana se nos viene peluda</h2>
     <p>
     <font color="white">  Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.
               Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500,
               cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó
               una galería de textos y los mezcló de tal manera que logró hacer un libro de textos
                especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno
                 en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado
                  en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de
                  Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus
                  PageMaker, el cual incluye versiones de Lorem Ipsum.
    </font>

     </span>
   </div>


EOM;
                    echo $after_widget; // post-widget code from theme
          }
}

add_action(
          'widgets_init',
          create_function('','return register_widget("BlueBox");')
);
?>
