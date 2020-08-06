<?php


namespace AYakovlev\Core;


class App
{
    public function __construct()
    {
    }

    public function run()
    {
        // разобрать запрос
        $request = new Request();

        // создать контроллер
        $controllerName = $request->getController();
        $controller = new $controllerName();

        // вызвать у него метод из команды, передать параметр $id
        $method = $request->getMethod();
        $id = $request->getId();
        $controller->$method();
    }
}