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

        // вызвать у него метод из команды
        $method = $request->getMethod();
        $id = $request->getId();
        if (isset($id)) {
            $controller->setIdArticle($id);
        }
        $controller->$method();
    }
}