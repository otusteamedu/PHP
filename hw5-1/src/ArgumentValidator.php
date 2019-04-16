<?php

namespace timga\calculator;

class ArgumentValidator
{
    public $validatorErrors = [];

    public function validate(Input $input)
    {
        $result = true;
        if ($input->getArgc() != 4) {
            $this->validatorErrors[] = "Incorrect number of arguments!";
            $result = false;
        }
        if (!is_numeric($input->getValueA())) {
            $this->validatorErrors[] = "Incorrect A-value!";
            $result = false;
        }
        if (!is_numeric($input->getValueB())) {
            $this->validatorErrors[] = "Incorrect B-value!";
            $result = false;
        }
        return $result;
    }

    public function showErrors()
    {
        print_r($this->validatorErrors);
        exit();
    }
}