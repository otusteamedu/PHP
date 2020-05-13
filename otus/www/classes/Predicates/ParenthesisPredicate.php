<?php

namespace Classes\Predicates;

/**
 * Проверка круглых скобок
 * Class ParenthesisPredicate
 * @package Brackets
 */

class ParenthesisPredicate extends BasePredicate implements BracketPredicate
{
    private $message;
    protected $openBracket = '(';
    protected $closeBracket = ')';

    public function isBracketsCorrect(string $string): bool
    {
        if (!$this->isBracketsBalanceCorrect($string)) {
            $this->message = 'Не корректное количество закрытых и открытых круглых скобок';
            return false;
        }

        if (!$this->isBracketsOrderCorrect($string)) {
            $this->message = 'Не корректная последовательность круглых скобок';
            return false;
        }

        return true;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
