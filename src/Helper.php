<?php

namespace nvggit;

/**
 * Class Helper
 * @package nvggit
 */
class Helper extends Input
{
    const MATH_OPERATORS = [
        'add' => 'Addition: Sum of $a and $b.',
        'sub' => 'Subtraction: Difference of $a and $b.',
        'mul' => 'Multiplication: Product of $a and $b.',
        'div' => 'Division: Quotient of $a and $b.'
    ];

    const HELPER_ARGUMENTS = [
        '-h,--help' => 'Print calculator helper'
    ];

    /**
     * Helper constructor.
     * @param $input
     * @param $inputCount
     */
    public function __construct($input, $inputCount)
    {
        parent::__construct($input, $inputCount);
    }

    public function getHelper()
    {
        if ((new ValidateInput(parent::getInput(), parent::getInputCount()))->isHelperArgsCompareDefault()) {
            if (in_array(parent::getOperator(), explode(',', array_keys(self::HELPER_ARGUMENTS)[0]))) {
                return $this->getHelperText();
            } else {
                return $this->getHelperArgumentsText();
            }
        }
    }

    public function getHelperArgumentsText(): string
    {
        $out = '';
        foreach (self::HELPER_ARGUMENTS as $helperArgumentKey => $helperArgumentVal)
            $out .= str_replace(',', ' ', $helperArgumentKey) . "    $helperArgumentVal\n";
        return $out;
    }

    public function getHelperMathOperatorsText(): string
    {
        $out = '';
        foreach (self::MATH_OPERATORS as $mathOperatorKey => $mathOperatorValue)
            $out .= "<operator> $mathOperatorKey    $mathOperatorValue\n";
        return $out;
    }

    public function getHelperText(): string
    {
        $out = "Usage: calculator.php <arg1> <operator> <arg2> \n";
        $out .= $this->getHelperArgumentsText();
        $out .= $this->getHelperMathOperatorsText();
        return $out;
    }
}