<?php
/**
* Template Name: Page Builder Full Width
*/
get_header(); ?>
	<main class="col-xs-12">
		<?php if (have_posts()) {  the_post(); ?>
			<div class="post-content">
				<?php the_content();?>
			</div>
			<?php
		} ?>
	</main>
<?php get_footer(); ?>