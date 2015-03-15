<?php
namespace Trophy\Controller;

use Trophy\Config\Config;

abstract class BaseController
{
    protected $config;

    public function __construct()
    {
        $this->config = Config::getConfig();
    }

    /**
     * All controllers must contain an index method
     */
    abstract public function index();
    abstract public function enter();
    abstract public function terms();
    abstract public function privacy();
}
