<?php

namespace App\Validator\Rules;

class Rules
{

    public static function get(): array
    {
        return [
            'not_empty'             => NotEmptyRule::class,
            'min_length'            => MinLengthRule::class,
            'parentheses_required'  => ParenthesesRequiredRule::class,
            'number_of_parentheses' => NumberOfParenthesesRule::class,
            'parentheses_sequence'  => ParenthesesSequenceRule::class,
        ];
    }

}