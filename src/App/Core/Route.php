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

    /**
     * Перенаправляет пользователя в нужный контроллер и действие
     */
    public static function dispatch()
    {
        $controller_name = self::DEFAULT_CONTROLLER_NAME;
        $action_name = self::DEFAULT_ACTION_NAME;

        $routers = explode("/", preg_replace("/(\?.*)/", "", $_SERVER['REQUEST_URI']));

        if (!empty($routers[1])) {
            $controller_name = $routers[1];
        }
        if (!empty($routers[2])) {
            $action_name = $routers[2];
        }

        $controller_name = ucfirst($controller_name) . self::CONTROLLER_POSTFIX;
        $controller_path = self::NAMESPACE_CONTROLLERS . $controller_name;
        $action_name = self::ACTION_PREFIX . $action_name;

        if (!class_exists($controller_path)) {
            Route::ErrorPage(404, "Not Found Controller");
        }

        $controller = new $controller_path;

        if (!method_exists($controller, $action_name)) {
            Route::ErrorPage(404, "Not Found Action");
        }

        $controller->$action_name();
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
