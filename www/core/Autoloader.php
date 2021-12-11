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
    /**
     * @param string $className
     * подключение классов с неймспейсами
     */
    private static function loader($className)
    {
        $coreClasses = ROOT . str_replace('\\', '/', $className) . '.php';

        if (file_exists($coreClasses))
        {
            require_once $coreClasses;
        }
    }
}