<?php

namespace crazydope\calculator;

class StrategySum
    implements StrategyInterface
{
    /**
     * @param $a
     * @param $b
     * @return mixed
     */
    public function execute( $a, $b )
    {
        return $a + $b;
    }
}