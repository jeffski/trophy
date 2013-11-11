<?php
//use Trophy\Loader\SplClassLoader;
use Trophy\Controller\FrontController;

const APP_PATH = "/";

$path = realpath('.');

define('ROOT', $path);

require ROOT . '/vendor/autoload.php';

//require_once __DIR__ . "/framework/Trophy/Loader/SplClassLoader.php";
//$autoloader = new SplClassLoader('Trophy', 'framework');
//$autoloader->register();

$frontController = new FrontController();
$frontController->run();