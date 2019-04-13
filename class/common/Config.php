<?php

namespace common;

use common\Utils;
use phpformbuilder\database\Mysql;

class Config
{
    public $nav_items;
    private $match;

    public function __construct($match)
    {
        $this->match = $match;

        // $p       = page number
        if (isset($match['params']['page'])) {
            $_GET['p']  = ltrim($match['params']['page'], 'p');
        }

        if (!isset($_SESSION['configOK']) || isset($_SESSION['admin_auth']) || $_SESSION['current_lang'] != SITE_LANG || DEBUG === true) {
            if (!isset($_SESSION['current_lang']) || $_SESSION['current_lang'] != SITE_LANG) {
                $_SESSION['current_lang'] = SITE_LANG;
            }

            $_SESSION['lang2'] = 'en';

            if (SITE_LANG == 'en') {
                $_SESSION['lang2'] = 'fr';
            }

            $this->getNavElements();

            $_SESSION['configOK'] =  true;
        }

        $_SESSION['language_btn_link'] = $this->getLanguageBtnLink($this->match);
    }

    private function getLanguageBtnLink($match)
    {
        $lang2 = $_SESSION['lang2'];
        $link = array();
        $base_link = str_replace('.fr', '.com', BASE_URL);

        if (SITE_LANG == 'en') {
            $base_link = str_replace('.com', '.fr', BASE_URL);
        }

        if ($match['name'] == 'nav-page') {
            $page   = $match['params']['nav'];
            $link[] = $_SESSION['nav_pages_' . $lang2][$page];
        } elseif ($match['name'] == 'dropdown-page') {
            $page     = $match['params']['nav'];
            $link[]   = $_SESSION['nav_pages_' . $lang2][$page];
            $dropdown = $match['params']['dropdown'];
            $link[]   = $_SESSION['dropdown_pages_' . $lang2][$page][$dropdown];
        }
        if (isset($match['params']['page'])) {
            $link[] = $match['params']['page'];
        }
        $link = implode('/', $link);

        return $base_link . $link;
    }

    private function getNavElements()
    {
        $lang2 = $_SESSION['lang2'];

        $structure   = json_decode(file_get_contents('inc/navbar-main-' . SITE_LANG . '.json'));
        $structure_2 = json_decode(file_get_contents('inc/navbar-main-' . SITE_LANG . '.json'));

        $_SESSION['nav_pages_' . $lang2] = array_combine($structure->nav_pages->url, $structure_2->nav_pages->url);

        $pages_count = count($structure->nav_pages->url);
        for ($i=0; $i < $pages_count; $i++) {
            $page_url       = $structure->nav_pages->url[$i];
            $page_url_lang2 = $structure_2->nav_pages->url[$i];
            if (isset($structure->dropdown_pages->$page_url)) {
                $_SESSION['dropdown_pages_' . $lang2][$page_url] = array_combine($structure->dropdown_pages->$page_url->url, $structure_2->dropdown_pages->$page_url_lang2->url);
            }
        }
    }

    private function pageNotFound($index)
    {
        if (DEBUG !== true) {
            header("HTTP/1.0 404 Not Found");
            exit;
        } else {
            echo '<p class="alert alert-danger m-2">Config->pageNotFound (' . $index . ')</p>';
        }
    }
}
