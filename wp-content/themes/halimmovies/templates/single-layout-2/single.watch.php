<?php

    $episode         = get_query_var('halim_episode');
    $server          = get_query_var('halim_server');
    $episode_display = cs_get_option('halim_episode_display');
    $meta            = get_post_meta($post->ID, '_halim_metabox_options', true );
    $is_copyright    = isset($meta['is_copyright']) ? $meta['is_copyright'] : '';
    $is_adult        = isset($meta['is_adult']) ? $meta['is_adult'] : '';
    $player_options  = cs_get_option('halim_jw_player_options');
    $player_autonext = isset($player_options['jw_player_autonext']) ? $player_options['jw_player_autonext'] : false;
    $check           = isset($meta['halim_movie_status']) ? $meta['halim_movie_status'] : '';
    $time            = explode(' ', esc_html($post->post_date));
    $date            = $time[0];
    $episode_slug = get_query_var('episode_slug') ? wp_strip_all_tags(get_query_var('episode_slug')) : '';
    if (have_posts()): while (have_posts()): the_post();
        ?>
        <div class="clearfix"></div>
        <?php dynamic_sidebar('halim-ad-above-player') ?>
        <div class="clearfix"></div>

        <?php if($is_copyright) : ?>
            <div id="is_copyright">
                <p><i class="hl-attention"></i> <?php _e('Copyright infringement!', 'halimthemes'); ?></p>
            </div>
        <?php else: ?>
            <div id="halim-player-wrapper" class="ajax-player-loading" data-adult-content="<?php echo $is_adult; ?>">
                <?php
                    if ( ! post_password_required( $post ) ) {
                    ?>
                        <div id="halim-player-loader"></div>
                        <div id="ajax-player" class="player"></div>
                        <?php
                            if($check == 'is_trailer') echo '<span class="trailer-button">Trailer</span>';
                    } else {
                        echo get_the_password_form();
                    }
                ?>
            </div>

            <div class="clearfix"></div>

            <div class="button-watch">
                <ul class="halim-social-plugin col-xs-4 hidden-xs">
                </ul>
                <ul class="col-xs-12 col-md-8">
                    <?php if($player_autonext == true) : ?>
                        <div id="autonext" class="btn-cs autonext">
                            <i class="icon-autonext-sm"></i>
                            <span><i class="hl-next"></i> <?php _e('Tự động chuyển tập', 'halimthemes') ?>: <span id="autonext-status"><?php _e('On', 'halimthemes') ?></span></span>
                        </div>
                    <?php endif ?>
                    <div id="toggle-light"><i class="hl-adjust"></i>
                        <?php _e('Tắt đèn', 'halimthemes') ?>
                    </div>
                    <div id="report" class="halim-switch"><i class="hl-attention"></i> <?php _e('Báo lỗi', 'halimthemes'); ?></div>
                    <div class="luotxem"><i class="hl-eye"></i>
                        <span><?php echo halim_display_post_view_count($post->ID) ?></span> <?php _e('lượt xem', 'halimthemes') ?>
                    </div>
                </ul>
            </div>

        <?php endif; ?>

        <div class="clearfix"></div>
        <?php dynamic_sidebar('halim-ad-below-player') ?>
        <div class="clearfix">
</div>

        <div class="title-block watch-page">
        <a href="javascript:;" data-toggle="tooltip" title="<?php _e('Thêm vào tủ phim', 'halimthemes'); ?>">
                <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-post_id="<?php echo $post->ID; ?>" data-thumbnail="<?php echo esc_url(halim_image_display()) ?>" data-href="<?php the_permalink(); ?>" data-title="<?php echo $post->post_title; ?>" data-date="<?php echo $date; ?>">
                    <!-- <div class="halim-pulse-ring"></div> -->
                </div>
            </a>
            <div class="title-wrapper full">
                <?php echo '<h1 class="entry-title"><a href="'.get_the_permalink().'" title="'.halim_get_the_title($post->ID).'" class="tl">'.halim_get_the_title($post->ID).'</a></h1>'; ?>

                <span class="plot-collapse" data-toggle="collapse" data-target="#expand-post-content" aria-expanded="false" aria-controls="expand-post-content" data-text="<?php _e('Nội dung', 'halimthemes'); ?>"><i class="hl-angle-down"></i></span>
            </div>

            <div class="ratings_wrapper">
                <?php echo halim_get_user_rate(); ?>
            </div>

        </div>

        <div class="entry-content htmlwrap clearfix collapse <?php echo cs_get_option('post_content_display_watch_page') == 'visible' ? 'in' : ''; ?>" id="expand-post-content">
            <article id="post-<?php echo $post->ID; ?>" class="item-content post-<?php echo $post->ID; ?>">
                <?php the_content(); ?>
            </article>
        </div>
        <div class="clearfix"></div>
        <?php
            if(isEpisodePagenav($meta) || $episode_display == 'show_paging_eps') {
                HaLimCore_Helper::halim_episode_pagination($post->ID, $server, $episode, false);
            } elseif ($episode_display == 'show_tab_eps') {
                HaLimCore_Helper::halim_show_all_eps_table($post->ID, $server, $episode_slug);
            } else {
                HaLimCore_Helper::halim_show_all_eps_list($post->ID, $server, $episode_slug, true);
            }
        ?>
        <div class="clearfix"></div>
        <?php
            endwhile;
    endif;

    if(cs_get_option('enable_fb_comment') == 1) : ?>
        <div class="htmlwrap clearfix">
            <div class="fb-comments"  data-href="<?php the_permalink(); ?>/" data-width="100%" data-mobile="true" data-colorscheme="dark" data-numposts="<?php echo cs_get_option('fb_comment_display'); ?>" data-order-by="<?php echo cs_get_option('fb_comment_order_by'); ?>"></div>
        </div>
    <?php endif;

    if(cs_get_option('enable_disqus_comment') == 1) : ?>

        <div class="htmlwrap clearfix">
            <div id="disqus_thread"></div>
            <script>
                var disqus_shortname = '<?php echo cs_get_option('disqus_shortname'); ?>';
                (function() {
                    var dsq = document.createElement('script'); dsq.async = true;
                    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
            </script>

        </div>
    <?php endif; ?>
    <div id="lightout"></div>

