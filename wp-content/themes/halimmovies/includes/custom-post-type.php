<?php

if ( ! function_exists('halim_post_type_tin_tuc') ) {

	function halim_post_type_tin_tuc() {
		// $post_type = cs_get_option('post_typ_news');
		$labels = array(
			'name'                  => __( 'News', 'halimthemes' ),
			'singular_name'         => __( 'News', 'halimthemes' ),
			'menu_name'             => __( 'News', 'halimthemes' ),
			'name_admin_bar'        => __( 'Add news', 'halimthemes' ),
		);
		$args = array(
			'label'                 => __( 'News', 'halimthemes' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields'),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'menu_icon' 			=> 'dashicons-id',
		);
		register_post_type( 'news', $args );
	}
	add_action( 'init', 'halim_post_type_tin_tuc', 1 );
}


if ( ! function_exists( 'halim_taxonomy_tin_tuc' ) ) {

	function halim_taxonomy_tin_tuc() {
		// $taxonomy = cs_get_option('taxonomy_news');
		$labels = array(
			'name'          => __( 'News categories', 'halimthemes' ),
			'singular_name' => __( 'News category', 'halimthemes' ),
			'menu_name'     => __( 'News categories', 'halimthemes' ),
			'all_items'     => __( 'All categories', 'halimthemes' ),
		);
		$rewrite = array(
			'slug'         => 'news-cat',
			'with_front'   => true,
			'hierarchical' => true,
		);
		$args = array(
			'labels'            => $labels,
			'has_archive'       => true,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => false,
			'query_var'         => 'news-cat',
			'rewrite'           => $rewrite,
		);
		register_taxonomy( 'news_cat', array( 'news' ), $args );
	}
	add_action( 'init', 'halim_taxonomy_tin_tuc', 1 );
}

if ( ! function_exists( 'halim_news_tag' ) ) {
	// $taxonomy_tag = cs_get_option('taxonomy_news_tag');
	function halim_news_tag() {

		$labels = array(
			'name'          => __( 'News tags', 'halimthemes' ),
			'singular_name' => __( 'News tag', 'halimthemes' ),
			'menu_name'     => __( 'News tags', 'halimthemes' ),
		);
		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'query_var'         => 'news-tag',
		);
		register_taxonomy( 'news_tag', array( 'news' ), $args );
	}
	add_action( 'init', 'halim_news_tag', 1 );
}


if ( ! function_exists('halim_post_type_video') ) {

	function halim_post_type_video() {
		// $post_type = cs_get_option('post-type-videos');
		$labels = array(
			'name'           => __( 'Videos', 'halimthemes' ),
			'singular_name'  => __( 'Video', 'halimthemes' ),
			'menu_name'      => __( 'Videos', 'halimthemes' ),
			'name_admin_bar' => __( 'Add new video', 'halimthemes' ),
		);
		$args = array(
			'label'               => __( 'Video', 'halimthemes' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields'),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'menu_icon'           => 'dashicons-video-alt3',
		);
		register_post_type( 'video', $args );
	}
	add_action( 'init', 'halim_post_type_video', 1 );
}

if ( ! function_exists( 'halim_taxonomy_video' ) ) {

	function halim_taxonomy_video() {
		// $taxonomy = cs_get_option('taxonomy-videos');
		$labels = array(
			'name'          => __( 'Video Categories', 'halimthemes' ),
			'singular_name' => __( 'Video Category', 'halimthemes' ),
			'menu_name'     => __( 'Video Categories', 'halimthemes' ),
			'all_items'     => __( 'All categories', 'halimthemes' ),
		);
		$rewrite = array(
			'slug'         => 'video-cat',
			'with_front'   => true,
			'hierarchical' => true,
		);
		$args = array(
			'labels'            => $labels,
			'has_archive'       => true,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => false,
			'query_var'         => 'video-cat',
			'rewrite'           => $rewrite,
		);
		register_taxonomy( 'video_cat', array( 'video' ), $args );
	}
	add_action( 'init', 'halim_taxonomy_video', 1 );
}

if ( ! function_exists( 'halim_video_tag' ) ) {

	function halim_video_tag() {
		// $taxonomy_tag = cs_get_option('taxonomy-videos-tag');
		$labels = array(
			'name'          => __( 'Video tags', 'halimthemes' ),
			'singular_name' => __( 'Video tag', 'halimthemes' ),
			'menu_name'     => __( 'Video tags', 'halimthemes' ),
		);
		$rewrite = array(
			'slug'         => 'video-tag',
			'with_front'   => true,
			'hierarchical' => true,
		);
		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'rewrite'           => $rewrite,
		);
		register_taxonomy( 'video_tag', array( 'video' ), $args );
	}
	add_action( 'init', 'halim_video_tag', 1 );
}



function halim_add_actor()
{
	// $taxonomy = cs_get_option('taxonomy-actor');
	$args = array(
    		'labels'            => array(
    			'name'          => 'Actors',
    			'singular'      => 'Actors',
    			'menu-name'     => 'Actors',
    			'all_item'      => 'All actors',
    			'add_new_item'  => 'Add new actor',
    		),
    		'hierarchical'      => false,
    		'public'            => true,
    		'show_ui'           => true,
    		'show_admin_column' => true,
    		'show_tagcloud'     => true,
    		'show_in_nav_menus' => true,
            'show_in_rest'      => true,
		);

	register_taxonomy('actor', 'post', $args);

}
add_action('init', 'halim_add_actor', 0);


function halim_add_director()
{
	// $taxonomy = cs_get_option('taxonomy-director');
    $args = array(
    		'labels' => array(
				'name'          => 'Directors',
				'singular'      => 'Directors',
				'menu-name'     => 'Directors',
				'all_item'      => 'All Directors',
				'add_new_item'  => 'Add new director',
			),
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_tagcloud'     => true,
            'show_in_rest'      => true,
            'show_in_nav_menus' => true
        );
    register_taxonomy('director', 'post', $args);
}
add_action('init', 'halim_add_director', 0);


function halim_add_year()
{
	// $taxonomy = cs_get_option('taxonomy-release');
    $args = array(
    		'labels' => array(
    			'name'          => 'Release',
    			'singular'      => 'Release',
    			'menu-name'     => 'Release',
    			'all_item'      => 'Xem tất cả',
    			'add_new_item'  => 'Add new',
    		),
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_tagcloud'     => true,
            'show_in_rest'      => true,
            'show_in_nav_menus' => true
        );

    register_taxonomy('release', 'post', $args);
}
add_action('init', 'halim_add_year', 0);


function halim_add_country()
{
	// $taxonomy = cs_get_option('taxonomy-country');
    $args = array(
    		'labels' => array(
        		'name'          => 'Country',
        		'singular'      => 'Country',
        		'menu-name'     => 'Country',
        		'all_item'      => 'Xem tất cả',
        		'add_new_item'  => 'Add new country',
        	),
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'show_tagcloud'     => true,
            'show_in_nav_menus' => true
        );

    register_taxonomy('country', 'post', $args);
}
add_action('init', 'halim_add_country', 0);



if ( ! function_exists( 'episode_type_taxonomy' ) ) {

    // Register Custom Taxonomy
    function episode_type_taxonomy() {

        $labels = array(
            'name'                       => _x( 'Episode Types', 'Episode type', 'halimthemes' ),
            'singular_name'              => _x( 'Episode Type', 'Episode type', 'halimthemes' ),
            'menu_name'                  => __( 'Episode Types', 'halimthemes' ),
            'all_items'                  => __( 'All Items', 'halimthemes' ),
            'parent_item'                => __( 'Parent Item', 'halimthemes' ),
            'parent_item_colon'          => __( 'Parent Item:', 'halimthemes' ),
            'new_item_name'              => __( 'New Item Name', 'halimthemes' ),
            'add_new_item'               => __( 'Add New Item', 'halimthemes' ),
            'edit_item'                  => __( 'Edit Item', 'halimthemes' ),
            'update_item'                => __( 'Update Item', 'halimthemes' ),
            'view_item'                  => __( 'View Item', 'halimthemes' ),
            'separate_items_with_commas' => __( 'Separate items with commas', 'halimthemes' ),
            'add_or_remove_items'        => __( 'Add or remove items', 'halimthemes' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'halimthemes' ),
            'popular_items'              => __( 'Popular Items', 'halimthemes' ),
            'search_items'               => __( 'Search Items', 'halimthemes' ),
            'not_found'                  => __( 'Not Found', 'halimthemes' ),
            'no_terms'                   => __( 'No items', 'halimthemes' ),
            'items_list'                 => __( 'Items list', 'halimthemes' ),
            'items_list_navigation'      => __( 'Items list navigation', 'halimthemes' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => false,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
            'show_in_rest'               => true,
        );
        register_taxonomy( 'episode-types', array( 'post' ), $args );

    }
    add_action( 'init', 'episode_type_taxonomy', 0 );

}

// hook into the init action and call custom_post_formats_taxonomies when it fires
add_action( 'init', 'custom_post_formats_taxonomies', 0 );

// create a new taxonomy we're calling 'format'
function custom_post_formats_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Status', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Status', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Status', 'textdomain' ),
		'all_items'         => __( 'All Status', 'textdomain' ),
		'parent_item'       => __( 'Parent Status', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Status:', 'textdomain' ),
		'edit_item'         => __( 'Edit Status', 'textdomain' ),
		'update_item'       => __( 'Update Status', 'textdomain' ),
		'add_new_item'      => __( 'Add New Status', 'textdomain' ),
		'new_item_name'     => __( 'New Status Name', 'textdomain' ),
		'menu_name'         => __( 'Status', 'textdomain' ),
	);


	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'status' ),
		'capabilities' => array(
			'manage_terms' => '',
			'edit_terms' => '',
			'delete_terms' => '',
			'assign_terms' => 'edit_posts'
		),
		'public' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud' => false,
	);
	register_taxonomy( 'status', array( 'post' ), $args ); // our new 'format' taxonomy
}


add_action( 'init', function () {
	$labels = array(
		'name'              => _x( 'Post options', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Post options', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search option', 'textdomain' ),
		'all_items'         => __( 'All options', 'textdomain' ),
		'parent_item'       => __( 'Parent', 'textdomain' ),
		'parent_item_colon' => __( 'Parent', 'textdomain' ),
		'edit_item'         => __( 'Edit', 'textdomain' ),
		'update_item'       => __( 'Update', 'textdomain' ),
		'add_new_item'      => __( 'Add New', 'textdomain' ),
		'new_item_name'     => __( 'New option name', 'textdomain' ),
		'menu_name'         => __( 'Options', 'textdomain' ),
	);


	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'post_options' ),
		'capabilities' => array(
			'manage_terms' => '',
			'edit_terms' => '',
			'delete_terms' => '',
			'assign_terms' => 'edit_posts'
		),
		'public' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud' => false,
	);
	register_taxonomy( 'post_options', array( 'post' ), $args ); // our new 'format' taxonomy
}
, 0 );



add_action( 'init', function() {
	if(!term_exists( 'completed', 'status' )){
		wp_insert_term(
			'Completed',
			'status',
			array(
			  'description'	=> 'Completed',
			  'slug' 		=> 'completed'
			)
		);
	}
	if(!term_exists( 'ongoing', 'status' )) {
		wp_insert_term(
			'Ongoing',
			'status',
			array(
			  'description'	=> 'Ongoing',
			  'slug' 		=> 'ongoing'
			)
		);
	}
	if(!term_exists( 'is_trailer', 'status' )) {
		wp_insert_term(
			'Trailer',
			'status',
			array(
			  'description'	=> 'Trailer',
			  'slug' 		=> 'is_trailer'
			)
		);
	}

	if(!term_exists( 'is_one_slide', 'post_options' )) {
		wp_insert_term(
			'Add to widget "One Slide" (Slider one by one)',
			'post_options',
			array(
			  'description'	=> 'Add to widget "One Slide" (Slider one by one)',
			  'slug' => 'is_one_slide'
			)
		);
	}
	if(!term_exists( 'is_carousel_slide', 'post_options' )){

		wp_insert_term(
			'Add to widget "Carousel Slider"',
			'post_options',
			array(
			  'description'	=> 'Add to widget "Carousel Slider"',
			  'slug' => 'is_carousel_slide'
			)
		);
	}
	if(!term_exists( 'paging_episode', 'post_options' )){

		wp_insert_term(
			'Paging the episode list',
			'post_options',
			array(
			  'description'	=> 'Paging the episode list',
			  'slug' => 'paging_episode'
			)
		);
	}
} );



// make sure there's a default Format type and that it's chosen if they didn't choose one
function halim_default_format_term( $post_id, $post ) {
    if ( 'publish' === $post->post_status ) {
        $defaults = array(
            'status' => 'ongoing' // change 'default' to whatever term slug you created above that you want to be the default
        );
        $taxonomies = get_object_taxonomies( $post->post_type );
        foreach ( (array) $taxonomies as $taxonomy ) {
            $terms = wp_get_post_terms( $post_id, $taxonomy );
            if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
                wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
            }
        }
    }
}
add_action( 'save_post', 'halim_default_format_term', 100, 2 );
