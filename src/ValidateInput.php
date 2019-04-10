<?php

namespace nvggit;

/**
 * Class ValidateInput
 * @package nvggit
 */
class ValidateInput
{
    const MATH_COUNT_ARGUMENTS = 4;
    const HELPER_COUNT_ARGUMENTS = 2;

    const ERROR_COUNT_ARGUMENTS = 1;
    const ERROR_WRONG_OPERATOR = 2;

    public $error;
    private $input;
    private $inputCount;

    /**
     * ValidateInput constructor.
     * @param $input
     * @param $inputCount
     */
    public function __construct($input, $inputCount)
    {
        $this->input = $input;
        $this->inputCount = $inputCount;
    }


    public function getError()
    {
      return $this->error;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function validate(): bool
    {
        if (!$this->validateCountArguments()) {
            $this->error = self::ERROR_COUNT_ARGUMENTS;
        } else {
            if ($this->isMathArgsCompareDefault() && !$this->validateOperator())
                $this->error = self::ERROR_WRONG_OPERATOR;
        }
        return true;
    }

    public function getInputCount()
    {
        return $this->inputCount;
    }

    public function getOperator()
    {
        return $this->input[2];
    }

    public function isMathArgsCompareDefault()
    {
        return $this->getInputCount() === self::MATH_COUNT_ARGUMENTS;
    }

    public function isHelperArgsCompareDefault()
    {
        return $this->getInputCount() === self::HELPER_COUNT_ARGUMENTS;
    }

    public function validateCountArguments(): bool
    {
        return  $this->isMathArgsCompareDefault() || $this->isHelperArgsCompareDefault();
    }

    public function validateOperator(): bool
    {
        return array_key_exists($this->getOperator(), Helper::MATH_OPERATORS);
    }
}