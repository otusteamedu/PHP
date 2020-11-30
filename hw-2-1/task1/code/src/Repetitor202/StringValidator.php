<?php

namespace Repetitor202;

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

    private function checkBracketsOrder()
    {
        $openBracketsCount = 0;

        for ($i = 0; $i < strlen($this->string); $i++) {
            if ($this->string[$i] == '(') $openBracketsCount++;

            if ($this->string[$i] == ')') {
                if($openBracketsCount == 0) {
                    throw new \Exception('Открывающаюся скобка отсутсвует, ошибка в ' . ++$i . ' символе');
                } else {
                    $openBracketsCount--;
                }
            }
        }

        if ($openBracketsCount != 0) {
            throw new \Exception('Не хватает закрывающих скобок');
        }
    }
}