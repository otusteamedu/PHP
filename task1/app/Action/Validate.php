<?php

namespace App\Action;

use App\Api\ActionInterface;
use App\Api\RequestInterface;
use App\Api\ResponseInterface;
use App\Api\ValidatorInterface;
use App\Api\ViewInterface;
use App\View;

class Validate implements ActionInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function execute(RequestInterface $request, ResponseInterface $response): ViewInterface
    {
        $text = htmlspecialchars($request->getPost('text'));
        $view = (new View('index'));
        $view->setParameters(['text' => $text]);
        if ($this->validator->validate($text)) {
            $response->setHttpCode(200);
            $view->setParameters(['message' => 'Validate successful passed.']);
        } else {
            $response->setHttpCode(400);
            $view->setParameters(['message' => 'Your input is invalid.']);
        }
        return $view;
    }
}