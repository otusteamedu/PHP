<?php


namespace Src\Services\Score;


use Src\Entities\Play;

class TwoRowResetScoreCalculator implements ScoreCalculator
{
    private const ROWS_RESET = 2;
    private const BONUS = 1.1;

    public function calculate(Play $play): int
    {
        return $play->getCurrentLevel()->getSpeed() * self::ROWS_RESET * self::BONUS;
    }
}