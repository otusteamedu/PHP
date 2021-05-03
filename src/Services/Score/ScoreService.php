<?php

namespace Src\Services\Score;

use Src\Entities\Play;

class ScoreService
{
    private ?ScoreCalculator $scoreCalculator = null;

    public function setCalculator(ScoreCalculator $scoreCalculator) : void
    {
        $this->scoreCalculator = $scoreCalculator;
    }

    public function calculate(Play $play) : int
    {
        return $this->scoreCalculator->calculate($play);
    }
}