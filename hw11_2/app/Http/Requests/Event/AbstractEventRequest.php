<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

abstract class AbstractEventRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    protected function parseConditions(string $conditions): ?array
    {
        return collect(explode("\n", $conditions))
            ->map(function ($item) {
                $pattern = '#^(?P<key>.*)\s?=\s?(?P<value>.*)#';
                $result = preg_match($pattern, trim($item), $matches);
                if ($result === 1) {
                    return ['key' => trim($matches['key']), 'value' => trim($matches['value'])];
                } else {
                    return null;
                }
            })
            ->filter()
            ->all();
    }
}
