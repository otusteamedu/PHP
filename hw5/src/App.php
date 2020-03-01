<?php

namespace Sergey\Otus;

class App
{
    public function __construct()
    {
        $controller = $this->getController();
        $action = $this->getAction();

        return $controller->$action();
    }

    protected function getController()
    {
        return new \Sergey\Otus\Controller\Validator();
    }

    protected function getAction()
    {
        return 'validate';
    }
}