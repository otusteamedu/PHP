<?php

namespace App\Http\Controllers;

use AAntonov\Validators\EmailValidator;
use App\Http\Requests\Request;
use App\Http\Response\Response;


class IndexController
{
    private Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function index()
    {
        $email = $this->request->post('email');
        $validator = new EmailValidator($email);
        if ($validator->validate()) {
            (new Response('Email is valid', 200))->send();
        } else {
            (new Response($validator->getErrors(), 400))->send();
        }
    }
}
