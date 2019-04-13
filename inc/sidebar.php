<?php
use bootstrap\Sidebar\sidebar;
use common\Utils;
use phpFastCache\CacheManager;

$CachedString  = $InstanceCache->getItem('sidebar_' . SITE_LANG . '_' . Utils::sanitize($_SERVER['REQUEST_URI']));

if (is_null($CachedString->get()) || isset($_SESSION["admin_auth"]) || ENVIRONMENT == 'development') {
    include_once CLASS_DIR . 'bootstrap/sidebar/Sidebar.php';

    $sidebar = new Sidebar('sidebar-main', SIDEBAR_CLASS);

    $user_identity = 'User Name';
    $user_profile = 'Profile';

    // Sidebar top content
    $sidebar->addCategory('sidebar-user', '', $user_identity, $user_profile);

    $sidebar->addCategory('sidebar-fruits', 'Fruits');
    $sidebar->sidebarFruits->addNav('fruits-nav', 'nav flex-column');
    $sidebar->sidebarFruits->fruitsNav->addLink('#', 'Apple', SITE_ICON_EDIT, false, 'class=nav-item', 'class=nav-link');
    $sidebar->sidebarFruits->fruitsNav->addLink('#', 'Banana', SITE_ICON_EDIT, false, 'class=nav-item', 'class=nav-link');
    $sidebar->sidebarFruits->fruitsNav->addLink('#', 'Pear', SITE_ICON_EDIT, true, 'class=nav-item', 'class=nav-link');

    // dropdown main link
    $sidebar->sidebarFruits->fruitsNav->addLink('#other-fruits', 'Others', SITE_ICON_EDIT, false, 'class=nav-item dropdown', 'class=nav-link, data-toggle=collapse, role=button, aria-expanded=false, aria-controls=other-fruits', 'other-fruits', 'flex-column collapse');

    // dropdown content
    $sidebar->sidebarFruits->fruitsNav->otherFruits->addLink('#', 'Orange', SITE_ICON_EDIT, false, 'class=nav-item', 'class=nav-link');
    $sidebar->sidebarFruits->fruitsNav->otherFruits->addLink('#', 'Kiwi', SITE_ICON_EDIT, false, 'class=nav-item ', 'class=nav-link');
} else {
    $sidebar = $CachedString->get();
}

// var_dump($nav);
