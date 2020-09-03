<?php

namespace App\Http\Requests;

use App\Http\Requests\Contracts\FormRequestContract;
use App\Http\Validators\MaxLenghtValidator;
use App\Http\Validators\MinLenghtValidator;
use App\Http\Validators\NotNullValidator;

class FormRequest implements FormRequestContract
{

    /**
     * @var Request
     */
    private $request;

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
        $field = $this->request->post('string');
        if (!(new NotNullValidator($field))->validate()) {
            return false;
        }

        if (!(new MinLenghtValidator($field, 10))->validate()) {
            return false;
        }

        if (!(new MaxLenghtValidator($field, 20))->validate()) {
            return false;
        }

        return true;
    }
}
