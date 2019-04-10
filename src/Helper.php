<?php

namespace nvggit;

/**
 * Class Helper
 * @package nvggit
 */
class Helper
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

    public $operator;

    /**
     * Helper constructor.
     * @param $operator
     */
    public function __construct($operator)
    {
        $this->operator = $operator;
    }

    public function getMessageForError($error)
    {
        if($error === ValidateInput::ERROR_COUNT_ARGUMENTS) {
                return "Wrong count of arguments! Expected 3!";
        } elseif ($error === ValidateInput::ERROR_WRONG_OPERATOR) {
                return $this->getHelper();
        }
    }

    public function getHelper()
    {
        if (in_array(  $this->operator, explode(',', array_keys(self::HELPER_ARGUMENTS)[0]))) {
            return $this->getHelperText();
        } else {
            return $this->getHelperArgumentsText();
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