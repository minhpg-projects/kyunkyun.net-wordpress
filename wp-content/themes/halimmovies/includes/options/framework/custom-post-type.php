<?php

$lng = get_bloginfo('language');

$default_ep_name = $lng == 'vi-VN' ? 'tập' : 'episode';
$default_ep_slug = $lng == 'vi-VN' ? 'tap' : 'ep';

$options[]   = array(
    'name'     => 'slug_section',
    'title'    => 'Custom Post Type',
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
            'id'       => 'post_typ_news',
            'type'     => 'text',
            'title'    => 'Post Type News Slug',
            'attributes' => array(
                'placeholder' => 'news',
            ),
            'default'        => 'news',
            'desc'           => 'Modify your SEO title by editing it right here',
            'after' => '<p class="cs-text-muted">{title} = film title, {episode} = film episode, {quality} = film quality, {release} = released, {org_title} = original title, {runtime} = duration, {country} = country</p>'
        ),

        array(
            'id'       => 'taxonomy_news',
            'type'     => 'text',
            'title'    => 'Taxonomy News Slug',
            'attributes' => array(
                'placeholder' => 'news-cat',
            ),
            'default'        => 'news-cat',
            'desc'           => 'Modify your SEO title by editing it right here',
            'after' => '<p class="cs-text-muted">{title} = film title, {episode} = film episode, {quality} = film quality, {release} = released, {org_title} = original title, {runtime} = duration, {country} = country</p>'
        ),

        array(
            'id'       => 'taxonomy_news_tagl',
            'type'     => 'text',
            'title'    => 'Taxonomy News Tags',
            'attributes' => array(
                'placeholder' => 'news_tag',
            ),
            'default'        => 'news_tag',
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