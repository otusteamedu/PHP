<?php

namespace Controllers;

abstract class Controller
{
    public $model;

    public function render(string $view, $data = ''): void
    {
        ob_start();
        include $_SERVER['DOCUMENT_ROOT'] . '/src/View/' . $view;
        $view = ob_get_contents();
        ob_end_clean();
        echo $view;
    }
}