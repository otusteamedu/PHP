<?php

declare(strict_types=1);

namespace App\Controller\BankAccount;

use App\Framework\Controller\AbstractController;
use App\Framework\Http\RequestInterface;
use App\Framework\Http\ResponseInterface;
use App\Model\BankAccount\UseCase\Request\GenerateAccountStatementCommand;
use App\Model\BankAccount\UseCase\Request\GenerateAccountStatementForm;
use App\Model\BankAccount\UseCase\Request\GenerateAccountStatementHandler;
use App\Service\Hydrator\HydratorInterface;
use InvalidArgumentException;

class BankAccountController extends AbstractController
{
    private HydratorInterface $hydrator;

    public function __construct(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function requestToGenerateAccountStatement(
        RequestInterface $request,
        GenerateAccountStatementHandler $generateAccountStatementHandler
    ): ResponseInterface {
        try {
            $form = new GenerateAccountStatementForm();
            $form->handleRequest($request);

            if (!$form->isValid()) {
                throw new InvalidArgumentException($form->getErrorMessage());
            }

            $formData = array_merge($form->getValidData(), ['accountId' => $this->getCurrentUserId()]);

            /* @var GenerateAccountStatementCommand $command */
            $command = $this->hydrator->hydrate(
                GenerateAccountStatementCommand::class,
                $formData
            );

            $generateAccountStatementHandler->handle($command);

            return $this->createSuccessResponse('Запрос на генерацию банковской выписки принят в обработку');
        } catch (InvalidArgumentException $e) {
            return $this->createFailResponse($e->getMessage());
        }
    }
}