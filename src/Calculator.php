<?php

namespace HW5_1;

class Calculator
{
    /**
     * @var string
     */
    private $expresion;

    /**
     * Calculator constructor.
     * @param string $expresion
     */
    public function __construct(string $expresion)
    {
        $expr = new InfixExpresion($expresion);
        $this->expresion = $expr->toPostfix();
    }

    public function calculate(): float
    {
        $input = $this->expresion;
        $tokens = explode(InfixExpresion::SEPARATOR, $input);
        $stack = new StackImpl();
        foreach ($tokens as $token) {
            $this->createCalcContext($token)->calculation($stack);
        }
        return $stack->isEmpty() ? 0.0 : (float)$stack->pop();
    }

    /**
     * @param $token
     * @return CalcContext
     */
    private function createCalcContext($token): CalcContext
    {
        switch ($token) {
            case InfixExpresion::ADDITION:
                $calcContext = new CalcContext(new AddOperation());
                break;
            case InfixExpresion::SUBTRACTION:
                $calcContext = new CalcContext(new MinOperation());
                break;
            case InfixExpresion::MULTIPLICATION:
                $calcContext = new CalcContext(new ProdOperation());
                break;
            case InfixExpresion::DIVISION:
                $calcContext = new CalcContext(new DivOperation());
                break;
            case InfixExpresion::MODULO:
                $calcContext = new CalcContext(new ModOperation());
                break;
            default:
                $calcContext = new CalcContext(new Operand($token));
        }
        return $calcContext;
    }
}