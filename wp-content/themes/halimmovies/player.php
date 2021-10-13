<?php

header('Content-type: application/json; charset=utf-8');
header('X-Frame-Options: SAMEORIGIN');
// header('Access-Control-Allow-Origin: domain.com, localhost');

$path = dirname( __FILE__ );
$path = substr( $path, 0, strpos( $path, 'wp-content' ) );

/** Load WordPress Bootstrap */
require_once( $path . 'wp-load.php' );

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if($isAjax)
{
	$episode_slug = isset($_GET['episode_slug']) && $_GET['episode_slug']
	? sanitize_text_field(str_replace('-', '_', $_GET['episode_slug'])) : '';
	$post_id = isset($_GET['post_id']) && $_GET['post_id'] ? absint($_GET['post_id']) : '';
	$server = isset($_GET['server_id']) && $_GET['server_id'] ? absint($_GET['server_id']) : '';
	$subsv_id = isset($_GET['subsv_id']) && $_GET['subsv_id'] ? absint($_GET['subsv_id']) : '';

	if($post_id) {
		halimPlayer($post_id, $episode_slug, $server, $subsv_id);
	}
	else {
	    print json_encode(array(
			'status' => true,
			'code' => 403
		));
	}
}
else {
	header("HTTP/1.1 404 Not Found");
}
