<?php

namespace Bjlag\Services;

class TopChannelStatistics
{
    /**
     * @var array
     */
    private $channelIds = [];

    /**
     * @param array $channelIds
     * @return TopChannelStatistics
     */
    public function setChannelIds(array $channelIds): TopChannelStatistics
    {
        foreach ($channelIds as $channel) {
            $id = $channel['_id']['channel_id'] ?? null;
            if ($id === null) {
                continue;
            }

            $this->channelIds[] = $id;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getChannelIds(): array
    {
        return $this->channelIds;
    }
}
