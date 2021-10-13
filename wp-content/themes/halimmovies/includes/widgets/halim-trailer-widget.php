<?php
class HaLim_Trailer_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'halim_trailer-widget',
			__( 'HaLim Trailer Widget', 'halimthemes' ),
			array(
				'classname'   => 'halim_trailer-widget',
				'description' => __( 'Display latest movie trailer', 'halimthemes' )
			)
		);
	}

	public function widget($args, $instance)
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
				<h3 class="section-title"><span><?php echo $title; ?></span></h3>
			</div>
			<?php endif ?>
			<div class="popular-post">
				<?php
					$args = array(
						'post_type'      => 'post',
						'post_status'    => 'publish',
						'posts_per_page' => $postnum,
						'order'          => 'DESC',
						'meta_query' => array(
							array(
								'key'     => '_halim_metabox_options',
								'value'   => 'is_trailer',
								'compare' => 'LIKE'
							),
						),
					);
					$wp_query = new WP_Query( $args );
					if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
						HaLimCore::display_popular_post_items();
					endwhile; endif; wp_reset_postdata(); ?>
			</div>
			<div class="clearfix"></div>
		<?php
		echo $after_widget;
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}
	public function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['postnum'] = $new_instance['postnum'];
		return $instance;
	}

	public function form($instance){
		$defaults = array(
			'title'   => 'Trailer',
			'postnum' => 6,
			'layout'  => 'default'
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'halimthemes'); ?></label>
			<br />
			<input class="widefat" style="width: 100%;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('postnum'); ?>"><?php _e('Number of post to show', 'halimthemes'); ?></label>
			<br />
			<input type="number" class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('postnum'); ?>" name="<?php echo $this->get_field_name('postnum'); ?>" value="<?php echo $instance['postnum']; ?>" />
		</p>
	<?php
	}
}

function HaLim_Trailer_Widgets()
{
	register_widget('HaLim_Trailer_Widget');
}
add_action('widgets_init', 'HaLim_Trailer_Widgets');
