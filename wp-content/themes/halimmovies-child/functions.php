
<?php
// Do not remove
add_action( 'wp_enqueue_scripts', 'halim_child_theme_enqueue_styles' );
function halim_child_theme_enqueue_styles() {
    wp_deregister_style('halimmovie-style');
    wp_enqueue_style( 'halimmovie-style', HALIM_THEME_URI . '/style.css', array(), wp_get_theme('halimmovies')->get('Version') );
    wp_enqueue_style( 'halimmovie-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'halimmovie-style' ),
        wp_get_theme('halimmovies')->get('Version')
    );
}

require_once 'custom-player.php';

add_filter( 'halim_custom_player_types', function($data)
{
    $id = HALIMHelper::getDriveId($data->link);
        if($data->episode_type)
        {
            $curl_test = HALIMHelper::cURL("http://95.217.1.3/api/private/drive/get/{$id}?key=Facebook123@");
            $api = json_decode($curl_test);
            if($api->status == "ok")     
                if($api->data->error ==false && $api->data->processing==false){
                    {
                    // $data->player_type = 'custom_api';
                    // $playlist_url = $api->data->playlist;
                    // $source_play[] =  array(
                    //     'file'      => $playlist_url,
                    //     'type'      => 'hls'
                    // );
                    // $data->sources = json_encode($source_play);
                    $data->player_type = 'custom_iframe';
                    $embed_url = $api->data->embed;
                    $data->sources = '<div class="embed-responsive embed-responsive-16by9" style="position:static"><iframe class="embed-responsive-item" src="'.$embed_url.'" allowfullscreen></iframe></div>';  
        
                    return $data;
                }
            }
            $data->player_type = 'custom_iframe';
            $api_key = 'e4ebc346d651c655442b3461ef48d8eb';
            $results = HALIMHelper::cURL('https://api.hydrax.net/'.$api_key.'/drive/'.$id);
            $slug = json_decode($results,true);    
            $embed_url = '//playhydrax.com/?v='.$slug['slug'];
            $data->sources = '<div class="embed-responsive embed-responsive-16by9" style="position:static"><iframe class="embed-responsive-item" src="'.$embed_url.'" allowfullscreen></iframe></div>';
          
    return $data;

        
    }
}, 10, 2);







