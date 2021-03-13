<?php


namespace Repetitor202\Domain\DataMappers\Explorers\YouTube\Channel;


use Repetitor202\Application\Clients\SQL\MongoDbClient;
use Repetitor202\Domain\Entities\Explorers\YouTube\ChannelEntity;

class ChannelMongoDbMapper implements IChannelMapper
{
    public const TABLE = 'youtube_channels';

    private function validateDbChannel(?array $channel): bool
    {
        if (! is_array($channel) ||
            ! isset($channel['_id']) ||
            ! isset($channel['ratioLikeDislike']) ||
            ! isset($channel['title'])
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
        $items = MongoDbClient::selectItems(self::TABLE, $params);

        if(! is_array($items)) {
            return null;
        }

        $collection = [];
        foreach ($items as $item) {
            $channel = (array) $item->jsonSerialize();

            if(! $this->validateDbChannel($channel)) {
                return null;
            }

            $channelEntity = new ChannelEntity(
                $channel['_id'],
                $channel['ratioLikeDislike'],
                $channel['title']
            );
            $collection[] = $channelEntity;
        }

        return $collection;
    }

    public function findChannelById(string $channelId): ?ChannelEntity
    {
        $channel = MongoDbClient::findById(self::TABLE, $channelId);

        if(! $this->validateDbChannel($channel)) {
            return null;
        }

        return new ChannelEntity(
            $channel['_id'],
            $channel['ratioLikeDislike'],
            $channel['title']
        );
    }

    public function createChannel(array $channel, string $channelId): ChannelEntity
    {
        MongoDbClient::createOneItem(self::TABLE, $channel, $channelId);

        return new ChannelEntity(
            $channelId,
            $channel['ratioLikeDislike'],
            $channel['title']
        );
    }

    public function deleteChannel(ChannelEntity $channelEntity): bool
    {
        return MongoDbClient::deleteById(self::TABLE, $channelEntity->getId());
    }
}