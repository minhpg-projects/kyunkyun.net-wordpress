<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// METABOX OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options      = array();

// -----------------------------------------
// Page Metabox Options                    -
// -----------------------------------------
$options[]    = array(
  'id'        => '_halim_metabox_options',
  'title'     => 'Post Info',
  'post_type' => 'post',
  'context'   => 'normal',
  'priority'  => 'default',
  'sections'  => array(

    // begin: a section
    array(
      'name'  => 'section_1',
      // begin: fields
      'fields' => array(

        array(
            'id'         => 'halim_add_to_widget',
            'type'       => 'checkbox',
            'title'      => __('Options', 'halimthemes'),
            'class'      => 'horizontal',
            'options'    => array(
                'is_one_slide' => __('Add to widget "One Slide" (Slider one by one)', 'halimthemes'),
                'is_carousel_slide' => __('Add to widget "Carousel Slider"', 'halimthemes'),
                'paging_episode' => __('Paging the episode list', 'halimthemes')
            ),
        ),

        array(
            'id'         => 'halim_movie_formality',
            'type'       => 'radio',
            'title'      => __('Formality', 'halimthemes'),
            'class'      => 'horizontal',
            'options'    => array(
                'single_movies'      => __('Movie', 'halimthemes'),
                'tv_series'   => __('TV series', 'halimthemes'),
                'tv_shows'   => __('TV shows', 'halimthemes'),
                'theater_movie'   => __('Theater movie', 'halimthemes')
            ),
            'default' => 'single_movies'
        ),

        array(
            'id'         => 'halim_movie_status',
            'type'       => 'radio',
            'title'      => __('Status', 'halimthemes'),
            'class'      => 'horizontal',
            'options'    => array(
                'is_trailer'  => __('Trailer', 'halimthemes'),
                'ongoing'     => __('Ongoing', 'halimthemes'),
                'completed'   => __('Completed', 'halimthemes')
            ),
            'default'    => 'ongoing'
        ),

        // begin: a field
        array(
            'id'    => 'fetch_info_url',
            'type'  => 'text',
            'title' => __('Fetch info URL', 'halimthemes'),
            'attributes'    => array(
                'placeholder' => 'http://www.imdb.com/title/tt0458525/?ref_=tt_rec_tt',
                'style'    => 'width: 100%;',
            ),
            'desc'            => __('Input url to fetch info.', 'halimthemes'),
            // 'after' => '<p class="class-name">Input url to fetch info.</p>',
        ),

        // end: a field
        array(
            'id'    => 'halim_poster_url',
            'type'  => 'upload',
            'title' => __('Poster image URL', 'halimthemes'),
            'attributes'    => array(
                'placeholder' => __('Upload or paste your poster image url', 'halimthemes'),
                'style'    => 'width: 100%;',
            ),
            'desc'            => __('Input image url or use Upload button.', 'halimthemes'),
        ),

        array(
          'id'    => 'save_poster_image',
          'type'  => 'switcher',
          'title' => __('Upload Poster image', 'halimthemes'),
          'label' => __('Remote upload the poster image to server', 'halimthemes'),
        ),

        array(
            'id'    => 'halim_thumb_url',
            'type'  => 'text',
            'title' => __('Featured image URL', 'halimthemes'),
            'attributes'    => array(
                'placeholder' => __('Post thumbnail URL', 'halimthemes'),
                'style'    => 'width: 100%;',
            ),
        ),

        array(
          'id'    => 'set_reatured_image',
          'type'  => 'switcher',
          'title' => __('Set as featured image', 'halimthemes'),
          'desc'  => __('Set as featured image and save image to server', 'halimthemes'),
          'after' => '<p class="cs-text-muted" style="display: inline-block;font-size: 12px;margin-top: 3px;margin-left: 5px;">'.__('This will be upload the image and will display on the', 'halimthemes').' <b style="color:red;font-weight:700;">'.__('Feature Image', 'halimthemes').'</b> '.__('box on right sidebar', 'halimthemes').'.</p>',
        ),

        array(
          'id'    => 'save_all_img',
          'type'  => 'switcher',
          'title' => __('Auto save images', 'halimthemes'),
          'label' => '<span class="cs-text-muted" style="display: inline-block;font-size: 12px;">'.__('Automatically find images in posts and save them to the your server and wp media library', 'halimthemes').'</span>',
          'desc'  => __('Auto save images to server', 'halimthemes'),
        ),

        array(
          'id'    => 'is_adult',
          'type'  => 'switcher',
          'title' => __('Adult content (18+)', 'halimthemes')
        ),

        array(
          'id'    => 'is_copyright',
          'type'  => 'switcher',
          'title' => __('Copyright', 'halimthemes')
        ),


        array(
            'id'    => 'halim_original_title',
            'type'  => 'text',
            'title' => __('Original title', 'halimthemes'),
            'attributes'    => array(
                'placeholder' => __('Original title', 'halimthemes'),
                'style'    => 'width: 100%;',
            ),
        ),

        array(
            'id'    => 'halim_trailer_url',
            'type'  => 'text',
            'title' => 'Trailer URL',
            'attributes'    => array(
                'placeholder' => 'Trailer URL',
                'style'    => 'width: 100%;',
            ),
        ),

        array(
            'id'    => 'halim_runtime',
            'type'  => 'text',
            'title' => __('Runtime', 'halimthemes'),
            'attributes'    => array(
                'placeholder' => __('Runtime (90 min)', 'halimthemes'),
                'style'    => 'width: 100%;',
            ),
        ),

        array(
            'id'    => 'halim_rating',
            'type'  => 'text',
            'title' => __('IMBD Rating', 'halimthemes'),
            'attributes'    => array(
                'placeholder' => __('IMBD Rating', 'halimthemes'),
                'style'    => 'width: 50%;',
            ),
        ),

        array(
            'id'    => 'halim_votes',
            'type'  => 'text',
            'title' => __('IMBD Votes', 'halimthemes'),
            'attributes'    => array(
                'placeholder' => __('IMBD Votes', 'halimthemes'),
                'style'    => 'width: 50%;',
            ),
        ),

        array(
            'id'    => 'halim_episode',
            'type'  => 'text',
            'title' => __('Episode', 'halimthemes'),
            'attributes'    => array(
                'placeholder' => __('Episode 20, Tập 20', 'halimthemes'),
                'style'    => 'width: 50%;',
            ),
        ),

        array(
            'id'    => 'halim_total_episode',
            'type'  => 'text',
            'title' => __('Total Episode', 'halimthemes'),
            'attributes'    => array(
                'placeholder' => __('70', 'halimthemes'),
                'style'    => 'width: 50%;',
            ),
        ),

        array(
            'id'    => 'halim_quality',
            'type'  => 'text',
            'title' => __('Quality', 'halimthemes'),
            'attributes'    => array(
                'placeholder' => 'HD, FULL HD, Vietsub, Thuyet Minh...',
                'style'    => 'width: 50%;',
            ),
        ),

        array(
            'id'      => 'halim_movie_notice',
            'type'    => 'wysiwyg',
            'title'   => __('Notification / Note', 'halimthemes'),
            'settings' => array(
                'textarea_rows' => 4,
                'tinymce'       => true,
                'media_buttons' => false,
              )
        ),

        array(
            'id'      => 'halim_showtime_movies',
            'type'    => 'wysiwyg',
            'title'   => __('Showtime movies', 'halimthemes'),
            'settings' => array(
                'textarea_rows' => 3,
                'tinymce'       => true,
                'media_buttons' => false,
              )
        ),



      ), // end: fields
    ), // end: a section

  ),
);


// -----------------------------------------
// Post Metabox Options                    -
// -----------------------------------------
$options[]    = array(
  'id'        => '_videos_metabox_options',
  'title'     => 'Video Metaboxes',
  'post_type' => 'video',
  'context'   => 'normal',
  'priority'  => 'default',
  'sections'  => array(

    array(
      'name'   => 'videos_metabox_options',
      'fields' => array(

        array(
          'id'         => 'video_type',
          'type'       => 'radio',
          'title'      => 'Type',
          'class'      => 'horizontal',
          'options'    => array(
            'video_url' => 'Video URL',
            'video_embed'    => 'Embed'
          ),
          'default'    => 'video_url'
        ),


        array(
          'id'        => 'halim_video_url',
          'type'      => 'fieldset',
          'title'     => 'Video URL',
          'dependency'   => array( 'video_type_video_url', '==', 'true' ),
          'fields'    => array(
                array(
                  'id'    => 'video_url',
                  'type'  => 'text',
                  'title' => 'Video URL',
                  'attributes' => array(
                    'placeholder' => 'Youtube, Vimeo, Dailymotion URL',
                  ),
                ),
            ),
        ),
        array(
          'id'        => 'halim_video_embed_code',
          'type'      => 'fieldset',
          'title'     => 'Embed / iframe',
          'dependency'   => array( 'video_type_video_embed', '==', 'true' ),
          'fields'    => array(
                array(
                      'id'    => 'video_embed',
                      'type'  => 'textarea',
                      'title' => 'Embed code',
                      'attributes' => array(
                        'placeholder' => 'Youtube, Vimeo, Dailymotion...',
                      ),
                    ),
                ),
        ),

        array(
          'id'    => 'video_thumbnail_url',
          'type'  => 'text',
          'title' => 'Thumbnail URL',
        ),

        array(
          'id'    => 'set_as_featured_image',
          'type'  => 'switcher',
          'title' => 'Set as featured image',
          'label' => 'Yes, Please do it.',
        ),

      ),
    ),

  ),
);


// -----------------------------------------
// Post Metabox Options                    -
// -----------------------------------------
$options[]    = array(
  'id'        => '_news_metabox_options',
  'title'     => 'News Metaboxes',
  'post_type' => 'news',
  'context'   => 'normal',
  'priority'  => 'default',
  'sections'  => array(

    array(
      'name'   => 'news_metabox_options',
      'fields' => array(

        array(
          'id'    => 'save_all_img',
          'type'  => 'switcher',
          'title' => __('Auto save images', 'halimthemes'),
          'label' => '<span class="cs-text-muted" style="display: inline-block;font-size: 12px;">'.__('Automatically find images in posts and save them to the your server and wp media library', 'halimthemes').'</span>',
          'desc'  => __('Auto save images to server', 'halimthemes'),
        ),
      ),
    ),

  ),
);




CSFramework_Metabox::instance( $options );
