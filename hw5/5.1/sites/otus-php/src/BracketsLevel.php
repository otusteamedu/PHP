<?php

namespace App\Brackets;

class BracketsLevel
{
    private $level;
    private $stateOpen = true;
    private $stateClose = false;
    private $openPosition;
    private $closePosition;

    /**
     * BracketsLevel constructor.
     * @param $level
     * @param $openPosition
     */
    public function __construct($level, $openPosition)
    {
        $this->level = $level;
        $this->openPosition = $openPosition;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $position
     */
    public function closeLevel(int $position): void
    {
        $this->stateClose = true;
        $this->closePosition = $position;
    }

    public function getOpenPosition(): int
    {
        return $this->openPosition;
    }

    public function getClosePosition(): int
    {
        return $this->closePosition;
    }

    public function isClosedLevel(): bool
    {
        return $this->stateOpen && $this->stateClose ? true : false;
    }
}





