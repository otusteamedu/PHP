<?php


namespace App\Controllers;


use App\Container;
use App\Services\Form\FormService;

class FormController
{
    public function get()
    {
        ob_start();
        include_once __DIR__ . '/../../resources/templates/form.php';
        return ob_get_clean();
    }

    public function post()
    {
        $service = Container::make(FormService::class);
        $service->publish(json_encode(array_merge($_POST, ['time' => time()])));
        ob_start();
        include_once __DIR__ . '/../../resources/templates/form.done.php';
        return ob_get_clean();
    }
}