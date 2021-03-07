<?php

namespace Service\Controllers;

use Service\Core\Request;
use Service\Core\Validator\Validator;
use Service\Core\View;

class HomeController
{
    public function show()
    {
        $view = new View('form');
        return $view->show();
    }

    public function validate() : void
    {
        $request = Request::getInstance();
        $email = $request->get('email');

        $validator = Validator::make([
            'email' => 'email',
        ], [
            'email' => $email,
        ]);

        $result = 'success';

        if(false === $validator->validate()){
            $result = 'error';
        }

        header("Location: /" .$result);
        exit();
    }

    public function showSuccess()
    {
        $view = new View('success');
        return $view->show();
    }

    public function showError()
    {
        $view = new View('error');
        http_response_code(400);
        return $view->show();
    }

}