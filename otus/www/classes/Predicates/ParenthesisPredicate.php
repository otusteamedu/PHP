<?php

namespace Classes\Predicates;

/**
 * Проверка круглых скобок
 * Class ParenthesisPredicate
 * @package Brackets
 */

class ParenthesisPredicate implements BracketPredicate
{

    public function isBracketsBalance(string $string): bool
    {
        preg_match_all('/\(/', $string, $openParenthesis);
        preg_match_all('/\)/', $string, $closedParenthesis);

        return count($openParenthesis[0]) === count($closedParenthesis[0]);
    }

    public function getMessage(): string
    {
        return 'Не корректное количество закрытых и открытых круглых скобок';
    }
}
