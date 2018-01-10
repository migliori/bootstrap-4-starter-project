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
    Font Awesome Icons
============================================= */

define('ICON_ADDRESS', 'fas fa-map-marker-alt');
define('ICON_ARROW_DOWN', 'fas fa-long-arrow-alt-down');
define('ICON_ARROW_LEFT', 'fas fa-angle-left');
define('ICON_ARROW_RIGHT', 'fas fa-angle-right');
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
define('ICON_NEW_TAB', ' far fa-clone');
define('ICON_PLUS', 'fas fa-plus-circle');
define('ICON_QUESTION', 'fas fa-question');
define('ICON_RESET', 'fas fa-undo');
define('ICON_SEARCH', 'fas fa-search');
define('ICON_SPINNER', 'fas fa-spinner');
define('ICON_STOP', 'far fa-stop-circle');
define('ICON_TRANSMISSION', 'fas fa-exchange-alt');
define('ICON_UNLOCK', 'fas fa-unlock-alt');
define('ICON_USER', 'fas fa-user');
define('ICON_USER_PLUS', 'fas fa-user-plus');
define('ICON_ZIP_CODE', 'fas fa-location-arrow');

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
