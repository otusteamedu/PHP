<?php

namespace App\Services;

class Validator
{
    private $value;
    private array $errors = [];

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    public function validate()
    {
        $this->notEmpty();
        $this->length(48);
        $this->addRegexp("<[a-z][=][()]+>");
        $this->countingSymbols('(', 20);
        $this->countingSymbols(')', 21);
    }

    private function notEmpty(): void
    {
        if (!$this->value) {
            $this->errors['empty'] = 'Не передано значение';
        }
    }

    private function addRegexp(string $regexp): void
    {
        $pregResult = preg_match($regexp, $this->value);
        if ($pregResult === 0) {
            $this->errors[] = 'Значение не соответствует регулярному выражению';
        }
    }

    private function length(int $length): void
    {
        if (strlen($this->value) !== $length) {
            $this->errors[] = sprintf('Длинна должна быть равна %s байт', $length);
        }
    }

    private function countingSymbols(string $symbol, int $count): void
    {
        $repetition = substr_count($this->value, $symbol);
        if ($repetition !== $count) {
            $this->errors[] = sprintf('Символ "%s" встречается %s раз,а должен %s', $symbol, $repetition, $count);
        }
    }

    public function getErrors(): array
    {
        if (isset($this->errors['empty'])) {
            return [$this->errors['empty']];
        }
        return $this->errors;
    }
}
