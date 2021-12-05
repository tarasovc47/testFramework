<?php

namespace core;

class Router
{
    private $_routes;
    public function __construct()
    {
        $this->_routes = require ROOT . 'config/routes.php';
    }

    public function run()
    {
        $uri = $this->getUri();
        foreach ($this->_routes as $uriPattern => $path) {
            if (preg_match("~{$uriPattern}~", $uri))
            {
                $internalRoute = preg_replace("~{$uriPattern}~", $path, $uri);
                if ($this->callAction($internalRoute)){
                    return true;
                }
            }
        }
        if ($this->callAction($uri))
        {
            return true;
        }
        $controller = new Controller();
        return $controller->showError();
    }
    private function getUri()
    {
        $uri = !empty($_SERVER['REQUEST_URI']) ? strtok(trim($_SERVER['REQUEST_URI'], '/'), '?') : null;
        return $uri ? $uri : '/';
    }
    public function callAction($string)
    {
        $segments = explode('/', $string); /* разбиваем пришедешее на массив */
        $controllerName = ucfirst(array_shift($segments) . 'Controller'); /*первый элемент вычитаем и формируем имя контроллера*/
        $actionName = 'action' . ucfirst(array_shift($segments)); /*из следующего пункта массива делаем имя экшена*/
        $parameters = $segments; /*остальное - в параметры*/
        $className = '\controllers\\' . $controllerName; /*формируем путь до контроллера*/
        if (class_exists($className)) /*если он есть*/
        {
            $controller = new $className();/*делаем его экземпляр*/
            if (!method_exists($controller, $actionName) && $actionName == 'action') /*если метода в контроллере нет И имя экшена - просто action */
            {
                $actionName = 'action' . ucfirst($controller->defaultAction); /*то формируем дефолтный экшен*/
            }
            if (method_exists($controller, $actionName)) /*если метод есть, то вызываем метод с параметрами и возвращаем true*/
            {
                call_user_func_array([$controller, $actionName], $parameters);
                return true;
            }
        }
        return false;
    }
}