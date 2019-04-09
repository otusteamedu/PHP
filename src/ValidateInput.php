<?php

namespace nvggit;

/**
 * Class ValidateInput
 * @package nvggit
 */
class ValidateInput extends Input
{
    const MATH_COUNT_ARGUMENTS = 4;
    const HELPER_COUNT_ARGUMENTS = 2;

    /**
     * ValidateInput constructor.
     * @param $input
     * @param $inputCount
     */
    public function __construct($input, $inputCount)
    {
        parent::__construct($input, $inputCount);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function validate(): bool
    {
        if (!$this->validateCountArguments()) {
            throw new \Exception('Wrong count of arguments!');
        } else {
            if ($this->isMathArgsCompareDefault() && !$this->validateOperator())
                throw new \Exception("Operator '" . parent::getOperator() . "' do not support!");
        }
        return true;
    }

    public function isMathArgsCompareDefault()
    {
        return parent::getInputCount() === self::MATH_COUNT_ARGUMENTS;
    }

    public function isHelperArgsCompareDefault()
    {
        return parent::getInputCount() === self::HELPER_COUNT_ARGUMENTS;
    }

    public function validateCountArguments(): bool
    {
        return  $this->isMathArgsCompareDefault() || $this->isHelperArgsCompareDefault();
    }

    public function validateOperator(): bool
    {
        return array_key_exists(parent::getOperator(), Helper::MATH_OPERATORS);
    }
}