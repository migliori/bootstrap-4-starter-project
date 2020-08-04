<?php

/* =============================================
    CORE DEFINITIONS - DON'T MODIFY ANYTHING
============================================= */

// GENERATOR & ADMIN settings definitions are for PHP CRUD GENERATOR - https://www.phpcrudgenerator.com

define('AUTHOR', 'Gilles Migliori');
define('VERSION', '1.4.4');

// sanitize root directory separator
$root = rtrim(dirname(dirname(__FILE__)), DIRECTORY_SEPARATOR);
$root = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $root) . DIRECTORY_SEPARATOR;
define('ROOT', $root);

include_once 'user-conf.php';

define('ADMIN_DIR', ROOT . 'admin/');
define('CLASS_DIR', ROOT . 'class/');
define('GENERATOR_DIR', ROOT . 'generator/');

// backup dir must exist on your server
define('BACKUP_DIR', GENERATOR_DIR . 'backup-files/');

define('ADMIN_URL', BASE_URL . 'admin/');
define('ADMINLOGINPAGE', ADMIN_URL . 'login');
define('ADMINREDIRECTPAGE', ADMIN_URL . 'home');
define('ASSETS_URL', BASE_URL . 'assets/');
define('CLASS_URL', BASE_URL . 'class/');
define('GENERATOR_URL', BASE_URL . 'generator/');

/* Translation */

if (file_exists(GENERATOR_DIR)) {
    if (!file_exists(ADMIN_DIR . 'i18n/' . LANG . '.php')) {
        exit('Language file doesn\'t exist. Please read documentation and add your language to i18n');
    } else {
        include_once ADMIN_DIR . 'i18n/' . LANG . '.php';
    }
}

define('DEMO', false);

/*
    localhost :
        shows queries on database errors
    production :
        hide queries
*/

$environment = 'production';
$debug = false;

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    // localhost settings
    $environment = 'development';
    $debug       = true;
}
define('ENVIRONMENT', 'development');
define('DEBUG', $debug);

/* =============================================
    ICONS
============================================= */

define('ICON_ADDRESS', 'fas fa-map-marker-alt');
define('ICON_ARROW_DOWN', 'fas fa-angle-down');
define('ICON_ARROW_LEFT', 'fas fa-angle-left');
define('ICON_ARROW_RIGHT', 'fas fa-angle-right');
define('ICON_ARROW_UP', 'fas fa-angle-up');
define('ICON_ARROW_RIGHT_CIRCLE', 'far fa-arrow-alt-circle-right');
define('ICON_BACK', 'fas fa-long-arrow-alt-left');
define('ICON_CALENDAR', 'far fa-calendar');
define('ICON_CANCEL', 'fas fa-times');
define('ICON_CHECKMARK', 'fas fa-check');
define('ICON_CITY', 'far fa-building');
define('ICON_COMPANY', 'fas fa-id-card');
define('ICON_CONTACT', 'fas fa-phone');
define('ICON_COUNTRY', 'fas fa-flag');
define('ICON_DASHBOARD', 'fas fa-power-off');
define('ICON_DELETE', 'fas fa-times-circle');
define('ICON_EDIT', 'fas fa-pencil-alt');
define('ICON_ENVELOP', 'fas fa-envelope');
define('ICON_FILTER', 'fas fa-filter');
define('ICON_HOME', 'fas fa-home');
define('ICON_HOUR_GLASS', 'fas fa-hourglass-half');
define('ICON_INFO', 'fas fa-info-circle');
define('ICON_LINK', 'fas fa-link');
define('ICON_LIST', 'fas fa-list');
define('ICON_LOCK', 'fas fa-lock');
define('ICON_LOGOUT', 'fas fa-power-off');
define('ICON_LOGIN', 'fas fa-user-circle');
define('ICON_NEW_TAB', ' fas fa-external-link-alt');
define('ICON_PASSWORD', 'far fa-eye-slash');
define('ICON_PLUS', 'fas fa-plus-circle');
define('ICON_QUESTION', 'fas fa-question');
define('ICON_RESET', 'fas fa-undo');
define('ICON_SEARCH', 'fas fa-search');
define('ICON_SPINNER', 'fas fa-spinner');
define('ICON_STOP', 'far fa-stop-circle');
define('ICON_TRANSMISSION', 'fas fa-exchange-alt');
define('ICON_UNLOCK', 'fas fa-unlock-alt');
define('ICON_UPLOAD', 'fas fa-upload');
define('ICON_USER', 'fas fa-user');
define('ICON_USER_PLUS', 'fas fa-user-plus');
define('ICON_ZIP_CODE', 'fas fa-location-arrow');

/* database connection */

/*=========================================================================
=            PHP Form Builder - https://www.phpformbuilder.pro            =
=========================================================================*/

if (file_exists(CLASS_DIR . 'phpformbuilder')) {
    include_once CLASS_DIR . 'phpformbuilder/database/db-connect.php';
}

/*=====  End of PHP Form Builder  ======*/

/* Register the default autoloader implementation in the php engine. */

function autoload($class)
{
    /* Define the paths to the directories holding class files */

    $paths = array(
        CLASS_DIR,
        ADMIN_DIR . 'class/',
        ADMIN_DIR . 'secure/'
    );
    foreach ($paths as $path) {
        $file = $path . str_replace('\\', '/', $class) . '.php';
        if (file_exists($file) === true) {
            require_once $file;
            break;
        }
    }
}
spl_autoload_register('autoload');
