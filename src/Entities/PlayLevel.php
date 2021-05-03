<?php


namespace Src\Entities;


class PlayLevel
{
    private int $speed;
    private int $needScore;

    public function __construct(int $speed, int $needScore)
    {
        $this->speed = $speed;
        $this->needScore = $needScore;
    }

    /**
     * @return int
     */
    public function getSpeed(): int
    {
        return $this->speed;
    }

    /**
     * @param int $speed
     */
    public function setSpeed(int $speed): void
    {
        $this->speed = $speed;
    }

    /**
     * @return int
     */
    public function getNeedScore(): int
    {
        return $this->needScore;
    }

    /**
     * @param int $needScore
     */
    public function setNeedScore(int $needScore): void
    {
        $this->needScore = $needScore;
    }
}