<?php

namespace Model;

abstract class Model
{
    protected $controller;

    /**
     * Model constructor.
     * @param $controller
     */
    public function __construct($controller)
    {
        $this->controller = $controller;
    }

}