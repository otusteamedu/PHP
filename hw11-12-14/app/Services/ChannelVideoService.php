<?php

namespace App\Services;

use App\Models\Channel;
use App\ModelHydrators\YoutubeHydratorInterface;
use App\Repositories\CUDRepositoryInterface;
use App\Repositories\ReadRepositoryInterface;
use App\Exceptions\NotAModelArgumentException;
use JetBrains\PhpStorm\ArrayShape;

class ChannelVideoService
{
    /**
     * @var ReadRepositoryInterface
     */
    protected ReadRepositoryInterface $youtubeChannelRepository;

    /**
     * @var YoutubeHydratorInterface
     */
    protected YoutubeHydratorInterface $channelModelHydrator;

    /**
     * @var ReadRepositoryInterface
     */
    protected ReadRepositoryInterface $youtubeSearchRepository;

    /**
     * @var YoutubeHydratorInterface
     */
    protected YoutubeHydratorInterface $searchModelHydrator;

    /**
     * @var ReadRepositoryInterface
     */
    protected ReadRepositoryInterface $youtubeVideoRepository;

    /**
     * @var YoutubeHydratorInterface
     */
    protected YoutubeHydratorInterface $videoModelHydrator;

    /**
     * @var CUDRepositoryInterface
     */
    protected CUDRepositoryInterface $elasticChannelRepository;

    /**
     * @var CUDRepositoryInterface
     */
    protected CUDRepositoryInterface $elasticVideoRepository;

    /**
     * ChannelVideoService constructor.
     *
     * @param ReadRepositoryInterface $youtubeChannelRepository
     * @param YoutubeHydratorInterface $channelModelHydrator
     * @param ReadRepositoryInterface $youtubeSearchRepository
     * @param YoutubeHydratorInterface $searchModelHydrator
     * @param ReadRepositoryInterface $youtubeVideoRepository
     * @param YoutubeHydratorInterface $videoModelHydrator
     * @param CUDRepositoryInterface $elasticChannelRepository
     * @param CUDRepositoryInterface $elasticVideoRepository
     */
    public function __construct(
        ReadRepositoryInterface $youtubeChannelRepository,
        YoutubeHydratorInterface $channelModelHydrator,
        ReadRepositoryInterface $youtubeSearchRepository,
        YoutubeHydratorInterface $searchModelHydrator,
        ReadRepositoryInterface $youtubeVideoRepository,
        YoutubeHydratorInterface $videoModelHydrator,
        CUDRepositoryInterface $elasticChannelRepository,
        CUDRepositoryInterface $elasticVideoRepository
    )
    {
        $this->youtubeChannelRepository = $youtubeChannelRepository;
        $this->channelModelHydrator = $channelModelHydrator;
        $this->youtubeSearchRepository = $youtubeSearchRepository;
        $this->searchModelHydrator = $searchModelHydrator;
        $this->youtubeVideoRepository = $youtubeVideoRepository;
        $this->videoModelHydrator = $videoModelHydrator;
        $this->elasticChannelRepository = $elasticChannelRepository;
        $this->elasticVideoRepository = $elasticVideoRepository;
    }

    /**
     * @param string $id
     *
     * @return array
     *
     * @throws NotAModelArgumentException
     */
    public function fetchChannelAndVideos(string $id): array
    {
        $resultChannel = $this->fetchChannelById($id);
        $channelId = empty($result['models'][0]) ? $resultChannel['models'][0]->getId() : null;

        if (!$channelId)
            return ['channel_id' => null, 'video_ids' => null];

        do {
            $resultSearch = $this->fetchSearchByChannelId($id);
            //pluck video ids from search results
            $videoIds = array_map(function ($model) {
                return $model->getId();
            }, $resultSearch['models']);
            //get videos from api to id
            $resultVideos = $this->fetchVideosByIds($videoIds);

            //now save videos to elastic
            $this->saveChannelToElastic($resultChannel['models'], $videoIds);
            $this->saveVideosToElastic($resultVideos['models'], $channelId);
            sleep(10);
        } while ($resultSearch['nextPageToken']);

        return ['channel_id' => $channelId, 'video_ids' => $videoIds];
    }

    /**
     * @param string $id
     *
     * @return array
     */
    public function fetchChannelById(string $id): array
    {
        $channelsRawData = $this->youtubeChannelRepository->findById($id);

        return $this->channelModelHydrator->hydrate($channelsRawData);
    }

    /**
     * @param array $channels
     *
     * @param array $videoIds
     *
     * @throws NotAModelArgumentException
     */
    public function saveChannelToElastic(array $channels, array $videoIds)
    {
        //write channel data to elastic here
        foreach ($channels as $channel) {
            if (!is_a($channel, Channel::class))
                throw new NotAModelArgumentException();

            $channel->setVideoIds($videoIds);
            $this->elasticChannelRepository->insert($channel);
        }
    }

    /**
     * @param string $id
     *
     * @return array
     */
    public function fetchSearchByChannelId(string $id): array
    {
        $searchRawData = $this->youtubeSearchRepository->findById($id);

        return $this->searchModelHydrator->hydrate($searchRawData);
    }

    /**
     * @param array $ids
     *
     * @return array
     */
    public function fetchVideosByIds(array $ids): array
    {
        $videoRawData = $this->youtubeVideoRepository->findManyByIds($ids);

        return $this->videoModelHydrator->hydrate($videoRawData);
    }

    /**
     * @param array $videos
     *
     * @param string|null $channelId
     */
    public function saveVideosToElastic(array $videos, ?string $channelId)
    {
        foreach ($videos as $video) {
            $video->setChannelId($channelId);
        }

        $this->elasticVideoRepository->insertMany($videos);
    }
}
