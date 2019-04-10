<?php

namespace nvggit;

/**
 * Class Input
 * @package nvggit
 */
class Input
{
    private $input;
    private $inputCount;

    /**
     * Input constructor.
     * @param $input
     * @param $inputCount
     */
    public function __construct($input, $inputCount)
    {
        $this->input = $input;
        $this->inputCount = $inputCount;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function getInputCount()
    {
        return $this->inputCount;
    }

    public function getOperator()
    {
        return $this->input[2];
    }

    public function getArg1()
    {
        return $this->input[1];
    }

    public function getArg2()
    {
        return $this->input[3];
    }
}