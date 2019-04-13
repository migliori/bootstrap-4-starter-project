<?php
namespace bootstrap\navbar;

class NavbarDropdown extends Navbar
{
    public $main_link_html;
    public $content = '';

    public function __construct($main_link_html)
    {
        $this->main_link_html = $main_link_html;
    }

    public function addLink($url, $text, $attr = '')
    {
        $this->content .= '        ' . parent::returnLink($url, $text, $attr);
    }

    public function addDivider()
    {
        $this->content .= '                <li class="divider"></li>' . "\n";
    }

    protected function start()
    {
        $main_li_active_class = $this->getMainLiActiveClass();
        $html = '            <li class="dropdown' . $main_li_active_class . '">' . "\n";
        $html .= '                <a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $this->main_link_html . '</a>' . "\n";
        $html .= '                <ul class="dropdown-menu">' . "\n";

        return $html;
    }

    protected function end()
    {
        $html = '                </ul>' . "\n";
        $html .= '            </li>' . "\n";

        return $html;
    }

    /**
     * Looks for active class in dropdown links
     * @return string main link active class (active | null)
     */
    private function getMainLiActiveClass()
    {
        if (preg_match('`class="([^"]?)active([^"]?)"`', $this->content)) {
            $out =  ' active';
        } else {
            $out = '';
        }

        return $out;
    }
}
