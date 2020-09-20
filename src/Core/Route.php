<?php

namespace Core;

class Route
{
    public static function start()
    {
        // контроллер и действие по умолчанию
        $controllerName = 'Main';
        $actionName = 'generate';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // получаем имя контроллера
        if (!empty($routes[1]) && !is_int(strpos($routes[1], '?'))) {
            $controllerName = $routes[1];
        }

        // получаем имя метода
        if (!empty($routes[2])) {
            $actionName = $routes[2];
        }

        $controllerName = $controllerName . 'Controller';

        // файл с классом контроллера
        $controllerFile = $controllerName . '.php';
        $controllerPath = "src/Controllers/" . $controllerFile;
        if (!file_exists($controllerPath)) {
            Route::errorPage404();
        }

        $controllerName = 'Controllers\\' . $controllerName;
        $controller = new $controllerName;
        $action = $actionName;

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            Route::errorPage404();
        }

    }

    public static function errorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}