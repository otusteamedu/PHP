<?php

namespace Classes\Predicates;

interface Predicates
{
    public const PREDICATES_LIST = [
        BracePredicate::class,
        ParenthesisPredicate::class,
        SquareBracketPredicate::class,
    ];
}
