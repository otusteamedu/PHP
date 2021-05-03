<?php


namespace Src\Services\Score;


use Src\Entities\Play;

class FourRowResetScoreCalculator implements ScoreCalculator
{
    private const ROWS_RESET = 4;
    private const BONUS = 1.5;

    public function calculate(Play $play): int
    {
        return $play->getCurrentLevel()->getSpeed() * self::ROWS_RESET * self::BONUS;
    }
}