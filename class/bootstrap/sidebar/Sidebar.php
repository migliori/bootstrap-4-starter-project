<?php
namespace bootstrap\sidebar;

use common\Utils;

class Sidebar
{
    public $class;
    public $id;
    public $categories = array();

    /*
    [Category]
        [Category title]
        [List]
            [List item][/List item]
            [List item]
                [Sublist]
                    [Sublist item][/Sublist item]
                [/Sublist]
            [/List item]
        [/List]
    [/Category]
    */

    public function __construct($id = 'sidebar-main', $class = 'sidebar-default')
    {
        $this->id     = $id;
        $this->class  = $class;
    }

    /**
     * add main sidebar category
     * @param [number] $id
     * @param [string] $title
     * @param string   $username
     * @param string   $userinfo
     */
    public function addCategory($category_id, $title, $username = '', $userinfo = '')
    {
        $category_id = Utils::camelCase($category_id);
        $this->$category_id = new SidebarCategories($title, $username, $userinfo);
        $this->categories[] = $this->$category_id;
    }
}
