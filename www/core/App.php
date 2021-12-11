<?php
namespace core;

use model\User;

class App
{
    /* @var object компоненты приложения*/
    public static $components;
    /* @var array массив конфигурации приложения*/
    private $_config;

    /* @param array $config старт приложения с учётом конфигурации*/
    public static function start($config)
    {
        session_start();

        $app = new self;
        $app->_config = $config;
        $app->setApp();

        $router = new Router();
        $router->run();
        return true;
    }

    /*заполнение компонентов*/
    private function setApp()
    {
        $array = [
            'session' => new Session(),
            'request' => new Request(),
        ];
        $components = $this->getComponents();
        self::$components = (object) array_merge($array, $components);
    }

    /* @return array создаём из конфигов компоненты и возвращаем их в виде массива */
    private function getComponents()
    {
        /** @var $components
         * изначально компонент - пустой массив
         */
        $components = [];
        if (!empty($this->_config['components']))
        {
            foreach ((array) $this->_config['components'] as $componentName => $params) {
                $class = !is_array($params) ? new $params() : null;
                if (!$class) {
                    $className = array_shift($params);
                    $class = new $className();
                    foreach ($params as $name => $value) {
                        $class->$name = $value;
                    }
                }
                $components[$componentName] = $class;
            }
        }
        $this->prepareUser($components);
        return $components;
    }
    private function prepareUser(&$components)
    {
        if (isset($components['user']))
        {
            $sessionUser = isset($_SESSION['user']) ? $_SESSION['user'] : null;
            if ($sessionUser)
            {
                $components['user'] = $sessionUser;
            }
        }
    }
}