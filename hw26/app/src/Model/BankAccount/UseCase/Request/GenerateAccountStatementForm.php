<?php

declare(strict_types=1);

namespace App\Model\BankAccount\UseCase\Request;

use App\Framework\Form\AbstractForm;

class GenerateAccountStatementForm extends AbstractForm
{
    protected function getRules(): array
    {
        return [
            'startDate' => [
                'required',
                'date',
            ],
            'endDate'   => [
                'required',
                'date',
            ],
        ];
    }
}