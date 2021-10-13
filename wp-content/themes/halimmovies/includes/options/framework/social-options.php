<?php

$options[]   = array(
    'name'     => 'social_section',
    'title'    => 'Social',
    'icon'     => 'fa fa-share-alt',
    'fields'   => array(

        array(
            'type'    => 'notice',
            'class'   => 'info',
            'content' => 'Enable or disable social sharing buttons on single posts using these buttons.',
        ),

        array(
            'id'       => 'halim_fb_apps_id',
            'type'     => 'text',
            'title'    => 'Facebook Apps ID',
            'attributes' => array(
                'placeholder' => '1384894948437637',
            ),
        ),
        array(
            'id'       => 'halim_fb_apps_admin_id',
            'type'     => 'text',
            'title'    => 'Facebook Admin IDs',
            'attributes' => array(
                'placeholder' => 'Separate by commas',
            ),
        ),

        array(
            'id'       => 'halim_fb_profile_url',
            'type'     => 'text',
            'title'    => 'Facebook Profile URL',
            'attributes' => array(
                'placeholder' => 'https://fb.me/hoangha.us',
            ),
        ),

        array(
            'id'       => 'halim_twitter_url',
            'type'     => 'text',
            'title'    => 'Twitter Profile URL',
            'attributes' => array(
                'placeholder' => 'https://twitter.com/halimplus',
            ),
        ),

        array(
            'id'       => 'halim_gplus_url',
            'type'     => 'text',
            'title'    => 'Google Plus URL',
            'attributes' => array(
                'placeholder' => 'http://google.com/+HaLimPlus',
            ),
        ),

        array(
            'id'       => 'halim_pinterest_url',
            'type'     => 'text',
            'title'    => 'Pinterest Profile URL',
            'attributes' => array(
                'placeholder' => 'https://fb.me/hoangha.us',
            ),
        ),

    )
);