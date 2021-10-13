<?php

function halim_auto_config_yoast_seo()
{
    if(cs_get_option('auto_config_yoast_seo'))
    {
        if(class_exists('WPSEO_Options'))
        {
            WPSEO_Options::save_option( 'wpseo_titles', 'title-post', "%%title%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-video', "%%title%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-news', "%%title%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-page', "%%title%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'noindex-tax-actor', true );
            WPSEO_Options::save_option( 'wpseo_titles', 'noindex-tax-director', true );
            WPSEO_Options::save_option( 'wpseo_titles', 'noindex-tax-release', true );
            WPSEO_Options::save_option( 'wpseo_titles', 'breadcrumbs-enable', true );
            WPSEO_Options::save_option( 'wpseo_titles', 'stripcategorybase', true );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-attachment', "%%title%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-home-wpseo', "%%sitename%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'post_types-post-maintax', "category" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-tax-post_tag', "%%term_title%% %%sep%% %%sitename%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-tax-category', "%%term_title%% %%sep%% %%sitename%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-tax-actor', "%%term_title%% %%sep%% %%sitename%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-tax-director', "%%term_title%% %%sep%% %%sitename%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-tax-release', "%%term_title%% %%sep%% %%sitename%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-tax-country', "%%term_title%% %%sep%% %%sitename%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-tax-post_format', "%%term_title%% %%sep%% %%sitename%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-tax-news_cat', "%%term_title%% %%sep%% %%sitename%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-tax-news_tag', "%%term_title%% %%sep%% %%sitename%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-tax-video_cat', "%%term_title%% %%sep%% %%sitename%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-tax-video_tag', "%%term_title%% %%sep%% %%sitename%%" );
            WPSEO_Options::save_option( 'wpseo_titles', 'disable-author', "off" );
            WPSEO_Options::save_option( 'wpseo_titles', 'title-author-wpseo', "%%name%%, Author at %%sitename%%" );
        }
    }
}
add_action('admin_init', 'halim_auto_config_yoast_seo');


if(function_exists('seopress_get_post_types'))
{
    function seopress_set_default_values() {
        $seopress_titles_options = get_option('seopress_titles_option_name');
        //Post Types
        foreach (seopress_get_post_types() as $seopress_cpt_key => $seopress_cpt_value) {
            $seopress_titles_options['seopress_titles_single_titles'][$seopress_cpt_key]['title'] = '%%post_title%%';
        }
        update_option('seopress_titles_option_name', $seopress_titles_options);
    }
    add_action( 'admin_init', 'seopress_set_default_values', 15 );
    add_filter('seopress_titles_title', 'halim_filter_movie_wpseo_title', 100);
    add_action('seopress_titles_canonical','halim_seopress_titles_canonical');
}


if(class_exists('RankMath')){

    function halim_rank_math_description( $description ) {
        global $post;
        $desc = RankMath\Post::get_meta( 'description', $post->ID );

        if ( ! $desc ) {
            $desc = RankMath\Helper::get_settings( "titles.pt_{$post->post_type}_description" );
            if ( $desc ) {
                return RankMath\Helper::replace_vars( $desc, $post );
            }
        }

        return $description;
    }
    add_action( 'rank_math/frontend/description', 'halim_rank_math_description');
    add_filter( 'rank_math/frontend/canonical', 'halim_custom_canonical', 10, 1);
    add_filter( 'rank_math/frontend/title', 'halim_filter_movie_wpseo_title', 100);
    add_filter( 'rank_math/opengraph/facebook/add_additional_images', 'halim_add_default_opengraph', 10, 1);
    add_filter( 'rank_math/opengraph/twitter/add_additional_images', 'halim_add_default_opengraph', 10, 1);

}

if (!function_exists('halim_get_the_title'))
{
    function halim_get_the_title($post_id)
    {
        $country = $release = '';
        $post_title   = get_the_title($post_id);
        $episode_name = HALIMHelper::is_type('tv_series') ? halim_get_episode_name($post_id) : '';
        $release      = has_term('', 'release') ? get_the_terms($post_id, 'release')[0]->name : '';
        $country      = has_term('', 'country') ? get_the_terms($post_id, 'country')[0]->name : '';
        $meta         = get_post_meta($post_id, '_halim_metabox_options', true );
        $quality      = isset($meta['halim_quality']) ? $meta['halim_quality'] : '';
        $runtime      = isset($meta['halim_runtime']) ? $meta['halim_runtime'] : '';
        $org_title    = isset($meta['halim_original_title']) ? $meta['halim_original_title'] : '';
        $halim_seo_titles_option = get_query_var('halim_action') ? cs_get_option('halim_seo_title_watch_page') : cs_get_option('halim_seo_title');

        $halim_titles_template_variables_array = array(
            '{title}',
            '{episode}',
            '{quality}',
            '{release}',
            '{org_title}',
            '{runtime}',
            '{country}'
        );

        $halim_titles_template_replace_array = array(
            $post_title,
            $episode_name,
            $quality,
            $release,
            $org_title,
            $runtime,
            $country
        );

        $halim_titles_title_template = str_replace($halim_titles_template_variables_array, $halim_titles_template_replace_array, $halim_seo_titles_option);

        return apply_filters( 'halim_seo_title_filter', $halim_titles_title_template);
    }
}

function halim_get_post_meta(){
    global $post;
    $post_id = $post->ID;
    $country = $release = '';
    $post_title   = get_the_title($post_id);
    $episode_name = HALIMHelper::is_type('tv_series') && get_query_var('halim_action') ? halim_get_episode_name($post_id) : '';
    $release      = has_term('', 'release') ? get_the_terms($post_id, 'release')[0]->name : '';
    $country      = has_term('', 'country') ? get_the_terms($post_id, 'country')[0]->name : '';
    $meta         = get_post_meta($post_id, '_halim_metabox_options', true );
    $quality      = isset($meta['halim_quality']) ? $meta['halim_quality'] : '';
    $runtime      = isset($meta['halim_runtime']) ? $meta['halim_runtime'] : '';
    $org_title    = isset($meta['halim_original_title']) ? $meta['halim_original_title'] : '';

    return [
        'post_id' => $post_id,
        'post_title' => $post_title,
        'original_title' => $org_title,
        'episode_name' => $episode_name,
        'country' => $country,
        'release' => $release,
        'quality' => $quality,
        'runtime' => $runtime,
    ];
}



if (!function_exists('halim_add_meta_tags'))
{
    function halim_add_meta_tags()
    {
        global $post;
        if(is_page('filter-movies') || is_page('az-list')) echo '<meta name="robots" content="noindex,nofollow"/>'."\n";

        if(is_single())
        {
            $yoast_meta = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
            if ($yoast_meta) {
                echo '<meta name="description" content="'.$yoast_meta.'" />'."\n";
            } else {
                $desc = halim_string_limit_word(halim_get_the_excerpt($post->ID), 150);
                echo '<meta name="description" content="'.$desc.'" />'."\n";
            }
        }
        if(cs_get_option('halim_fb_apps_id')) echo '<meta property="fb:app_id" content="'.cs_get_option('halim_fb_apps_id').'" />'."\n";
        if(cs_get_option('halim_fb_apps_admin_id')) echo '<meta property="fb:admins" content="'.cs_get_option('halim_fb_apps_admin_id').'" />'."\n";
        if(cs_get_option('msvalidate')) echo '<meta name="msvalidate.01" content="'.cs_get_option('msvalidate').'" />'."\n";
        if(cs_get_option('yandex_verification')) echo '<meta name="yandex-verification" content="'.cs_get_option('yandex_verification').'" />'."\n";
        if(cs_get_option('google_verification')) echo '<meta name="google-site-verification" content="'.cs_get_option('google_verification').'" />'."\n";
        if(cs_get_option('baidu_verification')) echo '<meta name="baidu-site-verification" content="'.cs_get_option('baidu_verification').'" />'."\n";

    }
}
add_action('wp_head', 'halim_add_meta_tags', 2);




if (!function_exists('halim_yoast_change_opengraph_type'))
{
    function halim_yoast_change_opengraph_type($type) {
      if ( is_single() )
        return 'video.movie';
    }
}
add_filter( 'wpseo_opengraph_type', 'halim_yoast_change_opengraph_type', 10, 1 );


if(!function_exists('halim_add_default_opengraph'))
{
    function halim_add_default_opengraph($object)
    {
        if ( !has_post_thumbnail() ) {
            $default_opengraph = halim_image_display();
            $object->add_image($default_opengraph);
        }
    }
}
add_action('wpseo_add_opengraph_images','halim_add_default_opengraph');



function halim_get_episode_name($post_id)
{
    $title = '';
    $ep_slug = str_replace('-', '_', get_query_var('episode_slug'));
    $server = get_query_var('halim_server');
    if($ep_slug) {
        $meta = get_post_meta($post_id, '_halimmovies', true );
        $meta = json_decode($meta, true);
        $title .= $meta[($server-1)]['halimmovies_server_data'][$ep_slug]['halimmovies_ep_name'];
    }
    return apply_filters( 'halim_episode_title_filter', $title);
}

function halim_add_episode_name_to_the_title($title)
{
    $default_episode_name = cs_get_option('halim_episode_name');
    if(!preg_match('/Tập|tập|tap|ep|EP|Ep|Episode|episode|'.$default_episode_name.'/is', $title)) {
        $title = $default_episode_name.' '.$title;
    }
    return $title;
}
add_filter('halim_episode_title_filter', 'halim_add_episode_name_to_the_title');


if(!function_exists('halim_filter_movie_wpseo_title'))
{
    function halim_filter_movie_wpseo_title($title)
    {
        global $post;
        if(is_single()){
            $title = halim_get_the_title($post->ID);
        }
        return apply_filters( 'halim_title_filter', $title);
    }
}
add_filter('wpseo_title', 'halim_filter_movie_wpseo_title', 100);



if(!function_exists('halim_custom_canonical'))
{
    function halim_custom_canonical($canonical){
    	global $wp;
        $eps_query_var = get_query_var('episode_slug');
        if($eps_query_var) {
        	$canonical = home_url( $wp->request );
        }
    	return $canonical;
    }
}
add_filter('wpseo_canonical', 'halim_custom_canonical', 10, 1);
add_filter('get_canonical_url', 'halim_custom_canonical', 10, 2);
add_filter('rank_math/frontend/canonical', 'halim_custom_canonical');
add_filter('redirect_canonical', 'halim_custom_canonical');


function halim_seopress_titles_canonical($html) {
    global $wp;
    $eps_query_var = get_query_var('episode_slug');
    if($eps_query_var) {
        $canonical = home_url( $wp->request );
    }
    $html = '<link rel="canonical" href="'.$canonical.'"/>';
    return $html;
}


function halim_remove_categories_prefix() {
    if(cs_get_option('halim_remove_categories_prefix')) {
        /* actions */
        add_action( 'created_category', 'remove_category_url_refresh_rules' );
        add_action( 'delete_category', 'remove_category_url_refresh_rules' );
        add_action( 'edited_category', 'remove_category_url_refresh_rules' );
        add_action( 'init', 'remove_category_url_permastruct' );

        /* filters */
        add_filter( 'category_rewrite_rules', 'remove_category_url_rewrite_rules' );
        add_filter( 'query_vars', 'remove_category_url_query_vars' );    // Adds 'category_redirect' query variable
        add_filter( 'request', 'remove_category_url_request' );       // Redirects if 'category_redirect' is set
    }
}
add_action('after_setup_theme', 'halim_remove_categories_prefix');


function remove_category_url_refresh_rules() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}

function remove_category_url_deactivate() {
    remove_filter( 'category_rewrite_rules',
        'remove_category_url_rewrite_rules' ); // We don't want to insert our custom rules again
    remove_category_url_refresh_rules();
}

/**
 * Removes category base.
 *
 * @return void
 */
function remove_category_url_permastruct() {
    global $wp_rewrite, $wp_version;

    if ( 3.4 <= $wp_version ) {
        $wp_rewrite->extra_permastructs['category']['struct'] = '%category%';
    } else {
        $wp_rewrite->extra_permastructs['category'][0] = '%category%';
    }
}

/**
 * Adds our custom category rewrite rules.
 *
 * @param  array $category_rewrite Category rewrite rules.
 *
 * @return array
 */
function remove_category_url_rewrite_rules( $category_rewrite ) {
    global $wp_rewrite;

    $category_rewrite = array();

    /* WPML is present: temporary disable terms_clauses filter to get all categories for rewrite */
    if ( class_exists( 'Sitepress' ) ) {
        global $sitepress;

        remove_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ) );
        $categories = get_categories( array( 'hide_empty' => false, '_icl_show_all_langs' => true ) );
        add_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ) );
    } else {
        $categories = get_categories( array( 'hide_empty' => false ) );
    }

    foreach ( $categories as $category ) {
        $category_nicename = $category->slug;
        if ( $category->parent == $category->cat_ID ) {
            $category->parent = 0;
        } elseif ( 0 != $category->parent ) {
            $category_nicename = get_category_parents( $category->parent, false, '/', true ) . $category_nicename;
        }
        $category_rewrite[ '(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$' ] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
        $category_rewrite[ '(' . $category_nicename . ')/page/?([0-9]{1,})/?$' ]                  = 'index.php?category_name=$matches[1]&paged=$matches[2]';
        $category_rewrite[ '(' . $category_nicename . ')/?$' ]                                    = 'index.php?category_name=$matches[1]';
    }

    // Redirect support from Old Category Base
    $old_category_base                                 = get_option( 'category_base' ) ? get_option( 'category_base' ) : 'category';
    $old_category_base                                 = trim( $old_category_base, '/' );
    $category_rewrite[ $old_category_base . '/(.*)$' ] = 'index.php?category_redirect=$matches[1]';

    return $category_rewrite;
}

function remove_category_url_query_vars( $public_query_vars ) {
    $public_query_vars[] = 'category_redirect';

    return $public_query_vars;
}

/**
 * Handles category redirects.
 *
 * @param $query_vars Current query vars.
 *
 * @return array $query_vars, or void if category_redirect is present.
 */
function remove_category_url_request( $query_vars ) {
    if ( isset( $query_vars['category_redirect'] ) ) {
        $catlink = trailingslashit( get_option( 'home' ) ) . user_trailingslashit( $query_vars['category_redirect'],
                'category' );
        status_header( 301 );
        header( "Location: $catlink" );
        exit;
    }

    return $query_vars;
}