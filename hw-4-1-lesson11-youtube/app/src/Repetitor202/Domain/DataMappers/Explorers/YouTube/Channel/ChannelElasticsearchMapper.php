<?php


namespace Repetitor202\Domain\DataMappers\Explorers\YouTube\Channel;


use Repetitor202\Application\Clients\SQL\ElasticsearchQuery;
use Repetitor202\Domain\Entities\Explorers\YouTube\ChannelEntity;

class ChannelElasticsearchMapper implements IChannelMapper
{
    public const TABLE = 'youtube_channels';

    private function validateDbChannel(?array $channel): bool
    {
        if (! is_array($channel) ||
            ! isset($channel['_id']) ||
            ! isset($channel['_source']) ||
            ! isset($channel['_source']['ratioLikeDislike']) ||
            ! isset($channel['_source']['title'])
        ) {
            return false;
        }

        return true;
    }

    private function validateDbChannels(?array $channels): bool
    {
        if (! is_array($channels) ||
            ! isset($channels['hits']) ||
            ! isset($channels['hits']['hits'])
        ) {
            return false;
        }

        return true;
    }

    /**
     * @param array $params
     *
     * TODO
     * @return ChannelEntity[]|null
     */
    public function getCollection(array $params = []): ?iterable
    {
        $items = ElasticsearchQuery::selectItems(self::TABLE, $params);

        if(! $this->validateDbChannels($items)) {
            return null;
        }

        $collection = [];
        foreach ($items['hits']['hits'] as $channel) {

            if(! $this->validateDbChannel($channel)) {
                return null;
            }

            $channelEntity = new ChannelEntity(
                $channel['_id'],
                $channel['_source']['ratioLikeDislike'],
                $channel['_source']['title']
            );
            $collection[] = $channelEntity;
        }

        return $collection;
    }

    public function findChannelById(string $channelId): ?ChannelEntity
    {
        $channel = ElasticsearchQuery::findById(self::TABLE, $channelId);
        if(! $this->validateDbChannel($channel)) {
            return null;
        }

        return new ChannelEntity(
            $channel['_id'],
            $channel['_source']['ratioLikeDislike'],
            $channel['_source']['title']
        );
    }

    public function createChannel(array $channel, string $channelId): ChannelEntity
    {
        ElasticsearchQuery::createOneItem(self::TABLE, $channel, $channelId);

        return new ChannelEntity(
            $channelId,
            $channel['ratioLikeDislike'],
            $channel['title']
        );
    }

    public function deleteChannel(ChannelEntity $channelEntity): bool
    {
        return ElasticsearchQuery::deleteById(self::TABLE, $channelEntity->getId());
    }
}