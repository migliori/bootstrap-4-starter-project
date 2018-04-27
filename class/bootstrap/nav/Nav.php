<?php
namespace bootstrap\nav;

use common\Utils;

class Nav
{
    public $active_link_class = 'active';
    public $class;
    public $id;
    public $items = array();

    public function __construct($id, $class = 'nav')
    {
        $this->class = $class;
        $this->id = $id;
    }

    public function addLink($url, $text, $icon = '', $active = false, $item_attr = '', $link_attr = '', $dropdown_id = '', $dropdown_class = '')
    {
        $item_attr       = Utils::getAttributes($item_attr);
        $link_attr       = Utils::getAttributes($link_attr);
        $dropdown_obj_id = Utils::camelCase($dropdown_id);
        // add active class to link_attr
        if ($active === true) {
            $link_attr = Utils::addClass($this->active_link_class, $link_attr);
        }
        // wrap text with span if it doesn't begin/finish with a tag
        if (!preg_match('`^<(.*)+>`', trim($text))) {
            $text = '<span class="sidenav-text">' . $text . '</span>';
        }
        $dropdown = '';
        if (!empty($dropdown_id)) {
            // create subnav if any
            $this->$dropdown_obj_id = new Nav($dropdown_id, $dropdown_class);
            $dropdown               = $this->$dropdown_obj_id;
            $link_attr              = Utils::addClass('dropdown-toggle collapsed', $link_attr);
        }
        $this->items[] = array(
            'url'            => $url,
            'text'           => $text,
            'icon'           => $icon,
            'item_attr'      => $item_attr,
            'link_attr'      => $link_attr,
            'dropdown_class' => $dropdown_class,
            'dropdown_id'    => $dropdown_id,
            'dropdown'       => $dropdown
        );
    }
}
