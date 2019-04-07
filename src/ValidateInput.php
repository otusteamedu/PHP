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

    public $input;

    /**
     * ValidateInput constructor.
     * @param $input
     */
    public function __construct($input)
    {
        $this->input = $input;
    }

    /**
     * @throws \Exception
     */
    public function validate()
    {
        if (!$this->validateCountArguments()) {
            throw new \Exception('Wrong count of arguments!');
        } else {
            if (count($this->input) === self::MATH_COUNT_ARGUMENTS && !$this->validateOperator())
                throw new \Exception("Operator '" . $this->getOperator() . "' do not support!");
        }
    }

    public function getOperator(): string
    {
        return $this->input[2];
    }

    public function validateCountArguments(): bool
    {
        return count($this->input) === self::MATH_COUNT_ARGUMENTS || count($this->input) === self::HELPER_COUNT_ARGUMENTS;
    }

    public function validateOperator(): bool
    {
        return array_key_exists($this->getOperator(), Helper::MATH_OPERATORS);
    }
}