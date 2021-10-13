<?php
	/**
	* Template Name: TV Series
	*/

	get_header();
	$sortby = $type = isset($_GET['sortby']) ? sanitize_text_field($_GET['sortby']) : '';

?>
<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
	<?php if ( is_active_sidebar( 'halim-ad-above-category' ) ) { ?>
	    <div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
	        <?php dynamic_sidebar( 'halim-ad-above-category' ); ?>
	    </div>
	<?php } ?>
	<section>
			<div class="section-bar clearfix">
			   <h3 class="section-title">
					<span><?php _e('Anime Bộ', 'halimthemes') ?></span>
<br>			   </h3>
			</div>
			<div class="halim_box">
			<?php
				if ( get_query_var('paged') ) {
						$paged = get_query_var('paged');
					} elseif ( get_query_var('page') ) {
						$paged = get_query_var('page');
					} else {
						$paged = 1;
				}
				$posts_per_page = get_option( 'posts_per_page' );
				$sortby = isset($_GET['sortby']) ? $_GET['sortby'] : '';
				$args = array(
					'post_type'			=> 'post',
					'paged'      		=> $paged,
					'posts_per_page' 	=> $posts_per_page,
					'post_status' 		=> 'publish',
				);
                $args['tax_query'] = array(array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-gallery'),
                    'operator' => 'IN'
                ));
			    if($sortby == 'lastupdate') {
			        $args['orderby'] = 'modified';
			    }

				if($sortby == 'mostview')
				{
					$args['orderby'] = 'meta_value_num';
		            $args['meta_query'] = array(
		                'relation' => 'AND',
		                array(
		                    'key'   => 'halim_view_post_all'
		                ),
		            );
				}

				$wp_query = new WP_Query( $args );
				if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
					if(HALIMHelper::is_type('tv_series')){
						HaLimCore::display_post_items();
					}
				endwhile; wp_reset_postdata(); endif; ?>
			</div>
		<div class="clearfix"></div>
		<?php halim_pagination(); ?>
	</section>
	<?php if ( is_active_sidebar( 'halim-ad-below-category' ) ) { ?>
	    <div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
	        <?php dynamic_sidebar( 'halim-ad-below-category' ); ?>
	    </div>
	<?php } ?>
</main>
<?php get_sidebar(); get_footer(); ?>