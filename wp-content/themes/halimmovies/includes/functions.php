<?php
include_once 'update-checker/plugin-update-checker.php';
include_once 'halim-seo.php';
include_once 'jquery-ajax-script.php';

function isLang($lng = 'vi-VN') {
    return get_bloginfo('language') == $lng ? true : false;
}

function isDomain($string)
{
    // $domain_validation = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
    if(preg_match('/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/', $string)){
        return true;
    }
    return false;
}
function getDomain($url)
{
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
    }
    return false;
}

function isEpisodePagenav($meta) {
    if(isset($meta['halim_add_to_widget']) && is_array($meta['halim_add_to_widget']) && in_array('paging_episode', $meta['halim_add_to_widget'])){
        return true;
    }
    return false;
}

function halim_show_custom_notice()
{
    global $hlapi;
    $screen = get_current_screen();

    if($screen->id == "widgets"): ?>
        <div class="notice notice-success update-available is-dismissible">
            <p><strong>Lưu ý!</strong> Sử dụng nhiều widget có thể làm chậm website một cách đáng kể. Chỉ sử dụng các widget thực sự cần thiết ở trang chủ, trang xem phim, thông tin phim. Hạn chế sử dụng các widget hiển thị các bài viết trùng lặp, các widget chứa hình ảnh có dung lượng cao...</p>
        </div>
    <?php endif;
}
add_action('admin_notices', 'halim_show_custom_notice');

function halim_unlink_tempfix( $data ) {
    if( isset($data['thumb']) ) {
        $data['thumb'] = basename($data['thumb']);
    }
    return $data;
}
add_filter( 'wp_update_attachment_metadata', 'halim_unlink_tempfix' );


function halim_register_query_vars( $vars ) {
    $vars[] = 'halim_action';
    $vars[] = 'halim_server';
    $vars[] = 'episode_slug';
    $vars[] = 'halim_episode';
    $vars[] = 'formality';
    $vars[] = 'status';
    $vars[] = 'country';
    $vars[] = 'release';
    $vars[] = 'category';
    $vars[] = 'sort';
    $vars[] = 'page';
    $vars[] = 'page1';
    $vars[] = 'letter';
    return $vars;
}
add_filter( 'query_vars', 'halim_register_query_vars' );


if(!function_exists('halim_rewrite_rule'))
{
    function halim_rewrite_rule()
    {
        $watch   = cs_get_option('halim_watch_url');
        $episode = cs_get_option('halim_episode_url');
        $server  = cs_get_option('halim_server_url');

        add_rewrite_rule( '^([^/]*)-'.$episode.'-([0-9]+)-'.$server.'-([0-9]+)/?', 'index.php?name=$matches[1]&halim_episode=$matches[2]&halim_server=$matches[3]','top' );
        add_rewrite_rule( '^'.$watch.'/([^/]*)-'.$episode.'-([0-9]+)-'.$server.'-([0-9]+)/?', 'index.php?name=$matches[1]&halim_episode=$matches[2]&halim_server=$matches[3]&halim_action=watch','top' );

        add_rewrite_rule( '^([^/]*)-'.$episode.'-([0-9]+)-'.$server.'([0-9]+)/?', 'index.php?name=$matches[1]&halim_episode=$matches[2]&halim_server=$matches[3]','top' );
        add_rewrite_rule( '^'.$watch.'/([^/]*)-'.$episode.'-([0-9]+)-'.$server.'([0-9]+)/?', 'index.php?name=$matches[1]&halim_episode=$matches[2]&halim_server=$matches[3]&halim_action=watch','top' );


        add_rewrite_rule(
            '^'.$watch.'-([^/]*)/([^/]*)-sv([0-9]+).html?$',
            'index.php?name=$matches[1]&episode_slug=$matches[2]&halim_server=$matches[3]&episode_id=$matches[4]&halim_action=watch','top'
        );


        add_rewrite_rule(
            '^filter-movies/([^/]*)/([^/]*)/([^/]*)/([^/]*)/([^/]*)/([^/]*)/([^/]*)/([^/]*)/?',
            'index.php?pagename=filter-movies&sort=$matches[1]&formality=$matches[2]&status=$matches[3]&country=$matches[4]&release=$matches[5]&category=$matches[6]&page=$matches[7]&page1=$matches[8]','top'
        );

        add_rewrite_rule(
            '^filter-movies/([^/]*)/([^/]*)/([^/]*)/([^/]*)/([^/]*)/([^/]*)/?',
            'index.php?pagename=filter-movies&sort=$matches[1]&formality=$matches[2]&status=$matches[3]&country=$matches[4]&release=$matches[5]&category=$matches[6]','top'
        );
        add_rewrite_rule(
            '^az-list/([^/]*)/([^/]*)/([^/]*)?',
            'index.php?pagename=az-list&letter=$matches[1]&page=$matches[2]&page1=$matches[3]','top'
        );

        add_rewrite_rule(
            '^az-list/([^/]*)?',
            'index.php?pagename=az-list&letter=$matches[1]','top'
        );

        flush_rewrite_rules();
    }
}

add_action('init', 'halim_rewrite_rule', 10, 0);


if(!function_exists('halim_filer_redirect_check'))
{
    function halim_filer_redirect_check()
    {
        if(isset($_GET['sort']))
        {
            if ($_GET['sort'] != '')
            {
                if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]) {
                    $location = 'https://';
                } else {
                    $location = 'http://';
                }
                $location .= $_SERVER['SERVER_NAME'];
                $location .= strtok($_SERVER['REQUEST_URI'],'?');
                $location = trailingslashit($location);
                $location .= $_GET['sort'];
                $location = trailingslashit($location);
                $location .= $_GET['formality'];
                $location = trailingslashit($location);
                $location .= $_GET['status'];
                $location = trailingslashit($location);
                $location .= $_GET['country'];
                $location = trailingslashit($location);
                $location .= $_GET['release'];
                $location = trailingslashit($location);
                $location .= $_GET['category'];
                $location = trailingslashit($location);
                $location .= $_GET['page'];
                $location = trailingslashit($location);
                $location .= $_GET['page1'];
                $location = trailingslashit($location);
                wp_redirect($location);
                exit;
            }
        }
    }
}

add_action('init','halim_filer_redirect_check');



function save_taxonomy_custom_meta($term_id)
{
    if (isset($_POST['term_meta']))
    {
        $t_id      = $term_id;
        $term_meta = get_option("taxonomy_$t_id");
        $cat_keys  = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key)
        {
            if (isset($_POST['term_meta'][$key]))
            {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        update_option("taxonomy_$t_id", $term_meta);
    }
}

function wp_check($key, $value = '', $get = false){
    if($get == true) {
        return get_option($key);
    }
    return update_option($key, $value);
}


/**
 * Display a custom taxonomy dropdown in admin
 * @author Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_action('restrict_manage_posts', 'halim_filter_post_type_by_taxonomy');
function halim_filter_post_type_by_taxonomy() {
    global $typenow;
    $post_type = 'post';
    $taxonomys  = array('release', 'country', 'status');
    if ($typenow == $post_type) {
        foreach ($taxonomys as $taxonomy)
        {
            $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            $info_taxonomy = get_taxonomy($taxonomy);
            wp_dropdown_categories(array(
                'show_option_all' => __("All {$info_taxonomy->label}"),
                'taxonomy'        => $taxonomy,
                'name'            => $taxonomy,
                'orderby'         => 'name',
                'selected'        => $selected,
                'show_count'      => true,
                'hide_empty'      => true,
            ));
        }
    };
}


/**
 * Filter posts by taxonomy in admin
 * @author  Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_filter('parse_query', 'halim_convert_id_to_term_in_query');
function halim_convert_id_to_term_in_query($query) {
    global $pagenow;
    $post_type = 'post';
    $taxonomys  = array('release', 'country', 'status');
    $q_vars    = &$query->query_vars;
    foreach ($taxonomys as $taxonomy)
    {
        if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }
    }

}



function halim_filter_by_the_author() {
    $params = array(
        'name' => 'author', // this is the "name" attribute for filter <select>
        'show_option_all' => 'All authors' // label for all authors (display posts without filter)
    );

    if ( isset($_GET['user']) )
        $params['selected'] = $_GET['user']; // choose selected user by $_GET variable

    wp_dropdown_users( $params ); // print the ready author list
}

add_action('restrict_manage_posts', 'halim_filter_by_the_author');



// add_action( 'restrict_manage_posts', 'add_export_button' );
function add_export_button() {
    $screen = get_current_screen();

    if (isset($screen->parent_file) && ('edit.php' == $screen->parent_file)) {
        ?>
        <input type="submit" name="export_all_posts" id="export_all_posts" class="button button-primary" value="Export All Posts">
        <script>
            jQuery(function($) {
                $('#export_all_posts').insertAfter('#post-query-submit');
            });
        </script>
        <?php
    }
}


// add_action( 'init', 'func_export_all_posts' );
function func_export_all_posts() {
    if(isset($_GET['export_all_posts'])) {
        $arg = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => -1,
            );

        global $post;
        $arr_post = get_posts($arg);
        if ($arr_post) {

            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename="'.sanitize_title(get_bloginfo('name')).'.csv"');
            header('Pragma: no-cache');
            header('Expires: 0');

            $file = fopen('php://output', 'w');

            fputcsv($file, array('Post Title', 'URL'));

            foreach ($arr_post as $post) {
                setup_postdata($post);
                fputcsv($file, array(get_the_title(), get_the_permalink()));
            }

            exit();
        }
    }
}

function add_site_favicon() {
    echo '<link rel="shortcut icon" href="' . HALIM_THEME_URI . '/assets/images/favicon.ico" />';
}
add_action('login_head', 'add_site_favicon');
add_action('admin_head', 'add_site_favicon');




function halimCreatePages(){
    if (is_admin())
    {
        if(!isset(get_page_by_title('Filter Movies')->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => 'Filter Movies',
                'post_content' => 'Filter Movies',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-filter-movies.php');
            }
        }

        if(!isset(get_page_by_title('List movie from A to Z')->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => 'List movie from A to Z',
                'post_content' => 'List movie from A to Z',
                'post_name'    => 'az-list',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-az-listing.php');
            }
        }

        $latest_movie = isLang() ? 'Phim mới' : 'Latest movie';

        if(!isset(get_page_by_title($latest_movie)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $latest_movie,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-latest.php');
            }
        }

        $single_movie = isLang() ? 'Phim lẻ' : 'Anime Movie';
        if(!isset(get_page_by_title($single_movie)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $single_movie,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-movies.php');
            }
        }


        $tv_series = isLang() ? 'Phim bộ' : 'Anime Bộ';
        if(!isset(get_page_by_title($tv_series)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $tv_series,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-tv-series.php');
            }
        }

        $theater_movie = isLang() ? 'Phim chiếu rạp' : 'Theater movie';
        if(!isset(get_page_by_title($theater_movie)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $theater_movie,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-theater-movie.php');
            }
        }

        $tv_shows = isLang() ? 'Phim truyền hình' : 'TV Shows';
        if(!isset(get_page_by_title($tv_shows)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $tv_shows,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-tvshows.php');
            }
        }

        $lastupdate = isLang() ? 'Phim mới cập nhật' : 'Mới cập nhật';
        if(!isset(get_page_by_title($lastupdate)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $lastupdate,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-lastupdate.php');
            }
        }


        $completed = isLang() ? 'Phim hoàn thành' : 'Completed';
        if(!isset(get_page_by_title($completed)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $completed,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-completed.php');
            }
        }

        $mostviewed = isLang() ? 'Phim nổi bật' : 'Nhiều lượt xem';
        if(!isset(get_page_by_title($mostviewed)->ID))
        {
            $new_page_id = wp_insert_post(array(
                'post_type'    => 'page',
                'post_title'   => $mostviewed,
                'post_content' => 'Please do not remove this page!',
                'post_status'  => 'publish',
                'post_author'  => 1,
            ));
            if($new_page_id){
                update_post_meta($new_page_id, '_wp_page_template', 'pages/page-feature-film.php');
            }
        }

    }
}

add_action( 'admin_init', 'halimCreatePages' );


// Delete all custom terms for this taxonomy
// delete_custom_terms('release-year');
function delete_custom_terms($taxonomy){
    global $wpdb;

    $query = 'SELECT t.name, t.term_id
            FROM ' . $wpdb->terms . ' AS t
            INNER JOIN ' . $wpdb->term_taxonomy . ' AS tt
            ON t.term_id = tt.term_id
            WHERE tt.taxonomy = "' . $taxonomy . '"';

    $terms = $wpdb->get_results($query);

    foreach ($terms as $term) {
        wp_delete_term( $term->term_id, $taxonomy );
    }
}


function delete_empty_terms(){
    $taxonomy_name = 'actor';
    $terms = get_terms( array(
        'taxonomy' => $taxonomy_name,
        'hide_empty' => false
    ) );
    foreach ( $terms as $term ) {
        $term_count = $term->count;
        if ($term_count < 1){ wp_delete_term($term->term_id, $taxonomy_name);
        }
    }
}
// add_action( 'wp_head', 'delete_empty_terms' );


function halim_get_post_format_type($type) {
    $post_formats = array(
        'movie' => 'aside',
        'movies' => 'aside',
        'single_movies' => 'aside',
        'tv_series' => 'gallery',
        'tv_shows' => 'video',
        'theater_movie' => 'audio'
    );
    $post_format = $type ? $post_formats[$type] : '';

    return $post_format;
}

function halim_save_custom_post_meta( $post_id )
{
    $currentScreen = get_current_screen();
    if($currentScreen->id == 'post')
    {
        $options = isset($_POST['_halim_metabox_options']) ? $_POST['_halim_metabox_options'] : '';
        if(isset($options['halim_movie_status'])) {
            wp_set_object_terms($post_id, $options['halim_movie_status'], 'status', false);
        }
        if(isset($options['halim_add_to_widget'])){
            wp_set_object_terms($post_id, $options['halim_add_to_widget'], 'post_options', false);
        }
        if(isset($options['halim_movie_formality'])){
            $post_format = halim_get_post_format_type($options['halim_movie_formality']);
            set_post_format($post_id, $post_format);
        }
    }
}
add_action( 'save_post', 'halim_save_custom_post_meta' );


function halim_get_actors($limit = 10)
{
    global $post;
    $html = '';
    $actors = get_the_terms($post->ID, 'actor');
    if(is_array($actors)){
        foreach(array_slice($actors, 0, $limit) as $actor){
            $html .= '<a href="'.home_url($actor->taxonomy . '/' . $actor->slug).'" title="'.$actor->name.'">'.$actor->name.'</a>';
        }
    }
    return $html;
}

function halim_get_country()
{
    global $post;
    $html = '';
    $country = get_the_terms($post->ID, 'country');
    if(is_array($country)){
        foreach($country as $ct){
            $html .= '<a href="'.home_url($ct->taxonomy . '/' . $ct->slug).'" title="'.$ct->name.'">'.$ct->name.'</a>';
        }
    }
    return $html;
}


function halim_get_directors()
{
    global $post;
    $html = '';
    $directors = get_the_terms($post->ID, 'director');
    if(is_array($directors)){
        foreach($directors as $director){
            if($director->name != '') {
                $html .= '<a class="director" href="'.home_url($director->taxonomy . '/' . $director->slug).'" title="'.$director->name.'">'.$director->name.'</a>';
            }
        }
    }
    return $html;
}

function array_value_last(array $array){
    return end($array);
}


function halim_get_last_episode($post_id)
{
    $last_episode = '';
    $metaPost = get_post_meta($post_id, '_halimmovies', true );
    $dataPlayer = json_decode($metaPost, true);
    if($dataPlayer){
        $last_episode = $dataPlayer[0]['halimmovies_server_data'][HALIMHelper::array_key_last($dataPlayer[0]['halimmovies_server_data'])]['halimmovies_ep_name'];
    }
    return $last_episode;
}

function halim_get_first_episode_link($post_id)
{
    $watch_link = '#';
    $watch_slug = cs_get_option('halim_watch_url');
    $post_slug = basename( get_permalink($post_id) );
    $metaPost = get_post_meta($post_id, '_halimmovies', true );
    $dataPlayer = json_decode($metaPost, true);
    if($dataPlayer){
        $episode_slug = $dataPlayer[0]['halimmovies_server_data'][key($dataPlayer[0]['halimmovies_server_data'])]['halimmovies_ep_slug'];
        $watch_link = home_url('/').$watch_slug.'-'.$post_slug.'/'.$episode_slug.'-sv1.html';
    }
    return $watch_link;
}

function halim_get_last_episode_link($post_id)
{
    $watch_link = '#';
    $watch_slug = cs_get_option('halim_watch_url');
    $post_slug = basename( get_permalink($post_id) );
    $metaPost = get_post_meta($post_id, '_halimmovies', true );
    $dataPlayer = json_decode($metaPost, true);
    if($dataPlayer){
        $episode_slug = $dataPlayer[0]['halimmovies_server_data'][HALIMHelper::array_key_last($dataPlayer[0]['halimmovies_server_data'])]['halimmovies_ep_slug'];
        $watch_link = home_url('/').$watch_slug.'-'.$post_slug.'/'.$episode_slug.'-sv1.html';
    }
    return $watch_link;
}

function halim_get_three_last_episode($post_id)
{
    $html = '';
    $type_slug = cs_get_option('halim_url_type');
    $watch_slug = cs_get_option('halim_watch_url');

    $server_slug = cs_get_option('halim_server_url');
    $single_tpl = cs_get_option('single_template');
    $post_slug = basename( get_permalink($post_id) );

    $watch_link = home_url('/').$watch_slug.'-'.$post_slug;

    $episode_slug = get_query_var('episode_slug') ? wp_strip_all_tags(get_query_var('episode_slug')) : '';

    $metaPost = get_post_meta($post_id, '_halimmovies', true );
    $dataPlayer = json_decode($metaPost, true);

    if($dataPlayer)
    {
        $last_eps = array_slice($dataPlayer[0]['halimmovies_server_data'], -3, 3, true);
        $html .= '<p class="lastEp">';
        $html .= '<span>'.__('Tập mới nhất', 'halimthemes').': </span>';
        foreach (array_reverse($last_eps, true) as $key => $value) {
            $html .= '<a href="'.$watch_link.'/'.$value['halimmovies_ep_slug'].'-sv1.html"><span class="last-eps box-shadow">'.$value['halimmovies_ep_name'].'</span></a>';
        }
        $html .= '</p>';
    }
    return $html;
}


function halim_get_last_episode_by_server_id($post_id, $server) {
    $episode_meta = get_post_meta( $post_id, '_halimmovies', true );
    $data = json_decode($episode_meta);
    if($data) {
        foreach ($data as $key => $value) {
            if($key == $server) {

                foreach ($value->halimmovies_server_data as $key => $val) {
                    $lastEl[] = $key;
                }
                $lastEl = end($lastEl);
                preg_match('/(\d+)/is', $lastEl, $lastEp);
                $lastEpisode = $lastEp[1];
            }
        }
        return $lastEpisode;
    }
    return false;
}


/**
* Removes or edits the 'Protected:' and 'Private:' part from posts titles
*/

function remove_private_and_protected_text() {
    return __('%s');
}
add_filter( 'protected_title_format', 'remove_private_and_protected_text' );
add_filter( 'private_title_format', 'remove_private_and_protected_text' );


function oz_run_after_title_meta_boxes() { //https://wpartisan.me/tutorials/wordpress-how-to-move-the-excerpt-meta-box-above-the-editor
    global $post, $wp_meta_boxes;
    # Output the `below_title` meta boxes:
    echo 'xxx';
}
// add_action( 'edit_form_after_title', 'oz_run_after_title_meta_boxes' );



if(!function_exists('halim_custom_password_form'))
{
    function halim_custom_password_form(){
        global $post;
        $post   = get_post( $post );
        $label  = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
        $output = '<div class="halim_password_form"><form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
        <p>' . __( 'This content is password protected. To view it please enter your password below:' ) . '</p>
        <p><label for="' . $label . '"><input name="post_password" id="' . $label . '" class="form-control" type="password" size="20" placeholder="' . __( 'Password' ) . '"/></label>
        <input type="submit" class="btn btn-primary" name="Submit" value="' . esc_attr_x( 'Enter', 'post password form' ) . '" /></p></form></div>';

        return apply_filters( 'halim_password_form', $output );
    }
}

add_filter( 'the_password_form', 'halim_custom_password_form' );

if(!function_exists('halim_get_the_content'))
{
    function halim_get_the_content($content){
        global $post;
        return apply_filters('halim_get_the_content',  wpautop($post->post_content));
    }
}

add_filter( 'the_content', 'halim_get_the_content', 10 );

if(!function_exists('halim_remove_empty_p'))
{
    function halim_remove_empty_p( $content ) {
        $content = force_balance_tags( $content );
        $content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
        $content = preg_replace( '~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content );
        return $content;
    }
}
add_filter('halim_get_the_content', 'halim_remove_empty_p', 20, 1);


function restrict_by_first_letter( $where, $qry ) {
  global $wpdb;
  $sub = $qry->get('substring_where');
  if (!empty($sub)) {
    $where .= $wpdb->prepare(
        " AND SUBSTRING( {$wpdb->posts}.post_title, 1, 1 ) = %s ",
        $sub
    );
  }
  return $where;
}
add_filter( 'posts_where' , 'restrict_by_first_letter', 1 , 2 );


function __active($query, $key){
    $active = $query == $key ? 'active' : '';
    return $active;
}



add_action('admin_bar_menu', 'add_toolbar_items', 100);
function add_toolbar_items($admin_bar){
    global $post;
    $admin_bar->add_menu( array(
        'id'    => 'halim-item',
        'title' => 'HaLim Menu',
        'href'  => admin_url('admin.php?page=halim-core-settings'),
        'meta'  => array(
            'title' => __('HaLim Menu'),
            'class' => 'halim-admin-bar-menu'
        ),
    ));
    $admin_bar->add_menu( array(
        'id'    => 'lcense-manage-item',
        'parent' => 'halim-item',
        'title' => 'License Manager',
        'href'  => admin_url('admin.php?page=halim-core-settings'),
        'meta'  => array(
            'title'  => __('License Manager'),
            'class'  => 'license_menu_item_class'
        ),
    ));

    $admin_bar->add_menu( array(
        'id'    => 'episode-manage-item',
        'parent' => 'halim-item',
        'title' => 'Manage Episodes',
        'href'  => admin_url('admin.php?page=halim-episode-manager'),
        'meta'  => array(
            'title'  => __('Manage Episodes'),
            'target' => '_blank',
            'class'  => 'episode_menu_item_class'
        ),
    ));

    $admin_bar->add_menu( array(
        'id'    => 'theme-options-item',
        'parent' => 'halim-item',
        'title' => 'Theme Options',
        'href'  => admin_url('admin.php?page=halim_options'),
        'meta'  => array(
            'title'  => __('Theme Options'),
            'class'  => 'theme_option_menu_item_class'
        ),
    ));

    $admin_bar->add_menu( array(
        'id'    => 'broken-movie-item',
        'parent' => 'halim-item',
        'title' => 'Broken Movie',
        'href'  => admin_url('admin.php?page=halim-movie-report'),
        'meta'  => array(
            'title' => __('Broken Movie'),
            'class' => 'broken_movie_menu_item_class'
        ),
    ));

    if(is_single()) {
        $admin_bar->add_menu( array(
            'id'    => 'edit-episode-item',
            'parent' => 'halim-item',
            'title' => 'Edit Episodes',
            'href'  => admin_url('admin.php?page=halim-episode-manager&act=edit_ep&post_id='.$post->ID.'&server=0'),
            'meta'  => array(
                'title' => __('Edit Episodes'),
                'class' => 'edit_episode_menu_item_class'
            ),
        ));
    }
}


if (!function_exists('halim_array_key_first')) {
    function halim_array_key_first(array $arr) {
        foreach($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}

function __selected($query, $key){
    $active = $query == $key ? ' selected' : '';
    return $active;
}

function getPlayerTypes($type = 'link'){

    $taxonomies = get_terms('episode-types', array('hide_empty' => false));
    $type = apply_filters( 'halim_episode_type', $type );
    ?>
        <option value="link" <?php selected($type, 'link' ); ?>>Link</option>
        <option value="mp4" <?php selected($type, 'mp4' ); ?>>MP4 file</option>
        <option value="embed" <?php selected($type, 'embed' ); ?>>Embed</option>
    <?php
    if ( !empty($taxonomies) ) :
        foreach( $taxonomies as $category ) { ?>
            <option value="<?php echo esc_attr( $category->slug ); ?>" <?php selected($type, $category->slug ); ?>><?php echo esc_html( $category->name ); ?></option>
        <?php
        }
    endif;
}

function getPlayerTypesJs($type = 'link'){
    $taxonomies = get_terms('episode-types', array('hide_empty' => false));
    $type = apply_filters( 'halim_episode_type', $type );
    $html = '';
    $html .= '<option value="link"'.__selected($type, 'link' ).'>Link</option><option value="mp4"'.__selected($type, 'mp4' ).'>MP4 file</option><option value="embed"'.__selected($type, 'embed' ).'>Embed</option>';
    if ( !empty($taxonomies) ) :

        foreach( $taxonomies as $category ) {
            $html .= '<option value="'.$category->slug.'"'.__selected($type, $category->slug).'>'.$category->name.'</option>';
        }
    endif;
    return $html;
}

function getPlayerTypesAsText(){
    $taxonomies = get_terms('episode-types', array('hide_empty' => false));
    $html = '';
    if ( !empty($taxonomies) ) :
        foreach( $taxonomies as $category ) {
            $html .= $category->slug.', ';
        }
    endif;
    return $html;
}

function check_plugin_active(){
    global $core;
    if(!class_exists('HaLimCore_API')) {
        wp_die('<strong><a href="wp-admin/plugins.php?plugin_status=inactive"><span style="color:red;">HaLimCore</span></a> '.__('plugin is required. Please activate it before activating this theme!', 'halimthemes').'</strong>');
    }
}
add_action('wp', 'check_plugin_active');
