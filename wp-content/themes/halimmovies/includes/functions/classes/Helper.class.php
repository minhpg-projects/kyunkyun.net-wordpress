<?php

class HALIMHelper
{

	public static function compress_htmlcode($codedata)
	{
		$searchdata = array(
		'/\>[^\S ]+/s', // remove whitespaces after tags
		'/[^\S ]+\</s', // remove whitespaces before tags
		'/(\s)+/s' // remove multiple whitespace sequences
		);
		$replacedata = array('>','<','\\1');
		$codedata = preg_replace($searchdata, $replacedata, $codedata);
		return $codedata;
	}

	public static function removeWhiteSpace($text)
    {
        $text = preg_replace('/[\t\n\r\0\x0B]/', '', $text);
        $text = preg_replace('/([\s])\1+/', ' ', $text);
        $text = trim($text);
        return $text;
    }

	public static function set_post_modified($post_id) {
	    $post = array(
	        'ID' => $post_id,
	        'post_modified_gmt' => date( 'Y:m:d H:i:s' )
	    );
	    wp_update_post( $post );
	}

	public static function get_eps_arr($ep_start, $ep_end)
	{
		$arr = [];
	    $i = $ep_start;
	    for ($i; $i <= $ep_end; $i++){
	        $arr[] = $i;
	    }
	    return $arr;
	}

    public static function array_key_last($array)
    {
	    // For PHP >= 7.3
	    // if ($key === array_key_first($array))
	    //     echo 'FIRST ELEMENT!';

	    // if ($key === array_key_last($array))
	    //     echo 'LAST ELEMENT!';

    	//For PHP <= 7.3
        if (!is_array($array) || empty($array)) {
            return NULL;
        }

        return array_keys($array)[count($array)-1];
    }

	public static function matchRegex($strContent, $strRegex, $intIndex = NULL)
	{
		$arrMatches = FALSE;
		preg_match_all($strRegex, $strContent, $arrMatches);
		if ($arrMatches === FALSE)
			return FALSE;
		if ($intIndex != NULL && is_int($intIndex)) {
			if ($arrMatches[$intIndex]) {
				return $arrMatches[$intIndex][0];
			}
			return FALSE;
		}
		return $arrMatches;
	}

	public static function find_youtube_trailer_url($key)
	{
		$YouTubeURL = "https://www.youtube.com/results?search_query=".urldecode($key);
		$YouTubeHTML = HALIMHelper::cURL($YouTubeURL);
		$trailer_id = HALIMHelper::matchRegex($YouTubeHTML, '~href="/watch\?v=(.*)"~Uis', 1);
		$trailer = "https://www.youtube.com/watch?v=$trailer_id";
		return $trailer;
	}

	public static function strposArr($string, $arr, $offset=0)
	{
	  	if(!is_array($arr)) $arr = array($arr);
	  	foreach($arr as $query) {
	      	if(strpos($string, $query, $offset) !== false) return true; // stop on first true result
	  	}
	  	return false;
	}

	public static function is_type($type, $postid = '')
	{
		global $post;
		$post_id = $postid != '' ? $postid : $post->ID;
		$meta = get_post_meta($post_id, '_halim_metabox_options', true);
		if(isset($meta['halim_movie_formality']) && $meta['halim_movie_formality'] == $type) {
			return true;
		}
		return false;
	}

	public static function is_status($status, $postid = '')
	{
		global $post;
		if(!$post) return;
		$post_id = $postid != '' ? $postid : $post->ID;
		$meta = get_post_meta($post_id, '_halim_metabox_options', true);
		if(isset($meta['halim_movie_status']) && $meta['halim_movie_status'] == $status) {
			return true;
		}
		return false;
	}


	public static function halim_get_meta_values( $key = '', $type = 'post', $status = 'publish' )
	{
	    global $wpdb;
	    if( empty( $key ) )
	        return;
	    $r = $wpdb->get_results( $wpdb->prepare( "
	        SELECT p.ID, pm.meta_value FROM {$wpdb->postmeta} pm
	        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
	        WHERE pm.meta_key = '%s'
	        AND p.post_status = '%s'
	        AND p.post_type = '%s'
	    ", $key, $status, $type ));
	    foreach ( $r as $my_r )
	        $metas[$my_r->ID] = $my_r->meta_value;

	    return $metas;
	}

	public static function number_format_short( $n, $precision = 1 )
	{
		// Converts a number into a short version, eg: 1000 -> 1k
		// Based on: http://stackoverflow.com/a/4371114
		if ($n < 900) { // 0 - 900
			$n_format = number_format($n, $precision);
			$suffix = '';
		} else if ($n < 900000) { // 0.9k-850k
			$n_format = number_format($n / 1000, $precision);
			$suffix = 'K';
		} else if ($n < 900000000) { // 0.9m-850m
			$n_format = number_format($n / 1000000, $precision);
			$suffix = 'M';
		} else if ($n < 900000000000) { // 0.9b-850b
			$n_format = number_format($n / 1000000000, $precision);
			$suffix = 'B';
		} else { // 0.9t+
			$n_format = number_format($n / 1000000000000, $precision);
			$suffix = 'T';
		}
		if ( $precision > 0 ) {
			$dotzero = '.' . str_repeat( '0', $precision );
			$n_format = str_replace( $dotzero, '', $n_format );
		}
		return $n_format . $suffix;
	}

	public static function halim_string_limit_word($string, $word_limit){
	    $words = explode(' ', $string, ($word_limit + 1));
	    if (count($words) > $word_limit) {
	        array_pop($words);
	    }
	    return implode(' ', $words);
	}

	public static function getDriveId($url) {
		preg_match('/[-\w]{25,}/is', $url, $id);
		return $id[0];
	}

	public static function getDailyMotionId($url)
	{
        preg_match('/dailymotion\.com\/(.*?)video\/(.*)/is', $url, $matches);
        return $matches[2];
	}

	public static function getVimeoId($url)
	{
		$regex = '~
			# Match Vimeo link and embed code
			(?:<iframe [^>]*src=")?         # If iframe match up to first quote of src
			(?:                             # Group vimeo url
					https?:\/\/             # Either http or https
					(?:[\w]+\.)*            # Optional subdomains
					vimeo\.com              # Match vimeo.com
					(?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
					\/                      # Slash before Id
					([0-9]+)                # $1: VIDEO_ID is numeric
					[^\s]*                  # Not a space
			)                               # End group
			"?                              # Match end quote if part of src
			(?:[^>]*></iframe>)?            # Match the end of the iframe
			(?:<p>.*</p>)?                  # Match any title information stuff
			~ix';

		preg_match( $regex, $url, $matches );

		return $matches[1];

	}

	public static function getYoutubeId($url)
	{
		$regex = '~
		# Match Youtube link and embed code
		(?:				 # Group to match embed codes
		   (?:<iframe [^>]*src=")?	 # If iframe match up to first quote of src
		   |(?:				 # Group to match if older embed
		      (?:<object .*>)?		 # Match opening Object tag
		      (?:<param .*</param>)*     # Match all param tags
		      (?:<embed [^>]*src=")?     # Match embed tag to the first quote of src
		   )?				 # End older embed code group
		)?				 # End embed code groups
		(?:				 # Group youtube url
		   https?:\/\/		         # Either http or https
		   (?:[\w]+\.)*		         # Optional subdomains
		   (?:               	         # Group host alternatives.
		       youtu\.be/      	         # Either youtu.be,
		       | youtube\.com		 # or youtube.com
		       | youtube-nocookie\.com	 # or youtube-nocookie.com
		   )				 # End Host Group
		   (?:\S*[^\w\-\s])?       	 # Extra stuff up to VIDEO_ID
		   ([\w\-]{11})		         # $1: VIDEO_ID is numeric
		   [^\s]*			 # Not a space
		)				 # End group
		"?				 # Match end quote if part of src
		(?:[^>]*>)?			 # Match any extra stuff up to close brace
		(?:				 # Group to match last embed code
		   </iframe>		         # Match the end of the iframe
		   |</embed></object>	         # or Match the end of the older embed
		)?				 # End Group of last bit of embed code
		~ix';

		preg_match( $regex, $url, $matches );

		return $matches[1];
	}

	public static function getVideoThumbnailByUrl($url, $format = 'small')
	{
		if(strpos($url, 'youtube'))
		{
			$id = HALIMHelper::getYoutubeId($url);
	        if ('medium' === $format) {
	            return 'https://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
	        }
	        return 'https://img.youtube.com/vi/' . $id . '/default.jpg';

		}
		elseif(strpos($url, 'vimeo'))
		{
			$id = HALIMHelper::getVimeoId($url);
	        $hash = unserialize(HALIMHelper::cURL("http://vimeo.com/api/v2/video/$id.php"));
	        /**
	         * thumbnail_small
	         * thumbnail_medium
	         * thumbnail_large
	         */
	        return $hash[0]['thumbnail_large'];

		}
		elseif(strpos($url, 'dailymotion'))
		{
			$url = str_replace('?autoPlay=1', '/', $url);
			return 'https:'.str_replace('embed', 'thumbnail', $url);
		}
	    return false;
	}

	public static function getVideoLocation($url)
	{
		if(strpos($url, 'youtube')) {
			$id = HALIMHelper::getYoutubeId($url);
			return 'https://www.youtube.com/embed/' . $id;
		} elseif(strpos($url, 'vimeo')) {
			$id = HALIMHelper::getVimeoId($url);
			return 'https://player.vimeo.com/video/' . $id;
		} elseif(strpos($url, 'dailymotion')) {
			$id = HALIMHelper::getDailyMotionId($url);
			return 'https://www.dailymotion.com/embed/video/' . $id;
		}
	    return false;
	}

	public static function cURL($url)
	{
		$ch = @curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		$head[] = "Connection: keep-alive";
		$head[] = "Keep-Alive: 300";
		$head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		$head[] = "Accept-Language: en-us,en;q=0.5";
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.0 Mobile/14E304 Safari/602.1');
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
		// curl_setopt($ch, CURLOPT_REFERER, HOST_NAME);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$page = curl_exec($ch);
		curl_close($ch);
		return $page;
	}
	public static function get_ip() {
		if ( function_exists( 'apache_request_headers' ) ) {
			$headers = apache_request_headers();
		} else {
			$headers = $_SERVER;
		}
		if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			$the_ip = $headers['X-Forwarded-For'];
		} elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
		) {
			$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
		} else {
			$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
		}
		return $the_ip;
	}
}

class Pagination {

    private $config = [
        'total' => 0,
        'limit' => 0,
        'page' => 1,
        'link' => 5,
        'type' => ''
    ];

    public function __construct($config = [])
    {
        $this->config = $config;
    }

	public function getAjaxPage() {
	    if ($this->config['limit'] == 'all') {
	        return '';
	    }

	    $last = ceil($this->config['total'] / $this->config['limit']);

	    $start = (($this->config['page'] - $this->config['link']) > 0) ? $this->config['page'] - $this->config['link'] : 1;
	    $end = (($this->config['page'] + $this->config['link']) < $last) ? $this->config['page'] + $this->config['link'] : $last;

	    $html = '<ul class="pagination '.$this->config['type'].'">';

	    $class = ($this->config['page'] == 1) ? "disabled" : "";
	    $html .= '<li class="' . $class . '"><a href="javascript:;" data-page="'.($this->config['page'] - 1).'" title="Page '.($this->config['page'] - 1).'">&laquo; Prev</a></li>';

	    if ($start > 1) {
	        $html .= '<li><a href="javascript:;" data-page="1">1</a></li>';
	        $html .= '<li class="disabled"><span>...</span></li>';
	    }

	    for ($i = $start ; $i <= $end; $i++) {
	        $class = ($this->config['page'] == $i) ? "active" : "";
	        $html .= '<li class="' . $class . '"><a href="javascript:;" data-page="'.$i.'">'.$i.'</a></li>';
	    }

	    if ($end < $last) {
	        $html .= '<li class="disabled"><span>...</span></li>';
	        $html .= '<li><a href="javascript:;" data-page="'.$last.'">'.$last.'</a></li>';
	    }

	    $class = ($this->config['page'] == $last) ? "disabled" : "";
	    $html .= '<li class="'.$class.'"><a href="javascript:;" data-page="'.($this->config['page'] + 1).'" title="Page '.($this->config['page'] + 1).'">Next &raquo;</a></li>';

	    $html .= '</ul>';

	    return $html;
	}

}