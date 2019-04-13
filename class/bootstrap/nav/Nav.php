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
        $tooltip = '';
        // wrap text with span if it doesn't begin/finish with a tag
        /*if (!preg_match('`^<(.*)+>`', trim($text))) {
            $tooltip = $text;
            $text    = '<span class="nav-text">' . $text . '</span>';
        }*/
        $dropdown = '';
        if (!empty($dropdown_id)) {
            // create subnav if any
            $this->$dropdown_obj_id = new Nav($dropdown_id, $dropdown_class);
            $dropdown               = $this->$dropdown_obj_id;
            $link_attr              = Utils::addClass('d-flex align-items-center justify-content-between dropdown-toggle collapsed', $link_attr);
            // dropdown-plus-icon
            if (strpos($item_attr, 'dropdown-plus-icon') !== false) {
                // dropdown with "+" sign on small screens
                $text .= '<span class="caret d-none d-md-inline-block"></span><span class="nav-mobile-dropdown-link d-inline-block d-md-none">
                    <i class="icon-plus far fa-plus-square p-1 text-gray-800"></i>
                    <i class="icon-minus d-none far fa-minus-square p-1 text-gray-800"></i>
                </span>';
            } else {
                // dropdown with caret
                $text .= '<span class="caret"></span>';
            }
        }
        $this->items[] = array(
            'dropdown'       => $dropdown,
            'dropdown_class' => $dropdown_class,
            'dropdown_id'    => $dropdown_id,
            'icon'           => $icon,
            'item_attr'      => $item_attr,
            'link_attr'      => $link_attr,
            'text'           => $text,
            'tooltip'        => $tooltip,
            'url'            => $url
        );
    }
}
