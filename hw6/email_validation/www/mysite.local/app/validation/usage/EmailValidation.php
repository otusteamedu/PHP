<?php

namespace App\Validation\Usage;

use App\Validation\Condition\EmailCondition;
use App\Validation\Condition\EmptyStringCondition;
use App\Validation\Condition\EmailMxRecordCondition;
use App\Validation\BaseValidator;
use App\Validation\ValidatorInterface;

class EmailValidation implements UsageInterface
{
    /** @var ValidatorInterface $validator */
    protected $validator;

    public function __construct()
    {
        $this->validator = (new BaseValidator())
            ->addCondition(new EmptyStringCondition())
            ->addCondition(new EmailCondition())
            ->addCondition(new EmailMxRecordCondition());
    }

    public function exec($data)
    {
        $this->validator->validate($data);
    }
}