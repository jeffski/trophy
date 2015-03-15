<?php
namespace Trophy\Utils;

class Template
{
    public $error_msg;
    public $vars;

    public function __construct()
    {
        global $error_msg;

        $this->error_msg = $error_msg;
    }

    public function setVar($key, $val)
    {
        $this->vars[$key] = $val;
    }

    public function process($theme, $template)
    {
        @extract($this->vars);
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . APP_PATH . "/themes/" . $theme . "/" . $template . ".php");
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }

    public function output($html)
    {
        echo $html;
        exit;
    }
}
