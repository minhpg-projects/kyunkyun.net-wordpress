<?php
// include_once 'welcomeMsg.php';

if(cs_get_option('enable_old_episode_manager')) include 'metaboxes.php';
if(cs_get_option('halim_disable_xmlrpc')) add_filter( 'xmlrpc_enabled', '__return_false' );

if(cs_get_option('halim_block_bad_query')) {
	add_action('plugins_loaded', 'halim_bbq_core');
}

function halim_bbq_core() {

	$request_uri_array  = apply_filters('request_uri_items',  array('@eval', 'eval\(', 'UNION(.*)SELECT', '\(null\)', 'base64_', '\/localhost', '\%2Flocalhost', '\/pingserver', 'wp-config\.php', '\/config\.', '\/wwwroot', '\/makefile', 'crossdomain\.', 'proc\/self\/environ', 'usr\/bin\/perl', 'var\/lib\/php', 'etc\/passwd', '\/https\:', '\/http\:', '\/ftp\:', '\/file\:', '\/php\:', '\/cgi\/', '\.cgi', '\.cmd', '\.bat', '\.exe', '\.sql', '\.ini', '\.dll', '\.htacc', '\.htpas', '\.pass', '\.asp', '\.jsp', '\.bash', '\/\.git', '\/\.svn', ' ', '\<', '\>', '\/\=', '\.\.\.', '\+\+\+', '@@', '\/&&', '\/Nt\.', '\;Nt\.', '\=Nt\.', '\,Nt\.', '\.exec\(', '\)\.html\(', '\{x\.html\(', '\(function\(', '\.php\([0-9]+\)', '(benchmark|sleep)(\s|%20)*\(', 'indoxploi', 'xrumer'));
	$query_string_array = apply_filters('query_string_items', array('@@', '\(0x', '0x3c62723e', '\;\!--\=', '\(\)\}', '\:\;\}\;', '\.\.\/', '127\.0\.0\.1', 'UNION(.*)SELECT', '@eval', 'eval\(', 'base64_', 'localhost', 'loopback', '\%0A', '\%0D', '\%00', '\%2e\%2e', 'allow_url_include', 'auto_prepend_file', 'disable_functions', 'input_file', 'execute', 'file_get_contents', 'mosconfig', 'open_basedir', '(benchmark|sleep)(\s|%20)*\(', 'phpinfo\(', 'shell_exec\(', '\/wwwroot', '\/makefile', 'path\=\.', 'mod\=\.', 'wp-config\.php', '\/config\.', '\$_session', '\$_request', '\$_env', '\$_server', '\$_post', '\$_get', 'indoxploi', 'xrumer'));
	$user_agent_array   = apply_filters('user_agent_items',   array('acapbot', '\/bin\/bash', 'binlar', 'casper', 'cmswor', 'diavol', 'dotbot', 'finder', 'flicky', 'md5sum', 'morfeus', 'nutch', 'planet', 'purebot', 'pycurl', 'semalt', 'shellshock', 'skygrid', 'snoopy', 'sucker', 'turnit', 'vikspi', 'zmeu'));

	$request_uri_string  = false;
	$query_string_string = false;
	$user_agent_string   = false;

	if (isset($_SERVER['REQUEST_URI'])     && !empty($_SERVER['REQUEST_URI']))     $request_uri_string  = $_SERVER['REQUEST_URI'];
	if (isset($_SERVER['QUERY_STRING'])    && !empty($_SERVER['QUERY_STRING']))    $query_string_string = $_SERVER['QUERY_STRING'];
	if (isset($_SERVER['HTTP_USER_AGENT']) && !empty($_SERVER['HTTP_USER_AGENT'])) $user_agent_string   = $_SERVER['HTTP_USER_AGENT'];

	if ($request_uri_string || $query_string_string || $user_agent_string) {

		if (

			// strlen( $_SERVER['REQUEST_URI'] ) > 255 || // optional

			preg_match('/'. implode('|', $request_uri_array)  .'/i', $request_uri_string)  ||
			preg_match('/'. implode('|', $query_string_array) .'/i', $query_string_string) ||
			preg_match('/'. implode('|', $user_agent_array)   .'/i', $user_agent_string)

		) {

			halim_bbq_response();

		}

	}

}

function halim_bbq_response() {

	header('HTTP/1.1 403 Forbidden');
	header('Status: 403 Forbidden');
	header('Connection: Close');

	exit();

}

if(!function_exists('halim_display_post_view_count'))
{
	function halim_display_post_view_count($postid, $type = 'all')
	{
		if($type == 'day') {
			$meta_key = 'halim_view_post_day';
		} elseif ($type == 'week') {
			$meta_key = 'halim_view_post_week';
		} elseif ($type == 'month') {
			$meta_key = 'halim_view_post_mon';
		} else {
			$meta_key = 'halim_view_post_all';
		}

		$count = get_post_meta($postid, $meta_key, true);
		if ($count == '') {
			delete_post_meta($postid, $meta_key);
			add_post_meta($postid, $meta_key, '0');
			return "0";
		}
		return HALIMHelper::number_format_short($count);
	}
}

function halim_update_view_post()
{
	$update = get_option('halim_view_last_update');
	if ($update !== false) {
		$date = getdate();
		if ($update != $date['mday']) {
			update_option('halim_view_last_update', $date['mday']);
			delete_post_meta_by_key('halim_view_post_day');
			if ($date['wday'] == 1) {
				delete_post_meta_by_key('halim_view_post_week');
			}
			if ($date['mday'] == 1) {
				delete_post_meta_by_key('halim_view_post_mon');
			}
		}
	} else {
		add_option('halim_view_last_update', 0, null, 'no');
	}
}
add_action('init', 'halim_update_view_post', 0);

function halim_set_post_view_count($postid)
{
	halim_update_post_view_count('halim_view_post_all', $postid);
	halim_update_post_view_count('halim_view_post_day', $postid);
	halim_update_post_view_count('halim_view_post_week', $postid);
	halim_update_post_view_count('halim_view_post_mon', $postid);
}

if(!function_exists('halim_update_post_view_count'))
{
	function halim_update_post_view_count($count_key, $postID)
	{
		$count = get_post_meta($postID, $count_key, true);
		if ($count == '') {
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		} else {
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}
}



function halim_pagination()
{
	if(paginate_links()!='') {
		global $wp_query;
		$big = 999999999;
		echo '<div class="text-center">';
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'type'         => 'list',
			'prev_text'    => __('<i class="hl-down-open rotate-left"></i>'),
			'next_text'    => __('<i class="hl-down-open rotate-right"></i>'),
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages
		) );
		echo '</div>';
	}
}


function halim_string_limit_word($string, $word_limit)
{
	$words = explode(' ', $string, ($word_limit + 1));
	if (count($words) > $word_limit) {
		array_pop($words);
	}
	return implode(' ', $words);
}


function halim_get_the_excerpt($post_id) {
	global $post;
	$postid = $post_id ? $post_id : $post->ID;
	$save_post = $post;
	$post = get_post($postid);
	$output = get_the_excerpt();
	$post = $save_post;
	return $output;
}
function halim_get_the_excerpt2($post_id) {
	global $post;
	$postid = $post_id ? $post_id : $post->ID;
	$post = get_post($postid);
	return halim_string_limit_word($post->post_content, 160);
}

if(!function_exists('halim_get_user_rate'))
{
	function halim_get_user_rate()
	{
		global $post, $current_user;
		$rate = get_post_meta( $post->ID , 'halim_user_rate', true );
		$count = get_post_meta( $post->ID , 'halim_users_num', true );
		if( !empty($rate) && !empty($count)){
			$total = (($rate/$count)/5)*100;
			$totla_users_score = round($rate/$count,2);
		}else{
			$totla_users_score = $total = $count = 0;
		}
	    $desc = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
	    $description = $desc != '' ? $desc : halim_string_limit_word(halim_get_the_excerpt($post->ID), 150);

	    ?>
		<?php
	}
}

if(!function_exists('halimReviewRating'))
{
	function halimReviewRating()
	{
		global $wp, $post, $current_user;

		if(!$post) return;

		$rate = get_post_meta( $post->ID , 'halim_user_rate', true );
		$rating_count = get_post_meta( $post->ID , 'halim_users_num', true );
		if( !empty($rate) && !empty($rating_count)){
			$total = (($rate/$rating_count)/5) * 100;
			$total_vote = round($rate/$rating_count, 2);
		}else{
			$total_vote = $total = $rating_count = 0;
		}
		if($total_vote == 0) $total_vote = 5;
		if($rating_count == 0) $rating_count = 3;
		$post_slug       = basename(get_permalink($post->ID));
		$type_slug       = cs_get_option('halim_url_type');
		$watch_slug      = cs_get_option('halim_watch_url');
		$episode_slug    = cs_get_option('halim_episode_url');
		$server_slug     = cs_get_option('halim_server_url');
		$single_tpl      = cs_get_option('single_template');
	    $link = $single_tpl !== NULL ? home_url('/').$watch_slug.'/'.$post_slug : home_url('/').$post_slug;
	    $logo = wp_get_attachment_image_src(cs_get_option('site_logo'), 'full')[0] ?: HALIM_THEME_URI .'/assets/images/halim-dark-logo.png';
	    $directors = has_term('', 'director') ? get_the_terms($post->ID, 'director')[0]->name : 'HaLim';

	    $json_data = array(
			  '@context' => 'http://schema.org',
			  '@type' => HALIMHelper::is_type('tv_series') ? 'TVSeries' : 'Movie',
			  'name' => halim_filter_movie_wpseo_title($post->post_title),
			  'dateModified' => get_the_modified_time('c'),
			  'dateCreated' => get_the_date('c'),
			  'url' => home_url($wp->request),
			  'datePublished' => get_the_date('c'),
			  'aggregateRating' => array(
			    '@type' => 'AggregateRating',
			    'bestRating' => '5',
			    'worstRating' => '2',
			    'ratingValue' => ceil($total_vote),
			    'reviewCount' => $rating_count,
			  ),
			  'image' => halim_image_display(),
			  'director' => $directors,
		);
	?>

		<script type="application/ld+json"><?php echo json_encode($json_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>
		<?php
	}

}
add_action('wp_head', 'halimReviewRating');


function yoastVariableToTitle($post_id) {
    $yoast_title = get_post_meta($post_id, '_yoast_wpseo_title', true);
    $title = strstr($yoast_title, '%%', true);
    if (empty($title)) {
        $title = get_the_title($post_id);
    }
    return $title;
}

if(!function_exists('halim_image_display'))
{
	function halim_image_display($size = 'movie-thumb')
	{
		global $post;
		if(!$post) {
			return;
		}
		$thumb = '';
		if($post->post_type == 'video') {
			$meta_data = get_post_meta($post->ID, '_videos_metabox_options', true );
			if(isset($meta_data) && $meta_data != '') {
				$thumb = $meta_data['video_thumbnail_url'];
			}
		}
		else {
			$meta_data = get_post_meta($post->ID, '_halim_metabox_options', true );
			if(isset($meta_data) && $meta_data != '') {
				$thumb = $meta_data['halim_thumb_url'];
			}
		}

		if ( has_post_thumbnail() ) {
			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id, $size);
			$image_url = $image_url[0];
		} elseif($thumb != '') {
			$image_url = $thumb;
		} else {
			$image_url = '';
			ob_start();
			ob_end_clean();
			preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
			if(isset($matches[1][0])) $image_url = $matches[1][0];
			if(empty($image_url)){
				$img = $post->post_type == 'video' || $post->post_type == 'news' ? 'default.png' : 'default-poster.jpg';
				$image_url = HALIM_THEME_URI."/assets/images/".$img;
			}
		}
		return esc_url($image_url);
	}
}


if(!function_exists('halim_get_first_image'))
{
	function halim_get_first_image() {
		global $post;
		$image_url = '';
		ob_start();
		ob_end_clean();
		preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if(isset($matches[1][0])) $image_url = $matches[1][0];
		if(empty($image_url)){
			$image_url = "https://i.imgur.com/UCpq7GW.png";
		}
		return $image_url;
	}
}

function halim_switch_to_relative_url($html, $id, $caption, $title, $align, $url, $size, $alt)
{
	$imageurl = wp_get_attachment_image_src($id, $size);
	$relativeurl = wp_make_link_relative($imageurl[0]);
	$html = str_replace($imageurl[0], $relativeurl, $html);

	return $html;
}
add_filter('image_send_to_editor','halim_switch_to_relative_url', 10, 8);


function halim_make_url_relative($url) {
	$relativeurl = wp_make_link_relative($url);
	return $relativeurl;
};
add_filter('wp_get_attachment_url', 'halim_make_url_relative');
