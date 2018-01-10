<?php
namespace bootstrap\sidebar;

use bootstrap\nav\Nav;
use common\Utils;

class SidebarCategories extends Sidebar
{
    public $title;
    public $username;
    public $userinfo;
    public $navs = array();

    public function __construct($title, $username, $userinfo)
    {
        $this->title    = $title;
        $this->username = $username;
        $this->userinfo = $userinfo;
    }

    public function addNav($nav_id, $nav_class)
    {
        $nav_obj_id = Utils::camelCase($nav_id);
        $this->$nav_obj_id = new Nav($nav_id, $nav_class);
        $this->navs[] = $this->$nav_obj_id;
    }
}
