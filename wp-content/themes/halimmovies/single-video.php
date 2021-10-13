<?php get_header(); ?>
<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
	<section id="content">
		<div class="clearfix wrap-content">
			<?php
				if (have_posts()): while (have_posts()): the_post(); halim_set_post_view_count($post->ID);
				$meta = get_post_meta($post->ID, '_videos_metabox_options', true);
				$video_url = (isset($meta['halim_video_url']['video_url'])) ? $meta['halim_video_url']['video_url'] : '';
				$video_embed = ($meta['halim_video_embed_code']['video_embed']) ? $meta['halim_video_embed_code']['video_embed'] : '';
				if(isset($meta['video_type']) && $meta['video_type'] == 'video_embed') {
					preg_match('/<iframe(.*?)src="(.*?)"/is', $video_embed, $url);
					echo '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="'.$url[2].'" gesture="media" allow="encrypted-media" allowfullscreen></iframe></div>';
				} else {
					$url = HALIMHelper::getVideoLocation($video_url);
					echo '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="'.$url.'" gesture="media" allow="encrypted-media" allowfullscreen></iframe></div>';
				}

			?>
			<h1 class="entry-header"><?php the_title() ?></h1>
			<span class="published-date"><i class="hl-clock"></i> <?php the_time('d/m/Y'); ?> / <?php the_terms($post->ID,'video_cat','', ', ')?> / <?php echo halim_display_post_view_count($post->ID) ?> <?php _e('view', 'halimthemes'); ?></span>
			<div class="entry-content">
				 <div class="item-content panel-body">
					 <?php the_content(); ?>
				 </div>
				<div id="fb-comments" class="fb-comments" data-href="<?php the_permalink() ?>" data-width="100%" data-numposts="10" data-colorscheme="dark"></div>
			</div>
				<?php
					$term_list = wp_get_post_terms($post->ID, 'video_tag', array("fields" => "all"));
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
	<section>
		<div class="section-bar clearfix">
		   <h3 class="section-title">
			   <span><?php _e('Related videos', 'halimthemes') ?></span>
		   </h3>
		</div>
		<div class="related-video halim_box video-item">
		<?php
			$custom_taxterms = wp_get_object_terms( $post->ID, 'video_cat', array('fields' => 'ids') );
			// arguments
			$args = array(
				'post_type'      => 'video',
				'post_status'    => 'publish',
				'posts_per_page' => 5,
				'orderby'        => 'rand',
				'post__not_in'   => array ($post->ID),
				'tax_query'      => array(
					array(
						'taxonomy' => 'video_cat',
						'field'    => 'id',
						'terms'    => $custom_taxterms
					)
				),
			);
			$related_items = new WP_Query( $args );
			// loop over query
			if ($related_items->have_posts()) :
				while ( $related_items->have_posts() ) : $related_items->the_post(); ?>
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
				<?php
				endwhile;
			endif;
			// Reset Post Data
			wp_reset_postdata();
		?>
		</div>
	</section>
</main>
<?php get_sidebar(); get_footer();?>