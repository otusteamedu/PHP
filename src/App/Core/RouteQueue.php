<?php

namespace Ozycast\App\Core;

/**
 * Роут для очередей
 *
 * Class RouteQueue
 * @package Ozycast\App\Core
 */
class RouteQueue
{
    // Пространства имен контроллеров
    const NAMESPACE_CONTROLLERS = "Ozycast\\App\\Controllers\\";

    // Постфикс названия файла контроллера
    const CONTROLLER_POSTFIX = "Controller";

    // Префикс названия действия
    const ACTION_PREFIX = "action";

    /**
     * Перенаправляет пользователя в нужный контроллер и действие
     */
    public static function dispatch($msg)
    {
        $queueRoute = json_decode($msg, true);
        $controller_name = $queueRoute['controller'];
        $action_name = $queueRoute['action'];

        $controller_name = ucfirst($controller_name) . self::CONTROLLER_POSTFIX;
        $controller_path = self::NAMESPACE_CONTROLLERS . $controller_name;
        $action_name = self::ACTION_PREFIX . $action_name;

        if (!class_exists($controller_path)) {
            file_put_contents(
                __DIR__."/../log/routeQueue.json",
                "Not Found Controller $controller_name->$action_name",
                FILE_APPEND
            );
        }

        $controller = new $controller_path;

        if (!method_exists($controller, $action_name)) {
            file_put_contents(
                __DIR__."/../log/routeQueue.json",
                "Not Found Action $controller_name->$action_name",
                FILE_APPEND
            );
        }

        $controller->$action_name($queueRoute['params']);
    }
}
