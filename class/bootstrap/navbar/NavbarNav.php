<?php
namespace bootstrap\navbar;

class NavbarNav extends Navbar
{
    public $attr = 'class=nav navbar-nav';
    public $content = '';

    public function __construct($attr = '')
    {
        if (!empty($attr)) {
            $this->attr = $attr;
        }
    }

    public function addLink($url, $text, $attr = '')
    {
        $this->content .= parent::returnLink($url, $text, $attr);
    }

    public function addContent($obj)
    {
        $this->content .= parent::returnContent($obj);
    }

    protected function start()
    {
        return '        <ul' . parent::getAttributes($this->attr) . '>' . "\n";
    }

    protected function end()
    {
        return '        </ul>' . "\n";
    }
}
