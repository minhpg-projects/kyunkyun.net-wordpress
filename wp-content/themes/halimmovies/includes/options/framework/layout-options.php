<?php

// ----------------------------------------
// a option section for options overview  -
// ----------------------------------------
$options[]      = array(
  'name'        => 'layout_options',
  'title'       => 'Layout',
  'icon'        => 'fa fa-wpforms',

  // begin: fields
  'fields'      => array(

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => 'This tab contains common setting options which will be applied to the whole theme.',
    ),

    array(
      'id'    => 'corner_rounded',
      'type'  => 'switcher',
      'title' => 'Round corners poster image',
      'label' => 'Round corners poster image',
      'default' => false,
    ),
    array(
      'id'    => 'halim_lazyload_image',
      'type'  => 'switcher',
      'title' => 'Lazyload Images',
      'default' => true,
    ),

    array(
      'id'    => 'halim_tooltip_post_info',
      'type'  => 'switcher',
      'title' => 'Tooltip post info',
      'default' => true,
    ),
    array(
      'id'           => 'halim_post_item_title_display',
      'type'         => 'image_select',
      'title'        => 'Select the style to display the movie title',
      'options'      => array(
        'default'    => HALIM_THEME_URI.'/assets/images/post-item-style-default.png',
        'style-1'    => HALIM_THEME_URI.'/assets/images/post-item-style-1.png',
        'style-2'    => HALIM_THEME_URI.'/assets/images/post-item-style-2.png',
        'style-3'    => HALIM_THEME_URI.'/assets/images/post-item-style-3.png',
      ),
      'radio'        => true,
      'default'      => 'default'
    ),

  ), // end: fields
);