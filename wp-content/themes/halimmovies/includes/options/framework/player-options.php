<?php


// ------------------------------
// Player                     -
// ------------------------------
$options[]   = array(
  'name'     => 'player_section',
  'title'    => 'Player Settings',
  'icon'     => 'fa fa-youtube-play',
  'fields'   => array(

    // array(
    //   'type'    => 'notice',
    //   'class'   => 'info',
    //   'content' => 'Enable or disable social sharing buttons on single posts using these buttons.',
    // ),


	array(
	  'id'    => 'detect_adblock',
	  'type'  => 'switcher',
	  'title' => 'Detect AdBlocker',
	  'desc' => 'Auto detects ad blockers and displays a notifications to users',
	  'default' => true
	),

    array(
      'id'      => 'adblock_msg',
      'type'    => 'textarea',
      'title'   => 'Adblock notices',
      'sanitize' => true,
      'desc'    => 'Ex: "Users please remove ad blocker!"',
      'default' => '<p style="padding-top:15px;"><h2>Sorry!</h2> Users please remove ad blocker!</p>'
    ),

    array(
      'id'      => 'player_error_detect',
      'type'    => 'radio',
      'title'   => 'JWPlayer error detect',
      'class'   => 'horizontal',
      'options' => array(
        'display_modal'    => 'Show modal popup',
        'autoload_server'   => ' Auto play alternative server',
        'auto_play_custom_server' => 'Auto play custom server'
      ),
      'default'   => 'display_modal',
      // 'after'   => '<div class="cs-text-muted">Reference site about Lorem Ipsum, a random Lipsum generator.</div>',
    ),

	array(
	  'id'    => 'resume_playback',
	  'type'  => 'switcher',
	  'title' => 'Resume Playback',
	  'desc' => 'Use localStorage to remember where the user left off and resume playback at the same time offset when revisiting the page.',
	  'default' => true
	),

	array(
	  'id'    => 'floating_player',
	  'type'  => 'switcher',
	  'title' => 'Minimize + Float Player on Scroll',
	  'desc' => 'A simple approach to minimizing and floating JW Player when the viewer scrolls beyond the video content.',
	  'default' => true
	),

	array(
	  'id'    => 'player_cache',
	  'type'  => 'switcher',
	  'title' => 'Cache Player',
	  'label' => 'Enable cache link',
	  'default' => true
	),
	array(
	  'id'    => 'auto_reset_cache',
	  'type'  => 'switcher',
	  'title' => 'Auto reset cache',
	  'label' => 'Automatically clear the cache if the player error',
	  'default' => false
	),

	array(
	  'id'         => 'player_cache_time',
	  'type'       => 'number',
	  'title'      => 'Cache time',
	  'after'      => '<p class="cs-text-muted">Cache expired time. (seconds)</p>',
	  'attributes' => array(
           'style'    => 'width: 100px;'
       ),
	  'default'    => '1800',
	),

	array(
	  'id'        => 'halim_jw_player_options',
	  'type'      => 'fieldset',
	  'title'     => 'JW Player Basic Settings',
	  // 'dependency'   => array( 'player_select_jw_player', '==', 'true' ),
	  'fields'    => array(


	  						array(
							  'id'             => 'jw_player_version',
							  'type'           => 'select',
							  'title'          => 'License Version',
							  'after'			=> '<p class="cs-text-muted">Select which edition of JW Player you own , <a href="http://www.jwplayer.com/pricing/" target="_blank" rel="nofollow">pricing page</a></p>',
							  'options'        => array(
								'jw_player_pro'      	 => 'Pro (free)',
								'jw_player_premium'  	 => 'Premium',
								'jw_player_ads'    		 => 'Ads',
							  ),
							),
							array(
							  'id'      => 'jw_player_library',
							  'type'    => 'upload',
							  'title'   => 'Player library URL',
							  'after'   => '<p class="cs-text-muted"> Add the url of the file jwplayer.js or using the Upload button.</p>',
								'settings'   => array(
									'upload_type'  => 'application/javascript',
									'button_title' => 'Upload JW Library',
									'frame_title'  => 'Select .js file',
									'insert_title' => 'Use this file',
								),
							  'attributes' => array(
								'placeholder' => 'https://cdn.jwplayer.com/libraries/IDzF9Zmk.js',
							  ),
							),

							array(
							  'id'         => 'jw_player_license_key',
							  'type'       => 'text',
							  'title'      => 'Jwplayer License key',
							  'after'      => '<p class="cs-text-muted">A license key is required for the Pro, Premium and Ads edition.</p>',
							),
							array(
							  'id'             => 'jw_player_skin',
							  'type'           => 'select',
							  'title'          => ' Select Your Favorite Skin',
							  'after'		   => '<p class="cs-text-muted"> Choose or upload a skin to customize your player.</p>',
								  'options'        => array(
									'halim'     			 => 'HaLim',
									'vapor'     			 => 'Vapor',
									'stormtrooper'   	 	 => 'Stormtrooper',
									'six'   				 => 'Six',
									'seven'   				 => 'Seven',
									'roundster'   			 => 'Roundster',
									'glow'   				 => 'Glow',
									'five'   				 => 'Five',
									'bekle'   				 => 'Bekle',
									'beelden'				 => 'Beelden',
								  ),
							),

							array(
							  'id'             => 'jw_player_logo',
							  'type'           => 'upload',
							  'title'          => 'Logo File',
							  'desc'		   => '',
							  'settings'       => array(
								'button_title' => 'Upload logo',
								'frame_title'  => 'Choose a logo',
								'insert_title' => 'Use this logo',
							  ),
							  'after' => '<p class="cs-text-muted">The URL of an external JPG, PNG or GIF image to be used as watermark (e.g. /assets/logo.png). We recommend using 24 bit PNG images with transparency</p>'
							),
							array(
							  'id'   		 => 'jw_player_logo_link',
							  'type'		 => 'text',
							  'title' 		 => 'Logo link',
							  'attributes' => array(
								'placeholder' => 'http://halimthemes.com',
							  ),
							  'after' => '<p class="cs-text-muted">The URL to visit when the watermark image is clicked. Clicking a logo will have no affect unless this is configured</p>'
							),
							array(
							  'id'    => 'jw_player_logo_hide',
							  'type'  => 'switcher',
							  'title' => 'Auto hide logo',
							  'label' => 'When this option is set to true, the logo will automatically show and hide along with the other player controls',
							),
							array(
							  'id'             => 'jw_player_logo_position',
							  'type'           => 'select',
							  'title'          => 'Logo Position',
							  'after'		   => '<p class="cs-text-muted"> This options block configures a clickable watermark that is overlayed on the video.</p>',
								  'options'        => array(
									'top-left'     			=> 'Top left',
									'top-right'     		=> 'Top right',
									'bottom-left'   	 	=> 'Bottom left',
									'bottom-right'   		=> 'Bottom right',
									'control-bar'   		=> 'Control bar'
								  ),
							  'after' => '<p class="cs-text-muted">This sets the corner in which to display the watermark. "control-bar" adds the logo as the leftmost icon in the right grouping of buttons in the control bar. </p>'
							),

							array(
							  'id'             => 'jw_player_poster_image',
							  'type'           => 'upload',
							  'title'          => 'Default poster image',
							  'desc'		   => 'The poster image file loaded inside of the player',
							  'settings'       => array(
								'button_title' => 'Upload',
								'frame_title'  => 'Choose poster image',
								'insert_title' => 'Use this poster image',
							  ),
							),

							array(
							  'id'      => 'jw_player_default_subtitle',
							  'type'    => 'upload',
							  'title'   => 'Default subtitle',
							  'after'   => '<p class="cs-text-muted"> Add the url of the file subtitle.srt, .vtt or using the Upload button.</p>',
								'settings'   => array(
									'upload_type'  => 'text/plain',
									'button_title' => 'Upload Subtitle',
									'frame_title'  => 'Select .srt, .vtt file',
									'insert_title' => 'Use this file',
								),
							  'attributes' => array(
								'placeholder' => home_url('subtitle/files/vietnamese.srt'),
							  ),
							),
							array(
							  'id'             => 'jw_player_subtitle_method',
							  'type'           => 'select',
							  'title'          => 'Select a method to read subtitles',
							  'after'		   => '<p class="cs-text-muted"> This options block configures a clickable watermark that is overlayed on the video.</p>',
								  'options'        => array(
									'direct_link'     		=> 'Direct link',
									'readsub_php'     		=> 'Use readsub.php'
								  ),
							  'after' => '<p class="cs-text-muted">Direct link: <i style="color: red;">https://dl.dropboxusercontent.com/s/wk5ibiqvrmgojoh/Default.srt?dl=0</i><br>Use readsub.php: <br><i style="color: #333;">'.HALIM_THEME_URI.'/player/readsub.php?file=</i><i style="color: red;">https://dl.dropboxusercontent.com/s/wk5ibiqvrmgojoh/Default.srt?dl=0</i></p>'
							),
					        array(
					          'id'      => 'jw_tracks_color',
					          'type'    => 'color_picker',
					          'title'   => 'Subtitle color',
					          'after' => '<p class="cs-text-muted">Select subtitle color</p>'
					        ),
						    array(
						      'id'      => 'jw_tracks_font_size',
						      'type'    => 'number',
						      'title'   => 'Subtitle font size',
						      'default' => '14',
							  'after' => '<i class="cs-text-muted"> px</i>'
						    ),
							array(
							  'id'    => 'jw_player_autoplay',
							  'type'  => 'switcher',
							  'title' => 'Autostart',
							  'label' => ' Automatically start playing the video on page load.',
							),

							array(
							  'id'    => 'jw_player_autopause',
							  'type'  => 'switcher',
							  'title' => 'Auto pause',
							  'label' => 'Automatically pauses the player based on certain rules',
							),
							array(
							  'id'    => 'jw_player_download',
							  'type'  => 'switcher',
							  'title' => 'Download',
							  'label' => 'Display download button'
							),

							array(
							  'id'    => 'jw_player_autonext',
							  'type'  => 'switcher',
							  'title' => 'Auto next',
							  'label' => 'Enable auto next episode'
							),

							array(
							  'id'    => 'jw_player_sharing_block',
							  'type'  => 'switcher',
							  'title' => 'Sharing Block',
							  'label' => 'This options block controls an overlay with social sharing options: copy embed code, copy video link and share video to Facebook, Twitter & Email.'
							),
							array(
							  'id'    => 'jw_player_share',
							  'type'  => 'text',
							  'title' => 'Share Heading',
							  'dependency'   => array( 'jw_player_sharing_block', '==', 'true' ),
							  'attributes' => array(
								'style'    => 'width: 80px;',
								'placeholder' => 'Share',
							  ),
							  'after' => '<p class="cs-text-muted">Short, instructive text to display at the top of the sharing screen. The default is Share Video. Also is displayed as a tooltip for the sharing icon.</p>'
							),
							array(
							  'id'    => 'jw_player_about_text',
							  'type'  => 'text',
							  'title' => 'About text',
							  'attributes' => array(
								'style'    => 'width: 150px;',
								'placeholder' => 'About us',
							  ),
							  'after' => '<p class="cs-text-muted">Custom text to display in the right-click menu. Can only be set for the Premium and Ads Editions</p>'
							),
							array(
							  'id'    => 'jw_player_about_link',
							  'type'  => 'text',
							  'title' => 'About link',
							  'attributes' => array(
								'placeholder' => 'Link to about page',
							  ),
							  'after' => '<p class="cs-text-muted">Custom URL to link to when clicking the right-click menu. Can only be set for the Premium and Ads Editions</p>'
							),

			  ),
              'default'   => array(
                'jw_player_version'			=> 'pro',
                'jw_player_skin'			=> 'halim',
                'jw_tracks_color'			=> '#fff',
                'jw_player_autoplay'		=> true,
                'jw_player_download'		=> true,
                'jw_player_license_key'		=> 'MBvrieqNdmVL4jV0x6LPJ0wKB/Nbz2Qq/lqm3g==',
              ),
	),

	array(
	  'id'        => 'halim_jw_player_ads',
	  'type'      => 'fieldset',
	  'title'     => 'Video Advertising Settings',
	  'fields'    => array(
							array(
							  'type'    => 'notice',
							  'class'   => 'success',
							  'content' => 'You Need <b>Advertising edition (Ads)</b> of JW Player to edit Video Advertising Settings',
							  'after'	=> '<p class="cs-notice cs-text-muted">A valid license for the Advertising edition of JW Player is required. The Free, Premium, and Enterprise editions do not support this function.</p>',
							),
							array(
							  'id'    => 'jw_player_show_ad',
							  'type'  => 'switcher',
							  'title' => 'Show ads',
							  // 'label' => 'When this option is set to true, the logo will automatically show and hide along with the other player controls',
							),

						    array(
						      'id'      => 'jw_player_custom_ads_code',
						      'type'    => 'textarea',
						      'title'   => 'Ads code',
						      'sanitize' => true,
							  'attributes' => array(
								'placeholder' => 'Example:
“advertising: {
	“tag: “https://playertest.longtailvideo.com/vast-30s-ad.xml”,
	“client: “vast”,
	“vpaidmode: “insecure”,
	“preloadAds: true
}',
							  ),
						      'after'   => '<p class="cs-text-warning"><pre><strong>ADS CONFIG EXAMPLE:</strong>
<b style="color:red;">Vast ads</b>
"advertising": {
	"tag": "https://playertest.longtailvideo.com/vast-30s-ad.xml",
	"client": "vast",
	"vpaidmode": "insecure",
	"preloadAds": true
}
<b style="color:red;">Googima ads</b>
"advertising": {
	"client": "googima",
	"schedule": "https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/124319096/external/ad_rule_samples&ciu_szs=300x250&ad_rule=1&impl=s&gdfp_req=1&env=vp&output=vmap&unviewed_position_start=1&cust_params=deployment%3Ddevsite%26sample_ar%3Dpremidpost&cmsid=496&vid=short_onecue&correlator=",
	"vpaidmode": "insecure",
	"companiondiv": {
		"id": "sample-companion-div",
		"height": 250,
		"width": 300
	}
}
</pre></p><div class="cs-text-muted">Set this to vast if you are running VAST/VPAID ads, or to googima if you are running Google IMA ads. <br/><a href="https://developer.jwplayer.com/jw-player/docs/developer-guide/customization/configuration-reference/#advertising" target="_blank" rel="nofollow">Learn More about Advertising.</a> | <a href="https://developer.jwplayer.com/jw-player/docs/developer-guide/advertising/monetize-your-content/" target="_blank" rel="nofollow">Monetize your content</a> | <a href="https://developer.jwplayer.com/tools/ad-tester/" target="_blank" rel="nofollow">JW Player Ad Tester</a></div>',
						      'desc'    => 'Specific advertising options.',
						    ),
			  ),

	),

  )
);