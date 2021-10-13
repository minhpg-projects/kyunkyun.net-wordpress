<?php

class halimRecentViewedPosts extends WP_Widget {
	// Constructor
	function __construct() {
		parent::__construct( 'halim_recent_viewed_posts', // Base ID
			'HaLim Posts Viewed Recently', // Name
			array(
				'description' => __( 'Displays recent viewed posts by a visitor as a responsive sidebar widget', 'halimthemes' )
			) // Args
		);
	}

	// Widget form creation
	function form( $instance ) {
		$widgetID = str_replace( 'halim_recent_viewed_posts-', '', $this->id );
		// Check values
		$title              = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Posts Viewed Recently';
		$numberofposts      = isset( $instance['numberofposts'] ) ? absint( $instance['numberofposts'] ) : 5;
		// $show_view          = isset( $instance['show_view'] ) ? (bool) $instance['show_view'] : false;

		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'halimthemes' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'numberofposts' ); ?>"><?php _e( 'Number of posts to show:', 'halimthemes' );	?></label>
            <input id="<?php echo $this->get_field_id( 'numberofposts' ); ?>" name="<?php echo $this->get_field_name( 'numberofposts' ); ?>" type="number" value="<?php echo $numberofposts; ?>"/>
        </p>
<!--         <p>
        	<input class="checkbox" type="checkbox" <?php checked( $show_view ); ?> id="<?php echo $this->get_field_id( 'show_view' ); ?>" name="<?php echo $this->get_field_name( 'show_view' ); ?>"/>
        	<label for="<?php echo $this->get_field_id( 'show_view' ); ?>"><?php _e( 'Display post view?', 'halimthemes' ); ?></label>
        </p> -->
	<?php if ( $widgetID != "__i__" ) { ?>
<!-- 		<p style="font-size: 11px; opacity:0.6">
			<span class="shortcodeTtitle">Shortcode:</span>
			<span class="shortcode">[halim-recentlyviewed widget_id="<?php echo $widgetID; ?>"]</span>
		</p> -->
	<?php
		} // End widget id check
	}

	// Widget update
	function update( $new_instance, $old_instance ) {
		$old_instance['title']              = isset( $new_instance['title'] ) ? $new_instance['title'] : '';
		$old_instance['numberofposts']      = isset( $new_instance['numberofposts'] ) ? absint( $new_instance['numberofposts'] ) : '';
		// $old_instance['show_view']          = isset( $new_instance['show_view'] ) ? (bool) $new_instance['show_view'] : false;

		return $old_instance;
	}

	// Widget display
	function widget( $args, $instance1 ) {

		// Check cookie existence
		$halim_cookie_posts = isset( $_COOKIE['halim_recent_posts'] ) ? json_decode( $_COOKIE['halim_recent_posts'], true ) : null;

		if ( isset( $halim_cookie_posts ) ) {
			// Remove current post
			$halim_cookie_posts = array_diff( $halim_cookie_posts, array( get_the_ID() ) );
			// Cookie posts count check after current post removal
			if ( count( $halim_cookie_posts ) > 0 ):

				$widgetID           = $args['widget_id'];
				$widgetID           = str_replace( 'halim_recent_viewed_posts-', '', $widgetID );
				$widgetOptions      = get_option( $this->option_name );
				$instance1          = $widgetOptions[ $widgetID ];
				$title              = ( ! empty( $instance1['title'] ) ) ? $instance1['title'] : __( 'Recently Visited Posts' );
				$title              = apply_filters( 'widget_title', $title, $instance1, $this->id_base );
				$number             = ( ! empty( $instance1['numberofposts'] ) ) ? absint( $instance1['numberofposts'] ) : 5;
				$lazyload = cs_get_option('halim_lazyload_image');
				// $show_view          = isset( $instance1['show_view'] ) ? $instance1['show_view'] : false;
				extract( $args, EXTR_SKIP );
				?>
				<div class="section-bar clearfix">
					<div class="section-title">
						<span><?php echo $title; ?></span>
					</div>
				</div>
			   <section class="tab-content">
					<div role="tabpanel" class="tab-pane active">
						<div class="popular-post">
							<?php

								$list_ids = implode(',', array_values($halim_cookie_posts));
								$args = array(
								    'post_type' => 'post',
								    'numberposts' => $number,
								    'order'	=> 'DESC',
								    'post__in' => is_array($list_ids) ? array_values($list_ids) : array()
								);
								// if($list_ids){
								// 	$args['post__in'] = array_values($list_ids);
								// }
								$posts = get_posts($args);

								foreach ($posts as $post) {
									$permalink = esc_url( get_permalink( $post->ID ) );
									    $meta = get_post_meta($post->ID, '_halim_metabox_options', true );
									    $org_title = isset($meta['halim_original_title']) ? $meta['halim_original_title'] : '';
									    $thumbnail = isset($meta['halim_thumb_url']) ? $meta['halim_thumb_url'] : '';
										if ( has_post_thumbnail($post->ID) ) {
											$image_id = get_post_thumbnail_id($post->ID);
											$image_url = wp_get_attachment_image_src($image_id, 'movie-thumb');
											$image_url = $image_url[0];
										} else {
											$image_url = $thumbnail;
										}

										?>
									    <div class="item post-<?php echo $post->ID; ?>">
									        <a href="<?php echo $permalink;?>" title="<?php echo esc_html($post->post_title); ?>">
									            <div class="item-link">
									            	<?php if($lazyload) : ?>
									                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo esc_url($image_url) ?>" class="lazyload blur-up post-thumb" alt="<?php echo esc_html($post->post_title); ?>" title="<?php echo esc_html($post->post_title); ?>" />
									                <?php else : ?>
									                <img src="<?php echo esc_url($image_url) ?>" class="post-thumb" alt="<?php echo esc_html($post->post_title); ?>" title="<?php echo esc_html($post->post_title); ?>" />
									            	<?php endif; ?>
									                <?php
									                if(HALIMHelper::is_status('is_trailer')){
									                    echo '<span class="is_trailer">Trailer</span>';
									                }  ?>
									            </div>
									            <h3 class="title"><?php echo esc_html($post->post_title); ?></h3>
									            <?php if($org_title) echo '<p class="original_title">'.esc_html($org_title).'</p>'; ?>
									        </a>
									        <div class="viewsCount"><?php echo halim_display_post_view_count($post->ID, 'all') ?> <?php _e('view', 'halimthemes') ?></div>
									    </div>
									<?php
								}
								wp_reset_query();
							?>
						</div>
					</div>
				</section>

				<div class="clearfix"></div>
				<?php
			endif; // Cookie posts count check end
		} // Cookie existence condition ends here
	} // Widget function end here
} // Class ends


// Register the widget
function halim_register_widget() {
	register_widget( 'halimRecentViewedPosts' );
}
add_action( 'widgets_init', 'halim_register_widget' );


function halim_posts_visited() {
	if ( is_single() || is_page() ) {
		$cookie    = 'halim_recent_posts';
		$posts = isset( $_COOKIE[ $cookie ] ) ? json_decode( $_COOKIE[ $cookie ], true ) : null;
		if ( isset( $posts ) ) {
			// Remove current post in the cookie
			$posts = array_diff( $posts, array( get_the_ID() ) );
			// update cookie with current post
			array_unshift( $posts, get_the_ID() );
		} else {
			$posts = array( get_the_ID() );
		}
		setcookie( $cookie, json_encode( $posts ), time() + ( DAY_IN_SECONDS * 31 ), COOKIEPATH, COOKIE_DOMAIN );
	}
}
add_action( 'template_redirect', 'halim_posts_visited' );


function halim_shortcode_recentlyViewed( $atts ) {
	// Configure defaults and extract the attributes into variables
	ob_start();
	the_widget( 'halimRecentViewedPosts');
	$output = ob_get_clean();

	return $output;
}

add_shortcode( 'halim-recentlyviewed', 'halim_shortcode_recentlyViewed' );