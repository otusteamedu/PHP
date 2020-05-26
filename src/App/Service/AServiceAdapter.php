<?php

namespace App\Service;

use App\Form\PayCardForm;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;

class AServiceAdapter
{
    public function process(PayCardForm $form): bool
    {
        // do something

        $response = $this->request();
        if ($response->getStatusCode() === 200) {
            return true;
        }

        if ($response->getStatusCode() === 403) {
            return false;
        }

        return false;
    }

    private function request(): ResponseInterface
    {
        return $this->creteSuccess();
    }

    private function creteSuccess(): ResponseInterface
    {
        return new Response('success', 200);
    }

    private function creteError(): ResponseInterface
    {
        return new Response('error', 403);
    }
}
