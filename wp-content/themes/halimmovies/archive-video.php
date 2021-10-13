<?php
get_header();?>
	<main class="col-xs-12 col-sm-12 col-md-12">
		<div class="section-bar is-tabs clearfix">
		   <h3 class="section-title"><span><?php post_type_archive_title() ?></span></h3>
		</div>
		<div class="halim_box video-item">
			<?php
				if ( get_query_var('paged') ) {
						$paged = get_query_var('paged');
					} elseif ( get_query_var('page') ) {
						$paged = get_query_var('page');
					} else {
						$paged = 1;
				}
				$posts_per_page = get_option( 'posts_per_page' );
				$args = array(
					'post_type'   => 'video',
					'post_status' => 'publish',
					'paged'       => $paged,
					'showposts'   => $posts_per_page,
				);
				$wp_query = new WP_Query( $args );
				if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
					?>
					<li class="col-md-3 col-sm-4 col-xs-6 thumb grid-item">
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
					</li>
			<?php endwhile; wp_reset_postdata(); endif; ?>
		</div>
		<div class="clearfix"></div>
		<div class="text-center">
			<?php echo halim_pagination() ?>
		</div>
	</main><!--./End #primary -->
<?php get_footer(); ?>