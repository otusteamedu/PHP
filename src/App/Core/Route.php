<?php

namespace Ozycast\App\Core;

class Route
{
    // Пространства имен контроллеров
    const NAMESPACE_CONTROLLERS = "Ozycast\\App\\Controllers\\";

    // Контроллер по умолчанию
    const DEFAULT_CONTROLLER_NAME = "Order";

    // Действие по умолчанию
    const DEFAULT_ACTION_NAME = "index";

    // Постфикс названия файла контроллера
    const CONTROLLER_POSTFIX = "Controller";

    // Префикс названия действия
    const ACTION_PREFIX = "action";

    private static $controller_name;
    private static $action_name;
    private static $namespace_controller;
    private static $params;

    /**
     * Перенаправляет пользователя в нужный контроллер и действие
     */
    public static function dispatch()
    {
        self::$controller_name = self::DEFAULT_CONTROLLER_NAME;
        self::$action_name = self::DEFAULT_ACTION_NAME;
        self::$namespace_controller = self::NAMESPACE_CONTROLLERS;

        if (php_sapi_name() == 'cli')
            self::parseURICli($_SERVER['argv']);
        else
            self::parseURI($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

        $controller_name = ucfirst(self::$controller_name) . self::CONTROLLER_POSTFIX;
        $controller_path = self::$namespace_controller . $controller_name;
        $action_name = self::ACTION_PREFIX . self::$action_name;

        if (!class_exists($controller_path)) {
            Route::ErrorPage(404, "Not Found Controller");
        }

        $controller = new $controller_path;

        if (!method_exists($controller, $action_name)) {
            Route::ErrorPage(404, "Not Found Action");
        }

        $controller->$action_name(self::$params);
    }

    /**
     * Разбираем УРЛ
     * @param $URI
     */
    public static function parseURI($URI, $method)
    {
        $url_parse = explode("/", preg_replace("/(\?.*)/", "", $URI));

        foreach (self::methodAction() as $router) {
            if (preg_match('/' . $router["method"] . '/i', $method)) {
                if (preg_match('/' . $router["path_reg"] . '/i', $URI)) {
                    self::$controller_name = $url_parse[1];
                    self::$action_name = $router["action"];
                    self::$params = $url_parse[2];
                }
            }
        }
    }

    /**
     * Разбираем УРЛ для сонсоли
     * @param $argv
     */
    public static function parseURICli($argv)
    {
        $routers = explode("/", preg_replace("/(\?.*)/", "", $argv[1]));

        if (!empty($routers[0])) {
            self::$controller_name = $routers[0];
        }
        if (!empty($routers[1])) {
            self::$action_name = $routers[1];
        }
    }

    public static function methodAction()
    {
        return [
            'index' => [
                "method" => "GET",
                "path_reg" => "\/([^\/]*)\/?",
                "action" => "index",
            ],
            'create' => [
                "method" => "POST",
                "path_reg" => "\/([^\/]*)\/?",
                "action" => "create",
            ],
            'update' => [
                "method" => "PATCH|PUT",
                "path_reg" => "\/([^\/]*)\/([^\/]*)",
                "action" => "edit",
            ],
            'show' => [
                "method" => "GET",
                "path_reg" => "\/([^\/]*)\/([^\/]*)",
                "action" => "show",
            ],
            'delete' => [
                "method" => "DELETE",
                "path_reg" => "\/([^\/]*)\/([^\/]*)",
                "action" => "delete",
            ],
        ];
    }

    /**
     * Страница ошибки
     * @param int $code
     * @param string $message
     */
    public static function ErrorPage($code, $message)
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . "/";
        header('HTTP/1.1 ' . $code . ' ' . $message);
        header('Status: ' . $code . ' ' . $message);
        header('Location: ' . $host, true, 301);
        exit;
    }
}
