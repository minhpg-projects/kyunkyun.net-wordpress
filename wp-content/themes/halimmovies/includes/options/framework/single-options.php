<?php

// ------------------------------
// Single options                     -
// ------------------------------
$options[]   = array(
  'name'     => 'single_template_section',
  'title'    => 'Single post options',
  'icon'     => 'fa fa-address-card-o',
  'fields'   => array(

    array(
      'id'    => 'enable_old_episode_manager',
      'type'  => 'switcher',
      'title' => 'Showing old episodes manager',
      'label' => 'Displays the old episodes manager in the post editor',
      'default' => false,
    ),

    array(
      'id'    => 'disable_gutenberg',
      'type'  => 'switcher',
      'title' => 'Disable Gutenberg',
      'desc'  => 'This option disables the new Gutenberg Editor (aka Block Editor) and replaces it with the Classic Editor',
      'label' => 'Disable Gutenberg completely',
      'default' => true,
    ),

    array(
      'id'             => 'single_template',
      'type'           => 'select',
      'title'          => 'Single Post Template',
      'options'        => array(
        'template-1'      => 'Single Template 1',
        'template-2'      => 'Single Template 2',
      ),
      'default'        => 'template-2',
      'default_option' => 'Default Template',
    ),



    array(
      'id'      => 'watch_btn_display',
      'type'    => 'radio',
      'title'   => 'Watch button',
      'class'   => 'vertical',
      'options' => array(
        'first_episode' => 'First episode',
        'last_episode' => 'Last episode',
      ),
      'default'   => 'first_episode',
      // 'after'   => '<div class="cs-text-muted">Reference site about Lorem Ipsum, a random Lipsum generator.</div>',
    ),

    array(
      'id'      => 'post_content_display_detail_page',
      'type'    => 'radio',
      'title'   => 'Post content (Detail page)',
      'class'   => 'vertical',
      'options' => array(
        'collapsible' => 'Thu nhỏ',
        'visible' => 'Visible',
      ),
      'default'   => 'collapsible',
      // 'after'   => '<div class="cs-text-muted">Reference site about Lorem Ipsum, a random Lipsum generator.</div>',
    ),

    array(
      'id'      => 'post_content_display_watch_page',
      'type'    => 'radio',
      'title'   => 'Post content (Watch page)',
      'class'   => 'vertical',
      'options' => array(
        'collapsible' => 'Thu nhỏ',
        'visible' => 'Visible',
      ),
      'default'   => 'collapsible',
    ),


    array(
      'id'      => 'episode_list_display',
      'type'    => 'radio',
      'title'   => 'Episode list (Detail page)',
      'class'   => 'vertical',
      'options' => array(
        'collapsible' => 'Thu nhỏ',
        'visible' => 'Visible',
      ),
      'default'   => 'collapsible',
    ),


    array(
      'id'      => 'episode_pagination',
      'type'    => 'number',
      'title'   => 'Episode pages show at most',
      'default' => '100',
      'desc'    => 'The number of episodes displayed on the page',
    ),


    array(
      'id'           => 'halim_episode_display',
      'type'         => 'image_select',
      'title'        => 'Select the style to display the episode list',
      'options'      => array(
        'show_tab_eps'    => HALIM_THEME_URI.'/assets/images/show_tab_episode.png',
        'show_list_eps'    => HALIM_THEME_URI.'/assets/images/show_list_episode.png',
        'show_paging_eps'    => HALIM_THEME_URI.'/assets/images/show_list_paging.png',
      ),
      'radio'        => true,
      'default'      => 'show_list_eps'
    ),


    array(
      'id'             => 'episode_display_mode',
      'type'           => 'select',
      'title'          => 'Episode order',
      'options'        => array(
        'asc'      => 'ASC',
        'desc'      => 'DESC',
      ),
      'default'        => 'asc'
    ),



    array(
      'id'    => 'removing_post_redirect',
      'type'  => 'switcher',
      'title' => 'Removing the redirect after changing a post or page\'s slug',
      'default' => false,
    ),

    array(
      'id'      => 'single_notice',
      'type'    => 'wysiwyg',
      'title'   => 'Notice',
      'help'    => 'This notice has been display in all posts',
      'settings' => array(
            'textarea_rows' => 4,
            'tinymce'       => true,
            'media_buttons' => false,
        ),
    ),

    array(
      'id'    => 'enable_disqus_comment',
      'type'  => 'switcher',
      'title' => 'Enable Disqus Comment',
      'default' => false,
    ),

    array(
      'id'    => 'disqus_shortname',
      'type'  => 'text',
      'title' => 'Disqus shortname',
        'attributes'    => array(
          'placeholder' => 'halimthemes'
        ),
      'default' => 'halimthemes',
      'desc'    => 'For example: <b style="color:red;">halimthemes</b>.disqus.com',
    ),


    array(
      'id'    => 'enable_fb_comment',
      'type'  => 'switcher',
      'title' => 'Enable Facebook Comment',
      'default' => true,
    ),

    array(
      'id'      => 'fb_comment_display',
      'type'    => 'number',
      'title'   => 'Number of comment to show',
      'default' => '5',
      'desc'    => 'The number of comments to show by default. The minimum value is 1.',
    ),

    array(
      'id'             => 'fb_comment_order_by',
      'type'           => 'select',
      'title'          => 'Order by',
      'options'        => array(
        'reverse_time'      => 'Reverse time',
        'social'            => 'Social',
        'time'              => 'Time',
      ),
      'default'        => 'reverse_time',
      'desc'    => 'The order to use when displaying comments. Can be "social", "reverse_time", or "time". The different order types are explained <a href="https://developers.facebook.com/docs/plugins/comments/?locale=en_US#faqorder" target="_blank">in the FAQ</a>',
    ),

  )
);