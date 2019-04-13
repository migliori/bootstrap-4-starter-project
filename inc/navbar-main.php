<?php
use bootstrap\nav\Nav;
use common\Utils;
use phpFastCache\CacheManager;

$CachedString  = $InstanceCache->getItem('navbar_' . SITE_LANG . '_' . Utils::sanitize($_SERVER['REQUEST_URI']));

if (is_null($CachedString->get()) || isset($_SESSION["admin_auth"]) || ENVIRONMENT == 'development') {
    $nav_items = json_decode(file_get_contents(ROOT . 'inc/navbar-main-' . SITE_LANG . '.json'));
    $active_url = 'home';

    $nav = new Nav('main-nav', MAIN_NAV_CLASS);

    /* build navbar
    -------------------------------------------------- */

    $nav_items_count = count($nav_items->nav_pages->url);

    for ($i=0; $i < $nav_items_count; $i++) {
        $item_name      = $nav_items->nav_pages->name[$i];
        $item_url       = $nav_items->nav_pages->url[$i];
        $dropdown_count = 0;
        if (isset($nav_items->dropdown_pages->$item_url)) {
            $dropdown_count = count($nav_items->dropdown_pages->$item_url->url);
        }

        $active     = false;
        $link_class = MAIN_NAV_LINK_CLASS;

        if ($item_url == $active_url) {
            $active     = true;
            $link_class = MAIN_NAV_ACTIVE_LINK_CLASS;
        }

        $item_attr      = 'role=presentation, class=nav-item';
        $link_attr      = 'class=nav-link ' . $link_class;
        $item_link      = BASE_URL . $item_url;
        $dropdown_id    = '';
        $dropdown_class = '';

        if ($dropdown_count > 0) {
            $dropdown_id    = $item_url . 'dropdown';
            $dropdown_obj   = Utils::camelCase($item_url . 'dropdown');
            $dropdown_class = 'dropdown-menu';
            // dropdown-plus-icon = dropdown with "+" sign on small screens
            $item_attr      = 'class=nav-item dropdown dropdown-plus-icon';
            $link_attr      = 'class=nav-link ' . $link_class . ', role=button, aria-haspopup=true, aria-expanded=false'; // , data-toggle=dropdown
        }

        $nav->addLink($item_link, ucfirst($item_name), '', $active, $item_attr, $link_attr, $dropdown_id, $dropdown_class);

        if ($dropdown_count > 0) {
            for ($j=0; $j < $dropdown_count; $j++) {
                $dropdown_url     = $nav_items->dropdown_pages->$item_url->url[$j];
                $dropdown_name    = $nav_items->dropdown_pages->$item_url->name[$j];
                $nav->$dropdown_obj->addLink($item_link . '/' . $dropdown_url, ucfirst($dropdown_name), '', $active, 'role=presentation, class=dropdown-item', 'class=nav-link');
            }
        }
    }

    $CachedString->set($nav)->expiresAfter(CACHE_DURATION);//in seconds, also accepts Datetime
    $InstanceCache->save($CachedString); // Save the cache item just like you do with doctrine and entities
} else {
    $nav = $CachedString->get();
}

// var_dump($nav);
