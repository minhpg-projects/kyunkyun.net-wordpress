<?php

class HaLim_FullWith_Slider_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'halim-fullwith-slider-widget',
			__( 'HaLim One Slide (Slider one by one)', 'halimthemes' ),
			array(
				'classname'   => 'halim-one-slide-widget',
				'description' => __( 'This widget displays posts specified in the post page. Drag the widget into the "One Slide (Slider one by one)" widget area.', 'halimthemes' )
			)
		);
	}

	public function widget( $args, $instance ) {
		global $post;
		extract( $args );
		$postnum = $instance['postnum'];
		$rand = $instance['rand'];
		echo $before_widget;
//		if ( $title )
//			echo $before_title . $title . $after_title;
		ob_start();
		?>
			<!-- Wrapper For Slides -->
			<div id="<?php echo $args['widget_id']; ?>" class="owl-carousel owl-carousel-fullwidth owl-theme">
				<?php
					$wp_query_args = array(
						'post_type'			=> 'post',
						'posts_per_page' 	=> $postnum,
						'post_status' 		=> 'publish'
					);

					$wp_query_args['tax_query'][] =  array(
						'taxonomy'  => 'post_options',
						'field'     => 'slug',
						'terms'     => array('is_one_slide', 'slider_show')
					);

					if($rand == 1) {
						$wp_query_args['orderby'] = 'rand';
					}
					$wp_query = new WP_Query( $wp_query_args );

					$i = 1;
					if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
				       		$meta = get_post_meta($post->ID, '_halim_metabox_options', true );
				            if(isset($meta)){
				                $poster = (isset($meta['halim_poster_url']) && $meta['halim_poster_url'] != '') ? $meta['halim_poster_url'] : halim_get_first_image();
				            }
							?>
							<div class="post-<?php echo $post->ID; ?> item<?php if($i == 1) echo ' active'; $i++; ?>">
								<a href="<?php the_permalink() ?>" title="<?php echo $post->post_title; ?>">
									<img src="<?php echo $poster ?>" alt="<?php echo $post->post_title; ?>"  class="slide-image" />
									<!-- <div class="slide-text">
										<h3 class="slider-title"><?php //echo $post->post_title; ?></h3>
										<div class="slider-meta hidden-xs">
											<?php
												// if(isset($meta['halim_original_title']) && $meta['halim_original_title'] != '') {
												// 	echo '<i>'.$meta['halim_original_title'].'</i>';
												// } else {
												// 	echo '<i>'.$post->post_title.'</i>';
												// } ?>
										</div>
									</div> -->
								</a>
							</div>
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
			 ?>
			</div><!-- End of Wrapper For Slides -->
			<script>
				jQuery(document).ready(function($) {
					var owl = $('#<?php echo $args['widget_id']; ?>');
					owl.owlCarousel({
						rtl:<?php echo is_rtl()?"true":"false"; ?>,
    					items: 1,
						loop: true,
						animateOut: 'fadeOutLeft',
						animateIn: 'fadeInRight',
						smartSpeed:450,
						autoplay: true,
						autoplayTimeout: 4000,
						autoHeight: true,
						autoplayHoverPause: true,
						nav: true,
						navText: ['<i class="hl-down-open rotate-left"></i>', '<i class="hl-down-open rotate-right"></i>'],
						responsiveClass: true,
					});
				});
			</script>
		<?php
		echo $after_widget;
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}

	public function update( $new_instance, $old_instance ) {
		$instance['postnum'] 	= $new_instance['postnum'];
		$instance['rand'] 	= $new_instance['rand'];
		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args(
			$instance,
			array('postnum' => 8, 'rand' => '')
		);
		?>
		<p class="random" style="clear: both; display:block;">
			<label for="<?php echo $this->get_field_id("rand"); ?>_rand">
				<input id="<?php echo $this->get_field_id("rand"); ?>_rand" class="rand" name="<?php echo $this->get_field_name("rand"); ?>" type="checkbox" value="1" <?php if (isset($rand)) { checked($rand, 1 ); } ?>/> <?php _e('Random post', 'halimthemes') ?>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('postnum'); ?>">
				<?php _e('Number of post to show', 'halimthemes'); ?>:</label>
			<br />
			<input type="number" class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('postnum'); ?>" name="<?php echo $this->get_field_name('postnum'); ?>" value="<?php echo $instance['postnum']; ?>" />
		</p>
		<?php
	}
}
function HaLim_FullWith_Slider_Widget() {
	register_widget( 'HaLim_FullWith_Slider_Widget' );
}
add_action( 'widgets_init', 'HaLim_FullWith_Slider_Widget' );

