<?php

namespace Tirei01\Hw12\Mvc;

class View
{
    private $model;
    private $controller;
    public function __construct($controller,$model) {
        $this->controller = $controller;
        $this->model = $model;
    }

    public function output($templateName = 'index'){
        $title = $this->controller->getTitle();
        $data = $this->controller->getData();
        ob_start();
        include_once 'templates/header.php';
        include_once 'templates/'.$templateName.'.php';
        include_once 'templates/footer.php';
        $body = ob_get_contents();
        ob_end_clean();
        return $body;
    }
}