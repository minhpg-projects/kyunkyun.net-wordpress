<?php'lượt xem'
    get_header();

    $halim_action  = get_query_var('halim_action');
    $episode_display = cs_get_option('halim_episode_display');
    $meta = get_post_meta($post->ID, '_halim_metabox_options', true );
    $player_options     = cs_get_option('halim_jw_player_options');
    $player_autonext    = isset($player_options['jw_player_autonext']) ? $player_options['jw_player_autonext'] : false;
    $server = get_query_var('halim_server');
    global $first_episode;

    $episode_slug = get_query_var('episode_slug') ? wp_strip_all_tags(get_query_var('episode_slug')) : str_replace('_', '-', $first_episode);

    if (have_posts()): while (have_posts()): the_post();
    ?>
        <div class="clearfix"></div>
        <?php dynamic_sidebar('halim-ad-above-player') ?>
        <div class="clearfix"></div>
        <div id="halim-player-wrapper" class="ajax-player-loading">
            <span class="resume"></span>
            <div id="halim-player-loader"></div>
            <?php
                $check = (isset($meta['halim_movie_status'])) ? $meta['halim_movie_status'] : '';
                if($check == 'trailer') echo '<span class="trailer-button">Trailer</span>';
            ?>
            <div id="ajax-player"></div>
        </div>

        <div class="clearfix"></div>

        <div class="button-watch">
                <ul class="halim-social-plugin col-xs-4 hidden-xs">
                    <li sclass="fb-like" data-href="<?php the_permalink() ?>/" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></li>
                </ul>
                <ul class="col-xs-12 col-md-8">
                    <?php if($player_autonext == true) : ?>
                        <div id="autonext" class="btn-cs autonext">
                            <i class="icon-autonext-sm"></i>
                            <span><i class="hl-next"></i> <?php _e('Tự động chuyển tập', 'halimthemes') ?>: <span id="autonext-status"><?php _e('On', 'halimthemes') ?></span></span>
                        </div>
                    <?php endif ?>
                    <div id="explayer" class="hidden-xs"><i class="hl-resize-full"></i>
                        <?php _e('Phóng to', 'halimthemes') ?>
                    </div>
                    <div id="toggle-light"><i class="hl-adjust"></i>
                        <?php _e('Tắt đèn', 'halimthemes') ?>
                    </div>
                    <div id="report" class="halim-switch"><i class="hl-attention"></i> <?php _e('Báo lỗi', 'halimthemes'); ?></div>
                    <div class="luotxem"><i class="hl-eye"></i>
                        <span><?php echo halim_display_post_view_count($post->ID) ?></span> <?php _e('lượt xem', 'halimthemes') ?>
                    </div>
                    <div class="luotxem visible-xs-inline">
                        <a data-toggle="collapse" href="#moretool" aria-expanded="false" aria-controls="moretool"><i class="hl-forward"></i> <?php _e('Share', 'halimthemes') ?></a>
                    </div>
                </ul>
            </div>

            <div class="collapse" id="moretool">
                <ul class="nav nav-pills x-nav-justified">
                    <div class="fb-save" data-uri="<?php the_permalink() ?>/" data-size="small"></div>
                </ul>
            </div>

        <div class="clearfix"></div>
        <?php dynamic_sidebar('halim-ad-below-player') ?>
        <div class="clearfix"></div>

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
                <?php echo halim_get_user_rate() ?>
            </div>

        </div>

        <div class="entry-content htmlwrap clearfix collapse" id="expand-post-content">
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
    if(cs_get_option('single_notice')) : ?>
        <div class="halim--notice">
            <p><?php echo cs_get_option('single_notice'); ?></p>
        </div>
    <?php
        endif;
        if(isset($meta['halim_movie_notice']) && $meta['halim_movie_notice'] !='') : ?>
        <div class="halim-film-notice">
            <p><?php echo $meta['halim_movie_notice']; ?></p>
        </div>
    <?php
        endif;
        if(isset($meta['halim_showtime_movies']) && $meta['halim_showtime_movies'] != '') : ?>
        <div class="halim_showtime_movies">
            <p><?php echo $meta['halim_showtime_movies']; ?></p>
        </div>
    <?php endif; ?>

    <div class="entry-content htmlwrap clearfix">
        <div class="video-item halim-entry-box">
            <div class="halim-movie-detail full">
                <?php HaLimCore::halim_get_movie_detail(true); ?>
            </div>
            <article id="post-<?php echo $post->ID; ?>" class="item-content post-<?php echo $post->ID; ?>">
                <?php the_content(); ?>
            </article>
            <div class="item-content-toggle">
                <div class="item-content-gradient"></div>
                <span class="show-more" data-single="true" data-showmore="<?php _e('Hiện thêm', 'halimthemes'); ?>" data-showless="<?php _e('Ẩn đi', 'halimthemes'); ?>"><?php _e('Hiện thêm', 'halimthemes'); ?></span>
            </div>
        </div>
    </div>
    <?php
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
                    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
            </script>

        </div>
    <?php endif; ?>
    <div id="lightout"></div>