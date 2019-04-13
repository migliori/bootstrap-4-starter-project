<?php
use altorouter\AltoRouter;

header("Content-Type: text/html");
include 'class/altorouter/AltoRouter.php';
$router = new AltoRouter();
$router->addMatchTypes(array('n' => 'nav-2|nav-3'));
$router->addMatchTypes(array('d' => 'dropdown-item-1|dropdown-item-2|dropdown-item-3|dropdown-item-4'));

// Main routes that non-customers see

$router->map('GET|POST', '/', 'home.php', 'home');

$router->map('GET|POST', '/[n:nav]', 'nav-page.php', 'nav-page');

$router->map('GET|POST', '/[n:nav]/[d:dropdown]', 'dropdown-page.php', 'dropdown-page');

/* Match the current request */
$match = $router->match();
if ($match) {
    require $match['target'];
} else {
    $is_404 = true;
    header("HTTP/1.0 404 Not Found");
    require 'home.php';
}
