<?php

class HaLimCore_Scripts extends HaLimCore_Abstract
{
	function __construct()
	{
		$this->addAction( 'admin_enqueue_scripts', 'halim_metaboxes_scripts', 15, 1 );
		$this->addAction('admin_enqueue_scripts', 'halim_license_details_enqueue_scripts', 10, 1);
	}


	public function halim_license_details_enqueue_scripts( $hook ) {

	    if($hook == 'toplevel_page_halim-episode-manager'){
			wp_enqueue_style('simplePagination', get_template_directory_uri(). '/assets/css/simplePagination.css', '', time());
		    wp_enqueue_script('simplePagination', get_template_directory_uri(). '/assets/js/jquery.simplePagination.js', array(), '', true );
		    wp_enqueue_script('jquery-sortable', '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js', array(), '', true );
	    }
	}


	function halim_metaboxes_scripts( $hook ) {
	    global $post;

	    if($hook == 'toplevel_page_halim-episode-manager')
	    {
			wp_enqueue_style('metaboxes-css-components', HALIM_THEME_URI . '/assets/css/halim-eps-metaboxes.css', time(), '');
			wp_enqueue_style('episode-manager', HALIM_THEME_URI . '/assets/css/episode-manager.css', time(), '');
			wp_enqueue_script('metaboxes-add-new-eps', HALIM_THEME_URI. '/assets/js/episode-manager.min.js', array(), time(), true );
			// wp_enqueue_script('metaboxes-add-new-eps', HALIM_THEME_URI. '/assets/js/episode-manager.js', array(), time(), true );
	    }

	    if ( $hook == 'post-new.php' || $hook == 'post.php' )
	    {
	        if ( 'post' === $post->post_type ) {
	        	wp_enqueue_style('metaboxes-css-components', HALIM_THEME_URI . '/assets/css/halim-eps-metaboxes.css', time(), '');
	        	wp_enqueue_script( 'bootstrap-script', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array(), '', true  );
				wp_enqueue_script('metaboxes-page-script', HALIM_THEME_URI. '/assets/js/metaboxes-script.js', array(), time(), true );
			    wp_localize_script(
					'metaboxes-page-script',
					'halimmovies_ajax_object',
			        array(
			        	'ajax_url' => admin_url( 'admin-ajax.php' ),
			        )
			    );
	        }
	    }
	}
}