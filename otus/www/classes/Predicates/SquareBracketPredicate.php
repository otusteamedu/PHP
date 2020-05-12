<?php

namespace Classes\Predicates;

/**
 * Проверка квадратных скобок
 * Class SquareBracketPredicate
 * @package Brackets
 */
class SquareBracketPredicate implements BracketPredicate
{
    public function isBracketsBalance(string $string): bool
    {
        preg_match_all('/\[/', $string, $openSquare);
        preg_match_all('/\]/', $string, $closedSquare);

        return count($openSquare[0]) === count($closedSquare[0]);
    }

    public function getMessage(): string
    {
        return 'Не корректное количество закрытых и открытых квадратных скобок';
    }
}
