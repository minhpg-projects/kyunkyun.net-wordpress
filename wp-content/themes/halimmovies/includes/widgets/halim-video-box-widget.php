<?php
class HaLim_Videos_Box_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'halim-video-box-widget',
			__( 'HaLim Video Box', 'halimthemes' ),
			array(
				'classname'   => 'halim-video-box-widget',
				'description' => __( 'Display list Videos', 'halimthemes' )
			)
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		global $post;
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : _x( 'Videos', 'halimthemes' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$categories = $instance['categories'];
		$postnum = $instance['postnum'];
		$url = $instance['url'];
		echo $before_widget;
//		if ( $title )
//			echo $before_title . $title . $after_title;
			ob_start();
		?>
		<section id="<?php echo $widget_id; ?>">
			<div class="section-bar clearfix">
		   		<a href="<?php echo ($categories == 'all') ? $url : get_category_link($categories);  ?>" title="<?php echo $title; ?>">
				   <h3 class="section-title">
					<span><?php echo $title; ?></span>
				   </h3>
				</a>
				<div class="np-viewall">
					<a href="<?php echo ($categories == 'all') ? $url : get_category_link($categories);  ?>">
					<span class="hl-forward"></span> <?php _e('See more', 'halimthemes'); ?></a>
				</div>
			</div>
			<div class="halim_box video-item">
			<?php
				$args = array(
					'post_type'      => 'video',
					'posts_per_page' => $postnum,
				);
				if($categories != 'all'){
					$args['tax_query'][] =  array(
						'taxonomy'  => 'video_cat',
						'field'     => 'id',
						'terms'     => $categories
					);
				}
				$query = new WP_Query( $args );
				if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
					?>
					<div class="col-md3 col-sm-4 col-xs-6 thumb grid-item">
						<div class="halim-item">
							<a class="halim-thumb" href="<?php the_permalink();?>" data-toggle="tooltip" title="<?php the_title();?>">
								<figure>
									<img class="img-responsive" src="<?php echo halim_image_display('blog-thumb') ?>"  alt="<?php the_title();?>" title="<?php the_title();?>">
								</figure>
								<div class="icon_overlay"></div>
							</a>
			                <div class="halim-post-title-box">
			                    <div class="halim-post-title">
			                        <h2><a href="<?php the_permalink();?>" title="<?php echo $post->post_title; ?>"><?php echo esc_html($post->post_title); ?></a></h2>
			                    </div>
			                </div>
						</div>
					</div>
				<?php endwhile; endif; wp_reset_postdata(); ?>
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
		$instance['categories'] = $new_instance['categories'];
		$instance['postnum'] 	= $new_instance['postnum'];
		$instance['url'] 		= $new_instance['url'];
		return $instance;
	}

	public function form( $instance ) {
		// Defadivts
		$instance = wp_parse_args(
			$instance,
			array(
				'title' 	=> _x( 'Videos', 'halimthemes' ),
				'postnum' 	=> 6,
			)
		);

		$title = esc_attr( $instance[ 'title' ] );
		$url = esc_attr( $instance[ 'url' ] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'halimthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('See more URL', 'halimthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Categories', 'halimthemes'); ?></label>
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>All categories</option>
				<?php $categories =  get_terms( 'video_cat', 'orderby=count&hide_empty=0' ); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->name; ?> [<?php echo $category->count ?>]</option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('postnum'); ?>"><?php _e('Number of post to show', 'halimthemes'); ?></label>
			<br />
			<input type="number" class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('postnum'); ?>" name="<?php echo $this->get_field_name('postnum'); ?>" value="<?php echo $instance['postnum']; ?>" />
		</p>
		<?php
	}
}
function HaLim_Videos_Box_Widget() {
	register_widget( 'HaLim_Videos_Box_Widget' );
}
add_action( 'widgets_init', 'HaLim_Videos_Box_Widget' );
