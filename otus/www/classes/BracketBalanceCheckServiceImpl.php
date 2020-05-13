<?php

namespace Classes;

class BracketBalanceCheckServiceImpl implements BracketBalanceCheckService
{
    private $bracketStringValidator;
    private const BAD_REQUEST_STATUS = '400 Bad Request';
    private const SUCCESS_STATUS = '200 OK';

    public function __construct(BracketStringValidator $bracketStringValidator)
    {
        $this->bracketStringValidator = $bracketStringValidator;
    }

    public function run(): BracketCheckResponse
    {
        $bracketCheckResponseBuilder = new BracketCheckResponseBuilder();

        if (!$this->bracketStringValidator->isValid()) {

            $responseMessage = 'Передаваемая строка не корректна';

            return $bracketCheckResponseBuilder
                ->setStatus(self::BAD_REQUEST_STATUS)
                ->setResponseMessage($responseMessage)
                ->setBracketCheckErrors($this->bracketStringValidator->getErrors())
                ->build();
        }

        return $bracketCheckResponseBuilder
            ->setStatus(self::SUCCESS_STATUS)
            ->setResponseMessage('Строка валидная')
            ->setBracketCheckErrors([])
            ->build();
    }
}
