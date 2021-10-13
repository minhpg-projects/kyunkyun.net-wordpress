<?php

define('HALIM_PATH', plugin_dir_path(__FILE__));
define('PLUGIN_URL', plugins_url('', __FILE__));

require_once HALIM_PATH . 'includes/youtube.class.php';
require_once HALIM_PATH . 'includes/getlink.class.php';
require_once HALIM_PATH . 'includes/playerFunctions.php';
require_once HALIM_PATH . 'includes/playerInstance.php';

if(is_admin()){
    add_action('admin_init', 'halim_register_settings');
    add_action('admin_menu', 'halim_add_setting_item');
}

function halim_register_settings() {
    register_setting('halim-player-settings', 'halim_fb_token');
    register_setting('halim-player-settings', 'halim_zing_cookie');
}

function halim_add_setting_item(){
    add_options_page("Tv.Zing.Vn Cookie", "Tv.Zing.Vn Cookie", 'manage_options', 'halim-zing-cookie', 'halim_setting_page');
    add_options_page("Manage player cache", "Manage player cache", 'manage_options', 'halim-cache-manager', 'halim_cache_manage_page');
}

function halim_player_plugin_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=halim_options') ) .'">'.__('Settings').'</a>';
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=halim-zing-cookie') ) .'">'.__('Tv.Zing.Vn Cookie').'</a>';
   $links[] = '<a href="https://halimthemes.com" target="_blank" style="color: #3db634">More plugins by HaLimThemes</a>';
   return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'halim_player_plugin_action_links' );


function halim_player_enqueue_scripts()
{
    $themeinfo = wp_get_theme('halimmovies');
    $player_cfg = HaLimCore_Abstract::cs_get_option('halim_jw_player_options');
    if(is_single()) {
        if(isset($player_cfg['jw_player_library']) && $player_cfg['jw_player_library'] != ''){
            wp_enqueue_script( 'halim-jwplayer', $player_cfg['jw_player_library'], array(), '', true );
        } else {
            wp_enqueue_script( 'halim-jwplayer', HALIM_THEME_URI.'/player/assets/js/jwplayer/jwplayer.js', array(), '', true );
            // wp_enqueue_script( 'jwplayer-hls-js', HALIM_THEME_URI.'/player/assets/js/jwplayer.hlsjs.min.js', array(), '', true );
            // wp_enqueue_script( 'hls-js', HALIM_THEME_URI.'/player/assets/js/hls.js', array(), '', true );
            // wp_enqueue_script( 'p2p-core', HALIM_THEME_URI.'/player/assets/js/p2p-media-loader-core.min.js', array(), '', true );
            // wp_enqueue_script( 'p2p-loader', HALIM_THEME_URI.'/player/assets/js/p2p-media-loader-hlsjs.min.js', array(), '', true );
        }

        if(!is_singular(array('news', 'video'))) {
            wp_enqueue_script( 'halim-ajax',  HALIM_THEME_URI.'/player/assets/js/player.min.js', array(), time(), true );
            wp_localize_script('halim-ajax', 'ajax_player', array(
                'url'   => HALIM_THEME_URI.'/halim-ajax.php',
                'nonce' => wp_create_nonce('halim-player-nonce'),
            ));
        }
    }
}
add_action('wp_enqueue_scripts', 'halim_player_enqueue_scripts');

function halim_setting_page(){ ?>
    <div class="wrap halim-wrap">
        <h1>Cookie manage</h1>
        <form method="post" action="options.php">
            <input type="hidden" name="option_page" value="halim_setting_page"/>
            <input type="hidden" name="action" value="update" />
            <?php
                settings_fields('halim-player-settings');
                $zing_cookie      = get_option('halim_zing_cookie');
            ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label>Tv.Zing.Vn Cookie</label></th>
                        <td>
                            <textarea name="halim_zing_cookie" rows="15" placeholder="Tv.Zing.Vn Cookie" class="regular-text" style="width: 100%"><?php echo $zing_cookie; ?></textarea>
                            <p>
                                <span>Using this extension to get cookie </span><a href="https://chrome.google.com/webstore/detail/cookiestxt/njabckikapfpffapmjgojcnbfjonfjfg">https://chrome.google.com/webstore/detail/cookiestxt/njabckikapfpffapmjgojcnbfjonfjfg</a>
                            </p>

                        </td>
                    </tr>
                </table>
            <?php submit_button(); ?>
        </form>
        <p><strong style="font-size: 20px;">Example:</strong></p>
        <p>
            <img src="https://i.imgur.com/WeJoC44.png">
        </p>
    </div>
    <?php
}

function halim_cache_manage_page(){ ?>
    <div class="wrap halim-wrap">
        <h1>Cache Manager</h1>
        <div class="halim-cache-box">
            <?php
                // $cache_folder = ABSPATH . '/wp-content/film_cache';
                $cache = new Cache(HALIM_CACHE_PART);

                $cache_count = json_decode($cache->cacheCount());
                if($cache_count->result == 1)
                    echo '<span class="cache-count" style="color: red;">Total cache: '.$cache_count->total_cache.'</span>';

                $get_cache = json_decode($cache->getCache());
                echo '<ul class="list-cache" style="
                    max-height: 300px;
                    overflow-x: hidden;
                    border: 1px solid;
                    padding: 15px;
                ">';
                if($get_cache) {

                    foreach ($get_cache as $key => $value) {
                        echo  '<li>'.$value->file.'</li>';
                    }
                }
                else
                {
                    echo '<li>Cache empty!</li>';
                }
                echo '</ul>';
                ?>
            <div id="delete-all-cache" class="button button-primary">Delete all cache</div>
            <div id="result"></div>
            <script>
                jQuery(document).ready(function($){
                    jQuery('#delete-all-cache').click(function($){
                        var confirmation = confirm("Are you sure you want to remove all cache?");
                        if (confirmation) {
                            jQuery.ajax({
                                type: 'POST',
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: {
                                    action: 'delete_all_cache'
                                },
                                success: function(data){
                                    jQuery('#result').html(data);
                                    jQuery('.list-cache').html('<li>Cache empty!</li>');
                                    jQuery('.cache-count').html('Total cache: 0');
                                }
                            });
                        }
                    })
                })

            </script>
        </div>
    </div>
    <?php
}



function delete_all_cache()
{
    $cache = new Cache(HALIM_CACHE_PART);
    $result = json_decode($cache->delAllCache(0), true);
    ?>
        <ul class="delete-cache">
            <li><span>Status: </span><?php echo $result['status'] == 1 ? 'Successfuly' : 'Error!'; ?></li>
            <li><span>Total cache: </span><?php echo $result['total_cache']; ?></li>
            <li><span>Cache time: </span><?php echo $result['time_limit']; ?></li>
            <li><span>Cache deleted: </span><?php echo $result['cache_deleted']; ?></li>
        </ul>

    <?php
    wp_die();
}
add_action('wp_ajax_delete_all_cache', 'delete_all_cache');
add_action('wp_ajax_nopriv_delete_all_cache', 'delete_all_cache');


function reset_player_cache()
{
    $server = isset($_POST['server_id']) ? (int)$_POST['server_id'] : '';
    $post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : '';
    $episode_slug = isset($_POST['episode_slug']) ? str_replace('-', '_', wp_strip_all_tags($_POST['episode_slug'])) : '';
    $film_meta = get_post_meta($post_id, '_halimmovies', true);
    $data = json_decode($film_meta, true);
    $link = $data[($server-1)]['halimmovies_server_data'][$episode_slug]['halimmovies_ep_link'];
    $cache = new Cache(HALIM_CACHE_PART);
    $cacheData = $cache->delCache($link);
    wp_send_json($cacheData);

}
add_action('wp_ajax_reset_player_cache', 'reset_player_cache');
add_action('wp_ajax_nopriv_reset_player_cache', 'reset_player_cache');

