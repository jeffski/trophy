<?php
namespace Trophy\Controller;

interface IFrontController
{
    public function setController($controller);
    public function setAction($action);
    public function setParams(array $params);
    public function run();
}
