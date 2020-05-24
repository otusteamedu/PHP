<?php

namespace App\Controller;

use App\Form\PayCardForm;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BillingController
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function payAction(ServerRequestInterface $request): ResponseInterface
    {
        $form = new PayCardForm($request);
        if (!$form->isValidate()) {
            return new JsonResponse([
                'is_succeed' => false,
                'errors' => $form->getErrors()
            ], 400);
        }

        return new JsonResponse([
            'is_succeed' => true,
        ], 200);
    }
}
