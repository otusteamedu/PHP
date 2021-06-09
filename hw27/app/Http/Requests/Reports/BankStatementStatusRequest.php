<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class BankStatementStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['guid' => "string"])]
    public function rules(): array
    {
        return [
            'guid' => 'required|uuid'
        ];
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['guid.required' => "string", 'guid.guid' => "string"])]
    public function messages(): array
    {
        return [
            'guid.required' => 'Guid is required!',
            'guid.uuid' => 'Incorrect guid format!'
        ];
    }
}
