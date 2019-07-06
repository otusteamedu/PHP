<?php

namespace App;

class Validator implements CommandInterface
{
    private $subject;

    /**
     * @param string $subject последовательность открывающихся из закрывающихся скобок
     */
    public function __construct(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * Возвращает true, если в строке находится правильная последовательность открывающихся и закрывающихся
     * скобок, и false, если неправильная
     * @return bool
     */
    public function execute()
    {
        $subject = $this->subject;
        $counter = 0;
        $chars = str_split($subject);
        foreach ($chars as $char) {
            if ($char == '(') {
                $counter++;
            } elseif ($char == ')') {
                $counter--;
            }
            // Проверка, что первым элементом не будет закрывающася скобка
            if ($counter < 0) {
                return false;
            }
        }
        // Проверка совпадения количеств открывающихся и закрывающихся скобок
        if ($counter != 0) {
            return false;
        }
        return true;
    }
}
