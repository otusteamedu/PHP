<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequest;
use App\Http\Response\Response;

class IndexController
{
    /**
     * @var FormRequest
     */
    private $formRequest;

    public function __construct()
    {
        $this->formRequest = new FormRequest();
    }

    public function index()
    {
        if ($this->formRequest->rules()) {
            (new Response())->response(null, 200);
        } else {
            (new Response())->response(null, 400);
        }
    }
}
