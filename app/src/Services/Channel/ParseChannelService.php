<?php

namespace App\Services\Channel;

use App\Entities\Channel;
use App\Entities\Video;
use App\Repositories\Video\VideoRepository;
use App\Services\ServiceContainer\AppServiceContainer;
use App\Services\YouTube\DataTransferObjects\PlaylistItemDTO;
use App\Services\YouTube\Exceptions\YouTubeApiBadResponseException;
use App\Services\YouTube\Managers\ChannelManager;
use App\Services\YouTube\Managers\PlaylistItemsManager;
use App\Services\YouTube\Managers\VideoManager;
use App\Repositories\Channel\ChannelRepository;

class ParseChannelService
{
    private ChannelManager $channelManager;
    private VideoManager $videoManager;
    private PlaylistItemsManager $playlistItemManager;
    private ChannelRepository $channelRepository;
    private VideoRepository $videoRepository;

    public function __construct()
    {
        $this->channelManager = new ChannelManager;
        $this->videoManager = new VideoManager;
        $this->playlistItemManager = new PlaylistItemsManager;
        $this->channelRepository = AppServiceContainer::getInstance()->resolve(ChannelRepository::class);
        $this->videoRepository = AppServiceContainer::getInstance()->resolve(VideoRepository::class);
    }

    /**
     * @param string $query
     * @throws YouTubeApiBadResponseException
     */
    public function execute(string $query): void
    {
        $channelIds = $this->channelManager->searchByString($query);
        $channelDTOs = $this->channelManager->listChannelsByIds($channelIds);

        foreach($channelDTOs as $channelDto){
            $channel = new Channel();
            $channel->setId($channelDto->getId());
            $channel->setTitle($channelDto->getTitle());
            $channel->setDescription($channelDto->getDescription());
            $channel->setViewsCount($channelDto->getViewsCount());
            $channel->setVideosCount($channelDto->getVideosCount());
            $channel->setSubscribersCount($channelDto->getSubscribersCount());
            $this->channelRepository->save($channel);

            $playlistDTOs = $this->getPlaylistItemsByUploadId($channelDto->getPlaysListItemsUploadsId());
            $videoIds = [];

            foreach($playlistDTOs as $playlistDTO){
                $videoIds[] = $playlistDTO->getVideoId();
            }

            $this->storeVideosByIds($videoIds);
        }
    }

    /**
     * @param string $uploadId
     * @return array | PlaylistItemDTO[]
     * @throws YouTubeApiBadResponseException
     */
    private function getPlaylistItemsByUploadId(string $uploadId) : array
    {
        return $this->playlistItemManager->listByPlaylistId($uploadId);
    }

    /**
     * @param array $videoIds
     * @throws YouTubeApiBadResponseException
     */
    private function storeVideosByIds(array $videoIds): void
    {
        $videoDTOs = $this->videoManager->listVideosByIds($videoIds);
        foreach($videoDTOs as $videoDTO) {
            $video = new Video();
            $video->setId($videoDTO->getId());
            $video->setChannelId($videoDTO->getChannelId());
            $video->setTitle($videoDTO->getTitle());
            $video->setDescription($videoDTO->getDescription());
            $video->setViewCount($videoDTO->getViewCount());
            $video->setDislikeCount($videoDTO->getDislikeCount());
            $video->setCommentCount($videoDTO->getCommentCount());
            $video->setFavoriteCount($videoDTO->getFavoriteCount());
            $video->setLikeCount($videoDTO->getLikeCount());
            $video->setPublishedAt($videoDTO->getPublishedAt());

            $this->videoRepository->save($video);
        }
    }
}