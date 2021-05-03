<?php


namespace Src\Services\Score;

use Src\Entities\Play;

interface ScoreCalculator
{
    public function calculate(Play $play) : int;
}