<?php


namespace Repetitor202\Domain\Factories\Explorers\YouTube\Video;


use Repetitor202\Application\Clients\SQL\MongoDbClient;
use Repetitor202\Domain\ActiveRecords\Explorers\YouTube\VideoActiveRecord;

class VideoMongoDbFactory extends VideoFactory
{
    public function getVideos(array $params = []): ?array
    {
        $videos = MongoDbClient::selectItems(VideoActiveRecord::TABLE, $params);

        if(is_null($videos)) {
            return null;
        }

        return $videos;
    }

    public function deleteVideos(array $params): bool
    {
        return MongoDbClient::deleteByParams(VideoActiveRecord::TABLE, $params);
    }
}