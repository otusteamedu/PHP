<?php

namespace Classes\Predicates;

interface BracketPredicate
{
    public function isBracketsBalance(string $string): bool;
    public function getMessage(): string;
}
