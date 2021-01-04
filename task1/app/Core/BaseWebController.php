<?php

namespace App\Core;

abstract class BaseWebController extends AbstractController
{

    protected function view(string $viewName, ?array $parameters = []): HttpResponse
    {
        $reflection = new \ReflectionClass($this);
        $controllerName = $reflection->getShortName();
        $pos = strrpos($controllerName, 'Controller');
        if ($pos === false) {
            throw new \Exception('Invalid controller name '.$controllerName);
        }
        $route = substr(strtolower($controllerName), 0, $pos);
        $view = (new View($route.'/'.$viewName))
            ->setParameters($parameters);
        return (new HttpResponse())->setView($view);
    }

}