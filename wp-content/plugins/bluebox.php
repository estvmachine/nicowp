<?php
/* Plugin Name: EnPelootas-BlueBox
Description: Caja azul con contenido para EnPelootas
Version: v0.0.2
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
                    //$categorys = wp_get_post_categories( $post_id, $args );
                    //$ts_page_id = (is_single()) ? $post->ID : get_queried_object_id();

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
     <h3 id="title-pregunta" style="color:white;"> <?php  print_r( $response[0]->contenido_pregunta);  ?></h3>
     <p>
     <font color="white">

       <span>
        <?php
            $post= new stdClass();
            $post->ID=$_GET['p'];
            $categories = get_the_category($post->ID);
            foreach($categories as $category) {
               $cat_name = $category->name;
               $cat_id = $category->cat_ID;
               echo $cat_id;

               if( $cat_id == 104  ||  $cat_name=='El Chat')
                echo $response[0]->sidebar_elchat;

               if( $cat_id == 105  ||  $cat_name=='El Dato Duro')
                echo $response[0]->sidebar_eldatoduro;

               if( $cat_id == 100  ||  $cat_name=='Le pasó a un@ amig@')
                 echo $response[0]->sidebar_lepaso;
            }
        ?>
      </span>

        <span><?php if(is_int ($ts_page_id)) {
            if($ts_page_id ==1831)  //Calentómetro
              echo $response[0]->sidebar_calentometro;

            if($ts_page_id ==1689)  //Calentómetro
              echo $response[0]->sidebar_empelotate;

        }


        ?></span>
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
