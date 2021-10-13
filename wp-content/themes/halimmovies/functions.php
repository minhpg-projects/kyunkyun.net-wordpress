<?php

if(version_compare(PHP_VERSION, '7.2', '<')) {
    wp_die('<strong>HaLimMovie</strong> require <strong>PHP 7.2 or PHP 7.3</strong>. Please upgrade your PHP version!', 'HaLimMovie require PHP 7.2 or newer.');
}

@ini_set('max_execution_time', 864000);
@ini_set('max_input_vars', 100000);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
error_reporting(0);

if(!defined('HALIM_THEME_URI')) {
    define('HALIM_THEME_URI', get_template_directory_uri());
}
if(!defined('HALIM_THEME_DIR')) {
    define('HALIM_THEME_DIR', get_template_directory());
}
if(!defined('HALIM_STYLESHEED_URI')) {
    define('HALIM_STYLESHEED_URI', get_stylesheet_uri());
}
define('HALIM_CACHE_PART', ABSPATH . 'wp-content/film-cache');
define('HALIM_DOWNLOAD_PART', ABSPATH . 'wp-content/halim-update-files');
define('HALIM_INC', HALIM_THEME_DIR.'/includes');
define('HALIM_INC_WIDGET', HALIM_INC.'/widgets');
define('HALIM_FW', HALIM_INC.'/framework');

// require_once 'func.plugins.php';
require_once HALIM_INC.'/theme-setup.php';
require_once HALIM_INC.'/functions.php';
require_once HALIM_FW.'/cs-framework.php';
require_once HALIM_INC.'/custom-post-type.php';
require_once HALIM_INC.'/plugin-activation.php';
require_once HALIM_INC.'/widgets/halim-widgets.php';

require_once HALIM_INC.'/functions/classes/Protect.class.php';
require_once HALIM_INC.'/functions/classes/Abstract.class.php';
require_once HALIM_INC.'/functions/classes/Helper.class.php';
require_once HALIM_INC.'/functions/classes/Core.class.php';
require_once HALIM_INC.'/functions/classes/Cache.class.php';
require_once HALIM_INC.'/functions/classes/navwalker.class.php';
require_once HALIM_INC.'/functions/classes/HaLimCrypt.class.php';

require_once HALIM_INC.'/functions/hackFunctions.php';
require_once HALIM_INC.'/functions/basicFunctions.php';
require_once HALIM_INC.'/functions/ajaxFunctions.php';

require_once 'ajax.php';
require_once 'core/src/autoload.php';
require_once 'player/halimPlayer.php';
