<?php

class HaLimCore extends HaLim_Abstract {

    public static function halim_get_list_server_by_sv($post_id)
    {
        $metaPost = get_post_meta( $post_id, '_halimmovies', true );
        $data = json_decode($metaPost);
        $results = array();
        foreach($data as $key => $vl){
            $results[]= ucfirst(($key+1));
        }
        $b = count($results)-1;
        $randArr = ($b !== -1) ? $results[rand(0, $b)] : 0;
        return $randArr;
    }

    public static function halim_get_list_server($post_id, $episode, $server)
    {
        $metaPost = get_post_meta( $post_id, '_halimmovies', true );
        $data = json_decode($metaPost);
        if($episode) $episode = ($episode-1);
        $dataPlayer = $results = array();
        if(isset($data[$server-1]->halimmovies_server_data[$episode])){
            $dataPlayer = $data[$server-1]->halimmovies_server_data[$episode];
        }
        else if(isset($data[0]->halimmovies_server_data[0])){
            $dataPlayer = $data[0]->halimmovies_server_data[0];
        }
        $halimmovies_listsv = (isset($dataPlayer->halimmovies_ep_listsv)) ? $dataPlayer->halimmovies_ep_listsv : '';
        if($halimmovies_listsv){
            foreach ($halimmovies_listsv as $key => $value) {
                $results[]= ucfirst(($key+1));
            }
        }
        $b = count($results)-1;
        $randArr = ($b !== -1) ? $results[rand(0, $b)] : 0;
        return $randArr;
    }

    public static function halim_get_movie_title()
    {
        global $post;

        $episode = get_query_var('halim_episode');
        if(isset($episode)){
            $eps_name = HALIMHelper::is_type('tv_series') ? __('episode', 'halimthemes').' '.$episode : '';
            $title = ($episode) ? $post->post_title.' '.$eps_name : $post->post_title;
        } else {
            $title = $post->post_title;
        }
        echo '<h1 class="entry-title"><a href="'.get_the_permalink().'" title="'.$post->post_title.'" class="tl">'.$title.'</a></h1>';
    }

    public static function halim_get_movie_detail($single = false)
    {
        global $post;
        ob_start();
        $directors = get_the_terms($post->ID, 'director');
        if(is_array($directors)){

            echo '<p class="directors">';
            _e('Đạo diễn', 'halimthemes');
            echo ':';
            foreach($directors as $director){
                if($director->name != '') {
                    echo '<a class="director" href="'.home_url($director->taxonomy . '/' . $director->slug).'" title="'.$director->name.'">'.$director->name.'</a>';
                }
            }
            echo '</p>';
        }

        $country = get_the_terms($post->ID, 'country');
        if(is_array($country)){
            echo '<p class="actors">';
            _e('Quốc gia', 'halimthemes'); echo ':';
            foreach($country as $ct){
                echo '<a href="'.home_url($ct->taxonomy . '/' . $ct->slug).'" title="'.$ct->name.'">'.$ct->name.'</a>';
            }
            echo '</p>';
        }

        if($single){
            $meta = get_post_meta($post->ID, '_halim_metabox_options', true );
            $eps = isset($meta['halim_episode']) ? $meta['halim_episode'] : '';
            $duration = isset($meta['halim_runtime']) ? $meta['halim_runtime'] : '';
            if($eps) {
                echo '<p class="_episode">';
                _e('Episode', 'halimthemes');
                echo ':';
                echo '<span>'.$eps.'</span></p>';
            }
            if($duration)
            {
                echo '<p class="_showtime">';
                _e('Duration', 'halimthemes');
                echo ':';
                echo '<span>'.$duration.'</span></p>';
            }

            echo '<p class="genres">';
                _e('Thể loại', 'halimthemes'); echo ':'; the_category(', ');
            echo '</p>';

        }

        $actors = get_the_terms($post->ID, 'actor');
        if(is_array($actors)){
            echo '<p class="actors">';
            _e('Diễn viên', 'halimthemes'); echo ':';
            foreach(array_slice($actors, 0, 10) as $actor){
                echo '<a href="'.home_url($actor->taxonomy . '/' . $actor->slug).'" title="'.$actor->name.'">'.$actor->name.'</a>';
            }
            echo '</p>';
        }
        $html = ob_get_clean();
        echo $html;
    }


    public static function halim_userAccess()
    {
        if (!class_exists('APSL_Lite_Login_Check_Class')){
            return;
        }
        global $current_user;
        ob_start();
        $options = get_option( APSL_SETTINGS );
        if ( is_user_logged_in() ) {
            if ( !empty( $_GET['redirect'] ) )
                $current_url = $_GET['redirect'];
            else
                $current_url = APSL_Lite_Login_Check_Class::curPageURL();

            if ( isset( $options['apsl_custom_logout_redirect_options'] ) && $options['apsl_custom_logout_redirect_options'] != '' ) {
                if ( $options['apsl_custom_logout_redirect_options'] == 'home' ) {
                    $user_logout_url = wp_logout_url( home_url() );
                } else if ( $options['apsl_custom_logout_redirect_options'] == 'current_page' ) {
                    $user_logout_url = wp_logout_url( $current_url );
                } else if ( $options['apsl_custom_logout_redirect_options'] == 'custom_page' ) {
                    if ( $options['apsl_custom_logout_redirect_link'] != '' ) {
                        $logout_page = $options['apsl_custom_logout_redirect_link'];
                        $user_logout_url = wp_logout_url( $logout_page );
                    } else {
                        $user_logout_url = wp_logout_url( $current_url );
                    }
                }
            } else {
                $user_logout_url = wp_logout_url( $current_url );
            }
            ?>
                <div class="user" id="pc-user-logged-in">
                    <div class="dropdown">
                        <a href="#" class="avt"><?php echo get_avatar( $current_user->ID, 40 ); ?></a>
                        <a href="#" id="userInfo" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <span class="name"><?php echo $current_user->data->display_name; ?></span>
                            <i class="hl-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userInfo">
                            <li><a href="<?php echo home_url()."/author/".get_the_author_meta('user_login', $current_user->ID); ?>"><i class="hl-user"></i> <?php _e('Profiles', 'halimthemes'); ?></a></li>
                            <li><a href="<?php echo $user_logout_url; ?>"><i class="hl-off"></i> <?php _e('Logout', 'halimthemes') ?></a></li>
                        </ul>
                    </div>
                </div>
            <?php
        } else {
            $current_url = APSL_Lite_Login_Check_Class::curPageURL();
            $encoded_url = urlencode( $current_url );
            $theme = $options['apsl_icon_theme'];

                if(isset($_SESSION['apsl_login_error_flag']) && $_SESSION['apsl_login_error_flag'] == '1'){ ?>
                    <div class='apsl-error'><?php _e('You have Access Denied. Please authorize the app to login.', 'halimthemes' ); ?></div>
                    <?php
                    unset($_SESSION['apsl_login_error_flag']);
                } ?>
                <?php if ( isset( $_REQUEST['error'] ) || isset( $_REQUEST['denied'] ) ) { ?>
                    <div class='apsl-error'><?php _e( 'You have Access Denied. Please authorize the app to login.', 'halimthemes' ); ?></div>
                <?php } ?>
                <div class="user user-login-option box-shadow" id="pc-user-login">
                    <div class="dropdown">
                        <a href="javascript:;" class="avt" id="userInfo" onclick="openLoginModal();">
                            <?php echo get_avatar( $current_user->ID, 20 ); ?>
                            <span class="name"><?php _e( 'Login', 'halimthemes' ); ?></span>
                        </a>
                        <ul class="dropdown-menu login-box" aria-labelledby="userInfo">
                            <?php
                                foreach ( $options['network_ordering'] as $key => $value ):
                                    if ( $options["apsl_{$value}_settings"]["apsl_{$value}_enable"] === 'enable' ) { ?>
                                    <li class="<?php echo $value; ?> box-shadow">
                                        <a rel="nofollow" href="<?php echo wp_login_url() ?>?apsl_login_id=<?php echo $value; ?>_login<?php
                                        if ( $encoded_url ) {
                                            echo "&state=" . base64_encode( "redirect_to=$encoded_url" );
                                        }
                                        ?>" title='<?php _e( 'Login with', 'halimthemes' ); echo ' ' . $value; ?>'><i class="hl-<?php echo ($value == 'google') ? 'gplus' : $value; ?>"></i> Login with <span><?php echo $value; ?></span>
                                        </a>
                                    </li>
                                        <?php
                                    }
                                endforeach;
                            ?>
                        </ul>
                    </div>
                </div>
            <?php
            $html = ob_get_clean();
            echo $html;
        }
    }

    public static function display_post_items($layout = '4col', $is_slider = false)
    {
        ob_start();
        global $post;
        if(!$post) return;

        $meta = get_post_meta($post->ID, '_halim_metabox_options', true );
        $quality = isset($meta['halim_quality']) && $meta['halim_quality'] ? $meta['halim_quality'] : '';
        $org_title = isset($meta['halim_original_title']) && $meta['halim_original_title'] ? $meta['halim_original_title'] : '';
        $lastep = HALIMHelper::is_type('tv_series') ? halim_add_episode_name_to_the_title(halim_get_last_episode($post->ID)) : '';
        $episode = isset($meta['halim_episode']) && $meta['halim_episode'] ? $meta['halim_episode'] : $lastep;
        $duration = isset($meta['halim_runtime']) && $meta['halim_runtime'] ? $meta['halim_runtime'] : '';
        $imdb_rating = isset($meta['halim_rating']) && $meta['halim_rating'] ? $meta['halim_rating'] : '';
        $col = $layout == '4col' ? 'col-md-3 col-sm-3 col-xs-6 ' : 'col-md-2 col-sm-4 col-xs-6 ';
        $tooltip = cs_get_option('halim_tooltip_post_info');
        $lazyload = cs_get_option('halim_lazyload_image');
        $post_content = apply_filters('the_content', $post->post_content);

        $post_categories = wp_get_post_categories($post->ID);
        $cats = $country = '';
        foreach($post_categories as $c){
            $cat = get_category( $c );
            $cats .= '<span class=category-name>'.$cat->name.'</span>';
        }

        $countries = get_the_terms($post->ID, 'country');
        if(is_array($countries)){
            foreach($countries as $ct){
                $country .= '<span class=category-name>'.$ct->name.'</span>';
            }

        }
        ?>
        <article class="<?php echo ($is_slider !== true) ? $col : ''; ?>thumb grid-item post-<?php echo $post->ID; ?>">
            <div class="halim-item">
                <a class="halim-thumb" href="<?php the_permalink();?>" title="<?php echo htmlspecialchars($post->post_title); ?>">
                    <?php if($lazyload) : ?>
                    <figure><img class="lazyload blur-up img-responsive" data-sizes="auto" data-src="<?php echo esc_url(halim_image_display()) ?>" alt="<?php echo htmlspecialchars($post->post_title); ?>" title="<?php echo htmlspecialchars($post->post_title); ?>"></figure>
                    <?php else: ?>
                    <figure><img class="img-responsive" src="<?php echo esc_url(halim_image_display()) ?>" alt="<?php echo htmlspecialchars($post->post_title); ?>" title="<?php echo htmlspecialchars($post->post_title); ?>"></figure>
                    <?php endif; ?>
                    <?php
                        if($quality) echo '<span class="status">'.esc_html($quality).'</span>';
                        if(HALIMHelper::is_status('is_trailer')){
                            echo '<span class="is_trailer"><i class="hl-play"></i> Trailer</span>';
                        } else {
                            if($episode) echo '<span class="episode">'.esc_html($episode).'</span>';
                        }
                        // if($duration) {
                        //     $time = explode(' ', $duration);
                        //     if(isset($time[0]) && isset($time[1])) echo '<span class="duration">'.esc_html($time[0]).'<br />'.esc_html($time[1]).'</span>';
                        // }
                    ?>

                    <div class="icon_overlay"<?php if($tooltip) : ?>
                            data-html="true"
                            data-toggle="halim-popover"
                            data-placement="top"
                            data-trigger="hover"
                            title="<span class=film-title><?php echo htmlspecialchars($post->post_title); ?></span>"
                            data-content="<?php echo $org_title ? '<div class=org-title>'.htmlspecialchars($org_title).'</div>' : ''; ?>
                            <div class=film-meta>
                                <div class=text-center>
                                    <?php echo has_term('', 'release') ? '<span class=released><i class=hl-calendar></i> '.get_the_terms($post->ID, 'release')[0]->name.'</span>' : ''; ?>
                                    <?php echo $duration ? '<span class=runtime><i class=hl-clock></i> '.$duration.'</span>' : ''; ?>
                                </div>
                                <div class=film-content><?php echo htmlspecialchars(wp_trim_words($post_content, 18)); ?></div>
                                <?php echo $country ? '<p class=category>'.__('Quốc gia', 'halimthemes').': '.$country.'</p>' : ''; ?>
                                <p class=category><?php _e('Thể loại', 'halimthemes'); ?>: <?php echo $cats; ?></p>
                            </div>"<?php endif; ?>>
                    </div>

                    <div class="halim-post-title-box">
                        <div class="halim-post-title <?php echo (!$org_title) ? 'title-2-line' : ''; ?>">
                            <?php echo '<h2 class="entry-title">'.esc_html($post->post_title).'</h2>';
                                if($org_title) echo '<p class="original_title">'.esc_html($org_title).'</p>';
                            ?>
                        </div>
                    </div>
                </a>
            </div>
        </article>
        <?php
        $html = ob_get_clean();
        echo $html;
    }

    public static function display_popular_post_items($type = 'day', $show_meta = false) {
        global $post;
        ob_start();
        $meta = get_post_meta($post->ID, '_halim_metabox_options', true );
        $org_title = isset($meta['halim_original_title']) ? $meta['halim_original_title'] : '';
        $quality = isset($meta['halim_quality']) ? $meta['halim_quality'] : '';
        $lastep = HALIMHelper::is_type('tv_series') ? halim_add_episode_name_to_the_title(halim_get_last_episode($post->ID)) : '';
        $episode = isset($meta['halim_episode']) && $meta['halim_episode'] ? $meta['halim_episode'] : $lastep;
        $runtime = isset($meta['halim_runtime']) ? $meta['halim_runtime'] : '';
        $lazyload = cs_get_option('halim_lazyload_image');
        ?>
        <div class="item post-<?php echo $post->ID; ?>">
            <a href="<?php the_permalink();?>" title="<?php echo esc_html($post->post_title); ?>">
                <div class="item-link">
                    <?php if($lazyload) : ?>
                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo esc_url(halim_image_display()) ?>" class="lazyload blur-up post-thumb" alt="<?php echo esc_html($post->post_title); ?>" title="<?php echo esc_html($post->post_title); ?>" />
                    <?php else : ?>
                    <img src="<?php echo esc_url(halim_image_display()) ?>" class="post-thumb" alt="<?php echo esc_html($post->post_title); ?>" title="<?php echo esc_html($post->post_title); ?>" />
                    <?php endif; ?>
                    <?php
                    if(HALIMHelper::is_status('is_trailer')){
                        echo '<span class="is_trailer">Trailer</span>';
                    }  ?>
                </div>
                <h3 class="title"><?php echo esc_html($post->post_title); ?></h3>
                <?php if($org_title) echo '<p class="original_title">'.esc_html($org_title).'</p>'; ?>
            </a>
            <div class="viewsCount"><?php echo halim_display_post_view_count($post->ID, $type) ?> <?php _e('lượt xem', 'halimthemes') ?></div>
            <?php if($show_meta == true) : ?>
                <span class="post_meta"><?php echo HALIMHelper::is_type('tv_series') ? $episode : $runtime; ?></span>
            <?php endif; ?>
        </div>
        <?php
        $html = ob_get_clean();
        echo $html;
    }
}


class HaLim_Auto_Save_Images extends HaLim_Abstract
{
    public function __construct()
    {
        if(isset($_POST['_halim_metabox_options']) || isset($_POST['_videos_metabox_options']) || isset($_POST['_news_metabox_options']))
        {
            $news_meta = isset($_POST['_news_metabox_options']) ? $_POST['_news_metabox_options'] : '';
            $meta = isset($_POST['_halim_metabox_options']) ? $_POST['_halim_metabox_options'] : '';
            $set_feature = isset($meta['set_reatured_image']) ? $meta['set_reatured_image'] : '';
            $save_poster_image = isset($meta['save_poster_image']) ? $meta['save_poster_image'] : '';
            $save_img = isset($meta['save_all_img']) ? $meta['save_all_img'] : '';
            $save_img_post_type_news = isset($news_meta['save_all_img']) ? $news_meta['save_all_img'] : '';
            $video_meta = isset($_POST['_videos_metabox_options']) ? $_POST['_videos_metabox_options'] : '';
            $set_feature_image_video = isset($video_meta['set_as_featured_image']) ? $video_meta['set_as_featured_image'] : '';
            if($save_img == 1) {
                $this->addFilter('content_save_pre', 'halim_post_save_images');
            }

            if($save_poster_image == 1 || $set_feature == 1 || $set_feature_image_video == 1 ) {
                $this->addAction('save_post', 'Halim_Generate_Poster_Image');
            }

            if($save_img_post_type_news == 1) {
                $this->addFilter('content_save_pre', 'halim_post_save_images');
            }
        }

    }

    public function Halim_Generate_Poster_Image( $post_id )
    {
        global $post;
        if ($post->post_type == 'video')
        {
            $video_meta = isset($_POST['_videos_metabox_options']) ? $_POST['_videos_metabox_options'] : '';
            $image_url = isset($video_meta['video_thumbnail_url']) ? $video_meta['video_thumbnail_url'] : '';
            $set_feature = isset($video_meta['set_as_featured_image']) ? $video_meta['set_as_featured_image'] : '';

            if($set_feature == 1 && !has_post_thumbnail($post_id)) {
                $this->halim_save_images($image_url, $post_id, $posttitle, true);
            }
        }

        if ($post->post_type == 'post')
        {
            $meta = get_post_meta($post_id, '_halim_metabox_options', true );
            $check_post_meta = isset($_POST['_halim_metabox_options']) ? $_POST['_halim_metabox_options'] : '';
            $check_thumbnail_url = $check_post_meta['halim_thumb_url'];
            $check_poster_url = $check_post_meta['halim_poster_url'];

            $save_poster_image = isset($meta['save_poster_image']) ? $meta['save_poster_image'] : '';
            $posttitle = isset($_POST['post_title']) ? $_POST['post_title'] : '';
            $set_feature = isset($meta['set_reatured_image']) ? $meta['set_reatured_image'] : '';
            $poster_url = isset($meta['halim_poster_url']) ? $meta['halim_poster_url'] : '';
            $thumb_url = isset($meta['halim_thumb_url']) ? $meta['halim_thumb_url'] : '';

            if($check_thumbnail_url != '') {
                if($set_feature == 1 && !has_post_thumbnail($post_id)) {
                    $this->halim_save_images($check_thumbnail_url, $post_id, $posttitle, true);
                    $thumb_image_url = get_the_post_thumbnail_url( $post_id, 'movie-thumb' );
                }
            }
            if(has_post_thumbnail($post_id)) {
                $thumb_image_url = get_the_post_thumbnail_url( $post_id, 'movie-thumb' );
            } else {
                $thumb_image_url = $thumb_url;
            }

            if($check_poster_url != '') {

                if($save_poster_image == 1) {
                    $res = $this->halim_save_images($check_poster_url, $post_id, $posttitle);
                    $poster_image_url = $res['url'];
                } else {
                    $poster_image_url = $poster_url;
                }
            }


            $meta['halim_thumb_url'] = $thumb_image_url;
            $meta['halim_poster_url'] = $poster_image_url;
            $meta['save_poster_image'] = '';
            $meta['set_reatured_image'] = '';
            update_post_meta($post_id, '_halim_metabox_options', $meta);
        }
    }

    public function halim_post_save_images($content)
    {
        if(isset($_POST['save']) || isset($_POST['publish']))
        {
            set_time_limit(500);
            global $post;
            $post_id = $post->ID;
            $posttitle = (isset($_POST['post_title'])) ? $_POST['post_title'] : '';
            $preg = preg_match_all('/<img.*?src="(.*?)"/', stripslashes($content), $matches);
            if($preg)
            {
                foreach($matches[1] as $image_url)
                {
                    if(empty($image_url)) continue;
                    $pos = strpos($image_url, $_SERVER['HTTP_HOST']);
                    if($pos===false)
                    {
                        $res = $this->halim_save_images($image_url, $post_id, $posttitle);
                        $replace = $res['url'];
                        $content = str_replace($image_url, $replace, $content);
                    }
                }
            }
        }
        remove_filter( 'content_save_pre', array( $this, 'halim_post_save_images' ) );
        return $content;
    }

    public function halim_save_images($image_url, $post_id, $posttitle, $set_thumb = false)
    {
        $file = file_get_contents($image_url);
        $postname = sanitize_title($posttitle);
        $im_name = "$postname-$post_id.jpg";
        $res = wp_upload_bits($im_name, '', $file);
        $this->halim_insert_attachment($res['file'], $post_id, $set_thumb);
        return $res;
    }

    public function halim_insert_attachment($file, $post_id, $set_thumb)
    {
        $dirs = wp_upload_dir();
        $filetype = wp_check_filetype($file);
        $attachment = array(
            'guid' => $dirs['baseurl'].'/'._wp_relative_upload_path($file),
            'post_mime_type' => $filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/','',basename($file)),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment($attachment, $file, $post_id);
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        wp_update_attachment_metadata($attach_id, $attach_data);
        if($set_thumb != false) {
            set_post_thumbnail( $post_id, $attach_id );
        }
        return $attach_id;
    }
}

$auto_save_img = new HaLim_Auto_Save_Images();
