<?php

class halim_related_video_Widget extends WP_Widget
{
	public function __construct() {
		parent::__construct(
			'halim_related_movies',
			__( 'Halim Related Movie', 'halimthemes' ),
			array(
				'classname'   => 'halim_related_movies',
				'description' => __( 'Display related movies', 'halimthemes' )
			)
		);
	}

	function widget($args, $instance)
	{
		global $post;
		extract($args);
		$title = $instance['title'];
		$postnum = $instance['postnum'];
		$type = $instance['type'];
		$related_by = $instance['related_by'];
		echo $before_widget;
		$class = $type == 'slider' ? 'owl-carousel owl-theme' : 'halim_box';
		$meta = get_post_meta($post->ID, '_halim_metabox_options', true);
		$post_format = halim_get_post_format_type($meta['halim_movie_formality']);
		ob_start();
		?>

		<div id="<?php echo $widget_id; ?>xx" class="wrap-slider">
		<?php if($title != '') : ?>
			<div class="section-bar clearfix">
			   <h3 class="section-title"><span><?php echo $title; ?></span></h3>
			</div>
		<?php endif ?>
			<div id="<?php echo $widget_id; ?>" class="<?php echo $class; ?> related-film">
				<?php

					$categories = get_the_category($post->ID);
					if ($categories){
						$category_ids = array();
						foreach ($categories as $individual_category) {
							$category_ids[] = $individual_category->term_id;
						}
					}

					$tags = wp_get_post_terms($post->ID, 'post_tag', ['fields' => 'ids'] );

					$args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'post__not_in'        => array($post->ID),
						'showposts'           => $postnum,
						'orderby'             => 'rand',
						'ignore_sticky_posts' => 1
					);
					if($related_by == 'tag') {
						if($tags) {
							// $args['tag__in'] = $tags;
						    $args['tax_query'] = [
						        [
						            'taxonomy' => 'post_tag',
						            'terms'    => $tags
						        ]
						    ];
						} else {
							$args['category__in'] = $category_ids;
						}
					} else {
						$args['category__in'] = $category_ids;
					}


	                $args['tax_query'] = array(array(
	                    'taxonomy' => 'post_format',
	                    'field' => 'slug',
	                    'terms' => array('post-format-'.$post_format),
	                    'operator' => 'IN'
	                ));

					$wp_query = new WP_Query($args);

					if($related_by == 'tag') {
						if($wp_query->post_count == 0) {
							$args1 = array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'post__not_in'        => array($post->ID),
								'category__in' 			=> $category_ids,
								'showposts'           => $postnum,
								'orderby'             => 'rand',
								'ignore_sticky_posts' => 1,
							);
						    // $args['tax_query'] = [
						    //     [
						    //         'taxonomy' => 'category',
						    //         'field'    => 'id',
						    //         'terms'    => $category_ids,
						    //         'operator' => 'IN'
						    //     ]
						    // ];
							$wp_query = new WP_Query($args1);
						}
					}

					if ($wp_query->have_posts()) {
						echo '';
						while ($wp_query->have_posts())
						{
							$wp_query->the_post();
							if($type == 'slider') {
								HaLimCore::display_post_items('', true);
							} else {
								HaLimCore::display_post_items('4col');
							}
						}
						wp_reset_postdata();
					}
				?>
			</div>
			<?php if($type == 'slider') : ?>
			<script>
				jQuery(document).ready(function($) {
				var owl = $('#<?php echo $widget_id; ?>');
				owl.owlCarousel({loop: true,margin: 4,autoplay: true,autoplayTimeout: 4000,autoplayHoverPause: true,nav: true,navText: ['<i class="hl-down-open rotate-left"></i>', '<i class="hl-down-open rotate-right"></i>'],responsiveClass: true,responsive: {0: {items:2},480: {items:3}, 600: {items:4},1000: {items: 4}}})});
			</script>
			<?php endif; ?>
		</div>
		<?php

		echo $after_widget;
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['postnum'] = $new_instance['postnum'];
		$instance['type'] = $new_instance['type'];
		$instance['related_by'] = $new_instance['related_by'];

		return $instance;
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array(
			'title' 	=> 'Similar movies',
			'postnum' 	=> 8,
			'type'		=> 'slider',
			'related_by' => 'category'
		) );
		extract($instance);

		 ?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'halimthemes') ?></label>
				<br>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
			</p>


			<p>
			<label><?php _e('Related by', 'halimthemes') ?></label>
			<br>
			<?php
			  $fx = array( 'tag' => __('Tag', 'halimthemes'), 'category' => __('Category', 'halimthemes'));
				foreach ($fx as $x => $n ) { ?>
				<label for="<?php echo $this->get_field_id("related_by"); ?>_<?php echo $x ?>">
					<input id="<?php echo $this->get_field_id("related_by"); ?>_<?php echo $x ?>" class="<?php echo $x ?>" name="<?php echo $this->get_field_name("related_by"); ?>" type="radio" value="<?php echo $x ?>" <?php if (isset($related_by)) { checked( $x, $related_by, true ); } ?> /> <?php echo $n ?>
				</label>
			<?php } ?>
			</p>
			<p>
			<label><?php _e('Layout', 'halimthemes') ?></label>
			<br>
			<?php
			  $f = array( 'slider' => __('Slide show', 'halimthemes'), 'grid' => __('Grid box', 'halimthemes'));
				foreach ($f as $x => $n ) { ?>
				<label for="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>">
					<input id="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>" class="<?php echo $x ?>" name="<?php echo $this->get_field_name("type"); ?>" type="radio" value="<?php echo $x ?>" <?php if (isset($type)) { checked( $x, $type, true ); } ?> /> <?php echo $n ?>
				</label>
			<?php } ?>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('postnum'); ?>"><?php _e('Number of post to show', 'halimthemes') ?></label>
				<input type="number" class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('postnum'); ?>" name="<?php echo $this->get_field_name('postnum'); ?>" value="<?php echo $instance['postnum']; ?>" />
			</p>
		<?php
	}
}

add_action('widgets_init', 'halim_related_video_widgets');
function halim_related_video_widgets()
{
	register_widget('halim_related_video_Widget');
}
?>