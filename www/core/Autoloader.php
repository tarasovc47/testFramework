<?php
namespace core;

class Autoloader
{
    /*
     * регистрация автозагрузчика
     */
    public static function register()
    {
        spl_autoload_register([self::class, 'loader']);
    }
    /*
     * подключение классов с неймспейсами
     */
    private static function loader($className)
    {
        $customClasses = ROOT . 'classes/' . str_replace('\\', '/', $className) . '.php';
        $coreClasses = ROOT . 'core/' . str_replace('\\', '/', $className) . '.php';
        if (file_exists($customClasses))
        {
            require_once $customClasses;
        }
        elseif (file_exists($coreClasses))
        {
            require_once $coreClasses;
        }
    }
}