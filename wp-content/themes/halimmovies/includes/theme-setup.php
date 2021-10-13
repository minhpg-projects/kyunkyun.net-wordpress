<?php

function halim_theme_setup()
{
	add_theme_support('nav-menus');
	add_theme_support('title-tag');
	add_theme_support( 'responsive-embeds' );
	register_nav_menus(array(
	    'header_menu' 	=> __('Header Menu')
	));

    add_theme_support( 'post-thumbnails' );
	if (function_exists('add_image_size')){
		add_image_size( 'movie-thumb', 300, 450, true );
	}

    add_theme_support( 'post-formats', array( 'aside', 'gallery', 'audio', 'video') );

    load_theme_textdomain( 'halimthemes', HALIM_THEME_DIR. '/languages');
	global $themeinfo;
	$themeinfo = wp_get_theme(get_template());
}

add_action( 'after_setup_theme', 'halim_theme_setup' );


function halim_set_permalink_structure() {
    // global $wp_rewrite;
    // $wp_rewrite->set_permalink_structure('/%postname%');
    update_option('permalink_structure', '/%postname%');
}
add_action( 'init', 'halim_set_permalink_structure' );


function rename_post_formats($translation, $text, $context, $domain) {
    $names = array(
        'Aside'  => __('Movie', 'halimthemes'),
        'Gallery'  => __('Anime Bộ', 'halimthemes'),
        'Video'  => __('TV Shows', 'halimthemes'),
        'Audio'  => __('Theater movie', 'halimthemes'),
    );
    if ($context == 'Post format') {
        $translation = str_replace(array_keys($names), array_values($names), $text);
    }
    return $translation;
}
add_filter('gettext_with_context', 'rename_post_formats', 10, 4);



function halim_enqueue_scripts()
{
	$themeinfo = wp_get_theme('halimmovies');
	wp_enqueue_script( 'jquery');
	if(cs_get_option('disable_gutenberg')) wp_deregister_style( 'wp-block-library' );
	wp_enqueue_style('bootstrap', HALIM_THEME_URI . '/assets/css/bootstrap.min.css', '', '');
	wp_enqueue_style('halimmovies-style', HALIM_STYLESHEED_URI, array(), $themeinfo->get('Version'));
	wp_style_add_data( 'halimmovies-style', 'rtl', 'replace' );

	if(cs_get_option('halim_lazyload_image'))
		wp_enqueue_script('lazysizes', HALIM_THEME_URI. '/assets/js/lazysizes.min.js', array(), '', true );
	wp_enqueue_script('bootstrap', HALIM_THEME_URI. '/assets/js/bootstrap.min.js', array(), '', true );
	wp_enqueue_script('carousel', HALIM_THEME_URI. '/assets/js/owl.carousel.min.js', array(), '', true );
	wp_enqueue_script('halim-init', HALIM_THEME_URI. '/assets/js/core.min.js', array(), $themeinfo->get('Version'), true );
	wp_localize_script('halim-init','halim', array(
		'ajax_url' => HALIM_THEME_URI.'/halim-ajax.php',
		'light_mode' => cs_get_option('halim_light_mode') ? 1 : 0,
        'light_mode_btn' => cs_get_option('halim_light_mode_switch_btn') ? 1 : 0,
        'ajax_live_search' => cs_get_option('enable_live_search'),
		'sync' => cs_get_option('halim_disable_debug'),
        'db_redirect_url' => cs_get_option('haim_debug_redirect_url') ?: 'https://halimthemes.com'
	));

	if(is_single())
    {
        wp_localize_script('halim-init', 'ajax_var', array(
            'url'   => HALIM_THEME_URI.'/halim-ajax.php',
            'nonce' => wp_create_nonce('ajax-nonce'),
        ));
		wp_localize_script('halim-init', 'halim_rate', array(
            'ajaxurl'   => HALIM_THEME_URI.'/halim-ajax.php',
            'nonce' 	=> wp_create_nonce( 'halim_rate_nonce' ),
            'your_rating' => __( 'Thank you for rating!', 'halimthemes' )
        ));
	}

    wp_enqueue_script('ajax-auth-script', HALIM_THEME_URI. '/assets/js/ajax-auth-script.min.js', array(), $themeinfo->get('Version'), true );
    wp_localize_script( 'ajax-auth-script', 'ajax_auth_object', array(
        'ajaxurl' => HALIM_THEME_URI.'/halim-ajax.php',
        'redirecturl' => home_url(),
        'loadingmessage' => __('Sending user info, please wait...', 'halimthemes'),
        'sitekey' => cs_get_option('recaptcha_site_key'),
        'languages' => array(
            'login' => __('Login', 'halimthemes'),
            'register' => __('Register'),
            'forgotpassword' => __('Lost your password?'),
            'already_account' => __('Already have an account?', 'halimthemes'),
            'create_account' => __('Create account', 'halimthemes'),
            'reset_captcha' => __('Reset captcha', 'halimthemes'),
            'username' => __('Username'),
            'email' => __('Email', 'halimthemes'),
            'username_email' => __('Username or Email', 'halimthemes'),
            'password' => __('Password'),
            'reset_password' => __('Reset Password'),
            'login_with' => __('Login with', 'halimthemes'),
            'register_with' => __('Register with', 'halimthemes'),
            'or' => __('or','halimthemes')
        )
    ));


}
add_action( 'wp_enqueue_scripts', 'halim_enqueue_scripts', 1 );

function halim_add_fb_scripts()
{
	$appId = cs_get_option('halim_fb_apps_id');
	$lang = str_replace(array('-', 'vi'), array('_', 'vi_VN'), get_bloginfo('language'));
	?>
	<script>
		jQuery('body').append('<div id="fb-root"></div>');
		window.fbAsyncInit = function() {
				FB.init({ appId : '<?php echo $appId ? $appId : '1384894948437637'; ?>', cookie : true, xfbml : true, version : 'v3.0'
			}); };
			_loadFbSDk=function(){ (function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/<?php echo $lang; ?>/sdk.js"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));
		}
		jQuery(window).load(function(){ setTimeout("_loadFbSDk()",100); });
	</script>
	<?php
}
add_action('wp_footer', 'halim_add_fb_scripts', 5);



add_action( 'wp_dashboard_setup', 'halim_wp_environment_menu' );
function halim_wp_environment_menu() {
    add_meta_box( 'halim_wp_environment', 'Environment', 'halim_wp_environment_menu_callback', 'dashboard', 'side', 'high' );
}
function halim_wp_environment_menu_callback() {
    global $themeinfo;
    ?>
    <div id="activity-widget">
        <div id="published-posts" class="activity-block">
            <ul>
                <li><span>Theme Name:</span> <a href="<?php echo $themeinfo->get('ThemeURI'); ?>" target="_blank"><?php echo $themeinfo->get('Name'); ?></a>
                </li>
                <li><span>Theme Author:</span> <a href="<?php echo $themeinfo->get('AuthorURI'); ?>" target="_blank"><?php echo $themeinfo->get('Author'); ?></a>
                </li>
                <li><span>Theme Version:</span> <span style="color: #0a0;font-weight: 700;"><?php echo $themeinfo->get('Version'); ?></span></li>
                <li style="background: #ffeaea;padding: 10px;border: 1px solid #ff9595;line-height: 21px;"><span><strong style="color: #333;">PHP Max Input Vars:</strong></span> <span style="color: red;"><strong><?php echo number_format(ini_get('max_input_vars')); ?></strong> - <?php echo isLang() ? 'Giá trị đề xuất' : 'Recommended Value'; ?>: <strong>100,000+</strong></span>
                    <span style="color: #ff8484;margin-top: 10px;">
                        <?php if(isLang()) : ?>
                            Giới hạn số lượng tham số truyền vào <code>max_input_vars</code> sẽ cắt bớt dữ liệu dầu vào của phương thức POST như <strong>danh sách menu, danh sách tập phim</strong>, điều này sẽ khiến cho danh sách tập phim bị cắt bớt và không thể lưu được số lượng lớn.
                            <br>
                            Bạn có thể tăng <code>max_input_vars</code> bằng cách chỉnh sửa trong tệp <strong>php.ini.</strong> Kích thước mặc định của biến này là 1000 nhưng nếu bạn muốn gửi số lượng lớn dữ liệu, bạn phải tăng kích thước tương ứng. <a href="https://www.google.com/search?q=Increasing+max+input+vars+limit" target="_blank" style="font-weight: 700;"> Tham khảo cách tăng PHP <code>max_input_vars</code></a>

                        <?php else : ?>
                            Max input vars limitation will truncate POST data such as menus or episodes. <a href="https://www.google.com/search?q=Increasing+max+input+vars+limit" target="_blank" style="font-weight: 700;">See: Increasing max input vars limit</a>
                        <?php endif; ?>
                        </span>
                </li>
            </ul>
        </div>
    </div>
    <?php
}
