<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequest;
use App\Http\Response\Response;

class IndexController
{
    private FormRequest $formRequest;

    public function __construct()
    {
        $this->formRequest = new FormRequest();
    }

    public function index()
    {
        if ($this->formRequest->rules()) {
            (new Response('', 200))->send();
        } else {
            (new Response($this->formRequest->getErrors(), 400))->send();
        }
    }
}
