<?php

namespace App\Services;

class Validator
{
    private ?string $value;
    private array $errors = [];

    public function __construct(string $value = null)
    {
        $this->value = $value;
    }

    public function getErrors(): array
    {
        if (isset($this->errors['empty'])) {
            return [$this->errors['empty']];
        }
        return $this->errors;
    }

    public function validate()
    {
        $this->notEmpty();
        $this->addRegexp("<\S{1,}@\S{2,}\.\S{2,}>");
        $this->validateMx();
        $this->validateEmail();
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

    private function validateEmail()
    {
        $result = filter_var($this->value, FILTER_VALIDATE_EMAIL);
        if (!$result) {
            $this->errors[] = 'Ошибка валидиации почты';
        }
    }

    private function validateMx(): void
    {
        $arEmail = explode('@', $this->value);
        $arMx = array();
        $checkMx = getmxrr($arEmail[1], $arMx);
        if ($checkMx === false || count($arMx) === 0) {
            $this->errors[] = 'Ошибка при проверке адреса по MX';
        }
    }
}
