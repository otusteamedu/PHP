<?php


namespace Repetitor202\Domain\Services\Explorers\YouTube;


use Repetitor202\Application\Clients\Explorers\YouTube\YouTubeClient;
use Repetitor202\Domain\Entities\Explorers\YouTube\ChannelEntity;
use Repetitor202\Domain\Repositories\Explorers\YouTube\ChannelsRepository;

class ChannelService
{
    private YouTubeClient $youTubeClient;
    private ChannelsRepository $repository;
    private VideoService $videoService;

    public function __construct()
    {
        $this->youTubeClient = new YouTubeClient();
        $this->repository = new ChannelsRepository();
        $this->videoService = new VideoService();
    }

    public function printChannels(): void
    {
        $report = $this->repository->getList();

        if(is_null($report) || empty($report)) {
            echo 'Required data are absent in the repository!' . PHP_EOL;
        } else {
            print_r($report);
        }
    }

    public function saveChannel(string $channelId): void
    {
        $channel = $this->youTubeClient->getChannel($channelId);
        $videos = $channel['videos'];

        $resultDeleteVideos = $this->deleteVideos($channelId);
        $resultDeleteChannel = $this->deleteChannel($channelId);
        $resultInsertChannel = $this->insertChannel($channel, $videos);

        $this->printReportDeleteInsertChannel(
            $channelId,
            $resultDeleteVideos,
            $resultDeleteChannel,
            $resultInsertChannel
        );

        $this->insertVideos($videos);
    }

    public function top(int $topNumber): void
    {
        $params = [
            'options' => [
                'skip' => 0,
                'limit' => $topNumber,
                'sort' => [
                    [
                        'col' => 'ratioLikeDislike',
                        'ascDesc' => 'desc'
                    ],
                ],
            ],
        ];

        print_r($this->repository->getList($params));
    }

    public function updateList(): void
    {
        $channels = $this->repository->getList();

        $channelIDs = [];
        foreach ($channels as $channel) {
            array_push($channelIDs, $channel['id']);
        }

        foreach ($channelIDs as $channelID) {
            $this->saveChannel($channelID);
        }
    }

    private function insertChannel(array $channel, array $videos): bool
    {
        $likeCount = 0;
        $dislikeCount = 0;

        foreach ($videos as $video) {
            $likeCount += $video['likeCount'];
            $dislikeCount += $video['dislikeCount'];
        }

        // TODO
        $ratioLikeDislike = ($dislikeCount != 0) ? $likeCount/$dislikeCount : $likeCount;

        $insertChannel = $this->repository->createChannel([
            'id' => $channel['id'],
            'ratioLikeDislike' => $ratioLikeDislike,
            'title' => $channel['title'],
        ]);

        return $insertChannel instanceof ChannelEntity;
    }

    private function deleteChannel(string $channelId): bool
    {
        return $this->repository->deleteChannel($channelId);
    }

    private function insertVideos(array $videosApi): void
    {
        $n = 0;

        foreach ($videosApi as $video) {
            $resultInsertVideo = $this->videoService->insertVideo($video);
            $n = $resultInsertVideo ? $n + 1 : $n;
            $this->videoService->printReportInsertVideo($video['id'], $resultInsertVideo);
        }

        echo '>>' . $n . ' video(s) is(are) inserted.' . PHP_EOL;
    }

    private function deleteVideos(string $channelId): bool
    {
        return $this->videoService->deleteVideos([
            'match' => ['channelId' => $channelId],
        ]);
    }

    private function printReportDeleteInsertChannel(
        string $channelId,
        bool $resultDeleteVideos,
        bool $resultDeleteChannel,
        bool $resultInsertChannel
    ): void
    {
        $videosDelete = '>>Videos of the channel id=' . $channelId;
        $videosDelete .= ' , if they were in the database, are ';
        $videosDelete .= $resultDeleteVideos ? '' : 'not';
        $videosDelete .= ' deleted.' . PHP_EOL;
        echo $videosDelete;

        $channelDelete = '>>The channel id=' . $channelId . ' , if it was in the database, is ';
        $channelDelete .= $resultDeleteChannel ? '' : 'not';
        $channelDelete .= ' deleted.' . PHP_EOL;
        echo $channelDelete;

        $channelInsert = '++++++++++Channel id=' . $channelId . ' is ';
        $channelInsert .= $resultInsertChannel ? '' : 'not';
        $channelInsert .= ' inserted.' . PHP_EOL;
        echo $channelInsert;
    }
}