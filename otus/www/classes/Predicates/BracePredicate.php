<?php

namespace Classes\Predicates;

/**
 * Проверка фигурных скобок
 * Class BracePredicate
 * @package Brackets
 */

class BracePredicate extends BasePredicate implements BracketPredicate
{
    private $message;
    protected $openBracket = '{';
    protected $closeBracket = '}';

    public function isBracketsCorrect(string $string): bool
    {
        if (!$this->isBracketsBalanceCorrect($string)) {
            $this->message = 'Не корректное количество закрытых и открытых фигурных скобок';
            return false;
        }

        if (!$this->isBracketsOrderCorrect($string)) {
            $this->message = 'Не корректная последовательность фигурных скобок';
            return false;
        }

        return true;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
