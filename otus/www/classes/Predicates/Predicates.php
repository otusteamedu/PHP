<?php

namespace Classes\Predicates;

interface Predicates
{
    public const PREDICATES = [
        BracePredicate::class,
        ParenthesisPredicate::class,
        SquareBracketPredicate::class,
    ];
}
