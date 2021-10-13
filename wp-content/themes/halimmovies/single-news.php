<?php get_header(); ?>
<main class="col-xs-12 col-sm-12 col-md-12">
	<section id="content">
		<div class="clearfix wrap-content halim-single-news">
		<?php if (have_posts()): while (have_posts()): the_post(); halim_set_post_view_count($post->ID); ?>

			<h1 class="entry-header"><?php the_title() ?></h1>

			<span class="published-date">
				<i class="hl-clock"></i> <?php the_time('d-m-Y'); ?> / <?php the_terms($post->ID,'news_cat','', ', ')?> / <?php echo halim_display_post_view_count($post->ID) ?> <?php _e('lượt xem', 'halimthemes'); ?>
			</span>

			<div class="entry-content">
				 <div class="item-content">
					 <?php the_content(); ?>
				 </div>
				<div id="fb-comments" class="fb-comments" data-href="<?php the_permalink() ?>" data-width="100%" data-numposts="10" data-colorscheme="dark"></div>
			</div>
				<?php
					$term_list = wp_get_post_terms($post->ID, 'news_tag', array("fields" => "all"));
					if($term_list) {
						echo '<div class="the_tag_list">';
							foreach($term_list as $term_single) {
								echo '#' . $term_single->name. ', ';
							}
						echo '</div>';
					}
				endwhile;
			endif ?>
		</div>
	</section>
	<section class="related-post">
		<div class="section-bar clearfix">
		   <h3 class="section-title">
			   <span><?php _e('Related news', 'halimthemes'); ?></span>
		   </h3>
		</div>
		<?php
			$custom_taxterms = wp_get_object_terms( $post->ID, 'news_cat', array('fields' => 'ids') );
			$args = array(
				'post_type'      => 'news',
				'post_status'    => 'publish',
				'posts_per_page' => 5,
				'orderby'        => 'rand',
				'post__not_in'   => array($post->ID),
				'tax_query' 	 => array(
					array(
						'taxonomy' => 'news_cat',
						'field'    => 'id',
						'terms'    => $custom_taxterms
					)
				),
			);
			$related_items = new WP_Query( $args );
			if ($related_items->have_posts()) :
				echo '<ul>';
				while ( $related_items->have_posts() ) : $related_items->the_post(); ?>
					<li>
						<a href="<?php the_permalink();?>">
						<img class="lazy img-responsive" src="<?php echo halim_image_display('blog-thumb') ?>"  alt="<?php the_title();?>" title="<?php the_title();?>" />
						</a>
						<a class="permalink" href="<?php the_permalink();?>"><?php the_title();?></a>
						<span class="published-date"><i class="hl-clock"></i> <?php the_time('d/m/Y'); ?></span>
					</li>
				<?php
				endwhile;
				echo '</ul>';
			endif;
			wp_reset_postdata();
		?>
	</section>
</main>
<?php get_footer();?>