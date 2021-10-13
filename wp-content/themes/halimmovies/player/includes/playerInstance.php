<?php


if(!function_exists('halimBuildPlayer'))
{
    function halimBuildPlayer($post_id, $sources = null, $tracks = array(), $link = '')
    {
        ob_start();
        $cache_time         = cs_get_option('player_cache_time');
        $player_ad_cfg      = cs_get_option('halim_jw_player_ads');
        $player_cfg         = cs_get_option('halim_jw_player_options');
        $detect_adblock     = cs_get_option('detect_adblock');
        $adblock_msg        = cs_get_option('adblock_msg') ? cs_get_option('adblock_msg') : '<p style="padding-top:15px;"><h2>Sorry!</h2> Users please remove ad blocker!</p>';
        $floating_player    = cs_get_option('floating_player');
        $meta               = get_post_meta($post_id, '_halim_metabox_options', true );
        $player_logo        = isset($player_cfg['jw_player_logo']) ? $player_cfg['jw_player_logo'] : '';
        $player_logo_hide   = isset($player_cfg['jw_player_logo_hide']) && $player_cfg['jw_player_logo_hide'] == 1 ? "true" : "false";
        $logo_position      = isset($player_cfg['jw_player_logo_position']) ? $player_cfg['jw_player_logo_position'] : '';
        $player_logo_link   = isset($player_cfg['jw_player_logo_link']) ? $player_cfg['jw_player_logo_link'] : 'https://kyunkyun.net';
        $captions_color     = isset($player_cfg['jw_tracks_color']) && $player_cfg['jw_tracks_color'] ? $player_cfg['jw_tracks_color'] : '#eeee22';
        $captions_font_size = isset($player_cfg['jw_tracks_font_size']) && $player_cfg['jw_tracks_font_size'] ? $player_cfg['jw_tracks_font_size'] : 12;
        $jwplayer_key       = isset($player_cfg['jw_player_license_key']) && $player_cfg['jw_player_license_key'] ?
        $player_cfg['jw_player_license_key'] : 'W7zSm81+mmIsg7F+fyHRKhF3ggLkTqtGMhvI92kbqf/ysE99';
        $player_sharing     = isset($player_cfg['jw_player_sharing_block']) ? $player_cfg['jw_player_sharing_block'] : '';
        $autoplay           = isset($player_cfg['jw_player_autoplay']) && $player_cfg['jw_player_autoplay'] == true ? 'true' : 'false';
        $autopause           = isset($player_cfg['jw_player_autopause']) && $player_cfg['jw_player_autopause'] == true ? 'true' : 'false';
        $poster             = isset($meta['halim_poster_url']) && $meta['halim_poster_url'] ? $meta['halim_poster_url'] : '';
        $jw_adcode          = isset($player_ad_cfg['jw_player_show_ad']) && $player_ad_cfg['jw_player_custom_ads_code'] ? $player_ad_cfg['jw_player_custom_ads_code'] : '';
        $sources            = $sources == '[]' || $sources == '' || $sources == 'null' || !json_decode($sources)[0]->file ? '[{ file: "//content.jwplatform.com/videos/not-a-real-video-file.mp4", label: "720p", type: "video/mp4"}]' : $sources;
        ?>
            <script>
                var resumeId = encodeURI('<?php echo md5($sources); ?>'),
                    playerInstance = jwplayer('ajax-player');
                if(typeof playerInstance != 'undefined'){
                    playerInstance.setup({
                        key: "W7zSm81+mmIsg7F+fyHRKhF3ggLkTqtGMhvI92kbqf/ysE99",
                        primary: "html5",
                        playlist: [{
                            image: "<?php echo $poster; ?>",
                            sources: <?php echo $sources; ?>,
                            tracks: <?php echo $tracks; ?>,
                            captions: {
                                color: "<?php echo $captions_color; ?>",
                                fontSize: <?php echo $captions_font_size; ?>,
                                backgroundOpacity: 0,
                                edgeStyle: "raised"
                            }
                        }],
                        <?php if($player_logo) : ?>
                        logo: {
                            file: "<?php echo $player_logo; ?>",
                            link: "<?php echo $player_logo_link; ?>",
                            hide: "<?php echo $player_logo_hide; ?>",
                            target: "_blank",
                            position: "<?php echo $logo_position; ?>",
                        },
                        <?php endif; ?>
                        <?php if($floating_player) : ?>
                        floating: {
                            dismissible: true
                        },
                        <?php endif; ?>
                        <?php if($autopause) : ?>
                        autoPause: {
                            viewability: true,
                            pauseAds: true
                        },
                        <?php endif; ?>
                        base: ".",
                        width: "100%",
                        height: "100%",
                        hlshtml: true,
                        autostart: <?php echo $autoplay; ?>,
                        fullscreen: true,
                        playbackRateControls: true,
                        aspectratio: "16:9",
                        <?php if($player_sharing == true) : ?>
                        sharing: {
                            sites: ["reddit","facebook","twitter","googleplus","email","linkedin"]
                        },
                        <?php endif; ?>
                        <?php echo $jw_adcode; ?>
                    });
                    // if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                    //     var engine = new p2pml.hlsjs.Engine();
                    //     jwplayer_hls_provider.attach();
                    //     p2pml.hlsjs.initJwPlayer(playerInstance, {
                    //         liveSyncDurationCount: 7, // To have at least 7 segments in queue
                    //         loader: engine.createLoaderClass(),
                    //     });
                    // }
                    halimResumeVideo(resumeId, playerInstance);
                    halimJwConfig(playerInstance);
                    <?php if($detect_adblock) : ?>
                        playerInstance.on('adBlock', function(){
                            playerInstance.pause();
                            jQuery("#halim-player-loader").show().html('<?php echo HALIMHelper::compress_htmlcode($adblock_msg); ?>');
                        });
                    <?php endif; ?>
                }
            </script>
        <?php

        do_action('halim_player_instance', (object)['post_id' => $post_id, 'link' => $link]);

        $html = ob_get_clean();
        echo $html;
    }
}

if(!function_exists('halimBuildPlayerShotcode'))
{
    function halimBuildPlayerShotcode($attr)
    {
        $args = shortcode_atts(array(
                'link' => '#',
                'post_id' => get_the_ID(),
                'sources' => '',
                'tracks' => '[]'

            ), $attr);

        halimBuildPlayer($args['post_id'], base64_decode($args['sources']), $args['tracks'], $args['link']);
    }
    add_shortcode( 'halimPlayer', 'halimBuildPlayerShotcode' );
}
