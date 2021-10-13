<?php

// ------------------------------
// accordion sections           -
// ------------------------------
$options[]   = array(
  'name'     => 'accordion_section',
  'title'    => 'Advanced settings',
  'icon'     => 'fa fa-cogs',
  'sections' => array(

    array(
      'name'     => 'homepage_section',
      'title'    => 'Homepage',
      'icon'     => 'fa fa-home',
	  'fields'    => array(
							array(
							  'type'    => 'notice',
							  'class'   => 'success',
							  'content' => 'From here, you can control the appearance and functionality of your homepage.',
							),

							array(
								  'id'             => 'vhtube_homepage_layouts',
								  'type'           => 'sorter',
								  'title'          => 'Homepage Templates',
								  'desc'		   => 'You are only allowed to use 1 of the 3 Widget include <b>"All Posts"</b>, <b>"Latest Videos"</b> and <b>"Latest Posts"</b>. If using <b>"Latest Videos"</b>, you need to disable <b>"All Posts"</b> and <b>"Latest Posts"</b>. <br /> You can change position by dragging and dropping widgets to get the best layout.',
								  'default'        => array(
									'enabled'      => array(
										'widget_box_on_top'   	 => 'Widget box on top',
										'latest_video'   		 => 'Latest Videos',
									),
									'disabled'     => array(
										'recent_post_all'		 => 'All Posts',
										'latest_post'    		 => 'Latest Posts',
										'widget_box_on_bottom'   => 'Widget box on bottom',
									),
								  ),
								),

							array(
							  'id'          => 'homepage_post_column',
							  'type'        => 'radio',
							  'title'       => 'Homepage post column',
							  'desc'		=> 'Select post column want to show on homepage.',
							  'options'     => array(
								'col-md-6'  => '2 Column',
								'col-md-4'  => '3 Column',
								'col-md-3'  => '4 Column',
								'col-md-2'	=> '6 Column (For Fullwidth layout)',
							  ),
							  'default'    =>  'col-md-4',
							),
							array(
							  'id'           => 'homepage_sidebar_layout',
							  'type'         => 'image_select',
							  'title'        => 'Layout Style',
							  'desc'	     => 'Choose the default sidebar position for your site. The position of the sidebar for individual posts can be set in the post editor. Note: This will not change sidebar position on homepage.',
							  'options'      => array(
								'left_sidebar'      => HALIM_THEME_URI.'/assets/images/left-sidebar.png',
								'full_width'    	=> HALIM_THEME_URI.'/assets/images/fullwidth.png',
								'right_sidebar'     => HALIM_THEME_URI.'/assets/images/right-sidebar.png',
							  ),
							  'radio'        => true,
							  'default'      => 'right_sidebar'
							),
							array(
							  'id'         => 'homepage_meta_info',
							  'type'       => 'checkbox',
							  'title'      => 'Homepage post meta info',
							  'class'      => 'horizontal',
							  'desc'	   => 'Organize how you want the post meta info to appear on the homepage',
							  'options'    => array(
								'view_count'    => 'View Count',
								'cmt_count'     => 'Comment Count',
								'duration'     => 'Duration',
								'liked'        => 'Likes count',
								'format_icon'  => 'Format icon',
								'published'    => 'Published time'
							  ),
							  'default'    =>  array( 'viewcount', 'liked', 'published' ),
							),
							  array(
								  'id'         => 'homepage_featured_box',
								  'type'       => 'radio',
								  'title'      => 'Featured box',
								  'options'    => array(
									'searchform'      => 'Search form',
									'carousel_slider' => 'Slider Show',
									'featured_post' => 'Featured Posts',
									'featured_videos' => 'Featured Videos'
								  ),
								  'default'    => 'searchform'
							  ),
							array(
							  'id'        => 'vhtube_homepage_slide_show',
							  'type'      => 'fieldset',
							  'title'     => 'Slider Options',
							  'dependency'   => array( 'homepage_featured_box_carousel_slider', '==', 'true' ),
							  'fields'    => array(

									array(
									  'id'             => 'homepage_carousel_slider_cat',
									  'type'           => 'select',
									  'title'          => 'Select Categories',
									  'options'        => 'categories',
									  'default_option' => 'Select a category',
									  'attributes' => array(
										'multiple' => 'only-key',
										'style'    => 'width: 150px; height: 125px;'
									  ),
									),
									   array(
										'id'      => 'homepage_slider_number_post',
										'type'    => 'number',
										'title'   => 'Number of post to show',
										),

									  array(
											  'id'                 => 'homepage_slide_order_block',
											  'type'               => 'select',
											  'title'              => 'Order by',
											  'options'            => array(
												'date'              => 'Date',
												'rand'             => 'Rand'
											  ),
											),
									  ),

							  'default'   => array(
								'homepage_slider_number_post' => 12,
							  ),
							),

							array(
								'id'      => 'homepage_featured_box_bg',
								'type'    => 'color_picker',
								'title'   => 'Featured box background',
								'default' => '#3e3e3e',
							),
							array(
							  'id'          => 'homepage_pagination_type',
							  'type'        => 'radio',
							  'title'       => 'Homepage Pagination Type',
							  'desc'        => 'Select pagination type.',
							  'options'     => array(
								'default'   => 'Next / Previous',
								'numbered'  => 'Numbered (1 2 3 4...)',
								'loadmore'  => 'Ajax (Load More Button)',
								'infinite'  => 'Ajax (Auto Infinite Scroll)'
							  ),
							  'default'   => 'numbered'
							),


			  ),
    ),

    array(
      'name'     => 'archive_section',
      'title'    => 'Archives',
      'icon'     => 'fa fa-archive',
	  'fields'    => array(
						  array(
						  'type'    => 'notice',
						  'class'   => 'success',
						  'content' => 'From here, you can control the appearance and functionality of your archive.',
						),
							array(
							  'id'          => 'archive_post_column',
							  'type'        => 'radio',
							  'title'       => 'Archive post column',
							  'class'       => 'horizontal',
							  'desc'		=> 'Select post column want to show on archive.',
							  'options'     => array(
								'col-md-12' => '1 Column',
								'col-md-6'  => '2 Column',
								'col-md-4'  => '3 Column',
								'col-md-3'  => '4 Column',
								'col-md-2'	=> '6 Column (For Fullwidth layout)',
							  ),
							  'default'    =>  'col-md-4',
							),
							array(
							  'id'           => 'archive_sidebar_layout',
							  'type'         => 'image_select',
							  'title'        => 'Layout Style',
							  'desc'	     => 'Choose the default sidebar position for your site. The position of the sidebar for individual posts can be set in the post editor. Note: This will not change sidebar position on archive.',
							  'options'      => array(
								'left_sidebar'      => HALIM_THEME_URI.'/assets/images/left-sidebar.png',
								'full_width'    	=> HALIM_THEME_URI.'/assets/images/fullwidth.png',
								'right_sidebar'     => HALIM_THEME_URI.'/assets/images/right-sidebar.png',
							  ),
							  'radio'        => true,
							  'default'      => 'right_sidebar'
							),
							array(
							  'id'         => 'archive_meta_info',
							  'type'       => 'checkbox',
							  'title'      => 'Archive post meta info',
							  'class'      => 'horizontal',
							  'desc'	   => 'Organize how you want the post meta info to appear on the archive',
							  'options'    => array(
								'view_count'    => 'View Count',
								'cmt_count'     => 'Comment Count',
								'duration'     => 'Duration',
								'liked'        => 'Likes count',
								'format_icon'  => 'Format icon',
								'published'    => 'Published time'
							  ),
							  'default'    =>  array( 'viewcount', 'liked', 'published' ),
							),
							  array(
								  'id'         => 'archive_featured_box',
								  'type'       => 'radio',
								  'title'      => 'Featured box',
								  'options'    => array(
									'searchform'      => 'Search form',
									'carousel_slider' => 'Slider Show',
									'featured_post' => 'Featured Posts',
									'featured_videos' => 'Featured Videos'
								  ),
								  'default'    => 'searchform'
							  ),
							array(
							  'id'        => 'vhtube_archive_slide_show',
							  'type'      => 'fieldset',
							  'title'     => 'Slider Options',
							  'dependency'   => array( 'archive_featured_box_carousel_slider', '==', 'true' ),
							  'fields'    => array(

									array(
									  'id'             => 'archive_carousel_slider_cat',
									  'type'           => 'select',
									  'title'          => 'Select Categories',
									  'options'        => 'categories',
									  'default_option' => 'Select a category',
									  'attributes' => array(
										'multiple' => 'only-key',
										'style'    => 'width: 150px; height: 125px;'
									  ),
									),
									array(
										'id'      => 'archive_slider_number_post',
										'type'    => 'number',
										'title'   => 'Number of post to show',
									),

									  array(
										  'id'                 => 'archive_slide_order_block',
										  'type'               => 'select',
										  'title'              => 'Order by',
										  'options'            => array(
											'date'              => 'Date',
											'rand'             => 'Rand'
										  ),
											),
									  ),

							  'default'   => array(
								'archive_slider_number_post' => 12,
							  ),
							),

							array(
								'id'      => 'archive_featured_box_bg',
								'type'    => 'color_picker',
								'title'   => 'Featured box background',
								'default' => '#3e3e3e',
							),
							array(
							  'id'          => 'archive_pagination_type',
							  'type'        => 'radio',
							  'title'       => 'Archive Pagination Type',
							  'desc'        => 'Select pagination type.',
							  'options'     => array(
								'default'   => 'Next / Previous',
								'numbered'  => 'Numbered (1 2 3 4...)',
								'loadmore'  => 'Ajax (Load More Button)',
								'infinite'  => 'Ajax (Auto Infinite Scroll)'
							  ),
							  'default'   => 'numbered'
							),


			  ),
    ),



    array(
      'name'     => 'single_post_section',
      'title'    => 'Single Post',
      'icon'     => 'fa fa-book',
	  'fields'    => array(
							array(
							  'type'    => 'notice',
							  'class'   => 'info',
							  'content' => 'From here, you can control the appearance and functionality of your single posts page',
							),
							array(
							  'id'        => 'single_post_options',
							  'type'      => 'fieldset',
							  'title'     => 'Single Post Options',
							  'fields'    => array(
								array(
								  'id'    => 'show_feature_image',
								  'type'  => 'switcher',
								  'title' => 'Show feature image',
								),
								array(
								  'id'    => 'display_related_post',
								  'type'  => 'switcher',
								  'title' => 'Show related post',
								),
								 array(
								  'id'      => 'related_post_number',
								  'type'    => 'number',
								  'title'   => 'Number of post to show',
								  ),


								array(
								  'id'    => 'display_random_post',
								  'type'  => 'switcher',
								  'title' => 'Show random post',
								),
								 array(
								  'id'      => 'random_post_number',
								  'type'    => 'number',
								  'title'   => 'Number of post to show',
								  ),

								array(
								  'id'    => 'show_next_prev_post',
								  'type'  => 'switcher',
								  'title' => 'Show Next/prev post',
								),
							),

							  'default'   => array(
								'display_related_post'	=> true,
								'related_post_number'	=> 4,
								'display_random_post'	=> true,
								'random_post_number'	=> 4,
								'show_next_prev_post'	=> true
							  ),
							),

			  ),
    ),

    array(
      'name'     => 'single_video_section',
      'title'    => 'Single Video',
      'icon'     => 'fa fa-youtube-play',
	  'fields'    => array(
							array(
							  'type'    => 'notice',
							  'class'   => 'info',
							  'content' => 'From here, you can control the appearance and functionality of your single posts page',
							),
							array(
							  'id'        => 'single_video_options',
							  'type'      => 'fieldset',
							  'title'     => 'Single Video Options',
							  'fields'    => array(
									array(
									  'id'    => 'display_related_video',
									  'type'  => 'switcher',
									  'title' => 'Show related videos',
									),
									 array(
									  'id'      => 'related_video_number',
									  'type'    => 'number',
									  'title'   => 'Number of video to show',
									  ),
									array(
									  'id'    => 'display_random_video',
									  'type'  => 'switcher',
									  'title' => 'Show random video',
									),
									 array(
									  'id'      => 'random_video_number',
									  'type'    => 'number',
									  'title'   => 'Number of video to show',
									  ),

									array(
									  'id'    => 'show_next_prev_video',
									  'type'  => 'switcher',
									  'title' => 'Show Next/prev video',
									),
								),

							  'default'   => array(
								'display_related_video'	=> true,
								'related_video_number'	=> 6,
								'display_random_video'	=> true,
								'random_video_number'	=> 6,
								'show_next_prev_video'	=> true
							  ),
							),

			  ),
    ),


    array(
      'name'     => 'page_layout_section',
      'title'    => 'Page Layout',
      'icon'     => 'fa fa-list-alt',
	  'fields'    => array(
						  array(
						  'type'    => 'notice',
						  'class'   => 'success',
						  'content' => 'Page Layout',
						),
							array(
							  'id'          => 'page_layout_columns',
							  'type'        => 'radio',
							  'title'       => 'Columns',
							  'options'     => array(
								'col-md-4'  => '3 Column',
								'col-md-3'  => '4 Column',
								'col-md-6'  => '2 Column',
							  ),
							  'default'    =>  'col-md-4',
							),
							  array(
								  'id'         => 'page_article',
								  'type'       => 'checkbox',
								  'title'      => 'Show details?',
								  'class'      => 'horizontal',
								  'options'    => array(
									'viewcount'    => 'Views Count',
									'duration'    => 'Durations',
									'liked'        => 'Likes count',
									'format_icon'  => 'Format icon',
									'published'     => 'Published time'
								  ),
								  'default'    =>  array( 'viewcount', 'liked' ),
								),
							  array(
								  'id'         => 'page_sidebar_layout',
								  'type'       => 'radio',
								  'title'      => 'Sidebar Layouts',
								  'options'    => array(
									'right_sidebar'     => 'Right Sidebar',
									'left_sidebar' 		=> 'Left Sidebar',
									'full_width' 		=> 'Full Width'
								  ),
								  'default'    =>  'right_sidebar',
							  ),

			  ),
    ),



    array(
      'name'     => 'search_section',
      'title'    => 'Search/Tags',
      'icon'     => 'fa fa-tags',
	  'fields'    => array(
						  array(
						  'type'    => 'notice',
						  'class'   => 'success',
						  'content' => 'From here, you can control the appearance and functionality of your search archive.',
						),
							array(
							  'id'          => 'search_post_column',
							  'type'        => 'radio',
							  'title'       => 'Search post column',
							  'class'       => 'horizontal',
							  'desc'		=> 'Select post column want to show on search archive.',
							  'options'     => array(
								'col-md-12' => '1 Column',
								'col-md-6'  => '2 Column',
								'col-md-4'  => '3 Column',
								'col-md-3'  => '4 Column',
								'col-md-2'	=> '6 Column (For Fullwidth layout)',
							  ),
							  'default'    =>  'col-md-4',
							),
							array(
							  'id'           => 'search_sidebar_layout',
							  'type'         => 'image_select',
							  'title'        => 'Layout Style',
							  'desc'	     => 'Choose the default sidebar position for your site. The position of the sidebar for individual posts can be set in the post editor. Note: This will not change sidebar position on search archive.',
							  'options'      => array(
								'left_sidebar'      => HALIM_THEME_URI.'/assets/images/left-sidebar.png',
								'full_width'    	=> HALIM_THEME_URI.'/assets/images/fullwidth.png',
								'right_sidebar'     => HALIM_THEME_URI.'/assets/images/right-sidebar.png',
							  ),
							  'radio'        => true,
							  'default'      => 'right_sidebar'
							),
							array(
							  'id'         => 'search_meta_info',
							  'type'       => 'checkbox',
							  'title'      => 'Search post meta info',
							  'class'      => 'horizontal',
							  'desc'	   => 'Organize how you want the post meta info to appear on the search archive',
							  'options'    => array(
								'view_count'   => 'View Count',
								'cmt_count'    => 'Comment Count',
								'duration'     => 'Duration',
								'liked'        => 'Likes count',
								'format_icon'  => 'Format icon',
								'published'    => 'Published time'
							  ),
							  'default'    =>  array( 'viewcount', 'liked', 'published' ),
							),
							  array(
								  'id'         => 'search_featured_box',
								  'type'       => 'radio',
								  'title'      => 'Featured box',
								  'options'    => array(
									'searchform'      => 'Search form',
									'carousel_slider' => 'Slider Show',
									'featured_post' => 'Featured Posts',
									'featured_videos' => 'Featured Videos'
								  ),
								  'default'    => 'searchform'
							  ),
							array(
							  'id'        => 'vhtube_search_slide_show',
							  'type'      => 'fieldset',
							  'title'     => 'Slider Options',
							  'dependency'   => array( 'search_featured_box_carousel_slider', '==', 'true' ),
							  'fields'    => array(

									array(
									  'id'             => 'search_carousel_slider_cat',
									  'type'           => 'select',
									  'title'          => 'Select Categories',
									  'options'        => 'categories',
									  'default_option' => 'Select a category',
									  'attributes' => array(
										'multiple' => 'only-key',
										'style'    => 'width: 150px; height: 125px;'
									  ),
									),
									   array(
										'id'      => 'search_slider_number_post',
										'type'    => 'number',
										'title'   => 'Number of post to show',
										),

									  array(
											  'id'                 => 'search_slide_order_block',
											  'type'               => 'select',
											  'title'              => 'Order by',
											  'options'            => array(
												'date'              => 'Date',
												'rand'             => 'Rand'
											  ),
											),
									  ),

							  'default'   => array(
								'search_slider_number_post' => 12,
							  ),
							),

							array(
								'id'      => 'search_featured_box_bg',
								'type'    => 'color_picker',
								'title'   => 'Featured box background',
								'default' => '#3e3e3e',
							),
							array(
							  'id'          => 'search_pagination_type',
							  'type'        => 'radio',
							  'title'       => 'Search archive Pagination Type',
							  'desc'        => 'Select pagination type.',
							  'options'     => array(
								'default'   => 'Next / Previous',
								'numbered'  => 'Numbered (1 2 3 4...)',
								'loadmore'  => 'Ajax (Load More Button)',
								'infinite'  => 'Ajax (Auto Infinite Scroll)'
							  ),
							  'default'   => 'numbered'
							),


			  ),

    ),

  ),
);