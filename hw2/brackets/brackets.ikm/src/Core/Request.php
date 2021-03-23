<?php
namespace ValidBrackets\Core;

class Request
{
    private $controller = "BracketsController";
    private $method = "index";

    public function getController()
    {
        return "ValidBrackets\Controller\\".$this->controller;
    }

    public function getMethod(){
        return $this->method;
    }
}
