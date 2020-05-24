<?php

namespace App\Controller;

use App\Form\PayCardForm;
use App\Repository\OrderRepository;
use App\Service\AServiceAdapter;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BillingController
{
    /** @var \App\Service\AServiceAdapter */
    private $serviceA;

    /** @var \App\Repository\OrderRepository */
    private $repository;

    /**
     * @param \App\Service\AServiceAdapter $serviceA
     * @param \App\Repository\OrderRepository $repository
     */
    public function __construct(AServiceAdapter $serviceA, OrderRepository $repository)
    {
        $this->serviceA = $serviceA;
        $this->repository = $repository;
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

        try {
            $this->repository->setOrderIsPaid($form->getOrderNumber(), $form->getSum());
        } catch (\Throwable $e) {
            return new JsonResponse([
                'is_succeed' => false,
                'errors' => [
                    'service' => [$e->getMessage()]
                ]
            ], 400);
        }

        return new JsonResponse([
            'is_succeed' => true,
        ], 200);
    }
}
