<?php
class halim_default extends HALIM_GetLink
{
	public function get_link($link)
	{
		$json[] = array(
			'file' => $link,
			'type' => 'video/mp4'
		);
		return json_encode($json);
	}
}