<?php


// add_filter('show_admin_bar', '__return_false');
if(cs_get_option('disable_gutenberg')) add_filter('use_block_editor_for_post', '__return_false');

if(cs_get_option('removing_post_redirect')){
    remove_action( 'template_redirect', 'wp_old_slug_redirect');
    remove_action( 'post_updated', 'wp_check_for_changed_slugs', 12, 3 );
    remove_filter('template_redirect', 'redirect_canonical');
}

function halim_custom_body_class($classes) {
    $corner_rounded = cs_get_option('corner_rounded') ? ' halim-corner-rounded' : '';
    $halim_light_mode = cs_get_option('halim_light_mode') ? ' halim-light-mode' : '';
    $classes[] = 'halimthemes halimmovies'.$corner_rounded.$halim_light_mode;
    return $classes;
}
add_filter('body_class', 'halim_custom_body_class');

function auto_remove_meta($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    $custom_fields = get_post_custom($post_id);
    if (!$custom_fields) {
        return;
    }
    foreach ($custom_fields as $key => $custom_field):
        $values = array_filter($custom_field);
        if (empty($values)):
            delete_post_meta($post_id, $key);
        endif;
    endforeach;
    return;
}
add_action('save_post', 'auto_remove_meta');


function halim_css_attributes_filter($var) {
  return is_array($var) ? array_intersect($var, array('current-menu-item', 'mega')) : '';
}
add_filter('nav_menu_css_class', 'halim_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'halim_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'halim_css_attributes_filter', 100, 1);


add_action( 'before_delete_post', 'halim_remove_attachment_with_post', 10 );
function halim_remove_attachment_with_post($post_id){
    if(has_post_thumbnail( $post_id )){
      $attachment_id = get_post_thumbnail_id( $post_id );
      wp_delete_attachment($attachment_id, true);
    }
}


function remove_thumbnail_width_height( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
add_filter( 'post_thumbnail_html', 'remove_thumbnail_width_height', 10, 5 );

function search_url_rewrite_rule(){
    if (is_search() && isset($_GET['s'])) {
        wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
        exit();
    }
}
add_action('template_redirect', 'search_url_rewrite_rule');

function halim_stop_loading_wp_embed_and_jquery() {
    if (!is_admin()) {
        wp_deregister_script('wp-embed'); //wp_deregister_script('jquery');
    }
}
add_action('init', 'halim_stop_loading_wp_embed_and_jquery');

function html5_style_tag($tag){
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}
add_filter('style_loader_tag', 'html5_style_tag');


function halim_redirect_single_post(){
    if (is_search()) {
        global $wp_query;
        if ($wp_query->post_count == 1) {
            wp_redirect(get_permalink($wp_query->posts['0']->ID));
        }
    }
}
add_action('template_redirect', 'halim_redirect_single_post');

function halim_dequeue_script() {
   wp_dequeue_script( 'apsl-frontend-js' );
}
add_action( 'wp_print_scripts', 'halim_dequeue_script', 100 );

function halim_dequeue_style() {
   wp_dequeue_style( 'fontawsome-css' );
   wp_dequeue_style( 'apsl-frontend-css' );
}
add_action( 'wp_print_styles', 'halim_dequeue_style', 100 );

/* Add the following code in the theme's functions.php and disable any unset function as required */
function remove_default_image_sizes( $sizes ) {

  /* Default WordPress */
  unset( $sizes[ 'thumbnail' ]);          // Remove Thumbnail (150 x 150 hard cropped)
  unset( $sizes[ 'medium' ]);          // Remove Medium resolution (300 x 300 max height 300px)
  unset( $sizes[ 'medium_large' ]);    // Remove Medium Large (added in WP 4.4) resolution (768 x 0 infinite height)
  unset( $sizes[ 'large' ]);           // Remove Large resolution (1024 x 1024 max height 1024px)

//  /* With WooCommerce */
  unset( $sizes[ 'shop_thumbnail' ]);  // Remove Shop thumbnail (180 x 180 hard cropped)
  unset( $sizes[ 'shop_catalog' ]);    // Remove Shop catalog (300 x 300 hard cropped)
  unset( $sizes[ 'shop_single' ]);     // Shop single (600 x 600 hard cropped)

  return $sizes;
}
// add_filter( 'intermediate_image_sizes_advanced', 'remove_default_image_sizes' );
// add_filter('image_size_names_choose', 'remove_default_image_sizes');

// add_filter('max_srcset_image_width', function(){
//     return 1;
// });


function wcr_remove_intermediate_image_sizes($sizes, $metadata) {
    $disabled_sizes = array(
        'thumbnail', // 150x150 image
        'medium', // max 300x300 image
        'large'   // max 1024x1024 image
    );

    // unset disabled sizes
    foreach ($disabled_sizes as $size) {
        if (!isset($sizes[$size])) {
            continue;
        }

        unset($sizes[$size]);
    }

    return $sizes;
}

// add_filter('intermediate_image_sizes_advanced', 'wcr_remove_intermediate_image_sizes', 10, 2);


function remove_extra_image_sizes() {
    foreach ( get_intermediate_image_sizes() as $size ) {
        if ( !in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            remove_image_size( $size );
        }
    }
}

// add_action('init', 'remove_extra_image_sizes');

//delete medium_large thumbnail size
update_option('medium_large_size_w', '0');
update_option('medium_large_size_h', '0');

function halim_change_admin_label() {
    global $menu;
    global $submenu;
    $menu[5][0]                 = __('List movies', 'halimthemes');
    $submenu['edit.php'][5][0]  = __('All posts', 'halimthemes');
    $submenu['edit.php'][10][0] = __('Add new', 'halimthemes');
    $submenu['edit.php'][15][0] = __('Category', 'halimthemes');
    $submenu['edit.php'][16][0] = __('Tags', 'halimthemes');
    echo '';
}
add_action( 'admin_menu', 'halim_change_admin_label' );

function halim_movies_label() {
    global $wp_post_types;
    $labels                     = &$wp_post_types['post']->labels;
    $labels->name               = __('List Movie', 'halimthemes');
    $labels->singular_name      = __('Movie', 'halimthemes');
    $labels->add_new            = __('Add new', 'halimthemes');
    $labels->add_new_item       = __('Add new movie', 'halimthemes');
    $labels->edit_item          = __('Edit', 'halimthemes');
    $labels->new_item           = __('Movie', 'halimthemes');
    $labels->view_item          = __('View post', 'halimthemes');
    $labels->search_items       = __('Search', 'halimthemes');
    $labels->not_found          = __('No result', 'halimthemes');
    $labels->not_found_in_trash = __('No result', 'halimthemes');
}
add_action( 'init', 'halim_movies_label' );


function halim_change_admin_bar_label() {?>
    <script>
        jQuery(document).ready(function($) {
            $('#wp-admin-bar-new-post > a').text('<?php _e('Add new movie', 'halimthemes') ?>');
        });
    </script>
    <?php
}
add_action( 'wp_after_admin_bar_render', 'halim_change_admin_bar_label' );


function halim_cleanup()
{
	// remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
	// remove_action( 'rest_api_init', 'wp_oembed_register_route' );
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'start_post_rel_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head',10,0); // for WordPress >= 3.0
	add_filter( 'embed_oembed_discover', '__return_false' );
}
add_action( 'after_setup_theme', 'halim_cleanup' );


function remove_jquery_migrate( &$scripts){
    if(!is_admin()){
        $scripts->remove( 'jquery');
        $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
    }
}
add_filter( 'wp_default_scripts', 'remove_jquery_migrate' );


// Remove pages from search results
function exclude_pages_from_search($query) {
    if ( $query->is_main_query() && is_search() ) {
        $query->set('post_type', 'post');
        $query->set('posts_per_page',  20);
    }
    return $query;
}
add_filter( 'pre_get_posts','exclude_pages_from_search' );

function replace_admin_menu_icons_css() {
    ?>
    <style>
		.dashicons-admin-post:before {
			content: "\f234";
		}
    </style>
    <?php
}

add_action( 'admin_head', 'replace_admin_menu_icons_css' );

function halim_loginLogo() {
    echo '<style>
        h1 a {
            background-image:url('.HALIM_THEME_URI.'/assets/images/halim-white-logo.png) !important;
            width: 100%!important;
            background-size: 100%!important;
    }
    </style>';
}
add_action('login_head', 'halim_loginLogo');


// Remove pointless post meta boxes
function halim_current_screen() {
    // "This function is defined on most admin pages, but not all."
    if ( function_exists('get_current_screen')) {
        $pt = get_current_screen()->post_type;
        if ( $pt != 'post' && $pt != 'page') return;
        remove_meta_box( 'authordiv', $pt, 'normal' );
        remove_meta_box( 'commentstatusdiv', $pt,'normal' );
        remove_meta_box( 'commentsdiv', $pt, 'normal' );
        // remove_meta_box( 'postcustom', $pt, 'normal' );
        remove_meta_box( 'postexcerpt', $pt, 'normal' );
        remove_meta_box( 'revisionsdiv', $pt, 'normal' );
        remove_meta_box( 'trackbacksdiv', $pt, 'normal' );
    }
}
add_action( 'current_screen', 'halim_current_screen' );


function disable_default_dashboard_widgets() {
    global $wp_meta_boxes;
    // Site Origin Page Builder
    unset($wp_meta_boxes['dashboard']['normal']['core']['so-dashboard-news']);
    // Default
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    // bbpress
    unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);
    // yoast seo
    // unset($wp_meta_boxes['dashboard']['normal']['core']['wpseo-dashboard-overview']);
    // gravity forms
    unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
}

if(current_user_can('manage_options')) {
    add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets', 999);
}



function halim_remove_menu_pages() {
    remove_menu_page('edit-comments.php');
    remove_submenu_page('options-general.php', 'options-discussion.php');
}
add_action( 'admin_menu', 'halim_remove_menu_pages' );


function fb_disable_feed() {
	wp_die( __('No feed available, please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
}
add_action('do_feed', 'fb_disable_feed', 1);
add_action('do_feed_rdf', 'fb_disable_feed', 1);
add_action('do_feed_rss', 'fb_disable_feed', 1);
#add_action('do_feed_rss2', 'fb_disable_feed', 1);
add_action('do_feed_atom', 'fb_disable_feed', 1);
add_action('do_feed_rss2_comments', 'fb_disable_feed', 1);
add_action('do_feed_atom_comments', 'fb_disable_feed', 1);

/**
 * Description: Protect WordPress Against Malicious URL Requests
 * Author: Perishable Press
 */
global $user_ID;
if($user_ID) {
    if(!current_user_can('administrator')) { if (strlen($_SERVER['REQUEST_URI']) > 255 || stripos($_SERVER['REQUEST_URI'], "eval(") || stripos($_SERVER['REQUEST_URI'], "CONCAT") || stripos($_SERVER['REQUEST_URI'], "UNION+SELECT") || stripos($_SERVER['REQUEST_URI'], "base64")) {
            @header("HTTP/1.1 414 Request-URI Too Long");
            @header("Status: 414 Request-URI Too Long");
            @header("Connection: Close");
            @exit;
        }
    }
}

#disable redirect to login page :
#http://wordpress.stackexchange.com/questions/85529/how-to-disable-multisite-sign-up-page
function rbz_prevent_multisite_signup() {
    wp_redirect( site_url() );
    die();
}
add_action( 'signup_header', 'rbz_prevent_multisite_signup' );

//remove xpingback header
function remove_x_pingback($headers) {
    unset($headers['X-Pingback']);
    return $headers;
}
add_filter('wp_headers', 'remove_x_pingback');


/**
 * Disable the emoji's
 */
if(cs_get_option('disable_emojis') == true) {
    function halim_disable_emojis(){
         remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
         remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
         remove_action( 'wp_print_styles', 'print_emoji_styles' );
         remove_action( 'admin_print_styles', 'print_emoji_styles' );
         remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
         remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
         remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    }
    add_action( 'init', 'halim_disable_emojis' );
}


function halim_remove_script_version( $src ){
    $parts = explode( '?ver', $src );
    return $parts[0];
}
// add_filter( 'script_loader_src', 'halim_remove_script_version', 15, 1 );
// add_filter( 'style_loader_src', 'halim_remove_script_version', 15, 1 );


function halim_unregister_default_wp_widgets() {
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
}
add_action('widgets_init', 'halim_unregister_default_wp_widgets', 11);

if ( version_compare( get_bloginfo('version'), '4.9.1', '>=' ) ) {
    DRA_Force_Auth_Error();
} else {
    DRA_Disable_Via_Filters();
}

/**
 * This function is called if the current version of WordPress is 4.7 or above
 * Forcibly raise an authentication error to the REST API if the user is not logged in
 */
function DRA_Force_Auth_Error() {
    if(cs_get_option('halim_disable_restapi'))
        add_filter( 'rest_authentication_errors', 'DRA_only_allow_logged_in_rest_access' );
}

/**
 * This function gets called if the current version of WordPress is less than 4.7
 * We are able to make use of filters to actually disable the functionality entirely
 */
function DRA_Disable_Via_Filters() {

    if(cs_get_option('halim_disable_restapi')) {
    	// Filters for WP-API version 1.x
        add_filter( 'json_enabled', '__return_false' );
        add_filter( 'json_jsonp_enabled', '__return_false' );

        // Filters for WP-API version 2.x
        add_filter( 'rest_enabled', '__return_false' );
        add_filter( 'rest_jsonp_enabled', '__return_false' );

        // Remove REST API info from head and headers
        remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
        remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
        remove_action( 'template_redirect', 'rest_output_link_header', 11 );
    }

}

/**
 * Returning an authentication error if a user who is not logged in tries to query the REST API
 * @param $access
 * @return WP_Error
 */
function DRA_only_allow_logged_in_rest_access( $access ) {

	if( !current_user_can('manage_options') && !is_user_logged_in() ) {
        return new WP_Error( 'rest_cannot_access', __( 'Only authenticated users can access the REST API.', 'halimthemes' ), array( 'status' => rest_authorization_required_code() ) );
    }
    return $access;

}



// add_filter('transient_update_plugins', 'update_active_plugins');    // Hook for 2.8.+
//add_filter('option_update_plugins', 'update_active_plugins');    // Hook for 2.7.x
function update_active_plugins( $value = '' ){
    /*
    The $value array passed in contains the list of plugins with time
    marks when the last time the groups was checked for version match
    The $value->reponse node contains an array of the items that are
    out of date. This response node is use by the 'Plugins' menu
    for example to indicate there are updates. Also on the actual
    plugins listing to provide the yellow box below a given plugin
    to indicate action is needed by the user.
    */
    if( (isset($value->response)) && (count($value->response)) ){

        // Get the list cut current active plugins
        $active_plugins = get_option('active_plugins');
        if ($active_plugins) {

            //  Here we start to compare the $value->response
            //  items checking each against the active plugins list.
            foreach($value->response as $plugin_idx => $plugin_item) {

                // If the response item is not an active plugin then remove it.
                // This will prevent WordPress from indicating the plugin needs update actions.
                if (!in_array($plugin_idx, $active_plugins))
                    unset($value->response[$plugin_idx]);
            }
        }
        else {
             // If no active plugins then ignore the inactive out of date ones.
            foreach($value->response as $plugin_idx => $plugin_item) {
                unset($value->response);
            }
        }
    }
    return $value;
}
