<?php
get_header();?>
	<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
		<?php if ( is_active_sidebar( 'halim-ad-above-category' ) ) { ?>
		    <div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
		        <?php dynamic_sidebar( 'halim-ad-above-category' ); ?>
		    </div>
		<?php } ?>
		<?php if (have_posts()) {  the_post(); ?>
			<div class="post-content">
				<?php the_content();?>
			</div>
			<?php
		} ?>
		<?php if ( is_active_sidebar( 'halim-ad-below-category' ) ) { ?>
		    <div class="a--d-wrapper" style="text-align: center; margin: 10px 0;">
		        <?php dynamic_sidebar( 'halim-ad-below-category' ); ?>
		    </div>
		<?php } ?>
	</main>
<?php get_sidebar(); get_footer(); ?>