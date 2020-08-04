<?php

error_reporting('E_ALL');
ini_set('display_errors', 1);

use common\Config;
use common\Utils;
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;

$match = $router->match();

include_once 'conf/conf.php';

startSession();

// autoload for fastcache
require_once ROOT . 'vendor/autoload.php';

CacheManager::setDefaultConfig(new ConfigurationOption([
    'path' => ROOT . 'tmp'
]));

$InstanceCache = CacheManager::getInstance('files');

include_once CLASS_DIR . 'common/Config.php';

$config = new config($match);

include_once ROOT . 'inc/init.php';

include_once ROOT . 'inc/navbar-main.php';

$message_404 = '';
if (isset($is_404) && $is_404 === true) {
    $message_404 = Utils::alert(lang('page-non-trouvee'), 'alert-danger has-icon');
}

/* get content from cache or build it
-------------------------------------------------- */

$cache_target = 'home';

$CachedString  = $InstanceCache->getItem($cache_target);
if (is_null($CachedString->get()) || isset($_SESSION["admin_auth"]) || ENVIRONMENT == 'development') {
    // Get your page content from db or any source ...
    $page = array(
        'title'   => 'My Home Page',
        'content' => '<p>Main content here</p>'
    );
    $CachedString->set($page)->expiresAfter(CACHE_DURATION); //in seconds, also accepts Datetime
    $InstanceCache->save($CachedString); // Save the cache item just like you do with doctrine and entities
} else {
    $page = $CachedString->get();
}

require_once CLASS_DIR . 'lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates');
$twig   = new Twig_Environment($loader, array('debug' => DEBUG));

$twig->addGlobal('session', $_SESSION);
$twig->addGlobal('match', $match);

if (ENVIRONMENT == 'development') {
    $twig->addExtension(new Twig_Extension_Debug());
}
$template = $twig->loadTemplate('home.html');


/* build title & description the way you want according to $match
--------------------------------------------------------------------- */

$meta = [
    'title' => 'Home page',
    'description' => 'Home description'
];
?>
<!DOCTYPE HTML>
<html lang="<?php echo SITE_LANG; ?>">

<head>
    <?php include_once 'inc/page-head.php'; ?>
    <?php include_once 'inc/css-includes.php'; ?>
</head>

<body>
    <?php
    echo $template->render(array('nav' => $nav, 'page' => $page, 'message_404' => $message_404));
    ?>
    <div id="ajax-content"></div>
    <?php
    include_once 'inc/js-includes.php';
    ?>
</body>

</html>
