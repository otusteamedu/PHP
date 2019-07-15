<?php


namespace Otus\Basic;

/**
 * Class Router
 * @package Otus\Basic
 */
class Router
{
    /**
     * @param $path
     */
    public static function route($path)
    {
        $controller = self::getControllerByPath($path);
        if (!class_exists($controller)) {
            self::routerError('Unknown controller ' . $controller);
        }
        $action = self::getActionByPath($path);
        $controllerClass = new $controller();
        $controllerClass->{$action}();
    }

    /**
     * @param $path
     * @return string
     */
    private static function getControllerByPath($path)
    {
        $pathInfo = explode('/', $path);
        if (count($pathInfo) > 0) {
            $controller = 'Otus\Controllers\\' . ucfirst($pathInfo[0] ? $pathInfo[0] : 'Index') . 'Controller';
        } else {
            $controller = 'Otus\Controllers\IndexController';
        }
        return $controller;
    }


    /**
     * @param $path
     * @return string
     */
    private static function getActionByPath($path)
    {
        $pathInfo = explode('/', $path);
        $action = array_key_exists(1, $pathInfo) ? ($pathInfo[1] ? $pathInfo[1] : 'index') : 'index';
        return $action;
    }

    /**
     * @param string $message
     * @param int $code
     */
    private static function routerError($message = 'Something strange with router...', $code = 400)
    {
        $response = new Response();
        $response->setContent($message);
        $response->setStatusCode($code);
        $response->send();
        exit();
    }
}