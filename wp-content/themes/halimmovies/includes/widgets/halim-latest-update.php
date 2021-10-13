<?php

class halim_latest_update_movie_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'halim_latest_update_movie-widget',
			__( 'Latest update movie', 'halimthemes' ),
			array(
				'classname'   => 'halim_latest_update_movie-widget',
				'description' => __( 'Display Latest Updated Movie & TV Series', 'halimthemes' )
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
		echo $before_widget;
		ob_start();
		?>

	   	<section class="col-md-6">

			<div class="section-bar clearfix">
				<div class="section-title">
					<span><?php echo $title; ?></span>
				</div>
			</div>
			<div class="popular-post">
				<?php
					$value = $type == 'movie' ? 'single_movies' : 'tv_series';
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => $postnum,
						'orderby' => 'modified',
						'meta_query' => array(
				            array(
				               'key' => '_halim_metabox_options',
				               'value' => $value,
				               'compare' => 'LIKE'
				            )
						),
					);
					$day = new WP_Query( $args );
					if ($day->have_posts()) : while ($day->have_posts()) : $day->the_post();
						HaLimCore::display_popular_post_items('all', true);
					endwhile; endif; wp_reset_postdata(); ?>
			</div>
		</section>
	<?php
		echo $after_widget;
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['postnum'] = $new_instance['postnum'];
		$instance['type'] = $new_instance['type'];
		return $instance;
	}

	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array(
			'title' 	=> '',
			'postnum' 	=> 5,
			'type'		=> 'movie'
		) );
		extract($instance);

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'halimthemes') ?></label>
			<br />
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label><?php _e('Type', 'halimthemes') ?></label>
			<br>
			<?php
			  $f = array( 'movie' => __('Movie', 'halimthemes'), 'tv_series' => __('Anime Bộ', 'halimthemes'));
				foreach ($f as $x => $n ) { ?>
				<label for="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>">
					<input id="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>" class="<?php echo $x ?>" name="<?php echo $this->get_field_name("type"); ?>" type="radio" value="<?php echo $x ?>" <?php if (isset($type)) { checked( $x, $type, true ); } ?> /> <?php echo $n ?>
				</label>
			<?php } ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('postnum'); ?>"><?php _e('Number of post to show', 'halimthemes') ?></label>
			<br />
			<input type="number" class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('postnum'); ?>" name="<?php echo $this->get_field_name('postnum'); ?>" value="<?php echo $instance['postnum']; ?>" />
		</p>
	<?php
	}
}

function halim_latest_update_movie_Widgets(){
	register_widget('halim_latest_update_movie_Widget');
}
add_action('widgets_init', 'halim_latest_update_movie_Widgets');