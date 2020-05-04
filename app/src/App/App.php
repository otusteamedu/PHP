<?php

namespace App;

use Http\Request;
use Http\Response;
use Validator\ValidatorInterface;
use Validator\ValidatorRegistrator;

class App
{
    const ALLOWED_METHOD = ['POST'];

    /** @var Request */
    protected $request;

    public function start()
    {
        $this->init();

        $response = $this->generateResponse();
        $response->send();

    }

    protected function init()
    {
        $this->request = Request::create();
    }

    protected function generateResponse()
    {
        $violations = [];
        if (!in_array($this->request->getMethod(), self::ALLOWED_METHOD)) {
            return new Response('', 405);
        }

        $validators = ValidatorRegistrator::registrateValidators($this->request);

        /** @var ValidatorInterface $validator */
        foreach ($validators as $order => $validator) {
            if (!$validator['validator']->validate()) {
                $violations[] = $validator['validator']->getViolation();
            }
        }

        if (count($violations) == 0) {
            return new Response();
        } else {
            return new Response(implode("\n", $violations), 400);
        }
    }
}
