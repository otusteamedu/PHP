<?php

declare(strict_types=1);

namespace App\Model\Request\UseCase\Add;

use App\Framework\Form\AbstractForm;

class AddRequestForm extends AbstractForm
{
    protected function getRules(): array
    {
        return [
            'name' => [
                'required',
            ],
        ];
    }
}