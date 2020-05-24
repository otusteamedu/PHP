<?php

namespace App\Controller;

use App\Form\PayCardForm;
use App\Service\AServiceAdapter;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BillingController
{
    /** @var \App\Service\AServiceAdapter */
    private $serviceA;

    public function __construct(AServiceAdapter $serviceA)
    {
        $this->serviceA = $serviceA;
    }

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

        if (!$this->serviceA->process($form)) {
            return new JsonResponse([
                'is_succeed' => false,
                'errors' => [
                    'service' => ['Service A couldn\'t write off the money']
                ]
            ], 400);
        }

        return new JsonResponse([
            'is_succeed' => true,
        ], 200);
    }
}
