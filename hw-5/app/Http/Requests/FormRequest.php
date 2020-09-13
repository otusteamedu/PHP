<?php

namespace App\Http\Requests;


use AAntonov\Validators\Contracts\ValidatorInterface;
use AAntonov\Validators\EmailMxValidator;
use AAntonov\Validators\EmailRegExpValidator;
use AAntonov\Validators\NotNullValidator;
use App\Http\Requests\Contracts\FormRequestContract;

class FormRequest implements FormRequestContract
{
    private Request $request;

    private array $errors;

    /**
     * FormRequest constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * @return bool
     */
    public function rules(): bool
    {
        $field = $this->request->post('email');
        if (!$this->validateByRule(new NotNullValidator($field))) {
            return false;
        }

        if (!$this->validateByRule(new EmailRegExpValidator($field))) {
            return false;
        }

        if (!$this->validateByRule(new EmailMxValidator($field))) {
            return false;
        }

        return true;
    }

    /**
     * @param ValidatorInterface $validator
     * @return bool
     */
    private function validateByRule(ValidatorInterface $validator): bool
    {
        if (!$validator->validate()) {
            $this->errors[] = $validator->getFirstError();
            return false;
        }
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
