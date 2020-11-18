<?php

namespace Otus;

class StringValidator
{
    private $string;
    private $error;

    function __construct(string $string)
    {
        $this->string = trim($string);
    }

    public function validate()
    {
        try {
            $this->checkEmpty();
            $this->checkStringLength();
            $this->checkBracketsCount();
            $this->checkBracketsOrder();
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }

    public function getError()
    {
        return $this->error;
    }

    private function checkEmpty()
    {
        if (!$this->string) {
            throw new \Exception('Передана пустая строка');
        }
    }

    private function checkStringLength()
    {
        if (strlen($this->string) % 2) {
            throw new \Exception('Число символов в строке не четное');
        }
    }

    private function checkBracketsCount()
    {
        $openBracketsCount = substr_count($this->string, '(');
        $closeBracketsCount = substr_count($this->string, ')');
        if ($openBracketsCount != $closeBracketsCount) {
            throw new \Exception('Разное количество открывающих и закрывающих скобок');
        }
    }

    private function checkBracketsOrder()
    {
        $openBracketsCount = 0;
        $closeBracketsCount = 0;
        for ($i = 0; $i < strlen($this->string); $i++) {
            if ($this->string[$i] == '(') $openBracketsCount++;
            if ($this->string[$i] == ')') $closeBracketsCount++;
            if ($closeBracketsCount > $openBracketsCount) {
                throw new \Exception('Не правильная последовательность открывающих и закрывающих скобок');
            }
        }
    }
}