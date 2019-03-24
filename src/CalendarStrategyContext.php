<?php

namespace crazydope\calculator;

use crazydope\calculator\Exceptions\DivisionByZeroException;
use crazydope\calculator\Exceptions\NotExpression;

class CalendarStrategyContext
{
    /**
     * @var StrategyInterface
     */
    private $strategy;
    /**
     * @var array
     */
    private $input;

    /**
     * @var
     */
    private $expressionList;

    /**
     * @param $a
     * @param $b
     * @return mixed
     * @throws DivisionByZeroException
     */
    private function execute( $a, $b )
    {
        return $this->strategy->execute($a, $b);
    }

    /**
     * @param string $operation
     * @return CalendarStrategyContext
     */
    private function setStrategy( string $operation ): CalendarStrategyContext
    {
        switch ( $operation ) {
            case '*':
                $this->strategy = new StrategyMultiply();
                break;
            case '/':
                $this->strategy = new StrategyDivision();
                break;
            case '+':
                $this->strategy = new StrategySum();
                break;
            case '-':
                $this->strategy = new StrategySubtract();
                break;
        }
        return $this;
    }

    public function __construct( array $input, ExpressionListInterface $expressionList )
    {
        $this->input = $input;
        $this->expressionList = $expressionList;
    }

    /**
     * @return int
     * @throws NotExpression
     * @throws DivisionByZeroException
     */
    public function calculate(): int
    {
        $result = 0;
        foreach ( $this->expressionList as $key => $expression ) {

            if ( !$expression instanceof ExpressionInterface ) {
                throw new NotExpression($key . ' не  явдяется Expression');
            }

            if ( $this->input[$expression->getAIdx()] === null ) {
                $expressionIdx = $this->expressionList->findB($expression->getAIdx());
                $a = $this->expressionList->get($expressionIdx)->getResult();
                $expression->setAIdx($this->expressionList->get($expressionIdx)->getAIdx());
                $this->expressionList->remove($expressionIdx);
            } else {
                $a = $this->input[$expression->getAIdx()];
                $this->input[$expression->getAIdx()] = null;
            }

            if ( $this->input[$expression->getBIdx()] === null ) {
                $expressionIdx = $this->expressionList->findA($expression->getBIdx());
                $b = $this->expressionList->get($expressionIdx)->getResult();
                $expression->setBIdx($this->expressionList->get($expressionIdx)->getBIdx());
                $this->expressionList->remove($expressionIdx);
            } else {
                $b = $this->input[$expression->getBIdx()];
                $this->input[$expression->getBIdx()] = null;
            }

            $result = $this
                ->setStrategy($expression->getOperator())
                ->execute($a, $b);

            $expression->setResult($result);
        }

        return $result;
    }
}