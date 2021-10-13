<?php

$default_ep_name = get_bloginfo('language') == 'vi-VN' ? 'tập' : 'episode';
$default_ep_slug = get_bloginfo('language') == 'vi-VN' ? 'tap' : 'ep';

$options[]   = array(
    'name'     => 'slug_section',
    'title'    => 'SEO Optimization',
    'icon'     => 'fa fa-link',
    'fields'   => array(

        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => 'This change of <b>Watch URL</b> does not apply to Default Template on Single Options',
        ),

        array(
          'id'    => 'auto_config_yoast_seo',
          'type'  => 'switcher',
          'title' => 'Auto config Yoast SEO',
          'default' => true,
        ),

        array(
          'id'    => 'display_custom_title',
          'type'  => 'switcher',
          'title' => 'Display custom title on the info page (including episode, release, quality...)',
          'default' => false,
        ),

        array(
          'id'    => 'halim_remove_categories_prefix',
          'type'  => 'switcher',
          'title' => 'Remove the categories prefix',
          'default' => true,
          'desc' => 'Category URLs in WordPress contain a prefix, usually <strong>/category/</strong>, this feature removes that prefix, for categories only.',
        ),

        array(
            'id'       => 'halim_seo_title',
            'type'     => 'text',
            'title'    => 'SEO title (Page movie info)',
            'attributes' => array(
                'placeholder' => 'Film {title} {quality}',
            ),
            'default'        => '{title} {quality}',
            'desc'           => 'Modify your SEO title by editing it right here',
            'after' => '<p class="cs-text-muted">{title} = film title, {episode} = film episode, {quality} = film quality, {release} = released, {org_title} = original title, {runtime} = duration, {country} = country</p>'
        ),

        array(
            'id'       => 'halim_seo_title_watch_page',
            'type'     => 'text',
            'title'    => 'SEO title (Page watch movie)',
            'attributes' => array(
                'placeholder' => 'Watch {title} {episode} {quality}',
            ),
            'default'        => 'Watch {title} {episode} {quality}',
            'desc'           => 'Modify your SEO title by editing it right here',
            'after' => '<p class="cs-text-muted">{title} = film title, {episode} = film episode, {quality} = film quality, {release} = released, {org_title} = original title, {runtime} = duration, {country} = country</p>'
        ),

        array(
            'id'       => 'halim_watch_url',
            'type'     => 'text',
            'title'    => 'Watch URL',
            'attributes' => array(
                'placeholder' => 'watch, xem-phim, xem, phim, film...',
            ),
            'default'        => 'watch',
            'desc'           => 'watch, xem-phim, xem, phim...',
            'after' => '<p class="cs-text-muted">example.com/<b style="color: red;">watch</b>-the-movie-title/<br>example.com/<b style="color: red;">xem-phim</b>-the-movie-title/</p>'
        ),

        array(
            'id'       => 'halim_episode_name',
            'type'     => 'text',
            'title'    => 'Default Episode Name',
            'attributes' => array(
                'placeholder' => 'Tập, Episode',
            ),
            'default'        => $default_ep_name,
            'desc'           => 'Tập, EP, Episode (Show alternative if the episode name is not set, or set to integer)',
            // 'after' => '<p class="cs-text-muted">https://halimthemes.com/watch/the-movie-title-<b style="color: red;">eps</b>-1-server-1/<br>https://halimthemes.com/xem-phim/the-movie-title-<b style="color: red;">tap</b>-1-server-1/<br>https://halimthemes.com/the-movie-title-<b style="color: red;">eps</b>-1-server-1/<br>https://halimthemes.com/the-movie-title-<b style="color: red;">tap</b>-1-s1/</p>'
        ),


        array(
            'id'       => 'halim_episode_url',
            'type'     => 'text',
            'title'    => 'Default Episode URL',
            'attributes' => array(
                'placeholder' => 'ep, eps, episode, tap...',
            ),
            'default'        => $default_ep_slug,
            'desc'           => 'ep, eps, episode, tap... (Show alternative if the episode name is not set, or set to integer)',
            'after' => '<p class="cs-text-muted">example.com/watch-the-movie-title/<b style="color: red;">tap</b>-1-sv1.html<br>example.com/xem-phim-the-movie-title/<b style="color: red;">tap</b>-1-sv1.html</p>'
        ),

        array(
            'id'       => 'halim_server_url',
            'type'     => 'text',
            'title'    => 'Server URL',
            'attributes' => array(
                'placeholder' => 'server, s, sv...',
            ),
            'default'        => 'server',
            'desc'           => 'server, s...',
            // 'after' => '<p class="cs-text-muted">https://halimthemes.com/watch/the-movie-title-eps-1-<b style="color: red;">server</b>-1/<br>https://halimthemes.com/watch/the-movie-title-eps-1-<b style="color: red;">s</b>1/<br>https://halimthemes.com/xem-phim/the-movie-title-tap-1-<b style="color: red;">sv</b>1/</p>'
        ),

        array(
            'id'             => 'halim_url_type',
            'type'           => 'select',
            'title'          => 'URL Type',
            'options'        => array(
                'slug-1'      => 'https://halimthemes.com/watch/the-movie-title-eps-1-server-1',
                'slug-2'    => 'https://halimthemes.com/watch/the-movie-title-eps-1-s1',
            ),
            'default'        => 'slug-1',
            // 'after' => '<p class="cs-text-muted">https://halimthemes.com/watch/the-movie-title-eps-1-<b style="color: red;">server-1</b>/<br>https://halimthemes.com/xem-phim/the-movie-title-tap-1-<b style="color: red;">server-1</b><br>https://halimthemes.com/watch/the_movie-title-eps-1-<b style="color: red;">s1</b>/</p>'
        ),

        // array(
        //   'type'    => 'notice',
        //   'class'   => 'danger',
        //   'content' => 'After setup please go to <a href="/wp-admin/options-permalink.php">Settings->Permalinks</a> and click on <b>Save Changes</b> button to apply the changes',
        // ),
    )
);