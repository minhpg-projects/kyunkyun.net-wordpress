<?php

class halim_tab_popular_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'halim_tab_popular_videos-widget',
			__( 'HaLim Polpular Movies', 'halimthemes' ),
			array(
				'classname'   => 'halim_tab_popular_videos-widget',
				'description' => __( 'Display popular post by day, week, month and alltime', 'halimthemes' )
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
					<ul class="halim-popular-tab" role="tablist">
						<li role="presentation" class="active">
							<a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="<?php echo $postnum; ?>" data-type="day"><?php _e('Ngày', 'halimthemes') ?></a>
						</li>
						<li role="presentation">
							<a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="<?php echo $postnum; ?>" data-type="week"><?php _e('Tuần', 'halimthemes') ?></a>
						</li>
						<li role="presentation">
							<a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="<?php echo $postnum; ?>" data-type="month"><?php _e('Tháng', 'halimthemes') ?></a>
						</li>
						<li role="presentation">
							<a class="ajax-tab" role="tab" data-toggle="tab" data-showpost="<?php echo $postnum; ?>" data-type="all"><?php _e('Toàn bộ', 'halimthemes') ?></a>
						</li>
					</ul>
				</div>
			</div>
		<?php endif ?>
	   <section class="tab-content">
			<div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
				<div class="halim-ajax-popular-post-loading hidden"></div>
				<div id="halim-ajax-popular-post" class="popular-post">
					<?php
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => $postnum,
							'orderby' => 'meta_value_num',
							'meta_query' => array(
								'relation' => 'AND',
								array(
									'key'   => 'halim_view_post_day'
								),
							),
						);
						$day = new WP_Query( $args );
						if ($day->have_posts()) : while ($day->have_posts()) : $day->the_post();
							HaLimCore::display_popular_post_items();
						endwhile; endif; wp_reset_postdata(); ?>
				</div>
			</div>
		</section>
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
		return $instance;
	}

	function form($instance)
	{
		$defaults = array(
			'title' 		=> __('Popular', 'halimthemes'),
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

function halim_tab_popular_widgets(){
	register_widget('halim_tab_popular_Widget');
}
add_action('widgets_init', 'halim_tab_popular_widgets');