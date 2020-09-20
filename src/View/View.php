<?php

namespace View;

abstract class View
{
    public $controller;

    /**
     * View constructor.
     * @param $controller
     */
    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function output()
    {
    }
}
