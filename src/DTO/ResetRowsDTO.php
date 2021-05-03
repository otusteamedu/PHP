<?php

namespace Src\DTO;

class ResetRowsDTO
{
    private int $from;
    private int $count;

    public function __construct(int $from, int $count)
    {
        $this->from = $from;
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getFrom(): int
    {
        return $this->from;
    }

    /**
     * @param int $from
     */
    public function setFrom(int $from): void
    {
        $this->from = $from;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }


}