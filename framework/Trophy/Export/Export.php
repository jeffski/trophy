<?php 
namespace Trophy\Export;

class Export
{
    public function getObject($class)
    {
        if (class_exists(__NAMESPACE__ . '\\' . $class)) {
            $class = __NAMESPACE__ . '\\' . $class;
            return new $class();
        }
        return null;
    }
}