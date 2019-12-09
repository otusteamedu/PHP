<?php

namespace App\Http\Requests\Event;

class CreateRequest extends AbstractEventRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'priority' => 'required|numeric',
            'conditions' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return collect($this->validated())
            ->transform(function ($value, $key) {
                if ($key === 'conditions') {
                    return $this->parseConditions($value);
                } elseif (is_numeric($value)) {
                    return (int)$value;
                }
                return $value;
            })
            ->all();
    }
}
