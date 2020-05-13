<?php

namespace Classes\Predicates;

interface BracketPredicate
{
    public function isBracketsCorrect(string $string): bool;
    public function getMessage(): string;
}
