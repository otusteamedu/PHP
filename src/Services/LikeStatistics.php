<?php

namespace Bjlag\Services;

class LikeStatistics
{
    /** @var int */
    private $likesTotal = 0;

    /** @var int */
    private $dislikesTotal = 0;

    /**
     * @return int
     */
    public function getLikesTotal(): int
    {
        return $this->likesTotal;
    }

    /**
     * @param int $likesTotal
     * @return \Bjlag\Services\LikeStatistics
     */
    public function setLikesTotal(int $likesTotal)
    {
        $this->likesTotal = $likesTotal;
        return $this;
    }

    /**
     * @return int
     */
    public function getDislikesTotal(): int
    {
        return $this->dislikesTotal;
    }

    /**
     * @param int $dislikesTotal
     * @return \Bjlag\Services\LikeStatistics
     */
    public function setDislikesTotal(int $dislikesTotal): self
    {
        $this->dislikesTotal = $dislikesTotal;
        return $this;
    }
}
