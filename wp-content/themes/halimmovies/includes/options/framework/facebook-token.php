<?php

// ----------------------------------------
// a option section for options overview  -
// ----------------------------------------
$options[]      = array(
  'name'        => 'facebook_token',
  'title'       => 'Facebook Token',
  'icon'        => 'fa fa-cog',

  // begin: fields
  'fields'      => array(

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => 'This tab contains common setting options which will be applied to the whole theme.',
    ),

    array(
      'id'    => 'enable_old_episode_manager',
      'type'  => 'switcher',
      'title' => 'Showing old episodes manager',
      'label' => 'Displays the old episodes manager in the post editor',
      'default' => false,
    ),


    array(
      'id'      => 'header_code',
      'type'    => 'textarea',
      'title'   => 'Header code',
      'sanitize' => true,
      'desc'    => 'Enter the code which you need to place before closing tag. (ex: Google Webmaster Tools verification, Bing Webmaster Center, BuySellAds Script, Alexa verification etc.)',
    ),

  ), // end: fields
);