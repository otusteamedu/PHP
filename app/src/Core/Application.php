<?php

namespace Core;

use Validator\ValidatorInterface;

class Application
{
    CONST ALLOWED_METHOD = ['POST'];

    /** @var array */
    private $validators;

    /** @var Request */
    private $request;

    public function run()
    {
        $this->init();
        $response = $this->validateEmails();
        $response->send();
    }

    protected function init()
    {
        $this->validators = ValidatorLoader::load();
        $this->request = new Request();
    }


    protected function validateEmails()
    {
        if (!in_array($this->request->getMethod(), self::ALLOWED_METHOD)) {
            return new Response('', 405);
        }

        $emails = json_decode($this->request->getRequest());
        if (is_null($emails)) {
            return new Response('Invalid json', 400);
        }

        $responseData['node'] = $_SERVER['SERVER_ADDR'];
        foreach ($emails as $email) {
            $violations = [];
            /** @var ValidatorInterface $validator */
            foreach ($this->validators as $validator) {
                if (!$validator['validator']->validate($email)) {
                    $violations[] = $validator['validator']->getViolation();
                }
            }
            $responseData['data'][$email] = count($violations) == 0 ? 'Email valid' : $violations;
        }

        $response = new Response(json_encode($responseData));
        $response->setContentType('application/json');
        return $response;
     }
}
