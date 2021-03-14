<?php


namespace Repetitor202\Domain\Services\Explorers\YouTube;


use Repetitor202\Application\Clients\SQL\ElasticsearchQuery;
use Repetitor202\Application\Clients\SQL\MongoDbQuery;
use Repetitor202\Domain\ActiveRecords\Explorers\YouTube\VideoActiveRecord;
use Repetitor202\Domain\Factories\Explorers\YouTube\Video\VideoElasticsearchFactory;
use Repetitor202\Domain\Factories\Explorers\YouTube\Video\VideoFactory;
use Repetitor202\Domain\Factories\Explorers\YouTube\Video\VideoMongoDbFactory;

class VideoService
{
    private VideoActiveRecord $activeRecord;
    private ?VideoFactory $factory;

    public function __construct()
    {
        switch ($_ENV['SQL_CLIENT']) {
            case ElasticsearchQuery::STORAGE_NAME:
                $this->factory = new VideoElasticsearchFactory();
                break;
            case MongoDbQuery::STORAGE_NAME:
                $this->factory = new VideoMongoDbFactory();
                break;
            default:
                $this->factory = null;
        }
        $this->activeRecord = new VideoActiveRecord();
    }

//    public function saveVideo(string $videoIDs): void{}

    public function insertVideo(array $params): bool
    {
        $this->activeRecord->setId($params['id']);
        $this->activeRecord->setChannelId($params['channelId']);
        $this->activeRecord->setLikeCount($params['likeCount']);
        $this->activeRecord->setDislikeCount($params['dislikeCount']);
        $this->activeRecord->setTitle($params['title']);

        return $this->activeRecord->insert();
    }

    public function report(): void
    {
        $report = $this->factory->getVideos();

        if(is_null($report) || empty($report)) {
            echo 'Required data are absent in the repository!' . PHP_EOL;
        } else {
            print_r($report);
        }
    }

    public function deleteVideos(array $params): bool
    {
        return $this->factory->deleteVideos($params);
    }

    public function printReportInsertVideo(string $videoId, bool $resultInsertVideo): void
    {
        $videoInsert = '+++++Video id=' . $videoId . ' is ';
        $videoInsert .= $resultInsertVideo ? '' : 'not';
        $videoInsert .= ' inserted.' . PHP_EOL;
        echo $videoInsert;
    }
}