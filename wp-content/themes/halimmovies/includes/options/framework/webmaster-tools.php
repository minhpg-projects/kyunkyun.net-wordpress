<?php

$options[]   = array(
    'name'     => 'webmaster_tools_section',
    'title'    => 'Webmaster Tools',
    'icon'     => 'fa fa-globe',
    'fields'   => array(

        // array(
        //     'type'    => 'notice',
        //     'class'   => 'info',
        //     'content' => 'Enable or disable social sharing buttons on single posts using these buttons.',
        // ),

        array(
            'id'       => 'google_verification',
            'type'     => 'text',
            'title'    => 'Google verification code',
            'attributes' => array(
                'placeholder' => 'Google verification code',
            ),
            'after' => '<p class="cs-text-muted">Get your Google verification code in <a href="https://www.google.com/webmasters/verification/verification?hl=en&tid=alternate&siteUrl='.urlencode(home_url()).'" target="_blank">Google Search Console</a></p>'
        ),
        array(
            'id'       => 'msvalidate',
            'type'     => 'text',
            'title'    => 'Bing verification code',
            'attributes' => array(
                'placeholder' => 'Bing verification code',
            ),
            'after' => '<p class="cs-text-muted">Get your Bing verification code in <a href="https://www.bing.com/toolbox/webmaster/#/Dashboard/?url='.urlencode(home_url()).'" target="_blank">Bing Webmaster Tools</a></p>'
        ),

        array(
            'id'       => 'yandex_verification',
            'type'     => 'text',
            'title'    => 'Yandex verification code',
            'attributes' => array(
                'placeholder' => 'Yandex verification code',
            ),
            'after' => '<p class="cs-text-muted">Get your Yandex verification code in <a href="https://webmaster.yandex.com/sites/add/" target="_blank">Yandex Webmaster Tools</a></p>'
        ),

        array(
            'id'       => 'baidu_verification',
            'type'     => 'text',
            'title'    => 'Baidu verification code',
            'attributes' => array(
                'placeholder' => 'Baidu verification code',
            ),
            'after' => '<p class="cs-text-muted">Get your Baidu verification code in <a href="https://ziyuan.baidu.com/site/siteadd" target="_blank">Baidu Webmaster Tools</a></p>'
        ),
    )
);