<?php

namespace Classes\Predicates;

/**
 * Проверка фигурных скобок
 * Class BracePredicate
 * @package Brackets
 */

class BracePredicate implements BracketPredicate
{

    public function isBracketsBalance(string $string): bool
    {
        preg_match_all('/\{/', $string, $openBrace);
        preg_match_all('/\}/', $string, $closedBrace);

        return count($openBrace[0]) === count($closedBrace[0]);
    }

    public function getMessage(): string
    {
        return 'Не корректное количество закрытых и открытых фигурных скобок';
    }
}
