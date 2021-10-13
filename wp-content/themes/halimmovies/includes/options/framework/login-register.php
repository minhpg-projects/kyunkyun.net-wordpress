<?php

$options[]   = array(
    'name'     => 'login_register_content_section',
    'title'    => 'Login / Register',
    'icon'     => 'fa fa-user',
    'fields'   => array(


        array(
          'id'    => 'enable_user_login_register',
          'type'  => 'switcher',
          'title' => 'Enable user login/register',
          'default' => true,
        ),


        array(
            'type'    => 'notice',
            'class'   => 'info',
            'content' => 'reCAPTCHA is a free service that protects your website from spam and abuse. reCAPTCHA uses an advanced risk analysis engine and adaptive challenges to keep automated software from engaging in abusive activities on your site. It does this while letting your valid users pass through with ease.',
        ),

        array(
            'id'       => 'recaptcha_site_key',
            'type'     => 'text',
            'title'    => 'reCAPTCHA site key',
            'desc'     => '<a href="https://www.google.com/recaptcha/admin#list" target="_blank">Click here</a> to create or view keys for Google reCaptcha.',
            'attributes' => array(
                'placeholder' => 'reCAPTCHA site key',
            ),
            'default' => get_option('login_nocaptcha_key') ?: ''
        ),

        array(
          'id'      => 'recaptcha_secret_key',
            'type'     => 'text',
            'title'    => 'reCAPTCHA secret key',
            'attributes' => array(
                'placeholder' => 'reCAPTCHA secret key',
            ),
            'default' => get_option('login_nocaptcha_secret') ?: ''
        ),

    )
);