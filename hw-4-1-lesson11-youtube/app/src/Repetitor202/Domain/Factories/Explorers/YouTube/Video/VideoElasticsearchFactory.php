<?php


namespace Repetitor202\Domain\Factories\Explorers\YouTube\Video;


use Repetitor202\Application\Clients\SQL\ElasticsearchQuery;
use Repetitor202\Domain\ActiveRecords\Explorers\YouTube\VideoActiveRecord;

class VideoElasticsearchFactory extends VideoFactory
{

    public function getVideos(array $params = []): ?array
    {
        $videos = ElasticsearchQuery::selectItems(VideoActiveRecord::TABLE, $params);

        if(is_null($videos)) {
            return null;
        }

        $list = [];
        foreach ($videos['hits']['hits'] as $video) {
            $item = [
                'id' => $video['_id'],
                'channelId' => $video['_source']['channelId'],
                'likeCount' => $video['_source']['likeCount'],
                'dislikeCount' => $video['_source']['dislikeCount'],
                'title' => $video['_source']['title'],
            ];
            $list[] = $item;
        }

        return $list;
    }

    public function deleteVideos(array $params): bool
    {
        return ElasticsearchQuery::deleteByParams(VideoActiveRecord::TABLE, $params);
    }
}