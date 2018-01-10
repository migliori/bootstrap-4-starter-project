<?php
use bootstrap\Sidebar\sidebar;

include_once CLASS_DIR . 'bootstrap/sidebar/Sidebar.php';

$sidebar = new Sidebar('sidebar-main', 'sidebar-default');

$user_identity = 'User Name';
$user_profile = 'Profile';

// Sidebar top content
$sidebar->addCategory('sidebar-user', '', $user_identity, $user_profile);

$sidebar->addCategory('sidebar-fruits', 'Fruits');
$sidebar->sidebarFruits->addNav('fruits-nav', 'nav flex-column');
$sidebar->sidebarFruits->fruitsNav->addLink('#', 'Apple', ICON_EDIT, false, 'class=nav-item', 'class=nav-link');
$sidebar->sidebarFruits->fruitsNav->addLink('#', 'Banana', ICON_EDIT, false, 'class=nav-item', 'class=nav-link');
$sidebar->sidebarFruits->fruitsNav->addLink('#', 'Pear', ICON_EDIT, true, 'class=nav-item', 'class=nav-link');

// dropdown main link
$sidebar->sidebarFruits->fruitsNav->addLink('#other-fruits', 'Others', ICON_EDIT, false, 'class=nav-item', 'class=nav-link, data-toggle=collapse, role=button, aria-expanded=false, aria-controls=other-fruits', 'other-fruits', 'flex-column collapse');

// dropdown content
$sidebar->sidebarFruits->fruitsNav->otherFruits->addLink('#', 'Orange', ICON_EDIT, false, 'class=nav-item', 'class=nav-link');
$sidebar->sidebarFruits->fruitsNav->otherFruits->addLink('#', 'Kiwi', ICON_EDIT, false, 'class=nav-item ', 'class=nav-link');

require_once CLASS_DIR . 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
$template = $twig->loadTemplate('sidebar.html');
echo $template->render(array('sidebar' => $sidebar));
