<?php

class HaLim_Latest_Post_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'halim-latest-widget',
			__( 'HaLim Latest Post Widget', 'halimthemes' ),
			array(
				'classname'   => 'halim-latest-widget',
				'description' => __( 'Display the latest movie', 'halimthemes' )
			)
		);
	}


	public function widget( $args, $instance ) {
		global $post;
		extract( $args );
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Mới nhất', 'halimthemes' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$categories = $instance['categories'];
		$postnum = $instance['postnum'];
		$layout = $instance['layout'];
		$rand = $instance['rand'];
		echo $before_widget;
		?>
		<div class="clearfix"></div>
		<section id="<?php echo $widget_id; ?>">
			<div class="section-bar clearfix">
		   		<a href="<?php echo get_category_link($categories);  ?>" title="<?php echo $title; ?>"><h3 class="section-title"><span><?php echo $title; ?></span></h3></a>
				<div class="np-viewall"><a href="<?php echo get_category_link($categories);  ?>"><span class="hl-forward"></span> <?php _e('Xem tất cả', 'halimthemes') ?></a></div>
			</div>
			<div class="halim_box">
				<?php
					$args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => $postnum,
					);

					if($categories ) $args['cat'] = $categories;

					if($rand == 1) $args['orderby'] = 'rand';

					$wp_query = new WP_Query( $args );
					if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
						HaLimCore::display_post_items($layout);
					endwhile; endif; wp_reset_postdata();
				?>
			</div>
		</section>
		<div class="clearfix"></div>
		<?php
		echo $after_widget;
	}


	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']  	= strip_tags( $new_instance['title'] );
		$instance['rand'] 		= $new_instance['rand'];
		$instance['categories'] = $new_instance['categories'];
		$instance['postnum'] 	= $new_instance['postnum'];
		$instance['layout'] 	= $new_instance['layout'];
		return $instance;
	}

	public function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array(
			'title' 	=> __( 'Title', 'halimthemes' ),
			'layout'	=> '4col',
			'postnum' 	=> 8,
		) );
		extract($instance); ?>
			<div class="hl_options_form">
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'halimthemes') ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
				</p>

				<p class="random" style="clear: both; display:block;">
					<label for="<?php echo $this->get_field_id("rand"); ?>_rand">
						<input id="<?php echo $this->get_field_id("rand"); ?>_rand" class="rand" name="<?php echo $this->get_field_name("rand"); ?>" type="checkbox" value="1" <?php if (isset($rand)) { checked($rand, 1 ); } ?>/> <?php _e('Random post', 'halimthemes') ?>
					</label>
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
				<p class="category" style="display: none;">
					<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Category', 'halimthemes') ?></label>
					<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
						<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>All categories</option>
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
function register_widget_HaLim_Latest_Post_Widget() {
	register_widget( 'HaLim_Latest_Post_Widget' );
}
add_action( 'widgets_init',  'register_widget_HaLim_Latest_Post_Widget');
