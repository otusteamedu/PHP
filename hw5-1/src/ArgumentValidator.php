<?php

namespace timga\calculator;

use timga\calculator\Exceptions\IncorrectAValueException;
use timga\calculator\Exceptions\IncorrectBValueException;
use timga\calculator\Exceptions\IncorrectNumberOfArgumentsException;

class ArgumentValidator
{

    public function __construct(Input $input)
    {
        $this->validate($input);
    }

    public function validate(Input $input)
    {
        if ($input->getArgc() != 4) {
            throw new IncorrectNumberOfArgumentsException();
        }
        if (!is_numeric($input->getValueA())) {
            throw new IncorrectAValueException();
        }
        if (!is_numeric($input->getValueB())) {
            throw new IncorrectBValueException();
        }
    }
}