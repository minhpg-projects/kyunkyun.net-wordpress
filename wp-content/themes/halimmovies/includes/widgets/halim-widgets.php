<?php

function halim_add_buttom_episode_manager() {
    add_meta_box('halim_add_buttom_episode_manager', __('Manage Episode', 'halimthemes'), 'halim_button_eps_manager','post', 'side', 'high');
}
add_action('add_meta_boxes', 'halim_add_buttom_episode_manager');
function halim_button_eps_manager() {
    echo '<style>
            select#halim_custom_sidebar {
                width: 100%;
            }
            #halim_add_buttom_episode_manager .inside {
                display: grid;
            }
            .btn-add-ep {
                background-image: linear-gradient(to right, #4c8c11 0%, #9dd249 100%, #62882b 100%);
                padding: 10px;
                text-align: center;
                color: #fff;
                font-size: 16px;
                font-weight: 700;
                text-decoration: none;
                border-radius: 3px;
            }
            .btn-add-ep:hover {
                color: #fff
            }
        </style>';
    $post_id = isset($_GET['post']) ? $_GET['post'] : '';
    if($post_id)
        // echo '<a class="btn-add-ep" href="'.admin_url('admin.php?page=halim-episode-manager&act=add_new_ep&post_id='.$post_id.'&server=0').'">Manage Episode</a>';
        echo '<a class="btn-add-ep" href="'.admin_url('admin.php?page=halim-episode-manager&act=edit_ep&post_id='.$post_id.'&server=0&episode=1&paged=1&cat=').'">Manage Episode</a>';
    else
        echo '<strong style="color:red">Please publish post before you can edit episodes</strong>';
}

// Widget lists
include_once HALIM_INC_WIDGET.'/halim-latest-post.php';
include_once HALIM_INC_WIDGET.'/halim-trailer-widget.php';
include_once HALIM_INC_WIDGET.'/halim-advanced-widget.php';
include_once HALIM_INC_WIDGET.'/halim-news-box-widget.php';
include_once HALIM_INC_WIDGET.'/halim-tag-cloud-widget.php';
include_once HALIM_INC_WIDGET.'/halim-video-box-widget.php';
include_once HALIM_INC_WIDGET.'/halim-popular-tab-widget.php';
include_once HALIM_INC_WIDGET.'/halim-popular-movie.php';
include_once HALIM_INC_WIDGET.'/halim-popular-tv-series.php';
include_once HALIM_INC_WIDGET.'/halim-latest-update.php';
include_once HALIM_INC_WIDGET.'/halim-vertical-widget.php';
include_once HALIM_INC_WIDGET.'/halim-recent-viewed-post.php';
include_once HALIM_INC_WIDGET.'/halim-related-video-widget.php';
include_once HALIM_INC_WIDGET.'/halim-carousel-slider-widget.php';
include_once HALIM_INC_WIDGET.'/halim-category-widget.php';
include_once HALIM_INC_WIDGET.'/halim-tv-series-widget.php';
include_once HALIM_INC_WIDGET.'/halim-movies-widget.php';
include_once HALIM_INC_WIDGET.'/halim-tv-shows-widget.php';
include_once HALIM_INC_WIDGET.'/halim-theater-movie-widget.php';
include_once HALIM_INC_WIDGET.'/halim-carousel-fullwidth-slider-widget.php';

/*-----------------------------------------------------------------------------------*/
/*	Enable Widgetized sidebar and Footer
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'register_sidebar' ) ) {
    function halim_register_sidebars() {
        $register_sidebar = cs_get_option('halim_register_sidebars');

        register_sidebar(array(
            'id'            => 'sidebar',
            'name'          => 'Sidebar Widget',
            'description'   => 'Khu vực widget hiển thị danh sách phim ở Sidebar (Vui lòng chèn các widget "HaLim TOP TV-Series", "HaLim TOP Movies", "HaLim Trailer Widget", "HaLim Posts Viewed Recently", "HaLim Polpular Movies" và các widget HTML tùy chỉnh)',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ));

        register_sidebar(array(
            'id'            => 'home-widget',
            'name'          => 'Homepage Widget',
            'description'   => 'Khu vực widget hiển thị danh sách phim, có thể chèn widget bất kì (Đề xuất: "HaLim Movies Widget", "HaLim TV-Series Widget", "HaLim Vertical Widget", "HaLim Category Widget" và các widget HTML tùy chỉnh)',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '',
            'after_title'   => '',
        ));

        register_sidebar(array(
            'id'            => 'bs-slider',
            'name'          => 'HaLim One Slide (Slider one by one)',
            'description'   => 'Khu vực widget hiển thị danh sách phim bằng thanh trượt (Widget HaLim One Slide - Slider one by one), có thể chèn thêm các widget khác',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '',
            'after_title'   => '',
        ));

        register_sidebar(array(
            'id'            => 'carousel-widget',
            'name'          => 'HaLim Carousel Slider',
            'description'   => 'Khu vực widget hiển thị danh sách phim bằng thanh trượt (Widget HaLim Carousel Slider), có thể chèn thêm các widget khác',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '',
            'after_title'   => '',
        ));


        register_sidebar(array(
            'id'            => 'related-video',
            'name'          => 'Related Movies',
            'description'   => 'Khu vực widget hiển thị phim cùng thể loại, có thể chèn thêm các widget khác',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '',
            'after_title'   => '',
        ));

        register_sidebar(array(
            'id'            => 'halim-ad-above-player',
            'name'          => 'Advertise above the player',
            'description'   => 'Khu vực widget hiển thị quảng cáo ở phía trên trình phát video',
            'before_widget' => '<div class="text-center">',
            'after_widget'  => '</div>',
            'before_title'  => '',
            'after_title'   => '',
        ));

        register_sidebar(array(
            'id'            => 'halim-ad-below-player',
            'name'          => 'Advertise below the player',
            'description'   => 'Khu vực widget hiển thị quảng cáo ở phía dưới trình phát video',
            'before_widget' => '<div class="text-center">',
            'after_widget'  => '</div>',
            'before_title'  => '',
            'after_title'   => '',
        ));

        register_sidebar(array(
            'id'            => 'halim-ad-above-category',
            'name'          => 'Advertise above the category, page, search, tag',
            'description'   => 'Khu vực widget hiển thị quảng cáo ở phía trên trang thể loại, trang tùy chỉnh, trang tìm kiếm, trang từ khóa',
            'before_widget' => '<div class="text-center">',
            'after_widget'  => '</div>',
            'before_title'  => '',
            'after_title'   => '',
        ));

        register_sidebar(array(
            'id'            => 'halim-ad-below-category',
            'name'          => 'Advertise below the category, page, search, tag',
            'description'   => 'Khu vực widget hiển thị quảng cáo ở phía dưới trang thể loại, trang tùy chỉnh, trang tìm kiếm, trang từ khóa',
            'before_widget' => '<div class="text-center">',
            'after_widget'  => '</div>',
            'before_title'  => '',
            'after_title'   => '',
        ));

        register_sidebar( array(
            'name'          => 'Footer',
            'id'            => 'footer',
            'description'   => 'Khu vực widget hiển thị ở footer, có thể chèn các widget HTML tùy chỉnh (Liên kết, banner...), Widget chuyên mục, Widget Thanh điều hướng...',
            'before_widget' => '<div id="%1$s" class="widget %2$s col-xs-12 col-sm-6 col-md-4">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );

        // Custom sidebars
        if ( !empty( $register_sidebar ) && is_array( $register_sidebar )) {
            foreach( $register_sidebar as $sidebar ) {
                if ( !empty( $sidebar['halim_custom_sidebar_id'] ) && !empty( $sidebar['halim_custom_sidebar_id'] ) && $sidebar['halim_custom_sidebar_id'] != 'sidebar-' ) {
                    register_sidebar( array( 'name' => ''.$sidebar['halim_custom_sidebar_name'].'', 'id' => ''.sanitize_title( strtolower( $sidebar['halim_custom_sidebar_id'] )).'', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3>', 'after_title' => '</h3>' ));
                }
            }
        }


    }

    add_action( 'widgets_init', 'halim_register_sidebars' );
}

function halim_custom_sidebar() {
    $halim_sidebar = cs_get_option('halim_sidebar_section');

	// Default sidebar
	$sidebar = 'sidebar';

	if ( is_home() && !empty( $halim_sidebar['sidebar_homepage'] )) $sidebar = $halim_sidebar['sidebar_homepage'];
    if ( is_single() && !empty( $halim_sidebar['sidebar_single_post'] )) $sidebar = $halim_sidebar['sidebar_single_post'];

    if ( is_page() && !empty( $halim_sidebar['sidebar_page'] )) $sidebar = $halim_sidebar['sidebar_page'];

    // Archives
	if ( is_archive() && !empty( $halim_sidebar['sidebar_archive'] )) $sidebar = $halim_sidebar['sidebar_archive'];
	if ( is_category() && !empty( $halim_sidebar['sidebar_category'] )) $sidebar = $halim_sidebar['sidebar_category'];
    if ( is_tag() && !empty( $halim_sidebar['sidebar_tag'] )) $sidebar = $halim_sidebar['sidebar_tag'];
    if ( is_date() && !empty( $halim_sidebar['sidebar_date'] )) $sidebar = $halim_sidebar['sidebar_date'];

    // Other
    if ( is_search() && !empty( $halim_sidebar['sidebar_search'] )) $sidebar = $halim_sidebar['sidebar_search'];
	if ( is_404() && !empty( $halim_sidebar['sidebar_404'] )) $sidebar = $halim_sidebar['sidebar_404'];


	// Page/post specific custom sidebar
	if ( is_page() || is_single() ) {
		wp_reset_postdata();
		global $post;
        $custom = get_post_meta( $post->ID, '_halim_custom_sidebar', true );
		if ( !empty( $custom )) $sidebar = $custom;
	}

	return $sidebar;
}


/*-----------------------------------------------------------------------------------*/
/*  Sidebar Selection meta box
/*-----------------------------------------------------------------------------------*/
function halim_add_sidebar_metabox() {
    $screens = array('post', 'page', 'news', 'video');
    foreach ($screens as $screen) {
        add_meta_box(
            'halim_sidebar_metabox',                  // id
            __('Sidebar', 'halimthemes'),    // title
            'halim_inner_sidebar_metabox',            // callback
            $screen,                                // post_type
            'side',                                 // context (normal, advanced, side)
            'high'                               // priority (high, core, default, low)
                                                    // callback args ($post passed by default)
        );
    }
}
add_action('add_meta_boxes', 'halim_add_sidebar_metabox');


/**
 * Print the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function halim_inner_sidebar_metabox($post) {
    global $wp_registered_sidebars;

    // Add an nonce field so we can check for it later.
    wp_nonce_field('halim_inner_sidebar_metabox', 'halim_inner_sidebar_metabox_nonce');

    /*
    * Use get_post_meta() to retrieve an existing value
    * from the database and use the value for the form.
    */
    $custom_sidebar = get_post_meta( $post->ID, '_halim_custom_sidebar', true );
    // $sidebar_location = get_post_meta( $post->ID, '_halim_sidebar_location', true );

    // Select custom sidebar from dropdown
    echo '<select name="halim_custom_sidebar" id="halim_custom_sidebar" style="margin-bottom: 10px;">';
    echo '<option value="" '.selected('', $custom_sidebar).'>-- '.__('Default', 'halimthemes').' --</option>';

    // Exclude built-in sidebars
    $hidden_sidebars = array('sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar');

    foreach ($wp_registered_sidebars as $sidebar) {
        if (!in_array($sidebar['id'], $hidden_sidebars)) {
            echo '<option value="'.esc_attr($sidebar['id']).'" '.selected($sidebar['id'], $custom_sidebar, false).'>'.$sidebar['name'].'</option>';
        }
    }
    echo '<option value="halim_nosidebar" '.selected('halim_nosidebar', $custom_sidebar).'>-- '.__('No sidebar --', 'halimthemes').'</option>';
    echo '</select><br />';

    // Select single layout (left/right sidebar)
    // echo '<div class="halim_sidebar_location_fields">';
    // echo '<label for="halim_sidebar_location_default" style="display: inline-block; margin-right: 20px;"><input type="radio" name="halim_sidebar_location" id="halim_sidebar_location_default" value=""'.checked('', $sidebar_location, false).'>'.__('Default side', 'halimthemes').'</label>';
    // echo '<label for="halim_sidebar_location_left" style="display: inline-block; margin-right: 20px;"><input type="radio" name="halim_sidebar_location" id="halim_sidebar_location_left" value="left"'.checked('left', $sidebar_location, false).'>'.__('Left', 'halimthemes').'</label>';
    // echo '<label for="halim_sidebar_location_right" style="display: inline-block; margin-right: 20px;"><input type="radio" name="halim_sidebar_location" id="halim_sidebar_location_right" value="right"'.checked('right', $sidebar_location, false).'>'.__('Right', 'halimthemes').'</label>';
    // echo '</div>';

    ?>
<!--     <script>
        jQuery(document).ready(function($) {
            function halim_toggle_sidebar_location_fields() {
                $('.halim_sidebar_location_fields').toggle(($('#halim_custom_sidebar').val() != 'halim_nosidebar'));
            }
            halim_toggle_sidebar_location_fields();
                $('#halim_custom_sidebar').change(function() {
                halim_toggle_sidebar_location_fields();
            });
        });
    </script> -->
    <?php
    //debug
    //global $wp_meta_boxes;
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function halim_save_custom_sidebar( $post_id ) {

    /*
    * We need to verify this came from our screen and with proper authorization,
    * because save_post can be triggered at other times.
    */

    // Check if our nonce is set.
    if ( ! isset( $_POST['halim_inner_sidebar_metabox_nonce'] ) )
    return $post_id;

    $nonce = $_POST['halim_inner_sidebar_metabox_nonce'];

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'halim_inner_sidebar_metabox' ) )
      return $post_id;

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return $post_id;

    // Check the user's permissions.
    if ( 'page' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;

    } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
    }

    /* OK, its safe for us to save the data now. */

    // Sanitize user input.
    $sidebar_name = sanitize_text_field( $_POST['halim_custom_sidebar'] );
    // $sidebar_location = sanitize_text_field( $_POST['halim_sidebar_location'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, '_halim_custom_sidebar', $sidebar_name );
    // update_post_meta( $post_id, '_halim_sidebar_location', $sidebar_location );

}
add_action( 'save_post', 'halim_save_custom_sidebar' );