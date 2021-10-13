<?php

// ------------------------------
// Sidebar                     -
// ------------------------------
$options[]   = array(
  'name'     => 'sidebar_section',
  'title'    => 'Sidebar',
  'icon'     => 'fa fa-trello',
  'fields'   => array(

		array(
		  'type'    => 'notice',
		  'class'   => 'info',
		  'content' => 'Now you have full control over the sidebars. Here you can manage sidebars and select one for each section of your site, or select a custom sidebar on a per-post basis in the post editor.',
		),

		array(
		  'id'              => 'halim_register_sidebars',
		  'type'            => 'group',
		  'title'           => 'Add Custom Sidebars',
		  'desc'            => 'Add custom sidebars. You need to save the changes to use the sidebars in the dropdowns below. You can add content to the sidebars in <a href="/wp-admin/widgets.php">Appearance > Widgets.</a>',
		  'button_title'    => 'Add Sidebar',
		  'accordion_title' => 'Add Sidebar',
		  'fields'          => array(

			array(
			  'id'          => 'halim_custom_sidebar_name',
			  'type'        => 'text',
			  'title'       => 'Sidebar Name',
			  'after'		=> '<p class="cs-text-muted"> Example: Homepage Sidebar<?p>',
			  'attributes' => array(
					'style'    => 'width: 175px;'
				),
			),

			array(
			  'id'          => 'halim_custom_sidebar_id',
			  'type'        => 'text',
			  'title'       => 'Sidebar ID',
			  'after'		=> '<p class="cs-text-muted">Enter a unique ID for the sidebar. Use only alphanumeric characters, underscores (_) and dashes (-), eg. "sidebar-home"</p>',
			  'attributes' => array(
					'style'    => 'width: 175px;'
				),
			  'default' => 'sidebar-',
			),

		  )
		),



		array(
			  'id'        => 'halim_sidebar_section',
			  'type'      => 'fieldset',
			  'title'     => 'Custom Sidebars',
			  'fields'    => array(
					array(
					  'id'       => 'sidebar_homepage',
					  'type'     => 'sidebar',
					  'title'    => 'Homepage',
					  'desc'     => 'Select a sidebar for the homepage.',
					),
					array(
					  'id'       => 'sidebar_single_post',
					  'type'     => 'sidebar',
					  'title'    => 'Sidebar Post',
					  'desc'     => 'Select a sidebar for the single posts. If a post has a custom sidebar set, it will override this.',
					),
					array(
					  'id'       => 'sidebar_single_video',
					  'type'     => 'sidebar',
					  'title'    => 'Sidebar Video',
					  'desc'     => 'Select a sidebar for the single videos. If a post has a custom sidebar set, it will override this.',
					),
					array(
					  'id'       => 'sidebar_single_news',
					  'type'     => 'sidebar',
					  'title'    => 'Sidebar News',
					  'desc'     => 'Select a sidebar for the single news. If a post has a custom sidebar set, it will override this.',
					),
					array(
					  'id'       => 'sidebar_page',
					  'type'     => 'sidebar',
					  'title'    => 'Sidebar Page',
					  'desc'     => 'Select a sidebar for the single pages. If a page has a custom sidebar set, it will override this.',
					),
					array(
					  'id'       => 'sidebar_archive',
					  'type'     => 'sidebar',
					  'title'    => 'Archive',
					  'desc'     => 'Select a sidebar for the archives. Specific archive sidebars will override this setting (see below).',
					),
					array(
					  'id'       => 'sidebar_category',
					  'type'     => 'sidebar',
					  'title'    => 'Category',
					  'desc'     => 'Select a sidebar for the category archives.',
					),
					array(
					  'id'       => 'sidebar_tag',
					  'type'     => 'sidebar',
					  'title'    => 'Tag Archive',
					  'desc'     => 'Select a sidebar for the tag archives.',
					),
					array(
					  'id'       => 'sidebar_date',
					  'type'     => 'sidebar',
					  'title'    => 'Date Archive',
					  'desc'     => 'Select a sidebar for the date archives.',
					),
					array(
					  'id'       => 'sidebar_search',
					  'type'     => 'sidebar',
					  'title'    => 'Search',
					  'desc'     => 'Select a sidebar for the search results.',
					),
					array(
					  'id'       => 'sidebar_404',
					  'type'     => 'sidebar',
					  'title'    => '404 Error',
					  'desc'     => 'Select a sidebar for the 404 Not found pages.',
					),

			),
		),

	)
);