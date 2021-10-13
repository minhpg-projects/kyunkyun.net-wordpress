<?php get_header();?>
	<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
		<?php if ( is_active_sidebar( 'halim-ad-above-category' ) ) { ?>
		    <div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
		        <?php dynamic_sidebar( 'halim-ad-above-category' ); ?>
		    </div>
		<?php } ?>
		<div class="section-bar clearfix">
		   <h3 class="section-title">
			<span><?php single_term_title(); ?></span>
		   </h3>
		</div>
		<div class="halim_box news">
			<?php

				$args = array(
					'post_type' => 'news',
					'post_status' => 'publish',
					'tax_query' => array(
						array(
							'taxonomy' => 'news_cat',
							'field' => 'slug',
							'terms' => get_query_var('term'),
						),
					),
				);

				$loop = new WP_Query($args);
				if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
					?>
					<div class="col-xs-12 grid-item list-news">
						<a class="halim-thumb news-thumb" href="<?php the_permalink();?>" title="<?php the_title();?>">
							<figure>
								<img class="lazy img-responsive" src="<?php echo halim_image_display('blog-thumb') ?>"  alt="<?php the_title();?>" title="<?php the_title();?>" />
							</figure>
						</a>
						<div class="post-info">
							<span><?php the_terms($post->ID, 'news_cat','', ' ')?></span>
							<h2 class="main-title">
							<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a>
							</h2>
							<span class="published-date"><i class="hl-clock"></i> <?php the_time('d/m/Y'); ?></span>
							<p><?php echo halim_string_limit_word(get_the_excerpt(), 30); ?>...</p>

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