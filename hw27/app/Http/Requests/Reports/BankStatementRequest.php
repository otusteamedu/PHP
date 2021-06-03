<?php
declare(strict_types=1);

namespace App\Http\Requests\Reports;

use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Foundation\Http\FormRequest;

class BankStatementRequest extends FormRequest
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
    #[ArrayShape(['from' => "string", 'to' => "string"])]
    public function rules(): array
    {
        return [
            'from' => 'required|date',
            'to' => 'required|date'
        ];
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['from.required' => "string", 'from.date' => "string", 'to.required' => "string", 'to.date' => "string"])]
    public function messages(): array
    {
        return [
            'from.required' => 'Start date must be entered!',
            'from.date' => 'Start date is not valid!',
            'to.required' => 'End date must be entered!',
            'to.date' => 'End date is not valid!',
        ];
    }
}
