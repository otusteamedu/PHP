<?php

namespace App\Services;

class Validator {

    private ?string $value;
    private $errors = [];

    public function __construct(string $value = null) {
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

    public function validateEmail() {
        $result = filter_var($this->value, FILTER_VALIDATE_EMAIL);
        if (!$result) {
            $this->errors[] = 'Ошибка валидиации почты';
        }
    }

    public function validateMx(): void {
        $arEmail = explode('@', $this->value);
        $arMx = array();
        $checkMx = getmxrr($arEmail[1], $arMx);
        if ($checkMx === false || count($arMx) === 0) {
            $this->errors[] = 'Ошибка при проверке адреса по MX';
        }
    }

    public function getErrors(): array {
        if (isset($this->errors['empty'])) {
            return [$this->errors['empty']];
        }
        return $this->errors;
    }
}
