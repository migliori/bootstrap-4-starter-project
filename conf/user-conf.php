<?php
use phpFastCache\CacheManager;

/* =============================================
    USER CONFIG - CAN BE CUSTOMIZED
============================================= */

/* Project BASE URL
-------------------------------------------------- */

$base_urls = getBaseUrls();

// Uncomment the following line to display the 2 returned values
// echo 'BASE_URL: ' . $base_urls['base_url'] . '<br>ROOT_RELATIVE_URL: ' . $base_urls['root_relative_url'] . '<br>';

// BASE_URL MUST lead to your project root url.
// You can redefine it here.
// This url MUST end with a slash.
// ie: define('BASE_URL', 'http://localhost/my-project/');
// ie: define('BASE_URL', 'https://www.domain.com/');
define('BASE_URL', $base_urls['base_url']);


/* PHP CRUD Generator settings
   https://www.phpcrudgenerator.com
-------------------------------------------------- */


// Lock Generator with login page
define('GENERATOR_LOCKED', false);

// ROOT_RELATIVE_URL is the ROOT RELATIVE URL leading to you admin folder.
// You can redefine it here.
// This url MUST end with a slash.
// ie: define('ROOT_RELATIVE_URL', '/my-project/');
// ie: define('ROOT_RELATIVE_URL', '/');
define('ROOT_RELATIVE_URL', $base_urls['root_relative_url']);

// Avoid timezone warning
date_default_timezone_set('UTC');

/* Admin panel settings
-------------------------------------------------- */

// Lock/Unlock admin panel with User Authentification
define('ADMIN_LOCKED', false);

// Admin panel main title
define('SITENAME', 'PHP CRUD GENERATOR');

// Admin panel language
// the translation file MUST exist in /admin/i18n/
define('LANG', 'en');

// date & time translations for lists
if (class_exists('Locale')) {
    Locale::setDefault('en-EN');
}

// Admin panel logo
define('ADMIN_LOGO', 'logo-height-100.png');

// password contraint for users acounts
// available contraints in
// /class/phpformbuilder/plugins-config/passfield.xml
define('USERS_PASSWORD_CONSTRAINT', 'lower-upper-number-min-6');

// Sidebar settings
define('COLLAPSE_INACTIVE_SIDEBAR_CATEGORIES', true);

/* Admin panel skin
-------------------------------------------------- */

define('DEFAULT_CARD_CLASS', 'card-white');
define('DEFAULT_TABLE_HEADING_BACKGROUND', 'bg-gray-dark');
define('DEFAULT_BUTTONS_BACKGROUND', 'bg-gray-200');


/* Public Website
-------------------------------------------------- */

define('MAIN_NAV_CLASS', 'navbar navbar-light navbar-expand-md mb-md-5 bg-white sticky-top');
define('MAIN_NAV_LINK_CLASS', 'bg-white');
define('MAIN_NAV_ACTIVE_LINK_CLASS', 'bg-white');

define('SIDEBAR_CLASS', 'sidebar-default sidebar-separate sidebar-fixed');

define('CACHE_DURATION', '7200'); // 2hours - 7200
define('RECAPTCHA_SITE_KEY', 'MY-PUBLIC-KEY');
define('RECAPTCHA_SECRET_KEY', 'MY-SECRET-KEY');

/* Project Language */

$site_lang = 'en';
$locale    = 'en_GB';
if (preg_match('`fr$`', $_SERVER['HTTP_HOST'])) {
    $site_lang = 'fr';
    $locale    = 'fr_FR';
}
define('SITE_LANG', $site_lang);
define('LOCALE', $locale);

function lang($string)
{
    return $_SESSION[$string];
}

/* Icons */

define('SITE_ICON_EDIT', 'far fa-edit');

/* =============================================
    Auto-detect base url
============================================= */

function getBaseUrls()
{
    // reliable document_root (https://gist.github.com/jpsirois/424055)
    $root_path = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME']);
    $conf_path    = rtrim(dirname(dirname(__FILE__)), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

    // reliable document_root with symlinks resolved
    $info = new \SplFileInfo($root_path);
    $real_root_path = $info->getRealPath();

    // defined root_relative url used in admin routing
    // ie: /my-dir/
    $root_relative_url = '/' . ltrim(
        str_replace(array($real_root_path, DIRECTORY_SEPARATOR), array('', '/'), $conf_path),
        '/'
    );
        // sanitize directory separator
        $base_url = (((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $root_relative_url;

    return array(
        'root_relative_url' => $root_relative_url,
        'base_url'          => $base_url
    );
}

/* =============================================
    Custom session to keep session variables
    between 2 domains (languages)
============================================= */


function startSession()
{
    if (isset($_POST['sid']) && isset($_POST['s_hash'])) {
        $hash = sha1($_POST['sid'] . $_SERVER['REMOTE_ADDR'] . 'apdme45g*;');
        if ($hash == $_POST['s_hash']) {
            session_id($_POST['sid']);
            session_start();
            $_SESSION['user-has-chosen-lang'] = true;
        }
    } else {
        session_start();
    }
}
