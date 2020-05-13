<?php

namespace Classes\Predicates;

/**
 * Проверка квадратных скобок
 * Class SquareBracketPredicate
 * @package Brackets
 */
class SquareBracketPredicate extends BasePredicate implements BracketPredicate
{
    private $message;
    protected $openBracket = '[';
    protected $closeBracket = ']';

    public function isBracketsCorrect(string $string): bool
    {
        if (!$this->isBracketsBalanceCorrect($string)) {
            $this->message = 'Не корректное количество закрытых и открытых квадратных скобок';
            return false;
        }

        if (!$this->isBracketsOrderCorrect($string)) {
            $this->message = 'Не корректная последовательность квадратных скобок';
            return false;
        }

        return true;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
