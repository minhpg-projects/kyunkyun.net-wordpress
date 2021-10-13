<?php

// ----------------------------------------
// a option section for options overview  -
// ----------------------------------------
$options[]      = array(
  'name'        => 'overwiew',
  'title'       => 'General settings',
  'icon'        => 'fa fa-cog',

  // begin: fields
  'fields'      => array(

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => 'This tab contains common setting options which will be applied to the whole theme.',
    ),

    array(
      'id'    => 'disable_filter_movie',
      'type'  => 'switcher',
      'title' => 'Disable Filter Movie',
      'default' => false,
    ),
    array(
      'id'    => 'disable_emojis',
      'type'  => 'switcher',
      'title' => 'Disable Emojis',
      // 'label' => 'Yes, Please do it.',
      'default' => true,
    ),

    array(
      'id'    => 'halim_light_mode',
      'type'  => 'switcher',
      'title' => 'Light Mode',
      'default' => false,
    ),

    array(
      'id'    => 'halim_light_mode_switch_btn',
      'type'  => 'switcher',
      'title' => 'Show light mode switch button',
      'default' => true,
    ),

    array(
      'id'    => 'alphabet_filter',
      'type'  => 'switcher',
      'title' => 'Alphabet filter',
      'default' => true,
    ),

    array(
      'id'    => 'hide_required_plugins',
      'type'  => 'switcher',
      'title' => 'Hide required plugins notice',
      'default' => true,
    ),

    array(
      'id'      => 'additional_css',
      'type'    => 'textarea',
      'title'   => 'Additional CSS',
      'sanitize' => true,
      'desc'    => 'Add your own CSS code here to customize the appearance and layout of your site. <br><a href="https://codex.wordpress.org/CSS" target="_blank" class="external-link">Learn more about CSS</a>',
      'attributes'    => array(
        'placeholder' => '.class_name { color: #000; padding: 10px; }'
      )
    ),


  ), // end: fields
);