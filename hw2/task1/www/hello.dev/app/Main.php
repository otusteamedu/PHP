<?php

namespace App;

use App\Exception\StringException;
use App\Exception\ValidateStringException;

/**
 * Class Main
 * @package App
 */
class Main
{
    private $string = '';

    /**
     * Main constructor.
     */
    public function __construct()
    {
        $this->string = $_POST['string'] ?? '';
    }

    /**
     * @throws StringException
     * @throws ValidateStringException
     */
    public function run()
    {
        $this->validate();
        echo "Сообщение корректно";
    }

    /**
     * @throws StringException
     * @throws ValidateStringException
     */
    private function validate()
    {
        if ($this->string === '') {
            header('HTTP/1.1 400 Bad Request');
            throw new StringException("POST['string'] - пустой или не передан");
        }

        $count = 0;
        $stringArray = str_split($this->string);

        foreach ($stringArray as $char) {
            $count = ($char === "(") ? ++$count : --$count;

            if ($count < 0) {
                header('HTTP/1.1 400 Bad Request');
                throw new ValidateStringException("Строка не корректна count: $count");
            }
        }

        if ($count !== 0 || $stringArray[0] !== '(' || $stringArray[count($stringArray) - 1] !== ')') {
            header('HTTP/1.1 400 Bad Request');
            throw new ValidateStringException("Строка не корректна count: $count");
        }
    }
}