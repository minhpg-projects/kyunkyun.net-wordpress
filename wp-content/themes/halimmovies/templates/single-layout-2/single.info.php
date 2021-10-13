<?php

    $episode         = get_query_var('halim_episode');
    $episode_slug    = get_query_var('episode_slug');
    $server          = get_query_var('halim_server');
    $type_slug       = cs_get_option('halim_url_type');
    $watch_slug      = cs_get_option('halim_watch_url');
    $episode_slug    = cs_get_option('halim_episode_url');
    $server_slug     = cs_get_option('halim_server_url');
    $post_slug       = basename(get_permalink($post->ID));
    $episode_display = cs_get_option('halim_episode_display');
    $meta            = get_post_meta($post->ID, '_halim_metabox_options', true );
    $org_title       = isset($meta['halim_original_title']) && $meta['halim_original_title'] !='' ? $meta['halim_original_title'] : '';
    $quality         = isset($meta['halim_quality']) && $meta['halim_quality'] !='' ? $meta['halim_quality'] : '';
    $halim_episode   = isset($meta['halim_episode']) && $meta['halim_episode'] !='' ? $meta['halim_episode'] : '';
    $runtime         = isset($meta['halim_runtime']) && $meta['halim_runtime'] !='' ? $meta['halim_runtime'] : '';
    $imdb_rating     = isset($meta['halim_rating']) && $meta['halim_rating'] ? $meta['halim_rating'] : '';
    $imdb_votes      = isset($meta['halim_votes']) && $meta['halim_votes'] ? $meta['halim_votes'] : '';
    $trailer         = isset($meta['halim_trailer_url']) ? $meta['halim_trailer_url'] : '';
    $is_copyright    = isset($meta['is_copyright']) ? $meta['is_copyright'] : '';
    $is_adult        = isset($meta['is_adult']) ? $meta['is_adult'] : '';
    $time            = explode(' ', esc_html($post->post_date));
    $date            = $time[0];
    if($trailer != '')
    {
        if(strpos($trailer, 'imdb.com')) {
            preg_match('/\/video\/imdb\/(.*?)\//is', $trailer, $imdb_embed);
            $trailer_url = 'https://www.imdb.com/videoembed/'.$imdb_embed[1];
        } else {
            $yt_id = HALIMHelper::getYoutubeId($trailer);
            $trailer_url = 'https://www.youtube.com/embed/'.$yt_id;
        }
    } else $trailer_url = '';
    ?>
    <div class="halim-movie-wrapper tpl-2">
        <div class="movie_info col-xs-12">
            <div class="movie-poster col-md-4">
                <img class="movie-thumb" src="<?php echo halim_image_display('movie-thumb'); ?>" alt="<?php the_title() ?>">


                <?php if(!$is_copyright) :

                    $watch_url = cs_get_option('watch_btn_display') == 'first_episode' ? halim_get_first_episode_link($post->ID) : halim_get_last_episode_link($post->ID);

                    ?>
                    <div class="halim-watch-box">
                        <a href="<?php echo $watch_url; ?>" class="btn btn-sm btn-danger watch-movie visible-xs-blockx"><i class="hl-play"></i> <?php _e('Xem Phim', 'halimthemes'); ?></a>
                        <span class="btn btn-sm btn-success quick-eps" data-toggle="collapse" href="#collapseEps" aria-expanded="false" aria-controls="collapseEps"><i class="hl-sort-down"></i> <?php _e('Tập Phim', 'halimthemes'); ?></span>
                    </div>
                <?php else : ?>
                    <span class="btn btn-sm btn-danger watch-movie visible-xs-blockx" data-toggle="tooltip" title="<?php _e('Copyright infringement', 'halimthemes'); ?>" style="width: 92%;"><?php _e('Copyright infringement', 'halimthemes'); ?></span>
                <?php endif; ?>
            </div>
            <?php
                $poster = isset($meta['halim_poster_url']) && $meta['halim_poster_url'] != '' ? $meta['halim_poster_url'] : halim_image_display('full');
                $check = isset($meta['halim_movie_status']) ? $meta['halim_movie_status'] : '';
                if($check == 'trailer') echo '<span class="trailer-button">Trailer</span>';
                $the_title = cs_get_option('display_custom_title') ? halim_get_the_title($post->ID) : get_the_title($post->ID);
            ?>
            <div class="film-poster col-md-8">
                <div class="movie-detail">
                    <h1 class="entry-title"><?php echo $the_title ?></h1>
                    <?php if($org_title) echo '<p class="org_title">'.$org_title.'</p>'; ?>

                        <p class="released">
                            <?php
                                if(has_term('', 'release')){
                                    $term_obj_list = get_the_terms($post->ID, 'release');
                                    $released = $term_obj_list[0];
                                    echo '<span class="released"><i class="hl-calendar"></i> <a href="'.home_url('/').$released->taxonomy.'/'.trim($released->slug).'" rel="tag">'.$released->name.'</a></span>';
                                } ?>
                            <?php echo $runtime ? '<i class="hl-clock"></i> '.$runtime : ''; ?>
                            <?php echo $imdb_rating ? '<i class="imdb-icon" data-rating="'.$imdb_rating.'"></i>' : ''; ?>
                        </p>

                        <?php if(HALIMHelper::is_type('tv_series') && !$is_copyright) : ?>
                            <p class="episode">
                                <span><?php _e('Tình trạng', 'halimthemes'); ?>: </span>
                                <span><?php echo $halim_episode ? $halim_episode : halim_add_episode_name_to_the_title(halim_get_last_episode($post->ID)); ?></span>
                            </p>
                            <?php echo halim_get_three_last_episode($post->ID); ?>
                        <?php endif; ?>

                    <?php if(halim_get_country()) : ?>
                    <p class="actors"><?php _e('Quốc gia', 'halimthemes'); ?>: <?php echo halim_get_country(); ?></p>
                    <?php endif; ?>
                    <?php if(halim_get_directors()) : ?>
                    <p class="directors"><?php echo _e('Đạo diễn', 'halimthemes'); ?>: <?php echo halim_get_directors(); ?></p>
                    <?php endif; ?>
                    <?php if(halim_get_actors()) : ?>
                    <p class="actors"><?php _e('Diễn viên', 'halimthemes'); ?>: <?php echo halim_get_actors(); ?></p>
                    <?php endif; ?>

                    <p class="category"><?php _e('Thể loại', 'halimthemes'); ?>: <?php the_category(', '); ?></p>

                    <div class="ratings_wrapper single-info">
                        <?php echo halim_get_user_rate() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div id="halim_trailer"></div>

    <div class="collapse <?php echo cs_get_option('episode_list_display') == 'visible' ? 'in' : ''; ?>" id="collapseEps">
        <?php

            if(isEpisodePagenav($meta) || $episode_display == 'show_paging_eps') {
                HaLimCore_Helper::halim_episode_pagination($post->ID, $server, $episode, false);
            } elseif ($episode_display == 'show_tab_eps') {
                HaLimCore_Helper::halim_show_all_eps_table($post->ID, $server, $episode_slug);
            } else {
                HaLimCore_Helper::halim_show_all_eps_list($post->ID, $server, $episode_slug, true);
            }
        ?>
    </div>

    <div class="clearfix"></div>
    <?php if(cs_get_option('single_notice')) : ?>
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
        <div class="section-title"><span><?php _e('Nội dung', 'halimthemes'); ?></span></div>
        <div class="video-item halim-entry-box">
             <article id="post-<?php echo $post->ID; ?>" class="item-content <?php echo cs_get_option('post_content_display_detail_page') == 'visible' ? 'toggled' : ''; ?>">
                <?php the_content(); ?>
             </article>
             <div class="item-content-toggle">
                <div class="item-content-gradient"></div>
                <span class="show-more" data-single="true" data-showmore="<?php _e('Hiện thêm', 'halimthemes'); ?>..." data-showless="<?php _e('Ẩn đi', 'halimthemes'); ?>..."><?php $txt = cs_get_option('post_content_display_detail_page') == 'visible' ? 'Ẩn đi' : 'Hiện thêm';  _e($txt, 'halimthemes'); ?>...</span>
            </div>
        </div>
    </div>