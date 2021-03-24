<?php


namespace App\Model;


class ChannelStatistic
{
    private int $likesCount;
    private int $dislikesCount;
    private string $channelId;

    /**
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * @param string $channelId
     */
    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }

    /**
     * @return int
     */
    public function getLikesCount(): int
    {
        return $this->likesCount;
    }

    /**
     * @param int $likesCount
     */
    public function setLikesCount(int $likesCount): void
    {
        $this->likesCount = $likesCount;
    }

    /**
     * @return int
     */
    public function getDislikesCount(): int
    {
        return $this->dislikesCount;
    }

    /**
     * @param int $dislikesCount
     */
    public function setDislikesCount(int $dislikesCount): void
    {
        $this->dislikesCount = $dislikesCount;
    }


}
