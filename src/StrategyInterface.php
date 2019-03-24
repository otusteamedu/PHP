<?php

namespace crazydope\calculator;

interface StrategyInterface
{
    public function execute($a, $b);
}