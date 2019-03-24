<?php

namespace crazydope\calculator;

class StrategySubtract
    implements StrategyInterface
{
    /**
     * @param $a
     * @param $b
     * @return mixed
     */
    public function execute( $a, $b )
    {
        return $a - $b;
    }
}