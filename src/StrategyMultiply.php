<?php

namespace crazydope\calculator;

class StrategyMultiply
    implements StrategyInterface
{
    /**
     * @param $a
     * @param $b
     * @return float|int
     */
    public function execute( $a, $b )
    {
        return $a * $b;
    }
}