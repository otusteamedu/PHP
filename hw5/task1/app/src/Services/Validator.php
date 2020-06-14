<?php

namespace App\Services;

class Validator {

    private $value;
    private $errors = [];

    public function __construct($value = null) {
        $this->value = $value;
    }

    public function notEmpty(): void {
        if (!$this->value) {
            $this->errors['empty'] = 'Не передано значение';
        }
    }

    public function addRegexp(string $regexp): void {
        $pregResult = preg_match($regexp, $this->value);
        if ($pregResult === 0) {
            $this->errors[] = 'Значение не соответствует регулярному выражению';
        }
    }

    public function length(int $length): void {
        if (strlen($this->value) !== $length) {
            $this->errors[] = sprintf('Длинна должна быть равна %s байт', $length);
        }
    }

    public function countingSymbols(string $symbol, int $count): void {
        $repetition = substr_count($this->value, $symbol);
        if ($repetition !== $count) {
            $this->errors[] = sprintf('Символ "%s" встречается %s раз,а должен %s', $symbol, $repetition, $count);
        }
    }

    public function getErrors(): array {
        if (isset($this->errors['empty'])) {
            return [$this->errors['empty']];
        }
        return $this->errors;
    }
}
