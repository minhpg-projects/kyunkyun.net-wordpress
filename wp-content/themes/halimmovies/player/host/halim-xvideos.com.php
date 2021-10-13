<?php

class halim_xvideos_com extends HALIM_GetLink
{
	public function get_link($link)
	{
		$html = $this->getXvideos($link);

		$sd = $this->getStr($html, "setVideoUrlLow('", "');");
		$hd = $this->getStr($html, "setVideoUrlHigh('", "');");
		$hls = $this->getStr($html, "setVideoHLS('", "');");

		if($hls) {
			$sources[] = [
				'file' => $hls,
				'type' => 'hls'
			];
		}
		else
		{
			$sources[] = [
				'file' => $sd,
				'type' => 'video/mp4',
				'label' => 'SD'
			];
			if($hd)
			{
				$sources[] = [
					'file' => $hd,
					'type' => 'video/mp4',
					'label' => 'HD'
				];
			}
		}

		return json_encode($sources);
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


	function getXvideos($service_url)
	{
	    $handle = curl_init($service_url);
	    curl_setopt_array($handle, array(
	        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36',
	        CURLOPT_ENCODING => 'utf8',
	        CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HTTPHEADER => array(),
			CURLOPT_COOKIEFILE => plugin_dir_path(__FILE__).'/xvideo-cookie.txt',
	        CURLOPT_SSL_VERIFYPEER => 0,
	        CURLOPT_FOLLOWLOCATION => 1,
	       	CURLOPT_REFERER => 'https://xvideos.com'
	    ));
	    $curl_response = curl_exec($handle);
	    curl_close($handle);
	    return $curl_response;
	}
}