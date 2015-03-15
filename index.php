<?php
use Trophy\Controller\FrontController;

/**
 * Application Path
 *
 * Change this when deploying the application in a sub directory.
 * Enter the subdirectory name with a forward slash - i.e. "/subdir"
 */
define('APP_PATH', "");

define('ROOT', realpath('.'));

require ROOT . '/vendor/autoload.php';

$frontController = new FrontController();
$frontController->run();
