<?php
/*$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . '/wp-config.php';
include_once $path . '/wp-load.php';
include_once $path . '/wp-includes/wp-db.php';
include_once $path . '/wp-includes/pluggable.php';*/
include_once '../../wp-config.php';
include_once '../../wp-load.php';
include_once '../../wp-includes/wp-db.php';
include_once '../../wp-includes/pluggable.php';


    $contenido_pregunta =$_POST['contenido_pregunta'];
    $fecha_inicio =$_POST['fecha_inicio'];
    $fecha_fin =$_POST['fecha_fin'];

    $sidebar_elchat =$_POST['sidebar_elchat'];
    $sidebar_eldatoduro =$_POST['sidebar_eldatoduro'];
    $sidebar_lepaso =$_POST['sidebar_lepaso'];
    $sidebar_calentometro =$_POST['sidebar_calentometro'];
    $sidebar_empelotate =$_POST['sidebar_empelotate'];

    $links_empelotate =$_POST['links_empelotate'];

  //  echo $contenido_pregunta;
  //  echo $fecha_inicio;
  //  echo $fecha_fin;
  //  echo $sidebar_content;
      function redirect($url, $statusCode = 303)
      {
         header('Location: ' . $url, true, $statusCode);
         die();
      };

    global $wpdb;
    $table = $wpdb -> prefix . 'pregunta_semana';
    $wpdb->insert( $table, array(
                          'contenido_pregunta'   => $contenido_pregunta,
                          'fecha_inicio'         => $fecha_inicio,
                          'fecha_fin'            => $fecha_fin,
                          'sidebar_elchat'       => $sidebar_elchat,
                          'sidebar_eldatoduro'   => $sidebar_eldatoduro,
                          'sidebar_lepaso'       => $sidebar_lepaso,
                          'sidebar_calentometro' => $sidebar_calentometro,
                          'sidebar_empelotate'   => $sidebar_empelotate,
                          'links_empelotate'     => $links_empelotate
                      )
    );

    redirect('../admin.php?page=tt_list');





 ?>
