<?php


namespace Src\Services\Score;


use Src\Entities\Play;

class OneRowResetScoreCalculator implements ScoreCalculator
{
    private const ROWS_RESET = 1;

    public function calculate(Play $play): int
    {
        return $play->getCurrentLevel()->getSpeed() * self::ROWS_RESET;
    }
}