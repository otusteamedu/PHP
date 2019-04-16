<?php

namespace timga\calculator;

class ArgumentValidator
{
    private $validatorErrors = [];

    public function __construct(Input $input)
    {
        $this->validate($input);
        $this->handleErrors();
    }

    private function validate(Input $input)
    {
        if ($input->getArgc() != 4) {
            $this->validatorErrors[] = "Incorrect number of arguments!";
        }
        if (!is_numeric($input->getValueA())) {
            $this->validatorErrors[] = "Incorrect A-value!";
        }
        if (!is_numeric($input->getValueB())) {
            $this->validatorErrors[] = "Incorrect B-value!";
        }
    }

    private function handleErrors()
    {
        if (!empty($this->validatorErrors)) {
            echo "ArgumentValidator errors:" . PHP_EOL;
            print_r($this->validatorErrors);
            exit();
        }
    }
}