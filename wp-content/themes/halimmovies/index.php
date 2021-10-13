<?php get_header(); ?>

	<div class="col-xs-12 carausel-sliderWidget">
		<?php dynamic_sidebar('carousel-widget') ?>
	</div>

	<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
		<?php
			if( is_active_sidebar( 'home-widget' ) ) {
			     dynamic_sidebar( 'home-widget' );
			} else {
				_e('This is widget area. Go to Appearance -> Widgets to add some widgets.', 'halimthemes');
			} ?>
	</main>

<?php get_sidebar(); get_footer(); ?>