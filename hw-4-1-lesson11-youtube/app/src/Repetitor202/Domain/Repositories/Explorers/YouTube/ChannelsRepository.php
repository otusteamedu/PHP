<?php


namespace Repetitor202\Domain\Repositories\Explorers\YouTube;


use Repetitor202\Application\helpers\Helper;
use Repetitor202\Application\Clients\SQL\ElasticsearchQuery;
use Repetitor202\Application\Clients\SQL\MongoDbQuery;
use Repetitor202\Domain\DataMappers\Explorers\YouTube\Channel\ChannelElasticsearchMapper;
use Repetitor202\Domain\DataMappers\Explorers\YouTube\Channel\ChannelMongoDbMapper;
use Repetitor202\Domain\DataMappers\Explorers\YouTube\Channel\IChannelMapper;
use Repetitor202\Domain\Entities\Explorers\YouTube\ChannelEntity;
use Repetitor202\Domain\Factories\Explorers\YouTube\ChannelFactory;

class ChannelsRepository
{
    private ?IChannelMapper $mapper;

    public function __construct()
    {
        switch ($_ENV['SQL_CLIENT']) {
            case ElasticsearchQuery::STORAGE_NAME:
                $this->mapper = new ChannelElasticsearchMapper();
                break;
            case MongoDbQuery::STORAGE_NAME:
                $this->mapper = new ChannelMongoDbMapper();
                break;
            default:
                $this->mapper = null;
        }
    }

    public function getList(array $params = []): ?array
    {
        $channelEntities = $this->mapper->getCollection($params);

        if(is_null($channelEntities)) {
            return null;
        }

        return (new ChannelFactory())->report($channelEntities);
    }

    public function createChannel(array $channel): ChannelEntity
    {
        Helper::keyMustExist('id', $channel);
        Helper::keyMustExist('ratioLikeDislike', $channel);
        Helper::keyMustExist('title', $channel);

        $modifiedChannel['ratioLikeDislike'] = $channel['ratioLikeDislike'];
        $modifiedChannel['title'] = $channel['title'];

        return $this->mapper->createChannel($modifiedChannel, $channel['id']);
    }

    public function deleteChannel(string $channelId): bool
    {
        $channel = $this->mapper->findChannelById($channelId);

        if ($channel instanceof ChannelEntity) {
            return $this->mapper->deleteChannel($channel);
        }

        return false;
    }
}