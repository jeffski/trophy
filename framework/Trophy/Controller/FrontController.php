<?php
// Controller has been hard coded in to application
namespace Trophy\Controller;

use Trophy\Application;

class FrontController implements IFrontController
{
    const DEFAULT_CONTROLLER = "Controller";
    const DEFAULT_ACTION     = "index";

    protected $controller    = self::DEFAULT_CONTROLLER;
    protected $action        = self::DEFAULT_ACTION;
    protected $params        = array();
    protected $basePath      = APP_PATH;

    public function __construct(array $options = array())
    {
        if (empty($options)) {
            $this->parseUri();
        } else {
            if (isset($options["controller"])) {
                $this->setController($options["controller"]);
            }
            if (isset($options["action"])) {
                $this->setAction($options["action"]);
            }
            if (isset($options["params"])) {
                $this->setParams($options["params"]);
            }
        }
    }

    protected function parseUri()
    {
        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");

        $path = preg_replace('/[^a-zA-Z0-9]\//', "", $path);

        if (!empty($this->basePath) && strpos("/" . $path, $this->basePath) === 0) {
            $path = substr($path, strlen($this->basePath));
        }

        @list($action, $params) = explode("/", $path, 2);

        // Controller is hard coded
        /*if (!empty($controller)) {
            $this->setController($controller);
        }*/

        if (!empty($action)) {
            $this->setAction($action);
        }
        if (!empty($params)) {
            $this->setParams(explode("/", $params));
        }
    }

    // Controller is hard coded - deprecate
    public function setController($controller)
    {
        $controller = ucfirst(strtolower($controller)) . "Controller";

        if (!class_exists('\\Trophy\\Application\\Controller')) {
            throw new \InvalidArgumentException(
                "The action controller '$controller' has not been defined."
            );
        }
        $this->controller = $controller;
        return $this;
    }

    public function setAction($action)
    {
        $class = "\\Trophy\\Application\\Controller";
        $reflector = new \ReflectionClass($class);
        if (!$reflector->hasMethod($action)) {
            throw new \InvalidArgumentException(
                "The controller action '$action' has been not defined."
            );
        }
        $this->action = $action;
        return $this;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    public function run()
    {
        $class = "\\Trophy\\Application\\Controller";

        $refMethod = new \ReflectionMethod($class, $this->action);
        $refMethod->invokeArgs(new $class, $this->params);
    }
}
