<?php

// ----------------------------------------
// a option section for options overview  -
// ----------------------------------------
$options[]      = array(
  'name'        => 'footer_options',
  'title'       => 'Footer',
  'icon'        => 'fa fa-window-maximize',

  // begin: fields
  'fields'      => array(

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => 'This tab contains common setting options which will be applied to the whole theme.',
    ),
    array(
      'id'        => 'footer_logo',
      'type'      => 'image',
      'title'     => 'Footer Logo',
      'desc'      => 'Upload your logo using the Upload Button.',
      'add_title' => 'Add Logo',
    ),


    array(
      'id'      => 'footer_code',
      'type'    => 'textarea',
      'title'   => 'Footer code',
      'sanitize' => true,
      'desc'    => 'Enter the codes which you need to place in your footer. Tracking Code or any other JavaScript. (ex: Google Analytics, Clicky, Woopra, Histats, etc.).',
    ),
    array(
      'id'    => 'enable_footer_banner_ads',
      'type'  => 'switcher',
      'title' => 'Enable footer ad',
      'default' => false,
    ),

    array(
      'id'      => 'footer_banner_ads',
      'type'    => 'textarea',
      'title'   => 'Footer ad code',
      'sanitize' => true,
      'desc'    => 'Use HTML, CSS, JS code',
    ),



    array(
      'id'      => 'footer_about_text',
      'type'    => 'wysiwyg',
      'title'   => 'Footer About Text',
      'help'    => 'You can change or remove our link from footer and use your own custom text. (Link back is always appreciated)',
      'settings' => array(
            'textarea_rows' => 4,
            'tinymce'       => true,
            'media_buttons' => false,
          )
    ),

    array(
      'id'      => 'copyright_text',
      'type'    => 'wysiwyg',
      'title'   => 'Copyright Text',
      'help'    => 'You can change or remove our link from footer and use your own custom text. (Link back is always appreciated)',
      'settings' => array(
            'textarea_rows' => 4,
            'tinymce'       => true,
            'media_buttons' => false,
          )
    ),
    array(
      'id'      => 'footer_right_text',
      'type'    => 'wysiwyg',
      'title'   => 'Footer Right',
      'help'    => 'You can change or remove our link from footer and use your own custom text. (Link back is always appreciated)',
      'settings' => array(
            'textarea_rows' => 4,
            'tinymce'       => true,
            'media_buttons' => false
          )
    ),


  ), // end: fields
);