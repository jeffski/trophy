<?php
/**
 * Config Class
 * Set and Get various config settings
 * @author: Jeff Shillitto
 */

namespace Trophy\Config;

class Config
{
    private static $instance; //store the single instance of the database
    private $config_file = "config.php";
    private $items = array();

    private function __construct()
    {
        $this->parse();
    }

    public function __get($id)
    {
        return $this->items[ $id ];
    }

    public static function getConfig()
    {
        if(!self::$instance)
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function parse()
    {
        require( $_SERVER["DOCUMENT_ROOT"] . "/" . APP_PATH . "/config/" . $this->config_file );

        foreach( $config as $key => $val ) {
           $this->items[ $key ] = $val;
        }
    }
}