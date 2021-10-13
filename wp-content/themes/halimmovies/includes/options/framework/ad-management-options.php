<?php

// ------------------------------
// Ad Management                    -
// ------------------------------
$options[]   = array(
  'name'     => 'ads_section',
  'title'    => 'Ad Management',
  'icon'     => 'fa fa-line-chart',
  'fields'   => array(

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => 'Now, ad management is easy with our options panel. You can control everything from here, without using separate plugins.',
    ),

    array(
      'id'      => 'posttop_adcode',
      'type'    => 'textarea',
      'title'   => 'Below Post Title',
      'desc'    => 'Paste your Adsense, BSA or other ad code here to show ads below your article title on single posts.',
    ),
    array(
      'id'      => 'posttop_adcode_time',
      'type'    => 'number',
      'title'   => 'Show After X Days',
      'desc'    => 'Enter the number of days after which you want to show the Below Post Title Ad. Enter 0 to disable this feature.',
      'after'   => ' <i class="cs-text-muted">(day)</i>',
      'default' => '0',
    ),

    array(
      'id'      => 'postend_adcode',
      'type'    => 'textarea',
      'title'   => 'Below Post Content',
      'desc'    => 'Paste your Adsense, BSA or other ad code here to show ads below the post content on single posts.',
    ),
    array(
      'id'      => 'postend_adcode_time',
      'type'    => 'number',
      'title'   => 'Show After X Days',
      'desc'    => 'Enter the number of days after which you want to show the Below Post Title Ad. Enter 0 to disable this feature.',
      'after'   => ' <i class="cs-text-muted">(day)</i>',
      'default' => '0',
    ),

  )
);