<?php


namespace YoutubeApp;


class Controller
{
    private YoutubeGetInfoModel $youtubeModel;
    private AddDataToCollectionModel $addDoc;
    private array $channelNames = ['KuTstupid', 'CentralPartnership', 'ctctv', 'fixiki', 'KanalDisneyCartoons'];

public function __construct()
{
    $this->youtubeModel = new YoutubeGetInfoModel();
    $this->addDoc = new AddDataToCollectionModel();
}

    public function run(): void
    {
        foreach ($this->channelNames as $channelName) {

            $channelInfo = $this->youtubeModel->getChannelInfoByName($channelName);

            $this->addDoc->setNameField($channelInfo->items[0]->snippet->title);
            $this->addDoc->setDescriptionField($channelInfo->items[0]->snippet->description);

            $videos = [];
            $channelVideos = $this->youtubeModel->getVideosInfoByChannelId($channelInfo->items[0]->id);
            foreach ($channelVideos->items as $channelVideo) {
                $videoStats = $this->youtubeModel->getVideosStatisticsById($channelVideo->id->videoId);
                $videos[] = [
                    'name' => $channelVideo->snippet->title,
                    'likes' => $videoStats->items[0]->statistics->likeCount,
                    'dislikes' => $videoStats->items[0]->statistics->dislikeCount
                ];
            }
            $this->addDoc->setVideosField($videos);
            $this->addDoc->addDocument();
        }
    }
}

