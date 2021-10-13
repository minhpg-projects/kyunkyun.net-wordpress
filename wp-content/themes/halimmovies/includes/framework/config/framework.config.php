<?php

if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$settings           = array(
  'menu_title'      => 'Theme Options',
  'menu_type'       => 'menu', // menu, submenu, options, theme, etc.
  'menu_slug'       => 'halim_options',
  'ajax_save'       => true,
  'show_reset_all'  => true,
  'framework_title' => '<img src="'.HALIM_THEME_URI.'/assets/images/halim-dark-logo.png" width="80%" height="100%"/>',
  'menu_icon'       => HALIM_THEME_URI.'/assets/images/favicon.ico',
);

$options        = array();

include_once HALIM_THEME_DIR.'/includes/options/framework/general-options.php';

include_once HALIM_THEME_DIR.'/includes/options/framework/single-options.php';
include_once HALIM_THEME_DIR.'/includes/options/framework/header-options.php';
include_once HALIM_THEME_DIR.'/includes/options/framework/footer-options.php';
include_once HALIM_THEME_DIR.'/includes/options/framework/layout-options.php';

include_once HALIM_THEME_DIR.'/includes/options/framework/login-register.php';

include_once HALIM_THEME_DIR.'/includes/options/framework/sidebar-options.php';

// include_once HALIM_THEME_DIR.'/includes/options/framework/advanced-options.php';

include_once HALIM_THEME_DIR.'/includes/options/framework/player-options.php';

// include_once HALIM_THEME_DIR.'/includes/options/framework/options.php';

include_once HALIM_THEME_DIR.'/includes/options/framework/seo-optimization.php';
include_once HALIM_THEME_DIR.'/includes/options/framework/webmaster-tools.php';
include_once HALIM_THEME_DIR.'/includes/options/framework/security-options.php';
include_once HALIM_THEME_DIR.'/includes/options/framework/social-options.php';
// include_once HALIM_THEME_DIR.'/includes/options/framework/custom-post-type.php';

include_once HALIM_THEME_DIR.'/includes/options/framework/adult-content-options.php';

// include_once HALIM_THEME_DIR.'/includes/options/framework/google-recaptcha.php';


// include_once HALIM_THEME_DIR.'/includes/options/framework/ad-management-options.php';


// ------------------------------
// backup                       -
// ------------------------------
$options[]   = array(
  'name'     => 'backup_section',
  'title'    => 'Backup',
  'icon'     => 'fa fa-shield',
  'fields'   => array(

    array(
      'type'    => 'notice',
      'class'   => 'warning',
      'content' => 'You can save your current options. Download a Backup and Import.',
    ),

    array(
      'type'    => 'backup',
    ),

  )
);


CSFramework::instance( $settings, $options );
