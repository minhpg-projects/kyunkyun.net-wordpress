<?php

	/**
	* Template Name: Filter Movies
	*/
	get_header();

	$release  = sanitize_text_field(get_query_var('release'));
	$country  = sanitize_text_field(get_query_var('country'));
	$category  = sanitize_text_field(get_query_var('category'));
	$formality = sanitize_text_field(get_query_var('formality'));
	$status 	= sanitize_text_field(get_query_var('status'));
	$sort     	= sanitize_text_field(get_query_var('sort'));

	$post_format = halim_get_post_format_type($formality);

	$posts_per_page = get_option('posts_per_page');

	if ( get_query_var('page1') ) {
			$paged = get_query_var('page1');
		} else {
			$paged = 1;
	}
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => $status == 'trailer' ? -1 : $posts_per_page,
		'order'          => 'DESC',
		'paged'          => $paged,
	);

	if($sort != 'sort')
	{
		if ($sort == 'updatetime') {
			$args['orderby'] = 'modified';
		}
		elseif ($sort == 'viewcount')
		{
			$args['meta_key'] 	= 'halim_view_post_all';
			$args['orderby'] 	= 'meta_value_num';

		} else {
			$args['orderby'] = 'date';
		}
	}

	if($release && $release != 'release'){
		$args['tax_query'][] =  array(
			'taxonomy'  => 'release',
			'field'     => 'slug',
			'terms'     => $release
	    );
	}
	if($country && $country != 'country'){
		$args['tax_query'][] =  array(
			'taxonomy'  => 'country',
			'field'     => 'slug',
			'terms'     => $country
		);
	}
	if($category && $category != 'category'){
	    $args['tax_query'][] =  array(
	    	'taxonomy'  => 'category',
	    	'field'     => 'term_id',
	    	'terms'     => $category
	    );
	}

	if($status && $status != 'status') {
		$args['tax_query'][] =  array(
			'taxonomy'  => 'status',
			'field'     => 'slug',
			'terms'     => $status
		);
	}
	if($formality && $formality != 'formality'){
        $args['tax_query'] = array(array(
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => array('post-format-'.$post_format),
            'operator' => 'IN'
        ));
	}

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
			<span><?php _e('Lists films', 'halimthemes') ?></span>
		   </h3>
		</div>
		<div class="halim_box">
		<?php
			$wp_query = new WP_Query( $args );
			while($wp_query->have_posts()): $wp_query->the_post();
				HaLimCore::display_post_items();
			endwhile; wp_reset_postdata(); ?>
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