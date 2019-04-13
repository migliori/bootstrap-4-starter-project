<?php
use common\Config;
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
include_once ROOT . 'inc/sidebar.php';

/* get content from cache or build it
-------------------------------------------------- */

$cache_target        = 'dropdown-page';
$cache_target_params = '';
$params              = array('nav', 'dropdown');

foreach ($params as $param) {
    if (isset($match['params'][$param]) && !empty($match['params'][$param])) {
        $cache_target_params .= '-' . $match['params'][$param];
    }
}

$CachedString  = $InstanceCache->getItem($cache_target);
if (is_null($CachedString->get()) || isset($_SESSION["admin_auth"]) || ENVIRONMENT == 'development') {
    // Get your page content from db or any source ...
    $page = array(
        'title'    => $match['params']['dropdown'],
        'subtitle' => $match['params']['nav'],
        'content'  => '<p>Main content here</p>'
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
$template = $twig->loadTemplate('dropdown-page.html');


/* build title & description the way you want according to $match
--------------------------------------------------------------------- */

$meta = [
    'title' => 'My dropdown page',
    'description' => 'My description'
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
    echo $template->render(array('nav' => $nav, 'sidebar' => $sidebar, 'page' => $page));
    ?>
    <div id="ajax-content"></div>
    <?php
    include_once 'inc/js-includes.php';
    ?>
</body>

</html>
