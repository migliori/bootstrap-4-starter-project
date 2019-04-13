<?php
namespace bootstrap\navbar;

class NavbarForm extends Navbar
{
    public $attr;
    public $content = '';

    public function __construct($attr = '')
    {
        $this->attr = $attr;
    }

    public function startButtonGroup()
    {
        $this->content .= '<div class="btn-group">' . "\n";
    }

    public function endButtonGroup()
    {
        $this->content .= '</div>' . "\n";
    }

    public function addInput($type, $attr)
    {
        $this->content .= '<input type="' . $type. '" class="form-control"' . parent::getAttributes($attr) . '>' . "\n";
    }

    public function addButton($type, $text, $attr)
    {
        $this->content .= '<button type="' . $type. '"' . parent::getAttributes($attr) . '>' . $text . '</button>' . "\n";
    }

    protected function start()
    {
        $html = '       <form' . parent::getAttributes($this->attr) . '>' . "\n";
        $html .= '      <div class="form-group">' . "\n";

        return $html;
    }

    protected function end()
    {
        $html = '    </div>' . "\n";
        $html .= '    </form>' . "\n";

        return $html;
    }
}
