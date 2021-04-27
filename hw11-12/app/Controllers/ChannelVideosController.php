<?php

namespace App\Controllers;

use App\Exceptions\NotAModelArgumentException;
use App\Services\StatisticsService;
use App\Services\ChannelVideoService;
use Symfony\Component\HttpFoundation\JsonResponse;

class ChannelVideosController
{
    /**
     * @var ChannelVideoService
     */
    private ChannelVideoService $channelVideoService;

    /**
     * @var StatisticsService
     */
    private StatisticsService $statisticsService;

    /**
     * ChannelVideosController constructor.
     *
     * @param ChannelVideoService $channelVideoService
     * @param StatisticsService $statisticsService
     */
    public function __construct(ChannelVideoService $channelVideoService, StatisticsService $statisticsService)
    {
        $this->channelVideoService = $channelVideoService;
        $this->statisticsService = $statisticsService;
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     *
     * @throws NotAModelArgumentException
     */
    public function fetchChannelAndVideos(string $id): JsonResponse
    {
        $response = $this->channelVideoService->fetchChannelAndVideos($id);

        return new JsonResponse($response);
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     */
    public function channelStatistics(string $id): JsonResponse
    {
        $response = $this->statisticsService->fetchChannelStatistics($id);

        return new JsonResponse($response);
    }

    /**
     * @param int $quantity
     *
     * @return JsonResponse
     */
    public function bestChannelStatistics(int $quantity): JsonResponse
    {
        $response = $this->statisticsService->fetchBestChannelsStatistics($quantity);

        return new JsonResponse($response);
    }
}
