<?php

	/**
	* Template Name: A-Z Listing
	*/
	get_header();

	$letter = sanitize_text_field(get_query_var('letter'));
	$posts_per_page = get_option('posts_per_page');

	if ( get_query_var('page1') ) {
			$paged = get_query_var('page1');
		} else {
			$paged = 1;
	}
	$args = array (
		'post_type' => 'post',
		'ignore_sticky_posts' => true,
		'posts_per_page' => $posts_per_page,
		'substring_where' => $letter,
		'paged' => $paged,
	);

?>
<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
	<?php if ( is_active_sidebar( 'halim-ad-above-category' ) ) { ?>
	    <div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
	        <?php dynamic_sidebar( 'halim-ad-above-category' ); ?>
	    </div>
	<?php } ?>
	<section>
		<div class="section-bar is-tabs clearfix">
		   <h3 class="section-title">
			<span><?php _e('Toàn Bộ Anime', 'halimthemes') ?></span>
		   </h3>
		</div>
		<div class="halim_box">
		<?php
			$wp_query = new WP_Query( $args );
			while($wp_query->have_posts()): $wp_query->the_post();
				HaLimCore::display_post_items();
			endwhile; wp_reset_postdata();?>
		</div>
		<div class="clearfix"></div>
		<?php halim_pagination(); ?>
	</section>
	<?php if ( is_active_sidebar( 'halim-ad-below-category' ) ) { ?>
	    <div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
	        <?php dynamic_sidebar( 'halim-ad-below-category' ); ?>
	    </div>
	<?php } ?>
</main><!--./End #primary -->
<?php get_sidebar(); get_footer(); ?>