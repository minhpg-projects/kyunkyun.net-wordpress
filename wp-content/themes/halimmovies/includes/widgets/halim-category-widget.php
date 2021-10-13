<?php

add_action( 'widgets_init', function () {
	register_widget( 'HaLim_Categories_Widget' );
} );


class HaLim_Categories_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'halim-category-widget',
			__( 'HaLim Categories Widget', 'halimthemes' ),
			array(
				'classname'   => 'halim-category-widget',
				'description' => __( 'Display posts by Category', 'halimthemes' )
			)
		);
	}

	public function widget( $args, $instance )
	{
		extract( $args );
		extract( $instance );
		echo $before_widget;
		ob_start();
		?>
		<div class="clearfix"></div>
		<section id="halim-category-widget-<?php echo $widget_id; ?>" class="halim-category-widget-<?php echo $widget_id; ?>" style="position: relative;">

				<div class="section-bar clearfix">
					<div class="section-title">
						<a href="<?php echo get_category_link($categories);  ?>" title="<?php echo $title; ?>"><h3 class="section-title"><span><?php echo $title; ?></span></h3></a>
						<ul class="halim-popular-tab" role="tablist">
							<?php
								$type_name = array( 'movie' => __('Movie', 'halimthemes'), 'tv_series' => __('Anime Bộ', 'halimthemes'), 'tv_shows' => __('TV Shows', 'halimthemes'), 'theater_movie' => __('Theater movie', 'halimthemes'));
								foreach ($display_type as $key => $val) {
									?>
									<li role="presentation"<?php echo $val == $type ? ' class="active"' : ''; ?>>
										<a class="ajax-category-widget" role="tab" data-toggle="tab" data-showpost="<?php echo $postnum; ?>" data-layout="<?php echo $layout; ?>" data-type="<?php echo $val; ?>" data-category="<?php echo $categories; ?>" data-widget-id="<?php echo $widget_id; ?>"><?php _e($type_name[$val], 'halimthemes') ?></a>
									</li>

								<?php
								}
							?>
						</ul>
					</div>
				</div>
			<div class="halim-ajax-popular-post-loading hidden"></div>
			<div class="halim_box" id="ajax-category-widget-<?php echo $widget_id; ?>">

				<?php
					$post_format = halim_get_post_format_type($type);
					$args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => $postnum,
					);

			        $args['tax_query'] = array(array(
			            'taxonomy' => 'post_format',
			            'field' => 'slug',
			            'terms' => array('post-format-'.$post_format),
			            'operator' => 'IN'
			        ));
					if($categories) $args['cat'] = $categories;

					if($rand == 1) $args['orderby'] = 'rand';

					$wp_query = new WP_Query( $args );
					if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
						HaLimCore::display_post_items($layout);
					endwhile; wp_reset_postdata(); endif;
				?>

			</div>
		</section>
		<div class="clearfix"></div>
		<?php
		echo $after_widget;
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']  	= strip_tags( $new_instance['title'] );
		$instance['type'] 		= $new_instance['type'];
		$instance['categories'] = $new_instance['categories'];
		$instance['postnum'] 	= $new_instance['postnum'];
		$instance['rand'] 		= $new_instance['rand'];
		$instance['layout'] 		= $new_instance['layout'];
		$instance['display_type'] 		= $new_instance['display_type'];
		return $instance;
	}

	public function form( $instance ) {
		// Defaults
		$instance = wp_parse_args( (array) $instance, array(
			'title' 	=> 'Widget title',
			'layout'	=> '4col',
			'postnum' 	=> 8,
			'type'		=> 'movie',
			'display_type' => array('movie' => 'movie', 'tv_series' => 'tv_series')
		) );
		extract($instance); ?>
		<div class="hl_slider_form">
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'halimthemes') ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
				<label><?php _e('Default Format', 'halimthemes') ?></label>
				<br>
				<?php
				  $f = array( 'movie' => __('Movie', 'halimthemes'), 'tv_series' => __('Anime Bộ', 'halimthemes'), 'tv_shows' => __('TV Shows', 'halimthemes'), 'theater_movie' => __('Theater movie', 'halimthemes'));
					foreach ($f as $x => $n ) { ?>
					<label for="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>" style="float: left;margin: 5px;display: inline-block;width: 45%;">
						<input id="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>" class="<?php echo $x ?>" name="<?php echo $this->get_field_name("type"); ?>" type="radio" value="<?php echo $x ?>" <?php if (isset($type)) { checked( $x, $type, true ); } ?> /> <?php echo $n ?>
					</label>
				<?php } ?>
			</p>

			<p>
				<label><?php _e('Select display format', 'halimthemes') ?></label>
				<br>
				<?php
				  $f2 = array( 'movie' => __('Movie', 'halimthemes'), 'tv_series' => __('Anime Bộ', 'halimthemes'), 'tv_shows' => __('TV Shows', 'halimthemes'), 'theater_movie' => __('Theater movie', 'halimthemes'));
					foreach ($f2 as $x => $n ) { ?>
					<label for="<?php echo $this->get_field_id("display_type"); ?>_<?php echo $x ?>" style="float: left;margin: 5px;display: inline-block;width: 45%;">
						<input id="<?php echo $this->get_field_id("display_type"); ?>_<?php echo $x ?>" class="<?php echo $x ?>" name="<?php echo $this->get_field_name("display_type"); ?>[<?php echo $x ?>]" type="checkbox" value="<?php echo $x ?>" <?php if (isset($display_type[$x])) { checked( $x, $display_type[$x], true ); } ?> /> <?php echo $n ?>
					</label>
				<?php } ?>
			</p>

			<p style="clear: both;">
				<label for="<?php echo $this->get_field_id('layout'); ?>">
				<?php _e('Layout:', 'halimthemes') ?>
				<br />
					<select id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>" class="widefat">
						<?php
						  $vl = array( '4col' => __('4 video/row', 'halimthemes'), '6col' => __('6 video/row', 'halimthemes'), );
								foreach ($vl as $layout_id => $layout_name) { ?>
									<option value="<?php echo $layout_id ?>" <?php selected( $layout_id, $instance['layout'], true ); ?>>
									<?php echo $layout_name ?>
									</option>
						<?php } ?>
					</select>
				</label>
			</p>
			<p class="random" style="clear: both; display:block;">
				<label for="<?php echo $this->get_field_id("rand"); ?>_rand">
					<input id="<?php echo $this->get_field_id("rand"); ?>_rand" class="rand" name="<?php echo $this->get_field_name("rand"); ?>" type="checkbox" value="1" <?php if (isset($rand)) { checked($rand, 1 ); } ?>/> <?php _e('Random post', 'halimthemes') ?>
				</label>
			</p>

			<p class="slider-category">
				<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Categories', 'halimthemes') ?></label>
				<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
					<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>><?php _e('All category', 'halimthemes') ?></option>
					<?php $categories = get_categories('hide_empty=1&depth=1&type=post'); ?>
					<?php foreach($categories as $category) { ?>
					<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?> [<?php echo $category->count ?>]</option>
					<?php } ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('postnum'); ?>"><?php _e('Number of post to show', 'halimthemes') ?></label>
				<br />
				<input type="number" class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('postnum'); ?>" name="<?php echo $this->get_field_name('postnum'); ?>" value="<?php echo $instance['postnum']; ?>" />
			</p>
		</div>
		<?php
	}
}



