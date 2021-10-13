<?php
get_header();?>
	<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
		<div class="section-bar clearfix">
		   <h3 class="section-title">
			<span><?php post_type_archive_title() ?></span>
		   </h3>
		</div>
		<div class="halim_box news">
			<?php
				if (have_posts()) : while (have_posts()) : the_post();
					?>
					<li class="col-xs-12 grid-item list-news">
						<a class="halim-thumb news-thumb" href="<?php the_permalink();?>" title="<?php the_title();?>">
							<figure>
								<img class="lazy img-responsive" src="<?php echo halim_image_display('blog-thumb') ?>"  alt="<?php the_title();?>" title="<?php the_title();?>" />
							</figure>
						</a>
						<div class="post-info">
							<span><?php the_terms($post->ID,'news_cat','', ' ')?></span>
							<h2 class="main-title">
							<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a>
							</h2>
							<span class="published-date"><i class="hl-clock"></i> <?php the_time('d/m/Y'); ?></span>
							<p><?php echo halim_string_limit_word(get_the_excerpt(), 25); ?>...</p>

						</div>
					</li>
			<?php endwhile; endif; ?>
		</div>
		<div class="clearfix"></div>
		<div class="text-center">
			<?php echo halim_pagination() ?>
		</div>
	</main><!--./End #primary -->
<?php get_sidebar(); get_footer(); ?>