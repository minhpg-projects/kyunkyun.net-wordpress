<?php

$options[]   = array(
    'name'     => 'adult_content_section',
    'title'    => 'Adult content',
    'icon'     => 'fa fa-exclamation-triangle',
    'fields'   => array(

        // array(
        //     'type'    => 'notice',
        //     'class'   => 'info',
        //     'content' => 'Enable or disable social sharing buttons on single posts using these buttons.',
        // ),

        array(
            'id'       => 'adult_content_title',
            'type'     => 'text',
            'title'    => 'Title',
            'attributes' => array(
                'placeholder' => 'Adult Content Warning!',
            ),
            'default' => 'Adult Content Warning!'
        ),

        array(
          'id'      => 'adult_content_info_text',
          'type'    => 'wysiwyg',
          'title'   => 'Adult content info',
          'settings' => array(
                'textarea_rows' => 4,
                'tinymce'       => true,
                'media_buttons' => false,
            ),
          'default' => 'This site contains content intended for individuals 18/21 years of age or older as determined by the local and national laws of the region in which you reside. If you are not yet 18+, leave this website immediately. By entering this website, you agree that you are at least 18 years of age or older. You will not redistribute this material to anyone, nor will you permit any minor to view this material.'
        ),

    )
);