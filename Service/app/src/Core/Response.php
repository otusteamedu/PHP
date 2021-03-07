<?php


namespace Service\Core;


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

    public function __invoke(): ?string
    {
        if(false === class_exists($this->controller)){
            throw new \RuntimeException('Controller ' . $this->controller . ' not exist');
        }

        $controllerObj = new $this->controller;

        return call_user_func_array([$controllerObj, $this->action], $this->arguments);
    }
}