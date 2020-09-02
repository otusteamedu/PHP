<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Http\Response\Response;

class IndexController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if ($this->request->post('string')) {
            (new Response())->response(null, 200);
        } else {
            (new Response())->response(null, 400);
        }
    }
}
