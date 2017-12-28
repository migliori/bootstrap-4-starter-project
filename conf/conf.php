<?php

/*========================================
=            Project settings            =
========================================*/

define('NO_REPLY_EMAIL', 'no-reply@domain.com');
define('CONTACT_EMAIL', 'contact@domain.com');

define('AUTHOR', 'Gilles Migliori');
define('LANG', 'en');
define('SITENAME', 'Site Name');

/*----------  Paths & URLs  ----------*/

// sanitize root directory separator
$root = rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR);
$root = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $root) . DIRECTORY_SEPARATOR;
define('ROOT', $root);

$sheme = 'http';
if (!empty($_SERVER['HTTPS'])) {
    $sheme = 'https';
}
define('BASEURL', $sheme . '://' . $_SERVER['HTTP_HOST'] . '/');

define('CLASS_DIR', ROOT . 'class/');
define('ASSETS_URL', BASEURL . 'assets/');
define('CLASS_URL', BASEURL . 'class/');

/*=====  End of project settings  ======*/

/*======================================
=            admin settings            =
======================================*/

define('ADMIN_LOCKED', true);

define('ADMIN_DIR', ROOT . 'admin/');
define('ADMIN_URL', BASEURL . 'admin/');
define('ADMINLOGINPAGE', ADMIN_URL . 'login');
define('ADMINREDIRECTPAGE', ADMIN_URL . 'home');

/*=====  End of admin settings  ======*/

/*==========================================
=            Generator settings            =
==========================================*/

define('GENERATOR_DIR', ROOT . 'generator/');
define('GENERATOR_URL', BASEURL . 'generator/');

// backup dir must exist on your server
define('BACKUP_DIR', GENERATOR_DIR . 'backup-files/');

/*----------  Translation  ----------*/

if (file_exists(GENERATOR_DIR)) {
    if (!file_exists(ADMIN_DIR . 'i18n/' . LANG . '.php')) {
        exit('Language file doesn\'t exist. Please read documentation and add your language to i18n');
    } else {
        include_once ADMIN_DIR . 'i18n/' . LANG . '.php';
    }
}

// password contraint for users acounts
// available contraints in /class/phpformbuilder/plugins-config/passfield.xml
define('USERS_PASSWORD_CONSTRAINT', 'lower-upper-number-min-6');

/*=====  End of Generator settings  ======*/

/*
    development :
        shows queries on database errors
    production :
        hide queries
*/

/*===========================================
=            Environment - Debug            =
===========================================*/

$environment = 'production';
$debug = false;

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    // localhost settings
    $environment = 'development';
    $debug       = true;
}
define('ENVIRONMENT', $environment);
define('DEBUG', $debug);

/*=====  End of Environment - Debug  ======*/

/* =============================================
    ICONS
============================================= */

define('ICON_ADDRESS', 'icon-location4');
define('ICON_ARROW_DOWN', 'icon-arrow-down8');
define('ICON_ARROW_LEFT', 'icon-arrow-left12');
define('ICON_ARROW_RIGHT', 'icon-arrow-right7');
define('ICON_ARROW_RIGHT_CIRCLE', 'icon-circle-right2');
define('ICON_BACK', 'icon-arrow-left7');
define('ICON_CALENDAR', 'icon-calendar22');
define('ICON_CANCEL', 'icon-cross3');
define('ICON_CHECKMARK', 'icon-checkmark');
define('ICON_CITY', 'icon-city');
define('ICON_COMPANY', 'icon-vcard');
define('ICON_CONTACT', 'icon-phone');
define('ICON_COUNTRY', 'icon-flag3');
define('ICON_DASHBOARD', 'icon-switch');
define('ICON_DELETE', 'icon-cross2');
define('ICON_EDIT', 'icon-pencil7');
define('ICON_ENVELOP', 'icon-envelop3');
define('ICON_FILTER', ' icon-filter3');
define('ICON_HOME', 'icon-home4');
define('ICON_HOUR_GLASS', 'icon-hour-glass2');
define('ICON_INFO', 'icon-info22');
define('ICON_LINK', 'icon-link');
define('ICON_LIST', 'icon-list');
define('ICON_LOCK', 'icon-lock2');
define('ICON_LOGOUT', 'icon-switch2');
define('ICON_LOGIN', 'icon-user-lock');
define('ICON_NEW_TAB', ' icon-new-tab');
define('ICON_PLUS', 'icon-plus-circle2');
define('ICON_QUESTION', 'icon-question7');
define('ICON_RESET', 'icon-reset');
define('ICON_SEARCH', 'icon-search4');
define('ICON_SPINNER', 'icon-spinner9');
define('ICON_STOP', 'icon-stop');
define('ICON_TRANSMISSION', 'icon-transmission');
define('ICON_UNLOCK', 'icon-unlocked2');
define('ICON_USER', 'icon-user-tie');
define('ICON_USER_CHECK', 'icon-user-check');
define('ICON_USER_PLUS', 'icon-user-plus');
define('ICON_ZIP_CODE', 'icon-stamp');

/* =============================================
    LAYOUT SKIN
============================================= */

define('DEFAULT_PANEL_CLASS', 'panel-flat');
define('DEFAULT_TABLE_HEADING_BACKGROUND', 'bg-grey-800');
define('DEFAULT_BUTTONS_BACKGROUND', 'bg-grey-500');

/* database connection */

/*=========================================================================
=            PHP Form Builder - https://www.phpformbuilder.pro            =
=========================================================================*/

if (file_exists(CLASS_DIR . 'phpformbuilder')) {
    include_once CLASS_DIR . 'phpformbuilder/database/db-connect.php';

    $_SESSION['email-replacements'] = array(
        'tpl-page-background'           => '#f7f7f7',
        'tpl-content-dark-background'   => '#182930',
        'tpl-content-light-background'  => '#f7f7f7',
        'tpl-content-dark-text'         => '#212121',
        'tpl-content-light-text'        => '#f7f7f7',
        'tpl-content-accent-text'       => '#fff',
        'tpl-content-accent-background' => '#E91E63',
        'root_url'                      => BASEURL
    );
}

/*=====  End of PHP Form Builder  ======*/

// Default timezone
date_default_timezone_set('Europe/Paris');

/* Register the default autoloader implementation in the php engine. */

function autoload($class)
{
    $found = false;

    /* Define the paths to the directories holding class files */

    $paths = array(
        CLASS_DIR,
        ADMIN_DIR . 'class/',
        ADMIN_DIR . 'secure/'
    );
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        $file = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $file);
        // var_dump($file);
        if (file_exists($file) === true) {
            require_once $file;
            $found = true;
            break;
        }
    }
}
spl_autoload_register('autoload');
