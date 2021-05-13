<?php


namespace App\Model\Youtube;


use App\Model\Service\VideoServiceInterface;
use App\Model\Storage\YoutubeStorageInterface;

class Analyzer
{
    const PER_REQUEST_VIDEOS = 50;

    private YoutubeStorageInterface $storage;
    private VideoServiceInterface $service;
    private DataMapper $dataMapper;

    public function __construct(YoutubeStorageInterface $storage, VideoServiceInterface $service, DataMapper $dataMapper)
    {
        $this->storage = $storage;
        $this->service = $service;
        $this->dataMapper = $dataMapper;
    }

    public function process(array $channelIds): array
    {
        $channels = $this->service->getChannels($channelIds);
        $videoIdsOnChannels = $this->service->getVideosOnChannel($channelIds);
        foreach ($channels as $channel) {
            $this->storage->addChannel($this->dataMapper->getChannel($channel));
            $videoIds = $videoIdsOnChannels[$channel->getId()] ?? null;
            if (!$videoIds) {
                continue;
            }
            $offset = 0;
            $videosCount = count($videoIds);
            while ($offset < $videosCount) {
                $channelVideoIds = array_slice($videoIds, $offset, self::PER_REQUEST_VIDEOS);
                $offset += self::PER_REQUEST_VIDEOS;
                $videos = $this->service->getVideosStatistics($channelVideoIds);
                foreach ($videos as $video) {
                    $result = $this->storage->addVideo($this->dataMapper->getVideo($video));
                }
            }
        }
        return $videoIdsOnChannels;
    }
}
