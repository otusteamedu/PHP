<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEmailController
{
    public function process(Request $request): Response
    {
        return new Response('Check email');
    }
}
