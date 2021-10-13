<?php

class halim_vertical_widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'halim-vertical-widget-box',
			__( 'HaLim Vertical Widget', 'halimthemes' ),
			array(
				'classname'   => 'halim-vertical-widget-box',
				'description' => __( 'Display Latest Updated Movie & TV Series', 'halimthemes' )
			)
		);
	}

	function widget($args, $instance)
	{
		global $post;
		extract($args);
		extract($instance);
		echo $before_widget;
		ob_start();
	?>

		<div id="halim-vertical-widget-<?php echo $widget_id; ?>" class="halim-vertical-widget">
		   	<section class="col-md-6 col-sm-6 col-xs-12">
				<div class="section-bar clearfix">
					<div class="section-title">
						<span><?php _e('Anime Movie', 'halimthemes'); ?></span>
						<ul class="halim-popular-tab" role="tablist">
							<li role="presentation" class="active">
								<a class="ajax-vertical-widget" role="tab" data-toggle="tab" data-showpost="<?php echo $postnum; ?>" data-sortby="latest" data-type="movie"><?php _e('Mới nhất', 'halimthemes') ?></a>
							</li>
							<li role="presentation">
								<a class="ajax-vertical-widget" role="tab" data-toggle="tab" data-showpost="<?php echo $postnum; ?>" data-sortby="lastupdate" data-type="movie"><?php _e('Mới cập nhật', 'halimthemes') ?></a>
							</li>
							<li role="presentation">
								<a class="ajax-vertical-widget" role="tab" data-toggle="tab" data-showpost="<?php echo $postnum; ?>" data-sortby="mostview" data-type="movie"><?php _e('Nhiều lượt xem', 'halimthemes') ?></a>
							</li>
						</ul>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane active halim-ajax-popular-post movie">
					<div class="halim-ajax-popular-post-loading hidden"></div>
					<div id="ajax-vertical-widget-movie" class="popular-post">
						<?php
							$movie = new WP_Query(array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => $postnum,
						        'tax_query' => array(array(
						            'taxonomy' => 'post_format',
						            'field' => 'slug',
						            'terms' => array('post-format-aside'),
						            'operator' => 'IN' //NOT IN
						        )),
							));
							if ($movie->have_posts()) : while ($movie->have_posts()) : $movie->the_post();
								HaLimCore::display_popular_post_items('all', true);
							endwhile; wp_reset_postdata(); endif;  ?>
					</div>
				</div>
			</section>
		   	<section class="col-md-6 col-sm-6 col-xs-12">
				<div class="section-bar clearfix">
					<div class="section-title">
						<span><?php _e('Anime Bộ', 'halimthemes'); ?></span>
						<ul class="halim-popular-tab" role="tablist">
							<li role="presentation">
								<a class="ajax-vertical-widget" role="tab" data-toggle="tab" data-showpost="<?php echo $postnum; ?>" data-sortby="latest" data-type="tv_series"><?php _e('Mới nhất', 'halimthemes') ?></a>
							</li>
							<li role="presentation" class="active">
								<a class="ajax-vertical-widget" role="tab" data-toggle="tab" data-showpost="<?php echo $postnum; ?>" data-sortby="lastupdate" data-type="tv_series"><?php _e('Mới cập nhật', 'halimthemes') ?></a>
							</li>
							<li role="presentation">
								<a class="ajax-vertical-widget" role="tab" data-toggle="tab" data-showpost="<?php echo $postnum; ?>" data-sortby="mostview" data-type="tv_series"><?php _e('Nhiều lượt xem', 'halimthemes') ?></a>
							</li>
						</ul>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane active halim-ajax-popular-post tv_series">
					<div class="halim-ajax-popular-post-loading hidden"></div>
					<div id="ajax-vertical-widget-tv_series" class="popular-post">
						<?php
							$tv_series = new WP_Query(array(
								'post_type' => 'post',
								'post_status' => 'publish',
								'posts_per_page' => $postnum,
								'orderby' => 'modified',
						        'tax_query' => array(array(
						            'taxonomy' => 'post_format',
						            'field' => 'slug',
						            'terms' => array('post-format-gallery'),
						            'operator' => 'IN' //NOT IN
						        )),
							));
							if ($tv_series->have_posts()) : while ($tv_series->have_posts()) : $tv_series->the_post();
								HaLimCore::display_popular_post_items('all', true);
							endwhile; wp_reset_postdata(); endif; ?>
					</div>
				</div>
			</section>
		</div>
		<div class="clearfix"></div>

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

function halim_vertical_widgets(){
	register_widget('halim_vertical_widget');
}
add_action('widgets_init', 'halim_vertical_widgets');