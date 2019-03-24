<?php

namespace crazydope\calculator;

interface ExpressionInterface
{
    public function getAIdx(): int;
    public function getBIdx(): int;

    public function setAIdx( int $aIdx );
    public function setBIdx( int $bIdx );

    public function getOperator(): string;

    public function getResult();
    public function setResult($result);
}