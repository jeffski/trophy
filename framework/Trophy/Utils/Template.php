<?php
namespace Trophy\Utils;

class Template
{
    public $error_msg;
    public $vars;

    function Template()
    {
        global $error_msg;

        $this->error_msg = $error_msg;
    }

    function set_var($key, $val)
    {
        $this->vars[$key] = $val;
    }

    function process($theme, $template)
    {
        @extract($this->vars);
        ob_start();
        include($_SERVER["DOCUMENT_ROOT"] . APP_PATH . "themes/" . $theme . "/" . $template . ".php");
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }

    function output($html)
    {
        echo $html;
        exit;
    }

}

// End of class Template (/framework/Template.php)
?>