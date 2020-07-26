<?php

namespace Ozycast\App\Core;

class Controller
{
    public $view;

    function __construct()
    {
        $this->view = new View();
    }

}