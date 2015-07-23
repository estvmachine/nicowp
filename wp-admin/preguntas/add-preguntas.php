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

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
};


    $contenido_pregunta =$_POST['contenido_pregunta'];
    $fecha_inicio =$_POST['fecha_inicio'];
    $fecha_fin =$_POST['fecha_fin'];
    $sidebar_content =$_POST['descripcion_pregunta'];

    echo $contenido_pregunta;
    echo $fecha_inicio;
    echo $fecha_fin;
    echo $sidebar_content;


    global $wpdb;
    $table = $wpdb -> prefix . 'pregunta_semana';
    $wpdb->insert( $table, array(
                          'contenido_pregunta' => $contenido_pregunta,
                          'fecha_inicio' => $fecha_inicio,
                          'fecha_fin' => $fecha_fin,
                          'sidebar_content' => $sidebar_content
                      )
                  );


    redirect('../admin.php?page=tt_list');

 ?>
