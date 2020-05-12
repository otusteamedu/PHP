<?php

namespace Classes;

class BracketBalanceCheckServiceImpl implements BracketBalanceCheckService
{
    private $bracketStringValidator;

    public function __construct(BracketStringValidator $bracketStringValidator)
    {
        $this->bracketStringValidator = $bracketStringValidator;
    }

    public function run(): BracketCheckResponse
    {
        $bracketCheckResponseBuilder = new BracketCheckResponseBuilder();

        if (!$this->bracketStringValidator->isValid()) {

            $responseMessage = 'Передаваемая строка не корректна';
            $errors = sprintf('Ошибки : %s', implode(';', $this->bracketStringValidator->getErrors()));

            return $bracketCheckResponseBuilder
                ->setStatus('400 Bad Request')
                ->setResponseMessage($responseMessage)
                ->setBracketCheckErrors($errors)
                ->build();
        }

        return $bracketCheckResponseBuilder
            ->setStatus('200 OK')
            ->setResponseMessage('Строка валидная')
            ->setBracketCheckErrors('')
            ->build();
    }
}
