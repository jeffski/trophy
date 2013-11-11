<?php
namespace Trophy\Controller;

use Trophy\Config\Config;

Abstract Class BaseController {

    protected $config;

    public function __construct() {
        $this->config = Config::getConfig();
    }

    /**
     * All controllers must contain an index method
     */
    abstract function index();
}

?>