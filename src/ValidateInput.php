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
            return $this->error = self::ERROR_COUNT_ARGUMENTS;
        }
        if ($this->isMathArgsCompareDefault() && !$this->validateOperator()) {
            return $this->error = self::ERROR_WRONG_OPERATOR;
        }
        return true;
    }

    public function getInputCount(): int
    {
        return $this->inputCount;
    }

    public function getOperator(): string
    {
        return $this->input[2];
    }

    public function isMathArgsCompareDefault(): bool
    {
        return $this->getInputCount() === self::MATH_COUNT_ARGUMENTS;
    }

    public function isHelperArgsCompareDefault(): bool
    {
        return $this->getInputCount() === self::HELPER_COUNT_ARGUMENTS;
    }

    public function validateCountArguments(): bool
    {
        return $this->isMathArgsCompareDefault() || $this->isHelperArgsCompareDefault();
    }

    public function validateOperator(): bool
    {
        return array_key_exists($this->getOperator(), Helper::MATH_OPERATORS);
    }
}