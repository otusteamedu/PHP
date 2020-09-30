<?php


namespace App\Controllers;


class ErrorController extends ModelController
{
    public function errorAction(int $err_code = 404, string $err_message = "Not Found")
    {
        $this->di->response->setResponseCode($err_code);
        echo $err_message;
    }
}