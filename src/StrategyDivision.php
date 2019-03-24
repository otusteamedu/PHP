<?php

namespace crazydope\calculator;

use crazydope\calculator\Exceptions\DivisionByZeroException;

class StrategyDivision
    implements StrategyInterface
{
    /**
     * @param $a
     * @param $b
     * @return float|int
     * @throws DivisionByZeroException
     */
    public function execute( $a, $b )
    {
        if ( $b == 0 ) {
            throw new DivisionByZeroException('Ошибка! Нельзя делить на 0!');
        }

        return $a / $b;
    }
}