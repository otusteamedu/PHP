<?php


namespace Src\Services\Score;


use Src\Entities\Play;

class ThreeRowResetScoreCalculator implements ScoreCalculator
{
    private const ROWS_RESET = 3;
    private const BONUS = 1.3;

    public function calculate(Play $play): int
    {
        return $play->getCurrentLevel()->getSpeed() * self::ROWS_RESET * self::BONUS;
    }
}