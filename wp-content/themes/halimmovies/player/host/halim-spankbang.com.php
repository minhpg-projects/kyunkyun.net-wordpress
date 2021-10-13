<?php

class halim_spankbang_com extends HALIM_GetLink
{
	public function get_link($link)
	{
		$html = $this->get($link);

		$stream_key = $this->getStr($html, 'data-streamkey="', '"');

		$getStream = $this->post($stream_key);

		$sources = json_decode($getStream, true)['m3u8'];

		$randSource = array_rand($sources);

		$api[] = [
			'file' => $sources[$randSource],
			'type' => 'hls'
		];

		return json_encode($api);
	}

	function post($stream_key)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://spankbang.com/api/videos/stream",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_REFERER => 'https://spankbang.com',
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "id=$stream_key&data=0",
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/x-www-form-urlencoded"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}

	function get($service_url)
	{
	    $handle = curl_init($service_url);
	    curl_setopt_array($handle, array(
	        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36',
	        CURLOPT_ENCODING => 'utf8',
	        CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HTTPHEADER => array(),
			CURLOPT_COOKIEFILE => plugin_dir_path(__FILE__).'/spankbang-cookie.txt',
	        CURLOPT_SSL_VERIFYPEER => 0,
	        CURLOPT_FOLLOWLOCATION => 1,
	       	CURLOPT_REFERER => 'https://spankbang.com'
	    ));
	    $curl_response = curl_exec($handle);
	    curl_close($handle);
	    return $curl_response;
	}

	public function getStr($source, $start, $end='', $html = false)
	{
		if(!$start) {
			$str = explode($end, $source);
			return $html == true ? $str[0] : trim(strip_tags($str[0]));
		} else {
			$str = explode($start, $source);
			if($end){
				$str = explode($end, $str[1]);
				return $html == true ? $str[0] : trim(strip_tags($str[0]));
			} else {
				return $html == true ? $str[0] : trim(strip_tags($str[1]));
			}
		}
	}


}
