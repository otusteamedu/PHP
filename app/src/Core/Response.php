<?php


namespace App\Core;


class Response
{
    private string $controller;
    private string $action;
    private array $arguments;

    public function __construct(string $controller, string $action, array $arguments = [])
    {
        $this->action = $action;
        $this->controller = $controller;
        $this->arguments = $arguments;
    }

    /**
     * @return false|mixed
     */
    public function __invoke()
    {
        if(false === class_exists($this->controller)){
            throw new \RuntimeException('Controller ' . $this->controller . ' not exist');
        }

        $controllerObj = new $this->controller;

        if(false === method_exists($controllerObj, $this->action)){
            throw new \RuntimeException('Method ' . $this->action . ' not exist in ' . $this->controller);
        }

        return call_user_func_array([$controllerObj, $this->action], $this->arguments);
    }
}