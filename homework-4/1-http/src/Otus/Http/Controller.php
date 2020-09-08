<?php

namespace Otus\Http;

class Controller
{
    public function index(Request $request): Response
    {
        $validator = new Validator($request);

        if (! $validator->validate('string')) {
            return new Response(Response::HTTP_BAD_REQUEST);
        }

        return new Response();
    }
}
