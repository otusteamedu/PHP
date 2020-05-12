<?php

namespace Classes;

use Classes\Predicates\BracketPredicate;
use Classes\Predicates\PredicateService;

class BracketStringValidatorImpl implements BracketStringValidator
{
    private const CONTENT_LENGTH = 48;

    private $errors = [];
    private $predicateService;
    private $bracketCheckRequest;

    public function __construct(PredicateService $predicateService, BracketCheckRequest $bracketCheckRequest)
    {
        $this->predicateService = $predicateService;
        $this->bracketCheckRequest = $bracketCheckRequest;
    }

    public function isValid(): bool
    {
        $string = $this->bracketCheckRequest->getString();

        if ($string === null) {
            $this->errors[] = 'Валидируемая строка не передана';
        }

        if ($string === '') {
            $this->errors[] = 'Валидируемая строка не может быть пустой';
        }

        if (strlen($string) !== self::CONTENT_LENGTH)
        {
            $this->errors[] = 'Длина валидируемой строки строки не соответствует настройкам';
        }

        $this->checkBracketsBalance($string);

        return empty($this->errors);
    }

    private function checkBracketsBalance (string $string): void
    {
        $predicates = $this->predicateService->getPredicatesCollection();
        /** @var BracketPredicate $predicate */
        foreach ($predicates as $predicate) {
            if (!$predicate->isBracketsBalance($string)) {
                $this->errors[] = $predicate->getMessage();
            }
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
