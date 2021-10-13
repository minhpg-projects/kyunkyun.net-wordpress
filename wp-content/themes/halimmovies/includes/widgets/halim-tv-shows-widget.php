<?php

add_action( 'widgets_init', function () {
	register_widget( 'HaLim_TV_Shows_Widget' );
} );

class HaLim_TV_Shows_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'halim-tv-shows-widget',
			__( 'HaLim TV Show Widget', 'halimthemes' ),
			array(
				'classname'   => 'halim-tv-shows-widget',
				'description' => __( 'Display posts by TV Shows', 'halimthemes' )
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
		<section id="halim-tv_shows-widget-<?php echo $widget_id; ?>" class="halim-tv_shows-widget-<?php echo $widget_id; ?>" style="position: relative;">

				<div class="section-bar clearfix">
					<div class="section-title">
						<a href="<?php echo get_category_link($categories);  ?>" title="<?php echo $title; ?>"><h3 class="section-title"><span><?php echo $title; ?></span></h3></a>
						<ul class="halim-popular-tab" role="tablist">

							<li role="presentation"<?php echo 'latest' == $type ? ' class="active"' : ''; ?>>
								<a onclick="HaLim.GetPostByWidgetType('tv_shows', '<?php echo $layout; ?>', <?php echo $postnum; ?>, 'latest', '<?php echo $widget_id; ?>');" role="tab" data-toggle="tab"><?php _e('Mới nhất', 'halimthemes') ?></a>
							</li>
							<li role="presentation"<?php echo 'lastupdate' == $type ? ' class="active"' : ''; ?>>
								<a onclick="HaLim.GetPostByWidgetType('tv_shows', '<?php echo $layout; ?>', <?php echo $postnum; ?>, 'lastupdate', '<?php echo $widget_id; ?>');" role="tab" data-toggle="tab"><?php _e('Mới cập nhật', 'halimthemes') ?></a>
							</li>
							<li role="presentation"<?php echo 'mostview' == $type ? ' class="active"' : ''; ?>>
								<a onclick="HaLim.GetPostByWidgetType('tv_shows', '<?php echo $layout; ?>', <?php echo $postnum; ?>, 'mostview', '<?php echo $widget_id; ?>');" role="tab" data-toggle="tab"><?php _e('Nhiều lượt xem', 'halimthemes') ?></a>
							</li>

						</ul>
					</div>
				</div>
			<div class="halim-ajax-popular-post-loading hidden"></div>
			<div class="halim_box" id="ajax-tv_shows-widget-<?php echo $widget_id; ?>">

				<?php

					$args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => $postnum,
					);

			        $args['tax_query'] = array(array(
			            'taxonomy' => 'post_format',
			            'field' => 'slug',
			            'terms' => array('post-format-video'),
			            'operator' => 'IN'
			        ));

			        if($type == 'lastupdate') {
			            $args['orderby'] = 'modified';
			        }
			        elseif($type == 'mostview')
			        {
			            $args['orderby'] = 'meta_value_num';
			            $args['meta_query'] = array(
			                'relation' => 'AND',
			                array(
			                    'key'   => 'halim_view_post_all'
			                ),
			            );
			        }

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
		$instance['postnum'] 	= $new_instance['postnum'];
		$instance['rand'] 		= $new_instance['rand'];
		$instance['layout'] 		= $new_instance['layout'];
		return $instance;
	}

	public function form( $instance ) {
		// Defaults
		$instance = wp_parse_args( (array) $instance, array(
			'title' 	=> 'TV-Shows',
			'layout'	=> '4col',
			'postnum' 	=> 8,
			'type'		=> 'latest'
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
				  $f = array( 'latest' => __('Mới nhất', 'halimthemes'), 'lastupdate' => __('Mới cập nhật', 'halimthemes'), 'mostview' => __('Most watched', 'halimthemes'));
					foreach ($f as $x => $n ) { ?>
					<label for="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>" style="float: left;margin: 5px;display: inline-block;width: 45%;">
						<input id="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>" class="<?php echo $x ?>" name="<?php echo $this->get_field_name("type"); ?>" type="radio" value="<?php echo $x ?>" <?php if (isset($type)) { checked( $x, $type, true ); } ?> /> <?php echo $n ?>
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

			<p>
				<label for="<?php echo $this->get_field_id('postnum'); ?>"><?php _e('Number of post to show', 'halimthemes') ?></label>
				<br />
				<input type="number" class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('postnum'); ?>" name="<?php echo $this->get_field_name('postnum'); ?>" value="<?php echo $instance['postnum']; ?>" />
			</p>
		</div>
		<?php
	}
}



