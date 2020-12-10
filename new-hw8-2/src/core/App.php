<?php


namespace AYakovlev\core;

use AYakovlev\Exception\CliException;

class App
{
    public function run(array $argv): void
    {
        // разобрать запрос

        // удалить имя скрипта из разбора
        unset($argv[0]);

        // создать контроллер
        $controllerName = '\\AYakovlev\\cli\\Controller\\' . array_shift($argv) . "Controller" ;
        if (!class_exists($controllerName)) {
            throw new CliException('Контроллер "' . $controllerName . '" не найден');
        }

        // распарсить параметры команды в ассоц. массив $params
        $params = [];
        foreach ($argv as $argument) {
            preg_match('/^-(.+)=(.+)$/', $argument, $matches);
            if (!empty($matches)) {
                $paramName = $matches[1];
                $paramValue = $matches[2];

                $params[$paramName] = $paramValue;
            }
        }

        // создать экземляр контроллера, передать ему параметры
        $controller = new $controllerName($params);

        // вызвать у него метод
        $controller->execute();
    }
}