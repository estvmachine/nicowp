<?php
function ts_essentials_dummy_array()
{
    return ts_essentials_dummy('array');
}

function ts_essentials_dummy($return = 'string')
{
    if($return == 'array')
        return array();
    elseif($return == 'int')
        return intval(0);
    else
        return '';
}

function ts_essentials_full_url($include_port = false)
{
    $s = empty($_SERVER['HTTPS']) ? '' : ($_SERVER['HTTPS'] == 'on') ? 's' : '';
    $protocol = substr(strtolower($_SERVER['SERVER_PROTOCOL']), 0, strpos(strtolower($_SERVER['SERVER_PROTOCOL']), '/')) . $s;
    $port = ($_SERVER['SERVER_PORT'] == '80') ? '' : (($include_port) ? ":".$_SERVER['SERVER_PORT'] : '');
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
}

function ts_essentials_num2str($val)
{
    $unit = array('','K','M','B');
    while($val >= 1000)
    {
        $val /= 1000;
        array_shift($unit);
    }
    $unit = array_shift($unit);		
    return (round($val, 0) > 99) ? round($val, 0).$unit : round($val, 1).$unit;
}

function ts_essentials_print($str = '', $balanceTags = false)
{
	return ($balanceTags) ? balanceTags($str) : $str;
}

function ts_essentials_escape($str = '', $type = '', $context = '')
{
    if(trim($str))
    {
        if($type == 'strip')
        {
            if($context == 'widget_before_after')
            {
                return strip_tags($str, '<div><ul><li>');
            }
            elseif($context == 'widget_title_before_after')
            {
                return strip_tags($str, '<div><ul><li><h3><h4><h5><h6><strong><em><i><b><span>');
            }
            elseif(substr($context, 0, 1) == '<')
            {
                return strip_tags($str, $context);
            }
            else
            {
                return strip_tags($str);
            }
        }
        elseif($type == 'bal' || $type == 'balance')
        {
            return balanceTags($str);
        }
        elseif($type == 'attr')
        {
            return esc_attr($str);
        }
        elseif($type == 'html')
        {
            return esc_html($str);
        }
        elseif($type == 'url')
        {
            return esc_url($str);
        }
        elseif($type == 'js')
        {
            return esc_js($str);
        }
        elseif($type == 'textarea')
        {
            return esc_textarea($str);
        }
        elseif($type == 'sql')
        {
            return esc_sql($str);
        }
        elseif($type == 'post')
        {
            return wp_kses_post($str);
        }
    }
    
    return $str;
}

function ts_essentials_get_map_coordinates($address, $force_refresh = false ) {

    $address_hash = md5( $address );
    $coordinates = get_transient( $address_hash );

    if ($force_refresh || $coordinates === false) {

        $args       = array('address' => urlencode( $address ), 'sensor' => 'false');
        $url        = add_query_arg( $args, 'https://maps.googleapis.com/maps/api/geocode/json' );
        $response   = wp_remote_get( esc_url($url) );

        if( is_wp_error( $response ) )
            return;

        $data = wp_remote_retrieve_body( $response );

        if( is_wp_error( $data ) )
            return;

        if ( $response['response']['code'] == 200 ) {

            $data = json_decode( $data );

            if ( $data->status === 'OK' ) {

                $coordinates = $data->results[0]->geometry->location;

                $cache_value['lat']     = $coordinates->lat;
                $cache_value['lng']     = $coordinates->lng;
                $cache_value['address'] = (string) $data->results[0]->formatted_address;

                // cache coordinates for 3 months
                set_transient($address_hash, $cache_value, 3600*24*30*3);
                $data = $cache_value;

            } elseif ( $data->status === 'ZERO_RESULTS' ) {
                return __( 'No location found for the entered address.', 'ThemeStockyard' );
            } elseif( $data->status === 'INVALID_REQUEST' ) {
                return __( 'Invalid request. Did you enter an address?', 'ThemeStockyard' );
            } else {
                return __( 'Something went wrong while retrieving your map, please ensure you have entered the shortcode correctly.', 'ThemeStockyard' );
            }

        } else {
            return __( 'Unable to contact Google API service.', 'ThemeStockyard' );
        }

    } else {
       // return cached results
       $data = $coordinates;
    }

    return $data;
}

function ts_essentials_slugify($str = '')
{
    $str = preg_replace('/[^a-zA-Z0-9 -_]/', '', trim($str));
    $str = strtolower(str_replace(' ', '-', trim($str)));
    $str = preg_replace('/-+/', '-', $str);
    return $str;
}

function ts_essentials_fontawesome_class($icon, $default = '')
{
    $icon = (trim($icon)) ? trim($icon) : $default;
    
    if(ts_starts_with($icon, 'fa-'))
        $icon = substr($icon, 3);
    elseif(ts_essentials_starts_with($icon, 'icon-'))
        $icon = substr($icon, 5);
    
    return (trim($icon)) ? esc_attr('fa fa-'.$icon) : '';
}

function ts_essentials_starts_with($haystack, $needle)
{
    if(is_array($needle))
    {
        foreach($needle AS $need)
        {
            $length = strlen($need);
            $result = (substr($haystack, 0, $length) === $need);
            if($result === true)
            {
                return true;
                break;
            }
        }
    }
    else
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
}

function ts_essentials_option_vs_default($option = '', $default = '', $avoid_empty_values = false)
{
    global $smof_data;
    if(trim($option)) {
        $parts = explode('::', $option);
        if(count($parts) == 2)
        {
            if(isset($smof_data[$parts[0]][$parts[1]]))
                return ($avoid_empty_values && $smof_data[$parts[0]][$parts[1]] == '') ? $default : $smof_data[$parts[0]][$parts[1]];
        }
        else
        {
            if(isset($smof_data[$option]))
                return ($avoid_empty_values && $smof_data[$option] == '') ? $default : $smof_data[$option];
        }
    }
    return ($default) ? $default : '';
}


function ts_essentials_output_social_icon($arg, $preset = '', $override = false) 
{
    $orig_arg = $arg;
    $social_icon_style = ts_essentials_option_vs_default('social_icon_style', 'fontawesome');
    $arg = 'social_url_'.$arg;
    $val = ($override !== false) ? $override : ts_essentials_option_vs_default($arg, $preset);
    if(trim($val)) :
        $url = $val;
        if($orig_arg == 'rss' && ($preset == '[rss_url]' || $url == '[rss_url]')) :
            $override = '[rss_url]';
            $url = ts_essentials_get_feed_url($override);
        endif;  
        
        $orig_arg = ($orig_arg == 'google_plus') ? 'google-plus' : $orig_arg;
        $orig_arg = ($orig_arg == 'vimeo') ? 'vimeo-square' : $orig_arg;
        
        return '<a href="'.esc_url($url).'" class="icon-style" target="_blank"><i class="fa fa-'.esc_attr($orig_arg).'"></i></a>';
    else :
        return '';
    endif;
}

function ts_essentials_get_feed_url($override = '')
{    
    if(trim($override)) {
        if(in_array($override, array('[rss]', '[rss_url]'))) 
            return get_bloginfo('rss2_url');
        else
            return $override;
    }
    
    return get_bloginfo('rss2_url');
}

function ts_essentials_number_within_range($num, $min = 1, $max = 100)
{
    // make sure max & min are placed correctly
    if($min > $max) list($min, $max) = array($max, $min);
    return ($num >= $min && $num <= $max) ? true : false;
}

function ts_essentials_max_charlength($charlength, $text = null) 
{
    $excerpt = ($text) ? $text : get_the_excerpt();
    $charlength++;
    echo (strlen($excerpt) > $charlength) ? ts_trim_text($excerpt, $charlength) : $excerpt;
}

function ts_essentials_trim_text($input, $length, $ellipses = true, $strip_html = true) 
{
    $length = (is_numeric($length)) ? $length : 100;
    
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags(do_shortcode($input));
    }
 
    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length)
        return $input;
        
    // first we see if there are any encoded characters
    $num = 0;
    $t = substr($input, 0, $length);
    preg_match_all("/&#?[a-zA-Z0-9]{1,7};/", $t, $specials);
    if(is_array($specials) && count($specials[0])) {
        $specials = $specials[0];
        foreach($specials AS $special) {
            $length = $length + strlen($special);
        }
    }
 
    // we do this again since we have now allowed for special chars
    if (strlen($input) <= $length)
        return $input;
 
    //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);
    $trimmed_text = ($trimmed_text) ? $trimmed_text : substr($input, 0, $length);
 
    return ($ellipses) ? $trimmed_text . '...' : $trimmed_text;
}

function ts_essentials_time2str($ts = null)
{
    $orig_ts = strtotime($ts);
    if(!ctype_digit($ts))
        $ts = strtotime($ts);

    $diff = time() - $ts;
    if($diff == 0)
        return 'now';
    elseif($diff > 0)
    {
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 60) return 'just now';
            if($diff < 120) return '1 minute ago';
            if($diff < 3600) return floor($diff / 60) . ' minutes ago';
            if($diff < 5400) return '1 hour ago';
            if($diff < 7200) return '2 hours ago';
            if($diff < 86400) return round($diff / 3600) . ' hours ago';
        }
        if($day_diff < 7)
        {
            $day_diff = ceil($diff / 86400);
            return ($day_diff <= 1) ? 'Yesterday' : $day_diff . ' days ago';
        }
        if($day_diff < 31) return (ceil($day_diff / 7) == 1) ? ceil($day_diff / 7) . ' week ago' : ceil($day_diff / 7) . ' weeks ago';
        if($day_diff < 60) return 'last month';
        return date('F Y', $ts);
    }
    else
    {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 120) return 'in a minute';
            if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
            if($diff < 5400) return 'in an hour';
            if($diff < 7200) return 'in 2 hours';
            if($diff < 86400) return 'in ' . round($diff / 3600) . ' hours';
        }
        if($day_diff == 1)
        {
            $day_diff = abs(ceil($diff / 86400));
            return ($day_diff <= 1) ? 'Tomorrow' : 'in '.$day_diff.' days';
        }
        if($day_diff < 4) return date('l', $ts);
        if($day_diff < 7 + (7 - date('w'))) return 'next week';
        if(ceil($day_diff / 7) < 4) return (ceil($day_diff / 7) == 1) ? 'in ' . ceil($day_diff / 7) . ' week' : 'in ' . ceil($day_diff / 7) . ' weeks';
        if(date('n', $ts) == date('n') + 1) return 'next month';
        return date('F Y', $ts);
    }
}

/*
 * Clean a tweet: translate links, usernames beginning '@', and hashtags
 */
function ts_essentials_clean_tweet($tweet, $links_in_new_tab = false)
{
    global $ts_open_tweet_links_in_new_tab;
    
    $ts_open_tweet_links_in_new_tab = ($links_in_new_tab) ? 1 : 0;
    
    $tweet = trim($tweet);
    
	$regexps = array
	(
		"link"  => '/[a-z]+:\/\/[a-z0-9-_]+\.[a-z0-9-_@:~%&\?\+#\/.=]+[^:\.,\)\s*$]/i',
		"at"    => '/(^|[^\w]+)\@([a-zA-Z0-9_]{1,15}(\/[a-zA-Z0-9-_]+)*)/',
		"hash"  => "/(^|[^&\w'\"]+)\#([a-zA-Z0-9_]+)/"
	);

	foreach ($regexps as $name => $re)
	{
		$tweet = preg_replace_callback($re, 'ts_essentials_parse_tweet_'.$name, $tweet);
	}
	
	unset($GLOBALS['ts_open_tweet_links_in_new_tab']);

	return $tweet;
}

/*
 * Wrap a link element around URLs matched via preg_replace()
 */
function ts_essentials_parse_tweet_link($m)
{
    global $ts_open_tweet_links_in_new_tab;
    $target = ($ts_open_tweet_links_in_new_tab == 1) ? '_blank' : '_self';
	return '<a href="'.esc_url($m[0]).'" target="'.esc_attr($target).'">'.$m[0].'</a>';
}

/*
 * Wrap a link element around usernames matched via preg_replace()
 */
function ts_essentials_parse_tweet_at($m)
{
    global $ts_open_tweet_links_in_new_tab;
    $target = ($ts_open_tweet_links_in_new_tab == 1) ? '_blank' : '_self';
    $url = 'https://twitter.com/'.$m[2];
	return $m[1].'<a href="'.esc_url($url).'" class="at-link" target="'.esc_attr($target).'"><span class="at-sym">@</span><span class="at-text">'.$m[2].'</span></a>';
}

/*
 * Wrap a link element around hashtags matched via preg_replace()
 */
function ts_essentials_parse_tweet_hash($m)
{   
    global $ts_open_tweet_links_in_new_tab;
    $target = ($ts_open_tweet_links_in_new_tab == 1) ? '_blank' : '_self';
    $url = 'https://twitter.com/search?q=%23'.$m[2];
	return $m[1].'<a href="'.esc_url($url).'" class="hash-link" target="'.esc_attr($target).'"><span class="hash-sym">#</span><span class="hash-text">'.$m[2].'</span></a>';
}



function ts_essentials_get_categories($category_name = 'category', $hide_empty = '1', $return = 'array') 
{
    $hide_empty  = ($hide_empty == 1) ? '1' : '0';
    $categories = get_categories(array('taxonomy' => $category_name, 'hide_empty' => $hide_empty));
    $categories = (isset($categories['errors'])) ? array() : $categories;
    
    if($return == 'array') 
        return $categories;    
    elseif($return == 'cb_metabox_array')
    {
        $category_list = array();
        foreach ($categories as $category) 
        {
            $category_list[] = array('name'=>$category->cat_name, 'value'=>$category->term_id);
        }
        
        return $category_list;
    }
    else
    {
        $all = ($parent) ? $parent : 'All';
        $category_list = array('0' => $all);
        
        foreach ($categories as $category) 
        {
            $category_list[] = $category['name'];
        }
            
        return $category_list;
    }
}

function ts_essentials_attr_is_true($arg)
{
    return ($arg === true || $arg === 1 || $arg == "1" || strtolower(trim($arg)) == 'true' || strtolower(trim($arg)) == 'yes') ? true : false;
}

function ts_essentials_attr_is_false($arg)
{
    return ($arg === false || $arg === 0 || $arg == "0" || strtolower(trim($arg)) == 'false' || strtolower(trim($arg)) == 'no') ? true : false;
}

function ts_essentials_divide_list_into_columns($content = '', $columns = 1, $arrange_columns = 'vertical', $ul_class = 'list-shortcode')
{
    $output = '';
    $columns = ($columns > 4) ? 4 : $columns;
    $ul_class = esc_attr($ul_class);
    
    if(is_array($content))
    {
        if($columns < 2)
        {
            $output .= "\n".'<ul class="'.esc_attr($ul_class).'">'.implode('', $content).'</ul>';
        }
        else
        {
            $count = count($content);
            $base_count_per_column = floor($count / $columns);            
            $high_count_per_column = ceil($count / $columns);
            $remainder = $og_remainder = $count - ($base_count_per_column * $columns);
            
            $column_class = 'ts-1-of-'.$columns;
            
            if($arrange_columns == 'vertical')
            {                
                $columns_array = array();
                for($i = 0; $i < $columns; $i++)
                {
                    $columns_array[$i] = '';
                }
                
                $j = 0;
                $k = 0;
                foreach($content AS $item)
                {
                    if(!trim($item)) continue;
                    
                    $count_per_column = ($remainder) ? $high_count_per_column : $base_count_per_column;
                    $columns_array[$k] .= "\t".$item."\n";
                    if($j == ($count_per_column - 1))
                    {
                        $j = 0;
                        $k++;
                        $remainder = ($remainder) ? $remainder - 1 : 0;
                    }
                    else
                    {
                        $j++;
                    }
                }
                
                $l = 1;
                foreach($columns_array AS $column)
                {
                    $column_class = ($l == $columns) ? $column_class.' ts-column-last' : $column_class;
                    $output .= "\n".'<ul class="'.esc_attr($ul_class.' '.$column_class).'">'."\n".$column.'</ul>';
                    $l++;
                }
                
            }
            else
            {
                $columns_array = array();
                for($i = 0; $i < $columns; $i++)
                {
                    $columns_array[$i] = '';
                }
                
                $j = 0;
                foreach($content AS $item)
                {
                    if(!trim($item)) continue;
                    
                    $count_per_column = $high_count_per_column;
                    $columns_array[$j] .= "\t".$item."\n";
                    if($j == ($columns - 1))
                    {
                        $j = 0;
                    }
                    else
                    {
                        $j++;
                    }
                }
                
                $l = 1;
                foreach($columns_array AS $column)
                {
                    $column_class = ($l == $columns) ? $column_class.' ts-column-last' : $column_class;
                    $output .= "\n".'<ul class="'.esc_attr($ul_class.' '.$column_class).'">'."\n".$column.'</ul>';
                    $l++;
                }
            }
            $output .= "\n".'<div class="clear"></div>'."\n";
        }
    }
    else
    {
        //$output .= $content;
        $output .= "\n".'<ul class="'.esc_attr($ul_class).'">'.$content.'</ul>';
    }
    
    return $output;
}

function ts_essentials_css_num($num, $allow_percent = false, $default = '')
{
    $num = trim(str_replace(' ', '', $num));
    if($allow_percent && strpos($num, '%') !== false) :
        $num = preg_replace("/[^0-9]*/", "", $num);
        $num = ($num == '') ? '' : $num.'%';
    else :
        $num = preg_replace("/[^0-9]*/", "", $num);
        $num = ($num == '') ? '' : $num.'px';
    endif;
    
    return ($num == '') ? $default : $num;
}


function ts_essentials_encode_all($str = '') 
{
    $str = mb_convert_encoding($str , 'UTF-32', 'UTF-8'); //big endian
    $split = str_split($str, 4);

    $res = "";
    foreach ($split as $c) {
        $cur = 0;
        for ($i = 0; $i < 4; $i++) {
            $cur |= ord($c[$i]) << (8*(3 - $i));
        }
        $res .= "&#" . $cur . ";";
    }
    return $res;
}

function ts_essentials_fade_in_class($arg = '')
{
    $arg = (in_array($arg, array('top','right','bottom','left','above','below'))) ? $arg : '';
    $arg = ($arg == 'below') ? 'bottom' : $arg;
    $arg = ($arg == 'above') ? 'top' : $arg;
    return ($arg) ? 'ts-fade-in-from-'.$arg : 'ts-fade-in';
}

function ts_essentials_oembed_html_api_fix($html = '')
{
    $iframe_id = 'vid-'.mt_rand();
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    $tag = $dom->getElementsByTagName('iframe')->item(0);
    $src = $tag->getAttribute('src');
    $src_parts = explode('?', $src);
    $connector = (isset($src_parts[1])) ? '&amp;' : '?';
    
    $class = '';
    
    if(strpos($src_parts[0], 'vimeo') !== false) :
        $src = $src.$connector.'api=1&amp;player_id='.$iframe_id;
        $class = "ts-vimeo-player";
    elseif(strpos($src_parts[0], 'youtu') !== false) :
        $src = $src.$connector.'enablejsapi=1';
        $class = "ts-youtube-player";
    else :
        return $html;
    endif;
    
    $tag->setAttribute('src', $src);
    $tag->setAttribute('id', $iframe_id);
    $tag->setAttribute('class', $class);
    
    return $dom->saveHTML($tag);
}

function ts_essentials_hex2rgb($hex, $return = 'array') 
{
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   
   return ($return == 'string') ? implode(", ", $rgb) : $rgb;
}