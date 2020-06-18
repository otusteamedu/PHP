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
        $this->checkBracketsOrder();
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

    protected function checkBracketsOrder()
    {
        $openBrackets = 0;
        $closeBrackets = 0;
        $bracketsOrder = 0;
        for ($i = 0; $i < strlen($this->value); $i++) {
            if ($this->value[$i] == '(') {
                $openBrackets++;
                $bracketsOrder++;
                if ($this->value[$i] == ')') {
                    $closeBrackets++;
                    $bracketsOrder--;
                }
                if ($bracketsOrder < 0) {
                    $this->errors[] = 'Несоответствие закрытых и открытых скобок';
                    return;
                }
            }
            if ($openBrackets !== $closeBrackets) {
                $this->errors[] = 'Несоответствие закрытых и открытых скобок';
                return;
            }
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
