<?php
global $smof_data, $ts_top_ad, $woocommerce, $ts_page_id;

$wp_session = WP_Session::get_instance();
if (get_query_var('id_pregunta')){
  //print "id_pregunta = $id_pregunta";
  $wp_session['id_pregunta'] = $id_pregunta;
}
echo $wp_session['id_pregunta'];

if(isset($_GET["id_pregunta"]) && trim($_GET["id_pregunta"]) !== ''){
   $slide = trim($_GET["id_pregunta"]);
   //echo "<script type='text/javascript'>alert('$slide');</script>";
   //echo $smof_data['id_pregunta'];
}
else{
   $slide = '';
}

?>
<script type="text/javascript">
jQuery(document).ready(function($) {

    //Detectar si se encuentra con algun id_pregunta activo
    var id_pregunta= getUrlParameter('id_pregunta');
    if(typeof id_pregunta!== 'undefined'){
      console.log(id_pregunta);
      $("#select-pregunta").val(id_pregunta).change();
    }
    else{
      //var last_id = $GLOBALS['wpdb']->get_results( 'SELECT id_pregunta FROM `wp_pregunta_semana` ORDER BY id_pregunta DESC LIMIT 1', ARRAY_A   );
      //console.log(last_id);
    //  window.location.href = window.location.pathname+"?id_pregunta="+3;

    }

    //Detectar cuando se selecciona una pregunta diferente
    $('#select-pregunta').on('change', function (e) {
      var conceptName = $(this).find(":selected").text();
      var value= $(this).find(":selected").val();
      window.location.href = window.location.pathname+"?id_pregunta="+value;
  });


});

function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
}
</script>
                <div id="top-wrap" class="<?php echo ts_top_class();?>">
                    <!-- Top -->
                    <div id="top-container" class="top-default">
                        <div id="top" class="ts-top">

                            <!-- top-bar -->
                            <?php //echo ts_get_top_bar();?>
                            <!-- /top-bar -->

                            <!-- ticker: top -->
                             <?php echo ts_get_ticker('top');?>
                            <!-- /ticker: top -->


                            <!--<div id="logo-nav-wrap">
                                <div id="logo-tagline-wrap" class="container logo-tagline-wrap">
                                    <div id="logo" class="main-logo">
                                        <?php
                                          //echo ts_theme_logo();
                                        //  echo ts_theme_logo_tagline();
                                        ?>
                                    </div>
                                </div>-->


                                <div id="nav" class="main-nav-wrap ts-main-nav-wrap container">

                                  <div class="row" id="barra-nav-custom">

                                      <a class="col-md-1" href="http://localhost/nico/">
                                        <!--<img src="./wp-content/themes/matador/images/logos/logo_navbar.jpg" style='width:auto;'/>-->
                                        <img src="http://i197.photobucket.com/albums/aa275/estv/11714429_943994605622967_1169464049_n_zpszgcgengb.jpg" style='width:auto;'/>
                                      </a>

                                      <div class="row col-md-1">

                                       <div class="row">
                                         <!--Pregunta dropdown -->
                                          <div class='col-md-12' style="width:100%;">
                                            <!--Pregunta dropdown -->
                                               <select id="select-pregunta" class='col-md-12' style='background-color:white;
                                                                                width:100%;
                                                                                -webkit-appearance: none;
                                                                                -moz-appearance: none;
                                                                                appearance: none;
                                                                                padding: 2px 2px 2px 20px;
                                                                                border: none;
                                                                                background: transparent url("http://cdn1.iconfinder.com/data/icons/cc_mono_icon_set/blacks/16x16/br_down.png") no-repeat left center;'>
                                                 <?php $results = $GLOBALS['wpdb']->get_results( 'SELECT * FROM `wp_pregunta_semana`', ARRAY_A   );

                                                   $id_;
                                                   for ($i = 0; $i < count($results); ++$i) {
                                                     foreach ($results[$i] as $k => $v) {

                                                             if($k == 'id_pregunta'){
                                                                 $id_= $v;
                                                             }
                                                             if($k == 'contenido_pregunta'){
                                                               echo '<option class="level-0" value='.$id_.'>';
                                                               echo($v);
                                                               echo "</option>";
                                                             }

                                                     }
                                                    }

                                                  ?>
                                                  <option class="leve-0" value="100">Holooo</option>
                                               </select>
                                          </div>

                                        </div> <!-- Parte superior de NAVBAR-->

                                        <div id="ts-main-nav-inner-wrap">
                                            <div id="main-nav-mobile" class="mobile-nav"><a id="ts-top-mobile-menu" class="mobile-menu"><strong class="mobile-menu-icon"></strong><span class="mobile-menu-sep"></span><?php _e('Menu','ThemeStockyard');?></a></div>
                                            <div id="main-nav" class="main-nav normal">
                                                <?php
                                                $nav_menu_options = array(
                                                    'container'         => false,
                                                    'theme_location'    => 'main_nav',
                                                    'menu_class'        => 'sf-menu clearfix',
                                                    'depth'             => 3,
                                                    'menu_id'           => 'main-nav-links',
                                                    'link_before'       => '<span>',
                                                    'link_after'        => '</span>',
                                                    'items_wrap'        => '<ul class="sf-menu clearfix">%3$s</ul>'
                                                );
                                                if( function_exists( 'uberMenu_direct' ) ) {
                                                    echo uberMenu_direct( 'main_nav', false, false);
                                                } else {
                                                    wp_nav_menu($nav_menu_options);
                                                }
                                                ?>
                                            </div>
                                        </div> <!-- Parte inferior de NAVBAR -->

                                      </div> <!--NAV BAR SIN LOGO -->

                                    </div> <!-- <div class="row" id="barra-nav-custom"> -->
                                </div>  <!--<div id="nav" class="main-nav-wrap ts-main-nav-wrap container"> -->
                            </div> <!--<div id="logo-nav-wrap"> -->

                            <!-- ticker: nav -->
                            <?php echo ts_get_ticker('nav');?>
                            <!-- /ticker: nav -->
                        </div>
                    </div>
                    <!-- / #top -->
                </div>
                <!-- / #top-wrap -->
