<?php

namespace App\Action;

use App\Api\ActionInterface;
use App\Api\RequestInterface;
use App\Api\ValidatorInterface;

class Validate implements ActionInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function execute(RequestInterface $request): void
    {
        $text = $request->getPost('text');
        if ($this->validator->validate($text)) {
            http_response_code(200);
            print 'Validate successful passed.';
        } else {
            http_response_code(400);
            print 'Your input is invalid.';
        }
    }
}