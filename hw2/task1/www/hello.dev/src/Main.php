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
        echo $this->validate();
    }

    /**
     * @return string
     * @throws StringException
     * @throws ValidateStringException
     */
    private function validate(): string
    {
        if ($this->string === '') {
            throw new StringException();
        }

        $count = 0;
        $stringArray = str_split($this->string);

        foreach ($stringArray as $char) {
            $count = ($char === "(") ? ++$count : --$count;

            if ($count < 0) {
                throw new ValidateStringException($count);
            }
        }

        if ($count !== 0 || $stringArray[0] !== '(' || $stringArray[count($stringArray) - 1] !== ')') {
            throw new ValidateStringException($count);
        }

        return 'Сообщение корректно';
    }
}