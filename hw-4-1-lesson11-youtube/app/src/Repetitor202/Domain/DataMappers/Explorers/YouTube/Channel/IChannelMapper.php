<?php


namespace Repetitor202\Domain\DataMappers\Explorers\YouTube\Channel;


use Repetitor202\Domain\Entities\Explorers\YouTube\ChannelEntity;

interface IChannelMapper
{
    /**
     * @param array $params
     *
     * TODO
     * @return ChannelEntity[]|null
     */
    public function getCollection(array $params = []): ?iterable;

    public function findChannelById(string $channelId): ?ChannelEntity;

    public function createChannel(array $channel, string $channelId): ChannelEntity;

    public function deleteChannel(ChannelEntity $channelEntity): bool;
}