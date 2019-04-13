<?php
namespace bootstrap\navbar;

class Navbar
{
    public $navbar_class;
    public $navbar_id;
    public $navbar_attr;
    public $content;
    protected static $instances = array();
    private $brand     = array();
    private $has_brand = false;
    private $options   = array(
        'mobileToggleText' => 'Toggle navigation'
    );

    public function __construct($navbar_id, $navbar_class = 'navbar navbar-default', $navbar_attr = '')
    {
        self::$instances[] = $this;
        $this->navbar_id = $navbar_id;
        $this->navbar_class = $navbar_class;
        $this->navbar_attr = $navbar_attr;
        $this->toggleId =  'navbar-collapse-' . self::getInstances($this);
    }

    /**
     * Sets options
     *
     * @param array $user_options (Optional) An associative array containing the
     *                            options names as keys and values as data.
     */

    public function setOptions($user_options = array())
    {
        $formClassOptions = array('mobileToggleText');
        foreach ($user_options as $key => $value) {
            if (in_array($key, $formClassOptions)) {
                $this->options[$key] = $value;
            }
        }
    }

    public function addBrand($href, $text, $class = 'navbar-brand')
    {
        $this->brand = array(
            'href'  => $href,
            'text'  => $text,
            'class' => $class
        );
        $this->has_brand = true;
    }

    public function addContent($obj)
    {
        $this->content .= $this->returnContent($obj);
    }

    public function render($debug = false)
    {
        $html = '<nav id="' . $this->navbar_id . '" class="' . $this->navbar_class . '"' . $this->getAttributes($this->navbar_attr) . ' role="navigation">' . "\n";
        $html .= '  <div class="container">' . "\n";
        $html .= '      <!-- Brand and toggle get grouped for better mobile display -->' . "\n";
        $html .= '      <div class="navbar-header">' . "\n";
        $html .= '          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#' . $this->toggleId . '">' . "\n";
        $html .= '              <span class="sr-only">' . $this->options['mobileToggleText'] . '</span>' . "\n";
        $html .= '              <span class="icon-bar"></span>' . "\n";
        $html .= '              <span class="icon-bar"></span>' . "\n";
        $html .= '              <span class="icon-bar"></span>' . "\n";
        $html .= '          </button>' . "\n";
        if ($this->has_brand === true) {
            $html .= '          <a class="' . $this->brand['class'] . '" href="' . $this->brand['href'] . '">' . $this->brand['text'] . '</a>' . "\n";
        }
        $html .= '      </div>' . "\n";
        $html .= '      <!-- Collect the nav links, forms, and other content for toggling -->' . "\n";
        $html .= '      <div class="collapse navbar-collapse" id="' . $this->toggleId . '">' . "\n";
        $html .= $this->content;
        $html .= '      </div><!-- /.navbar-collapse -->' . "\n";
        $html .= '  </div><!-- /.container -->';
        $html .= '</nav>';
        if ($debug == true) {
            echo '<pre class="prettyprint">' . htmlspecialchars($html) . '</pre>';
        } else {
            echo $html;
        }
    }

    /**
     * defines active class for the given link
     * @param  string $href The link
     * @return string class="active" | empty string
     */
    private function getActiveClass($href)
    {
        if ($this->getBaseUrl($href) == $this->getBaseUrl($_SERVER['REQUEST_URI'])) {
            return ' class="active"';
        } else {
            return '';
        }
    }

    /**
     * convert link to '#' if it corresponds to active page
     * @param  string $href The link
     * @return string $href | #
     */
    private function getHref($href)
    {
        if ($this->getBaseUrl($href) == $this->getBaseUrl($_SERVER['REQUEST_URI'])) {
            return '#';
        } else {
            $href;
        }

        return $href;
    }

    /**
    * Returns linearised attributes.
    * @param string $attr The element attributes
    * @return string Linearised attributes
    *                Exemple : size=30, required=required => size="30" required="required"
    */
    protected function getAttributes($attr)
    {
        if (empty($attr)) {
            return '';
        } else {
            $attr = preg_replace('`\s*=\s*`', '="', $attr) .  '"'; // adding quotes
            $attr = preg_replace_callback('`(.){1},\s*`', array($this, 'replaceCallback'), $attr);

            return ' ' . $attr;
        }
    }

    /**
    * Used for getAttributes regex.
    */
    private function replaceCallback($motif)
    {
        /* if there's no antislash before the comma */
        if (preg_match('`[^\\\]`', $motif[1])) {
            return $motif[1] . '" ';
        } else {
            return ',';
        }
    }

    /**
     * returns root url without starting slash and without file extension
     * @param  string $url
     * @return string root url
     */
    private function getBaseUrl($url)
    {
        $find = array('`http(s)?://`', "'`" . $_SERVER['SERVER_NAME'] . "`'", '`\.([a-zA-Z]+)`');
        $replace = array('', '', '');

        return ltrim(preg_replace($find, $replace, $url), './');
    }

    /**
     * gets number of instances to give an unique id for toggle div
     * @param  obj     $this
     * @param  boolean $includeSubclasses
     * @return number  number of instances on page.
     */
    protected static function getInstances($this, $includeSubclasses = false)
    {
        $return = array();
        foreach (self::$instances as $instance) {
            $class = get_class($this);
            if ($instance instanceof $class) {
                $instance_class = get_class($instance);
                if ($includeSubclasses || ($instance_class === $class)) {
                    $return[] = $instance;
                }
            }
        }

        return count($return);
    }

    protected function returnLink($url, $text, $attr)
    {
        if ($this->isActive($url)) {
            return '            <li' . $this->getActiveClass($url) . '><a href="' . $this->getHref($url) . '"' . $this->getAttributes($attr) . '>' . $text . '</a></li>' . "\n";
        } else {
            return '';
        }
    }

    protected function returnContent($obj)
    {
        $content = $obj->start();
        $content .= $obj->content;
        $content .= $obj->end();

        return $content;
    }

    /**
     * looks for active / inactive urls if $_SESSION['active_pages'] exists
     * @param  string  $url page link
     * @return boolean true | false
     */
    protected function isActive($url)
    {
        $navbar_id = $this->navbar_id;
        if (isset($_SESSION['active_pages'][$navbar_id])) {
            if (in_array($this->getBaseUrl($url), $_SESSION['active_pages'][$navbar_id])) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}
