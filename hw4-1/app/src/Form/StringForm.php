<?php

declare(strict_types=1);

namespace App\Form;

class StringForm extends AbstractForm
{

    protected function getRules(): array
    {
        return [
            'string' => [
                'not_empty',
                'min_length:2',
                'parentheses_required',
                'number_of_parentheses',
                'parentheses_sequence',
            ],
        ];
    }

}