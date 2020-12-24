<?php

namespace App;

class App
{
    public function run()
    {
        $this->data = $_POST;

        if (!$this->validateRequest()) {
            http_response_code(400);
        }
    }

    /**
     * Общий метод проверок, сюда можно дописывать новые типы проверок
     * @return bool
     */
    private function validateRequest()
    {
        if (!$this->verifyBlank()) {
            return false;
        }

        if (!$this->verifyContentLength()) {
            return false;
        }

        if (!$this->checkValidBrackets()) {
            return false;
        }

        return true;
    }

    /**
     * Проверка на непустоту отправленного ресурса
     * @return bool
     */
    private function verifyBlank()
    {
        if (count($this->data)) {
            return true;
        }

        return false;
    }

    /**
     * Проверка на макс. допустимую длину строки
     * @return bool
     */
    private function verifyContentLength()
    {
        if (array_key_exists('string', $this->data) && strlen($this->data['string']) <= 48 && strlen($this->data['string']) > 0) {
            return true;
        }

        return false;
    }

    /**
     * Проверка на корректность кол-ва открытых и закрытых скобок
     * @return bool
     */
    private function checkValidBrackets()
    {
        if (strlen($this->data['string']) % 2 !== 0) {
            return false;
        }

        $result = 0;
        for ($i = 0; $i < strlen($this->data['string']); $i++) {
            if ($this->data['string'][$i] === '(' && $result >= 0) {
                $result++;
            }
            if ($this->data['string'][$i] === ')' && $result >= 0) {
                $result--;
            }
        }

        if ($result === 0) {
            return true;
        }

        return false;
    }

    /**
     * Проверка строки на корректный email адрес
     * @param $string
     * @return bool
     */
    public function validateEmail($string)
    {
        if (empty($string) && gettype($string) !== 'string') {
            return false;
        }

        if (!preg_match('/^.+@.+\..+$/', $string)) {
            return false;
        }

        if (!checkdnsrr(array_pop(explode("@",$string)),"MX")) {
            return false;
        }

        return true;
    }
}
