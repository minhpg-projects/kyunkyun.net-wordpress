<?php

class halim_popular_movie_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'halim_popular_movie-widget',
			__( 'HaLim TOP Movies', 'halimthemes' ),
			array(
				'classname'   => 'halim_popular_movie-widget',
				'description' => __( 'Display popular post by movie', 'halimthemes' )
			)
		);
	}

	function widget($args, $instance)
	{
		global $post;
		extract($args);
		$title = $instance['title'];
		$postnum = $instance['postnum'];
		echo $before_widget;
		if($title != '') :
		ob_start();
		?>
			<div class="section-bar clearfix">
				<div class="section-title">
					<span><?php echo $title; ?></span>
				</div>
			</div>
		<?php endif ?>
	   <section class="tab-content">
			<div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
				<div class="popular-post">
					<?php
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => $postnum,
							'orderby' => 'meta_value_num',
				        	'tax_query' => array(array(
					            'taxonomy' => 'post_format',
					            'field' => 'slug',
					            'terms' => array('post-format-aside'),
					            'operator' => 'IN' //NOT IN
				           	)),
							'meta_query' => array(
								'relation' => 'AND',
								array(
									'key'   => 'halim_view_post_all'
								),
					            // array(
					            //    'key' => '_halim_metabox_options',
					            //    'value' => 'single_movies',
					            //    'compare' => 'LIKE'
					            // )
							),
						);
						$day = new WP_Query( $args );
						if ($day->have_posts()) : while ($day->have_posts()) : $day->the_post();
							HaLimCore::display_popular_post_items('all');
						endwhile; endif; wp_reset_postdata(); ?>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
	<?php
		echo $after_widget;
		$html = ob_get_clean();
		echo $html;
	}
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['postnum'] = $new_instance['postnum'];
		return $instance;
	}

	function form($instance)
	{
		$defaults = array(
			'title' 		=> __('TOP Movies', 'halimthemes'),
			'postnum' 		=> 6,
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'halimthemes') ?></label>
			<br />
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('postnum'); ?>"><?php _e('Number of post to show', 'halimthemes') ?></label>
			<br />
			<input type="number" class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('postnum'); ?>" name="<?php echo $this->get_field_name('postnum'); ?>" value="<?php echo $instance['postnum']; ?>" />
		</p>
	<?php
	}
}

function halim_popular_movie_Widgets(){
	register_widget('halim_popular_movie_Widget');
}
add_action('widgets_init', 'halim_popular_movie_Widgets');