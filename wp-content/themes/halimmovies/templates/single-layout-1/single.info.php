<?php
    $episode      = get_query_var('halim_episode');
    $server       = get_query_var('halim_server');
    $post_slug    = basename(get_permalink($post->ID));
    $type_slug    = cs_get_option('halim_url_type');
    $watch_slug   = cs_get_option('halim_watch_url');
    $episode_slug = cs_get_option('halim_episode_url');
    $server_slug  = cs_get_option('halim_server_url');
    $episode_display = cs_get_option('halim_episode_display');
    $meta         = get_post_meta($post->ID, '_halim_metabox_options', true );
    $trailer      = (isset($meta['halim_trailer_url'])) ? $meta['halim_trailer_url'] : '';
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
    <div class="halim-movie-wrapper">
    <div class="title-block watch-page">
    <a href="javascript:;" data-toggle="tooltip" title="<?php _e('Thêm vào tủ phim', 'halimthemes'); ?>">
                <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-post_id="<?php echo $post->ID; ?>" data-thumbnail="<?php echo esc_url(halim_image_display()) ?>" data-href="<?php the_permalink(); ?>" data-title="<?php echo $post->post_title; ?>" data-date="<?php echo $date; ?>">
                    <!-- <div class="halim-pulse-ring"></div> -->
                </div>
            </a>
        <div class="title-wrapper">
            <h1 class="entry-title" data-toggle="tooltip" title="<?php echo get_the_title($post->ID); ?>"><?php echo the_title(); ?><?php the_terms( $post->ID, 'release', '<span class="title-year"> (', '', ')</span>' ); ?></h1>
        </div>

        <div class="ratings_wrapper hidden-xs">
            <?php echo halim_get_user_rate() ?>
        </div>
        <div class="more-info">
            <?php
                $eps = isset($meta['halim_episode']) ? $meta['halim_episode'] : '';
                $duration = isset($meta['halim_runtime']) ? $meta['halim_runtime'] : '';
                if($eps) echo "<span>{$eps}</span>";
                if($duration) echo "<span>{$duration}</span>";
            ?>
            <span><?php the_category(', '); ?></span>
        </div>
    </div>
    <div class="movie_info col-xs-12">
        <div class="movie-poster col-md-3">
            <img class="movie-thumb" src="<?php echo halim_image_display('movie-thumb'); ?>" alt="<?php the_title() ?>">
            <?php
                $imdb_rating = isset($meta['halim_rating']) ? $meta['halim_rating'] : '';
                $imdb_votes = isset($meta['halim_votes']) ? $meta['halim_votes'] : '';
                if($imdb_rating != '') echo '<div class="halim_imdbrating"><span>'.esc_html($imdb_rating).'</span></div>';
            ?>

                <a href="<?php echo halim_get_first_episode_link($post->ID); ?>" class="btn btn-sm btn-danger watch-movie visible-xs-block"><i class="hl-play"></i><?php _e('Xem Phim', 'halimthemes'); ?></a>



            <span class="btn btn-sm btn-success quick-eps"><a data-toggle="collapse" href="#collapseEps" aria-expanded="false" aria-controls="collapseEps"><i class="hl-sort-down"></i> <?php _e('Quick Eps', 'halimthemes'); ?></a>
            </span>
        </div>
        <?php
            $poster = isset($meta['halim_poster_url']) && $meta['halim_poster_url'] != '' ? ($meta['halim_poster_url']) : halim_image_display('full');
            $check = isset($meta['halim_movie_status']) ? $meta['halim_movie_status'] : '';
            if($check == 'trailer') echo '<span class="trailer-button">Trailer</span>';
        ?>
        <div class="film-poster col-md-9">
            <div class="film-poster-img" style="background: url('<?php echo $poster ?>');background-size: cover;background-repeat: no-repeat;background-position: 30% 25%;height: 300px;-webkit-filter: grayscale(100%); filter: grayscale(100%);"></div>
            <div class="halim-play-btn hidden-xs">

                <a href="<?php echo halim_get_first_episode_link($post->ID); ?>" class="play-btn" title="<?php _e('Click to Play', 'halimthemes'); ?>" data-toggle="tooltip" data-placement="bottom"><?php _e('Click to Play', 'halimthemes'); ?></a>
            </div>
            <div class="movie-trailer hidden"></div>
            <div class="movie-detail">

                <?php if(halim_get_country()) : ?>
                <p class="actors"><?php _e('Quốc gia', 'halimthemes'); ?>: <?php echo halim_get_country(); ?></p>
                <?php endif; ?>
                <?php if(halim_get_directors()) : ?>
                <p class="directors"><?php echo _e('Đạo diễn', 'halimthemes'); ?>: <?php echo halim_get_directors(); ?></p>
                <?php endif; ?>
                <?php if(halim_get_actors()) : ?>
                <p class="actors"><?php _e('Diễn viên', 'halimthemes'); ?>: <?php echo halim_get_actors(); ?></p>
                <?php endif; ?>

            </div>
        </div>
    </div>

    </div>

    <div class="clearfix"></div>

    <div id="halim_trailer"></div>

    <div class="collapse" id="collapseEps">
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
        <div class="halim--notice">
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
             <article id="post-<?php echo $post->ID; ?>" class="item-content">
                <?php the_content(); ?>
             </article>
             <div class="item-content-toggle">
                <div class="item-content-gradient"></div>
                <span class="show-more" data-single="true" data-showmore="<?php _e('Hiện thêm', 'halimthemes'); ?>" data-showless="<?php _e('Ẩn đi', 'halimthemes'); ?>"><?php _e('Hiện thêm', 'halimthemes'); ?></span>
            </div>
        </div>
    </div>