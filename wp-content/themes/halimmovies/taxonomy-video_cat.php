<?php get_header();?>
	<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
		<?php if ( is_active_sidebar( 'halim-ad-above-category' ) ) { ?>
		    <div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
		        <?php dynamic_sidebar( 'halim-ad-above-category' ); ?>
		    </div>
		<?php } ?>
		<div class="section-bar clearfix">
		   <h3 class="section-title"><span><?php single_term_title(); ?></span>
		   </h3>
		</div>
		<div class="halim_box video-item">
		<?php

			$args = array(
				'post_type' => 'video',
				'post_status' => 'publish',
				'tax_query' => array(
					array(
						'taxonomy' => 'video_cat',
						'field' => 'slug',
						'terms' => get_query_var( 'term' ),
					),
				),
			);

			$loop = new WP_Query($args);
				if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
					?>
					<div class="col-sm-4 col-xs-6 thumb grid-item">
						<div class="halim-item">
							<a class="halim-thumb" href="<?php the_permalink();?>" title="<?php the_title();?>">
								<figure>
									<img class="lazy img-responsive" src="<?php echo halim_image_display('blog-thumb') ?>"  alt="<?php the_title();?>" title="<?php the_title();?>">
								</figure>
								<div class="icon_overlay"></div>
							</a>
							<div class="halim-post-title-box">
				            	<div class="halim-post-title">
				                	<h2><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a></h2>
				                </div>
				            </div>
						</div>
					</div>
			<?php endwhile; wp_reset_postdata(); endif; ?>
		</div>
		<div class="clearfix"></div>
		<div class="text-center">
			<?php echo halim_pagination() ?>
		</div>
		<?php if ( is_active_sidebar( 'halim-ad-below-category' ) ) { ?>
		    <div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
		        <?php dynamic_sidebar( 'halim-ad-below-category' ); ?>
		    </div>
		<?php } ?>
	</main><!--./End #primary -->
<?php get_sidebar(); get_footer(); ?>