<?php

class HaLim_News_Box_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'halim-news-box-widget',
			__( 'HaLim News Box', 'halimthemes' ),
			array(
				'classname'   => 'halim-news-box-widget',
				'description' => __( 'Display list news by category', 'halimthemes' )
			)
		);

	}


	public function widget( $args, $instance ) {
		extract( $args );
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : _x( 'News', 'halimthemes' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$lazyload = cs_get_option('halim_lazyload_image');
		$categories = $instance['categories'];
		$postnum = $instance['postnum'];
		$url = $instance['url'];
		echo $before_widget;
		ob_start();
//		if ( $title )
//			echo $before_title . $title . $after_title;
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
			<div class="halim_box news">
			<?php
				$args = array(
				'post_type' => 'news',
				'posts_per_page' => $postnum,
				);
				if($categories != 'all'){
					$args['tax_query'][] =  array(
						'taxonomy'  => 'news_cat',
						'field'     => 'id',
						'terms'     => $categories
					);
				}
				$query = new WP_Query( $args );
				if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
					?>
					<div class="col-xs-12 grid-item list-news">
						<a class="halim-thumb news-thumb" href="<?php the_permalink();?>" title="<?php the_title();?>">
							<figure>
								<?php if($lazyload) : ?>
								<img class="lazyload blur-up img-responsive" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo halim_image_display('blog-thumb') ?>"  alt="<?php the_title();?>" title="<?php the_title();?>" />
								<?php else: ?>
								<img class="img-responsive" src="<?php echo halim_image_display('blog-thumb') ?>"  alt="<?php the_title();?>" title="<?php the_title();?>" />
								<?php endif; ?>
							</figure>
						</a>
						<div class="post-info">
							<span><?php the_terms(get_the_ID(), 'news_cat', '', ' ')?></span>
							<h2 class="main-title">
							<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a></h2>
							<span class="published-date"><i class="hl-clock"></i> <?php the_time('d/m/Y'); ?></span>
							<p><?php echo halim_string_limit_word(get_the_excerpt(), 25); ?>...</p>
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
				'title' 	=> __( 'News', 'halimthemes' ),
				'postnum' 	=> 6,
			)
		);

		$title = esc_attr( $instance[ 'title' ] );
		$url = esc_attr( $instance[ 'url' ] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('News', 'halimthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('See more page URL', 'halimthemes'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Category', 'halimthemes'); ?></label>
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>All categories</option>
				<?php $categories =  get_terms( 'news_cat', 'orderby=count&hide_empty=0' ); ?>
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
function HaLim_News_Box_Widget() {
	register_widget( 'HaLim_News_Box_Widget' );
}
add_action( 'widgets_init', 'HaLim_News_Box_Widget' );
