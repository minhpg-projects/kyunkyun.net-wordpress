<?php

class halim_tagcloud_widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'halim_tagcloud_widget',
			__('HaLim Tag Cloud','halimthemes'),
			array( 'description' => __( 'Display all tags cloud. Drag and Drop on Footer Widget','halimthemes' ) )
		);
	}

 	public function form( $instance ) {
		$defaults = array(
			'number' => 15,
			'smallest' => 8,
			'largest' => 22,
            'taxonomy' => 'post_tag',
			'title'	=> 'Tag Cloud'
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : __( 'Tag Cloud','halimthemes' );
		$number = isset( $instance[ 'number' ] ) ? intval( $instance[ 'number' ] ) : 15;
		$smallest = isset( $instance[ 'smallest' ] ) ? intval( $instance[ 'smallest' ] ) : 8;
		$largest = isset( $instance[ 'largest' ] ) ? intval( $instance[ 'largest' ] ) : 22;
        $taxonomy = isset( $instance[ 'taxonomy' ] ) ? $instance[ 'taxonomy' ] : 'post_tag';
        ob_start();
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title','halimthemes' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
        <p>
            <label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy','halimthemes'); ?>:</label>
            <select id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" style="width:100%;">
                <option value="post_tag" <?php selected('post_tag', $taxonomy); ?>><?php _e('Tags','halimthemes'); ?></option>
                <option value="category" <?php selected('category', $taxonomy); ?>><?php _e('Category','halimthemes'); ?></option>
            </select>
        </p>

		<p>
			<label for="<?php echo $this->get_field_id("smallest"); ?>"><?php _e( 'Show number of smallest', 'halimthemes'); ?>
				<input id="<?php echo $this->get_field_id( 'smallest' ); ?>" name="<?php echo $this->get_field_name( 'smallest' ); ?>" type="number" min="1" step="1" value="<?php echo $smallest; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id("largest"); ?>"><?php _e( 'Show number of largest', 'halimthemes'); ?>
				<input id="<?php echo $this->get_field_id( 'largest' ); ?>" name="<?php echo $this->get_field_name( 'largest' ); ?>" type="number" min="1" step="1" value="<?php echo $largest; ?>" />
			</label>
		</p>


		<p>
	       <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of tag to show', 'halimthemes' ); ?>
	       <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" min="1" step="1" value="<?php echo $number; ?>" />
	       </label>
       </p>

		<?php
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['smallest'] = intval( $new_instance['smallest'] );
		$instance['largest'] = intval( $new_instance['largest'] );
		$instance['number'] = intval( $new_instance['number'] );
		$instance['taxonomy'] = $new_instance['taxonomy'];
		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title    = apply_filters( 'widget_title', $instance['title'] );
		$number   = $instance['number'];
		$taxonomy = $instance['taxonomy'];
		$smallest = $instance['smallest'];
		$largest  = $instance['largest'];
		echo $before_widget;
		if ( ! empty( $title ) ) echo $before_title . $title . $after_title; ?>

	        <div class="video-item halim-entry-box hidden-xs">
	            <div class="item-content tagcloud">
					<?php
						$args = array(
							'smallest'                  => $smallest,
							'largest'                   => $largest,
							'unit'                      => 'pt',
							'number'                    => $number,
							'format'                    => 'flat',
							'separator'                 => "\n",
							'orderby'                   => 'name',
							'order'                     => 'ASC',
							'exclude'                   => null,
							'include'                   => null,
							'topic_count_text_callback' => null,
							'link'                      => 'view',
							'taxonomy' 					=> $taxonomy,
							'echo'                      => true,
							'child_of'                  => null, // see Note!
						);
						wp_tag_cloud( $args );
					?>
	                <div class="clearfix"></div>
	            </div>
	            <div class="item-content-toggle">
	                <div class="item-content-gradient"></div>
	                <span class="show-more hl-angle-down" data-icon="hl-angle-down" data-single="false"></span>
	            </div>
	        </div>
		<?php
		echo $after_widget;
	}
}
register_widget("halim_tagcloud_widget");