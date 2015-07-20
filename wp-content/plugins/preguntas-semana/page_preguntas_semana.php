<?php
//http://codex.wordpress.org/Class_Reference/wpdb
//http://techslides.com/creating-a-wordpress-plugin-admin-page
//http://techslides.com/a-z-category-index-wordpress-plugin
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>


  <h2>Preguntas Semana Enpelootas <input type="submit" id="add-pregunta" class="button" value="Agregar nueva"></h2>

  <p class="search-box">
    <label class="screen-reader-text" for="post-search-input">Buscar preguntas:</label>
    <input type="search" id="post-pregunta-input" name="s" value="">
    <input type="submit" id="search-submit" class="button" value="Buscar preguntas">
  </p>


  <!--<div class="tablenav top">

		<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text">Selecciona acción en lote</label>
      <select name="action" id="bulk-action-selector-top">
        <option value="-1" selected="selected">Acciones en lote</option>
        	<option value="edit" class="hide-if-no-js">Editar</option>
        	<option value="trash">Mover a la papelera</option>
      </select>
      <input type="submit" id="doaction" class="button action" value="Aplicar">
		</div>
		<div class="alignleft actions">
      		<label for="filter-by-date" class="screen-reader-text">Filtrar por fecha</label>
      		<select name="m" id="filter-by-date">
      			<option selected="selected" value="0">Todas las fechas</option>
            <option value="201507">julio 2015</option>
            <option value="201506">junio 2015</option>
            <option value="201505">mayo 2015</option>
            <option value="201501">enero 2015</option>
      		</select>
      <label class="screen-reader-text" for="cat">Filtrar por categoría</label>
      <select name="cat" id="cat" class="postform">
      	<option value="0">Todas las categorías</option>
      	<option class="level-0" value="2">Calentometro</option>
      	<option class="level-0" value="3">El Dato Duro</option>
      	<option class="level-0" value="4">Enpeloota</option>
      	<option class="level-0" value="5">Fashion</option>
      	<option class="level-0" value="6">Food</option>
      	<option class="level-0" value="7">Le paso a un amig@</option>
      	<option class="level-0" value="8">Lifestyle</option>
      	<option class="level-0" value="9">Music</option>
      	<option class="level-0" value="10">Photography</option>
      	<option class="level-0" value="1">Sin categoría</option>
      	<option class="level-0" value="11">Technology</option>
      	<option class="level-0" value="12">Travel</option>
      	<option class="level-0" value="13">Uncategorized</option>
      </select>
      <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Filtrar">
    </div>

    <div class="tablenav-pages"><span class="displaying-num">32 elementos</span>
        <span class="pagination-links"><a class="first-page disabled" title="Ir a la primera página" href="http://localhost/wpnico/wp-admin/edit.php">«</a>
        <a class="prev-page disabled" title="Ir a la página anterior" href="http://localhost/wpnico/wp-admin/edit.php?paged=1">‹</a>
        <span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Seleccionar página</label><input class="current-page" id="current-page-selector" title="Página actual" type="text" name="paged" value="1" size="1"> de <span class="total-pages">2</span></span>
        <a class="next-page" title="Ir a la página siguiente" href="http://localhost/wpnico/wp-admin/edit.php?paged=2">›</a>
        <a class="last-page" title="Ir a la última página" href="http://localhost/wpnico/wp-admin/edit.php?paged=2">»</a></span>
    </div>

    <input type="hidden" name="mode" value="list">
    <div class="view-switch">
      <a href="/wpnico/wp-admin/edit.php?mode=list" class="view-list current" id="view-switch-list"><span class="screen-reader-text">Vista de lista</span></a>
      <a href="/wpnico/wp-admin/edit.php?mode=excerpt" class="view-excerpt" id="view-switch-excerpt"><span class="screen-reader-text">Ver extracto</span></a>
		</div>

		<br class="clear">
	</div>-->



  <?php
  global $wpdb;

  $arr = $wpdb->get_results("SELECT * FROM `wp_pregunta_semana`");

  echo '<div id="dt_example"><div id="container"><form><div id="demo">';
  echo '<table class="wp-list-table widefat fixed striped posts"  id="example"><thead><tr>';

  foreach ($arr[0] as $k => $v) {
      echo "<td>".$k."</td>";
  }

  echo '</tr></thead><tbody>';

  foreach($arr as $i=>$j){
  	echo "<tr>";
  	foreach ($arr[$i] as $k => $v) {
  	    echo "<td>".$v."</td>";
  	}
  	echo "</tr>";
  }

  echo '</tbody></table>';
  echo '</div></form></div></div>';
  ?>

  </body>

  <!--
  <script type="text/javascript">
  jQuery(document).ready(function($) {
  	$('#example').dataTable();
  });
  </script>-->

</html>
