<?php

class HaLim_Advanced_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'halim-advanced-widget',
			__( 'HaLim Advanced Widget', 'halimthemes' ),
			array(
				'classname'   => 'halim-advanced-widget',
				'description' => __( 'Display posts by category, latest, most viewed, last update', 'halimthemes' )
			)
		);
	}


	public function widget( $args, $instance ) {

		extract($args);
		extract($instance);
		echo $before_widget;
		ob_start();
		?>
		<section id="<?php echo $widget_id; ?>">
			<h4 class="section-heading">
		   		<a href="<?php echo ($categories == 'all') ? $url : get_category_link($categories);  ?>" title="<?php echo $title; ?>">
		   			<span class="h-text"><?php echo $title; ?></span>
		   		</a>
				<?php
					$cat_id = array();
					if(isset($tabs)){
						echo '<ul class="heading-nav pull-right hidden-xs">';
							foreach($tabs as $l){
								$cat_id[] = $l;
							}
							foreach($cat_id as $p => $k){
								echo '<li class="section-btn halim_ajax_get_post" data-catid="'.$k.'" data-showpost="'.$postnum.'" data-widgetid="'.$args['widget_id'].'" data-layout="'.$instance['layout'].'"><span data-text="'.get_the_category_by_ID($k).'"></span></li>';
							}
						echo '</ul>';
					}
				?>
			</h4>
			<div id="<?php echo $args['widget_id']; ?>-ajax-box" class="halim_box">
			<?php
				$args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => $postnum,
				);

				if($type == 'popular'){
					$args['orderby'] = 'meta_value_num';
					$args['meta_query'] =  array(
							array(
								'key' => 'halim_view_post_all'
							),
						);
				} elseif($type == 'categories') {

					$args['cat'] = $categories;

				} elseif($type == 'movies') {
			        $args['tax_query'] = array(array(
			            'taxonomy' => 'post_format',
			            'field' => 'slug',
			            'terms' => array('post-format-aside'),
			            'operator' => 'IN' //NOT IN
			        ));
				}
				elseif($type == 'tvseries'){
			        $args['tax_query'] = array(array(
			            'taxonomy' => 'post_format',
			            'field' => 'slug',
			            'terms' => array('post-format-gallery'),
			            'operator' => 'IN' //NOT IN
			        ));
				}
				elseif($type == 'tv_shows'){
			        $args['tax_query'] = array(array(
			            'taxonomy' => 'post_format',
			            'field' => 'slug',
			            'terms' => array('post-format-video'),
			            'operator' => 'IN' //NOT IN
			        ));
				}
				elseif($type == 'theater_movie'){
			        $args['tax_query'] = array(array(
			            'taxonomy' => 'post_format',
			            'field' => 'slug',
			            'terms' => array('post-format-audio'),
			            'operator' => 'IN'
			        ));
				}
				elseif($type == 'completed') {
			        $args['tax_query'] = array(array(
			            'taxonomy' => 'status',
			            'field' => 'slug',
			            'terms' => 'completed',
			            'operator' => 'IN'
			        ));

				} elseif($type == 'lastupdate') {
					$args['orderby'] = 'modified';
				}

				if($rand == 1 && $type != 'lastupdate') {
					$args['orderby'] = 'rand';
				}
				$query = new WP_Query( $args );
				if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
					HaLimCore::display_post_items($layout);
				endwhile; wp_reset_postdata(); endif;
				echo '<div class="clearfix"></div>';
				printf( '<a href="%s" class="see-more">' . __( 'Xem tất cả »', 'halimthemes' ) . '</a>', ($categories == 'all') ? $url : get_category_link($categories));
			?>

			</div>
		</section>
		<div class="clearfix"></div>
		<?php
		echo $after_widget;
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}


	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']  	= strip_tags( $new_instance['title'] );
		$instance['url'] 		= $new_instance['url'];
		$instance['tabs'] 		= $new_instance['tabs'];
		$instance['type'] 		= $new_instance['type'];
		$instance['rand'] 		= $new_instance['rand'];
		$instance['categories'] = $new_instance['categories'];
		$instance['postnum'] 	= $new_instance['postnum'];
		$instance['layout'] 	= $new_instance['layout'];
		return $instance;
	}

	public function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array(
			'title'      => __( 'Title', 'halimthemes' ),
			'layout'     => '4col',
			'postnum'    => 8,
			'item'       => 5,
			'type'       => 'latest',
			'url'        => '',
			'rand'       => '',
			'tabs'		=> '',
			'categories' => 'all'
		) );
		extract($instance); ?>
			<div class="hl_options_form">
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'halimthemes') ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e('View more URL', 'halimthemes') ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" placeholder="http://play.halimthemes.com/phim-moi/"/>
				</p>
					<p style="display: inline-block;">
					<label><?php _e('Display posts by', 'halimthemes') ?></label>
					<br>
					<label for="<?php echo $this->get_field_id("type"); ?>_latest" style="float: left;margin: 5px;display: inline-block;width: 45%;">
						<input id="<?php echo $this->get_field_id("type"); ?>_latest" class="latest" name="<?php echo $this->get_field_name("type"); ?>" type="radio" value="latest" checked/> <?php _e('Mới nhất', 'halimthemes') ?>
					</label>
					<?php
					  $f = array(
							'categories' 	=> __('Category', 'halimthemes'),
						  	'completed'		=> __('Completed', 'halimthemes'),
						  	'lastupdate'	=> __('Mới cập nhật', 'halimthemes'),
							'popular' 		=> __('Nhiều lượt xem', 'halimthemes'),
							'tvseries'		=> __('Anime Bộ', 'halimthemes'),
							'movies'		=> __('Anime Movie', 'halimthemes'),
							'tv_shows'		=> __('TV Shows', 'halimthemes'),
							'theater_movie'		=> __(' Theater movie', 'halimthemes')
						);
						foreach ($f as $x => $n ) { ?>
						<label for="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>" style="float: left;margin: 5px;display: inline-block;width: 45%;">
							<input id="<?php echo $this->get_field_id("type"); ?>_<?php echo $x ?>" class="<?php echo $x == 'categories' ? $x.' cat' : $x; ?>" name="<?php echo $this->get_field_name("type"); ?>" type="radio" value="<?php echo $x ?>" <?php if (isset($type)) { checked( $x, $type, true ); } ?> /> <?php echo $n ?>
						</label>
					<?php } ?>
					</p>
					<script>
						jQuery(document).on('click', function(e) {
							var $this = jQuery(e.target);
							var $form = $this.closest('.hl_options_form');

							if ($this.is('.categories')) {
								var $halim = $form.find('.category');
								var val = $this.is(':checked');
								if (val) {
									$halim.slideDown();
								}
							} else if ($this.is('.popular, .latest, .tvseries, .movies, .lastupdate, .completed')) {
								var $halim = $form.find('.category');
								var val = $this.is(':checked');
								if (val) {
									$halim.slideUp();
								}
							}

							if ($this.is('.lastupdate')) {
								var $halim = $form.find('.random');
								var val = $this.is(':checked');
								if (val) {
									$halim.slideUp();
								}
							} else if ($this.is('.popular, .latest, .tvseries, .movies, .lastupdate, .completed')) {
								var $halim = $form.find('.random');
								var val = $this.is(':checked');
								if (val) {
									$halim.slideDown();
								}
							}

						});

						jQuery(document).ready(function($){
							if ($("input.lastupdate").is(':checked')) {
								 if ($('input.lastupdate:checked').val() == 'lastupdate') {
										$('.random').slideUp();
								  }
							}

							if ($("input.cat").is(':checked')) {
								 if ($('input.cat:checked').val() == 'categories') {
										$('.category').slideDown();
								  }
							}
						});
					</script>
				<br/>
				<p class="random" style="clear: both; display:block;">
					<label for="<?php echo $this->get_field_id("rand"); ?>_rand">
						<input id="<?php echo $this->get_field_id("rand"); ?>_rand" class="rand" name="<?php echo $this->get_field_name("rand"); ?>" type="checkbox" value="1" <?php if (isset($rand)) { checked($rand, 1 ); } ?>/> <?php _e('Random post', 'halimthemes') ?>
					</label>
				</p>
				<br />
				<div class="hl_select_tabs" style="clear: both;border: 1px solid #f1f1f1;padding: 6px;background: #fdfdfd;">
					<h4 style="margin-top: 0;margin-bottom: 5px;"><?php _e('Sub category', 'halimthemes'); ?></h4>
					<div class="hl_select_tabs" style="max-height: 150px;overflow-x: auto;border: 1px solid #eee;padding: 5px;">
						<?php
							$showsubcat = get_categories('hide_empty=1&depth=1&hierarchical=1&type=post');
							foreach($showsubcat as $getsubcat) { ?>
							<label for="<?php echo $this->get_field_id("tabs"); ?>_<?php echo $getsubcat->term_id; ?>" class="alignleft" style="display: block; width: 50%; margin-bottom: 5px;">
								<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("tabs"); ?>_<?php echo $getsubcat->term_id; ?>" name="<?php echo $this->get_field_name("tabs"); ?>[<?php echo $getsubcat->term_id; ?>]" value="<?php echo $getsubcat->term_id; ?>" <?php if (isset($tabs[$getsubcat->term_id])) { checked( $getsubcat->term_id, $tabs[$getsubcat->term_id], true ); } ?> /><?php echo $getsubcat->cat_name; ?> [<?php echo $getsubcat->count ?>]
							</label>
						<?php }
						?>
					</div>
				</div>

				<p style="clear: both;">
					<label for="<?php echo $this->get_field_id('layout'); ?>">
					<?php _e('Layout', 'halimthemes') ?>
					<br />
						<select id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>" class="widefat">
							<?php
							  	$vl = array( '4col' => __('4 item/row', 'halimthemes'), '6col' => __('6 item/row', 'halimthemes') );
									foreach ($vl as $layout_id => $layout_name) { ?>
										<option value="<?php echo $layout_id ?>" <?php selected( $layout_id, $instance['layout'], true ); ?>>
										<?php echo $layout_name ?>
										</option>
							<?php } ?>
						</select>
					</label>
				</p>
				<p class="category" style="display: none;">
					<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Category', 'halimthemes') ?></label>
					<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
						<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>All categories</option>
						<?php $categories = get_categories('hide_empty=1&depth=1&type=post'); ?>
						<?php foreach($categories as $category) { ?>
						<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?> [<?php echo $category->count ?>]</option>
						<?php } ?>
					</select>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id('postnum'); ?>"><?php _e('Number of post to show', 'halimthemes') ?></label>
					<br />
					<input type="number" class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('postnum'); ?>" name="<?php echo $this->get_field_name('postnum'); ?>" value="<?php echo $instance['postnum']; ?>" />
				</p>
			</div>
		<?php
	}
}
function _HaLim_Advanced_Widget() {
	register_widget( 'HaLim_Advanced_Widget' );
}
add_action( 'widgets_init', '_HaLim_Advanced_Widget' );