<?php
//http://codex.wordpress.org/Class_Reference/wpdb
//http://techslides.com/creating-a-wordpress-plugin-admin-page
//http://techslides.com/a-z-category-index-wordpress-plugin

global $wpdb;

echo "<h2>Preguntas Semana Enpelootas</h2>";

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

<script type="text/javascript">
jQuery(document).ready(function($) {
	$('#example').dataTable();
});
</script>
