<?php

function halim_ajax_publish_post(){
    $post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : '';
    if($post_id) {
        // wp_publish_post($post_id);

        $postData = [ 'ID' => $post_id, 'post_status' => 'publish' ];
        wp_update_post( $postData );

        $json['status'] = true;
        wp_send_json($json);
    } else wp_die('Empty post id');
}
add_action( 'wp_ajax_halim_ajax_publish_post', 'halim_ajax_publish_post' );

if(!function_exists('halim_ajax_get_eps_tab'))
{
    function halim_ajax_get_eps_tab()
    {

        $clean = new xssClean();
        $postid = $clean->clean_input(wp_strip_all_tags($_POST['postid']));
        $server = $clean->clean_input(wp_strip_all_tags($_POST['server']));
        $episode = $clean->clean_input(wp_strip_all_tags($_POST['episode']));

        if(!$server) $server = 1;
        $metaPost = get_post_meta($postid, '_halimmovies', true );
        $data = json_decode($metaPost);
        $result = '';
        // $result .='<div class="text-center"><div id="halim-ajax-list-server"></div></div>';
        // $result .='<div id="halim-list-server">';
        if($data)
        {
            $result .='<ul class="nav nav-tabs" role="tablist">';
            foreach ($data as $key => $value)
            {
                $activeroletab = (($key + 1) == $server) ? 'active' : '';
                $result .='<li role="presentation" class="'.$activeroletab.' server-'.($key+1).'"><a href="#server-'.$key.'" aria-controls="server-'.$key.'" role="tab" data-toggle="tab"><i class="hl-server"></i> '.$value->halimmovies_server_name.'</a></li>';
            }
            $result .='</ul>';
            $result .='<div class="tab-content">';
            foreach ($data as $key => $value)
            {
                $activetab = (($key + 1) == $server) ? 'active' : '';
                $result .= '<div role="tabpanel" class="tab-pane '.$activetab.' server-'.($key+1).'" id="server-'.$key.'">';
                $result .= '<div class="halim-server">';
                $halimmovies_server_data = $value->halimmovies_server_data;
                if($halimmovies_server_data)
                {
                    $result .= '<ul class="halim-list-eps">';
                    foreach ($halimmovies_server_data as $k => $v)
                    {
                        if($v->halimmovies_ep_name)
                        {
                            if($server == ($key+1) && $episode == ($k+1)){
                                $active = 'active ';
                            } else {
                                $active = '';
                            }
                            $position = '';
                            if($k == 0){
                                $position = 'first';
                                if(!$episode && ($key+1) == 1) $active = 'active ';
                            }
                            if($k == count($halimmovies_server_data) - 1){
                                $position = 'last';
                            }
                            $eps_name = HALIMHelper::is_type('tv_series', $postid) ? __('episode', 'halimthemes').' '.($k+1) : '';
                            $embed = $v->halimmovies_ep_type == 'embed' ? 1 : 0;
                            $url_type = strpos($v->halimmovies_ep_link, 'facebook') ? 'facebook' : 'none';
                            $result .= '<li class="halim-episode"><span class="halim-btn halim-btn-2 '.$active.'halim-info-'.($key+1).'-'.($k+1).' box-shadow" data-post-id="'.$postid.'" data-server="'.($key+1).'" data-episode="'.($k+1).'" data-position="'.$position.'" data-embed="'.$embed.'" data-type="'.$url_type.'" data-title="'.get_the_title($postid).' '.$eps_name.'">'.$v->halimmovies_ep_name.'</span></li>';
                        }
                    }
                    $result .= '</ul>';
                }
                $result .= '<div class="clearfix"></div>';
                $result .= '</div>';
                $result .= '</div>';
            }
            $result .= '</div>';
        }
        // $result .= '</div>';

        wp_die($result);
    }
}
add_action('wp_ajax_nopriv_halim_ajax_get_list_eps', 'halim_ajax_get_eps_tab');
add_action('wp_ajax_halim_ajax_get_list_eps', 'halim_ajax_get_eps_tab');

if(!function_exists('halim_ajax_get_eps_list'))
{
    function halim_ajax_get_eps_list()
    {
        $clean = new xssClean();
        $postid = $clean->clean_input(wp_strip_all_tags($_POST['postid']));
        $server = $clean->clean_input(wp_strip_all_tags($_POST['server']));
        $episode = $clean->clean_input(wp_strip_all_tags($_POST['episode']));
        $link = true;

        if(!$server) $server = 1;

        $type_slug = cs_get_option('halim_url_type');
        $watch_slug = cs_get_option('halim_watch_url');
        $episode_slug = cs_get_option('halim_episode_url');
        $server_slug = cs_get_option('halim_server_url');

        $post_slug = basename( get_permalink($postid) );
        $single_tpl = cs_get_option('single_template');
        if($single_tpl !== NULL){
            $watch_link = home_url('/').$watch_slug.'/'.$post_slug;
        } else {
            $watch_link = home_url('/').$post_slug;
        }
        $metaPost = get_post_meta( $postid, '_halimmovies', true );
        $data = json_decode($metaPost);
        $result = '';
        if($data)
        {
            foreach ($data as $key => $value)
            {
                if($key >= 1) :

                    $result .= '<div class="halim-server">';
                    $result .= '<span class="halim-server-name"><span class="hl-server"></span> '.$value->halimmovies_server_name.'</span>';
                    $halimmovies_server_data = $value->halimmovies_server_data;
                    if($halimmovies_server_data)
                    {
                        $result .= '<ul class="halim-list-eps">';
                        foreach ($halimmovies_server_data as $k => $v)
                        {
                            if($v->halimmovies_ep_name)
                            {
                                if($server == ($key+1) && $episode == ($k+1)){
                                    $active = 'active ';
                                } else {
                                    $active = '';
                                }
                                $position = '';
                                if($k == 0){
                                    $position = 'first';
                                    if(!$episode && ($key+1) == 1) $active = 'active ';
                                }
                                if($k == count($halimmovies_server_data) - 1){
                                    $position = 'last';
                                }
                                $embed = $v->halimmovies_ep_type == 'embed' ? 1 : 0;
                                $url_type = strpos($v->halimmovies_ep_link, 'facebook') ? 'facebook' : 'none';
                                $eps_name = HALIMHelper::is_type('tv_series', $postid) ? __('episode', 'halimthemes').' '.($k+1) : '';
                                if($link !== true){
                                    $result .= '<li class="halim-episode"><span class="halim-btn '.$active.'halim-info-'.($key+1).'-'.($k+1).' box-shadow" data-post-id="'.$postid.'" data-server="'.($key+1).'" data-episode="'.($k+1).'" data-position="'.$position.'" data-embed="'.$embed.'" data-type="'.$url_type.'" data-title="'.get_the_title($postid).' '.$eps_name.'">'.$v->halimmovies_ep_name.'</span></li>';
                                } else {
                                    if($type_slug == 'slug-1') {
                                       $result .= '<li class="halim-episode"><a href="'.$watch_link.'-'.$episode_slug.'-'.($k+1).'-'.$server_slug.'-'.($key+1).'"><span>'.$v->halimmovies_ep_name.'</span></a></li>';
                                    } else {
                                       $result .= '<li class="halim-episode"><a href="'.$watch_link.'-'.$episode_slug.'-'.($k+1).'-'.$server_slug.($key+1).'"><span>'.$v->halimmovies_ep_name.'</span></a></li>';
                                    }
                                }
                            }
                        }
                        $result .= '</ul>';
                    }
                    $result .= '<div class="clearfix"></div>';
                    $result .= '</div>';
                endif;
            }
        }
        die($result);
    }
}
add_action('wp_ajax_nopriv_halim_ajax_get_server_list', 'halim_ajax_get_eps_list');
add_action('wp_ajax_halim_ajax_get_server_list', 'halim_ajax_get_eps_list');

if(!function_exists('halim_ajax_show_all_eps_list'))
{
    function halim_ajax_show_all_eps_list()
    {
        $clean = new xssClean();
        $postid = $clean->clean_input(wp_strip_all_tags($_POST['postid']));
        $server = $clean->clean_input(wp_strip_all_tags($_POST['server']));
        $episode = $clean->clean_input(wp_strip_all_tags($_POST['episode']));
        $link = false;

        if(!$server) $server = 1;

        $type_slug = cs_get_option('halim_url_type');
        $watch_slug = cs_get_option('halim_watch_url');
        $episode_slug = cs_get_option('halim_episode_url');
        $server_slug = cs_get_option('halim_server_url');

        $post_slug = basename( get_permalink($postid) );
        $single_tpl = cs_get_option('single_template');
        if($single_tpl !== NULL){
            $watch_link = home_url('/').$watch_slug.'/'.$post_slug;
        } else {
            $watch_link = home_url('/').$post_slug;
        }

        ob_start();
        $metaPost = get_post_meta( $postid, '_halimmovies', true );
        $data = json_decode($metaPost);
        $result = '';
        if($data)
        {
            foreach ($data as $key => $value)
            {
                $result .= '<div class="halim-server show_all_eps">';
                $result .= '<span class="halim-server-name"><span class="hl-server"></span> '.$value->halimmovies_server_name.'</span>';
                $halimmovies_server_data = $value->halimmovies_server_data;
                if($halimmovies_server_data)
                {
                    $result .= '<ul class="halim-list-eps">';
                    foreach ($halimmovies_server_data as $k => $v)
                    {
                        if($v->halimmovies_ep_name)
                        {
                            if($server == ($key+1) && $episode == ($k+1)){
                                $active = 'active ';
                            } else {
                                $active = '';
                            }
                            $position = '';
                            if($k == 0){
                                $position = 'first';
                                if(!$episode && ($key+1) == 1) $active = 'active ';
                            }
                            if($k == count($halimmovies_server_data) - 1){
                                $position = 'last';
                            }
                            $embed = $v->halimmovies_ep_type == 'embed' ? 1 : 0;
                            $url_type = strpos($v->halimmovies_ep_link, 'facebook') ? 'facebook' : 'none';
                            $eps_name = HALIMHelper::is_type('tv_series', $postid) ? __('episode', 'halimthemes').' '.($k+1) : '';
                            if($link !== true){
                                $result .= '<li class="halim-episode"><span class="halim-btn '.$active.'halim-info-'.($key+1).'-'.($k+1).' box-shadow" data-post-id="'.$postid.'" data-server="'.($key+1).'" data-episode="'.($k+1).'" data-position="'.$position.'" data-embed="'.$embed.'" data-type="'.$url_type.'" data-title="'.get_the_title($postid).' '.$eps_name.'">'.$v->halimmovies_ep_name.'</span></li>';
                            } else {
                                if($type_slug == 'slug-1') {
                                   $result .= '<li class="halim-episode"><a href="'.$watch_link.'-'.$episode_slug.'-'.($k+1).'-'.$server_slug.'-'.($key+1).'"><span class="'.$active.'halim-info-'.($key+1).'-'.($k+1).' box-shadow" data-post-id="'.$postid.'" data-server="'.($key+1).'" data-episode="'.($k+1).'" data-position="'.$position.'" data-embed="'.$embed.'" data-type="'.$url_type.'" data-title="'.get_the_title($postid).' '.$eps_name.'">'.$v->halimmovies_ep_name.'</span></a></li>';
                                } else {
                                   $result .= '<li class="halim-episode"><a href="'.$watch_link.'-'.$episode_slug.'-'.($k+1).'-'.$server_slug.($key+1).'"><span class="'.$active.'halim-info-'.($key+1).'-'.($k+1).' box-shadow" data-post-id="'.$postid.'" data-server="'.($key+1).'" data-episode="'.($k+1).'" data-position="'.$position.'" data-embed="'.$embed.'" data-type="'.$url_type.'" data-title="'.get_the_title($postid).' '.$eps_name.'">'.$v->halimmovies_ep_name.'</span></a></li>';
                                }
                            }
                        }
                    }
                    $result .= '</ul>';
                }
                $result .= '<div class="clearfix"></div>';
                $result .= '</div>';
            }
        }
        echo $result;
        $html = ob_get_clean();
        wp_die($html);
    }
}
add_action('wp_ajax_nopriv_halim_ajax_show_all_eps_list', 'halim_ajax_show_all_eps_list');
add_action('wp_ajax_halim_ajax_show_all_eps_list', 'halim_ajax_show_all_eps_list');

if(!function_exists('halim_ajax_get_listsv'))
{
    function halim_ajax_get_listsv()
    {
        ob_start();
        $clean = new xssClean();
        $postid = $clean->clean_input(wp_strip_all_tags($_POST['postid']));
        $server = $clean->clean_input(wp_strip_all_tags($_POST['server']));
        $episode = $clean->clean_input(wp_strip_all_tags($_POST['episode']));

        if(!$server) $server = 1;
        if($episode) $episode = ($episode-1);
        $metaPost = get_post_meta( $postid, '_halimmovies', true );
        $data = json_decode($metaPost);

        $dataPlayer = array();
        if(isset($data[$server-1]->halimmovies_server_data[$episode])){
            $dataPlayer = $data[$server-1]->halimmovies_server_data[$episode];
        }
        elseif(isset($data[0]->halimmovies_server_data[0])){
            $dataPlayer = $data[0]->halimmovies_server_data[0];
        }

        $halimmovies_listsv = (isset($dataPlayer->halimmovies_ep_listsv)) ? $dataPlayer->halimmovies_ep_listsv : '';

        if($halimmovies_listsv)
        {
            foreach ($halimmovies_listsv as $key => $value)
            {
                echo '<span id="get-eps-'.($key+1).'" class="get-eps no-active box-shadow" data-url="'.($key+1).'">'.trim($value->halimmovies_ep_listsv_name).'</span>';
            }
        } else {
            echo 'NULL';
        }
        $html = ob_get_clean();
        wp_die($html);
    }
}

add_action('wp_ajax_nopriv_halim_get_listsv', 'halim_ajax_get_listsv');
add_action('wp_ajax_halim_get_listsv', 'halim_ajax_get_listsv');

if(!function_exists('halim_ajax_filter'))
{
    function halim_ajax_filter()
    {
        if(false == $ajax_html = get_transient('halim_ajax_filter_html')) :
            ob_start();
            $categories = get_categories();
            $country = get_terms('country');
            $release = get_terms('release');
            $status = get_terms('status');
        ?>
        <div class="halim-search-filter">
            <div class="btn-group col-md-12">
                <form id="form-filter" class="form-inline" method="GET" action="<?php echo esc_url(home_url('/filter-movies')); ?>">
                    <div class="col-md-1 col-xs-12 col-sm-6">
                        <div class="filter-box">
                        <div class="filter-box-title"><?php _e('Sort by', 'halimthemes') ?></div>
                            <select class="form-control" id="sort" name="sort">
                                <option value="sort"><?php _e('Sort by', 'halimthemes') ?></option>
                                <option value="posttime"><?php _e('Mới nhất', 'halimthemes') ?></option>
                                <option value="viewcount"><?php _e('Nhiều lượt xem', 'halimthemes') ?></option>
                                <option value="updatetime"><?php _e('Mới cập nhật', 'halimthemes') ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1 col-xs-12 col-sm-6">
                        <div class="filter-box">
                        <div class="filter-box-title"><?php _e('Formats', 'halimthemes') ?></div>
                            <select class="form-control" id="type" name="formality">
                                <option value="formality"><?php _e('Formality', 'halimthemes') ?></option>
                                <option value="movies"><?php _e('Anime Movie', 'halimthemes') ?></option>
                                <option value="tv_series"><?php _e('Anime Bộ', 'halimthemes') ?></option>
                                <option value="tv_shows"><?php _e('TV Shows', 'halimthemes') ?></option>
                                <option value="theater_movie"><?php _e('Theater movie', 'halimthemes') ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <div class="filter-box">
                        <div class="filter-box-title"><?php _e('Status', 'halimthemes') ?></div>
                            <select class="form-control" name="status">
                                <option value="status"><?php _e('Status', 'halimthemes') ?></option>
                                <?php foreach($status as $value): ?>
                                    <option value="<?php echo sanitize_title($value->slug); ?>"><?php echo esc_html($value->name); ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <div class="filter-box">
                        <div class="filter-box-title"><?php _e('Country', 'halimthemes') ?></div>
                            <select class="form-control" name="country">
                                <option value="country"><?php _e('Country', 'halimthemes') ?></option>
                                <?php foreach($country as $value): ?>
                                    <option value="<?php echo sanitize_title($value->slug); ?>">
                                        <?php echo esc_html($value->name); ?>
                                        </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 col-xs-12 col-sm-6">
                        <div class="filter-box">
                        <div class="filter-box-title"><?php _e('Release', 'halimthemes') ?></div>
                            <select class="form-control" name="release">
                                <option value="release"><?php _e('Release', 'halimthemes') ?></option>
                                <?php foreach($release as $year):?>
                                    <option value="<?php echo esc_html($year->slug) ?>"><?php echo esc_html($year->name)?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-12 col-sm-6">
                        <div class="filter-box">
                        <div class="filter-box-title"><?php _e('Genres', 'halimthemes') ?></div>
                            <select class="form-control" id="category" name="category">
                                <option value="category"><?php _e('Genres', 'halimthemes') ?></option>
                                <?php foreach($categories as $cat):?>
                                    <option value="<?php echo esc_html($cat->term_id)?>"><?php echo esc_html($cat->cat_name)?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <button type="submit" id="btn-movie-filter" class="btn btn-danger"><?php _e('Filter movie', 'halimthemes') ?></button>
                    </div>
                </form>
            </div>
        </div><!-- end panel-body -->
        <?php
            $ajax_html = ob_get_clean();
            set_transient('halim_ajax_filter_html', $ajax_html, DAY_IN_SECONDS);
        else :
            $ajax_html = get_transient('halim_ajax_filter_html');
        endif;

        wp_die($ajax_html);
    }
}
add_action('wp_ajax_nopriv_halim_ajax_filter', 'halim_ajax_filter');
add_action('wp_ajax_halim_ajax_filter', 'halim_ajax_filter');


function dashboard_widget_ajax_function()
{
    ob_start();
    $rss = fetch_feed("https://halimthemes.com/feed/");
    $html = '';
    if ( is_wp_error($rss) ) {
        if ( is_admin() || current_user_can( 'manage_options' ) ) {
            $html .= '<p>';
            $html .= '<strong>RSS Error</strong>'.$rss->get_error_message();
            $html .= '</p>';
        }
        return;
    }

    if ( !$rss->get_item_quantity() ) {
        $html .= '<p>Apparently, there are no updates to show!</p>';
        $rss->__destruct();
        unset($rss);
        return;
    }

    if ( !isset($items) )
        $items = 5;

    foreach ( $rss->get_items( 0, $items ) as $item )
    {
        $title = esc_html( $item->get_title() );
        $content = $item->get_content();
        $date = $item->get_date();
        $html .= "<div class='halim-change-log-item'><span class='title'><strong>$title</strong></span><span class='date'>[$date]</span><div class='rssSummary'>$content</div></div>";
    }
    $rss->__destruct();
    unset($rss);
    echo $html;
    $result = ob_get_clean();
    wp_die($result);
}

// add_action( 'wp_ajax_halim_rss_ajax', 'dashboard_widget_ajax_function' );

// add_filter('wp_feed_cache_transient_lifetime', function(){
//     return 3600;
// });