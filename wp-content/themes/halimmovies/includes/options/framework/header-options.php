<?php

// ----------------------------------------
// a option section for options overview  -
// ----------------------------------------
$options[]      = array(
  'name'        => 'header_options',
  'title'       => 'Header',
  'icon'        => 'fa fa-window-maximize',

  // begin: fields
  'fields'      => array(

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => 'This tab contains common setting options which will be applied to the whole theme.',
    ),

    array(
      'id'        => 'site_logo',
      'type'      => 'image',
      'title'     => 'Site Logo',
      'desc'      => 'Upload your logo using the Upload Button.',
      'add_title' => 'Add Logo',
    ),

    array(
      'id'             => 'favicon',
      'type'           => 'upload',
      'title'          => 'Favicon',
      'desc'           => 'Upload a 16 x 16 px image that will represent your website\'s favicon.',
      'settings'       => array(
    'upload_type'  => 'image/x-icon',
        'button_title' => 'Upload',
        'frame_title'  => 'Choose a favicon',
        'insert_title' => 'Use this favicon',
      ),
    ),
    array(
      'id'             => 'apple_touch_icon',
      'type'           => 'upload',
      'title'          => 'Apple touch icon',
      'desc'           => 'Upload a 152 x 152 px image that will represent your website\'s touch icon for iOS 2.0+ and Android 2.1+ devices.',
      'settings'       => array(
    'upload_type'  => 'image/png',
        'button_title' => 'Upload',
        'frame_title'  => 'Choose a icon',
        'insert_title' => 'Use this icon',
      ),
    ),
    array(
      'id'    => 'hover_dropdown_menu',
      'type'  => 'switcher',
      'title' => 'Dropdown menu on hover',
      'default' => true,
    ),
    array(
      'id'    => 'enable_live_search',
      'type'  => 'switcher',
      'title' => 'Enable Ajax Live Search',
      'default' => true,
    ),

    array(
      'id'    => 'show_total_post_in_search_form',
      'type'  => 'switcher',
      'title' => 'Show total post count in search form',
      'default' => true,
    ),

    array(
      'id'      => 'header_code',
      'type'    => 'textarea',
      'title'   => 'Header code',
      'sanitize' => true,
      'desc'    => 'Enter the code which you need to place before closing tag. (ex: Google Webmaster Tools verification, Bing Webmaster Center, BuySellAds Script, Alexa verification etc.)',
    ),

    array(
      'id'    => 'enable_header_banner_ads',
      'type'  => 'switcher',
      'title' => 'Enable header ad',
      'default' => false,
    ),

    array(
      'id'      => 'header_banner_ads',
      'type'    => 'textarea',
      'title'   => 'Header Ad code',
      'sanitize' => true,
      'desc'    => 'Use HTML, CSS, JS code',
    ),

  ), // end: fields
);