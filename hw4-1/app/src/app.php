<?php

declare(strict_types=1);

namespace App;

use App\Form\StringForm;
use App\Http\Request;
use App\Http\Response;
use InvalidArgumentException;

class App
{

    public function run(): void
    {
        try {
            $request = $this->getRequest();

            $form = new StringForm();
            $form->handleRequest($request);

            if (!$form->isValid()) {
                throw new InvalidArgumentException($form->getErrorMessage());
            }

            $this->sendSuccessResponse('Строка валидна');
        } catch (InvalidArgumentException $e) {
            $this->sendFailResponse($e->getMessage());
        }
    }

    private function getRequest(): Request
    {
        return new Request();
    }

    private function sendSuccessResponse(string $content): void
    {
        $response = new Response(200, $content);
        $response->send();
    }

    private function sendFailResponse(string $content): void
    {
        $response = new Response(400, $content);
        $response->send();
    }

}
