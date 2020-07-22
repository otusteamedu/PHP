<?php


namespace App\Controllers;

use Services\ChannelStatisticServiceInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class YoutubeChannelStatisticController
{
    private $channelStatisticService;

    public function __construct(ChannelStatisticServiceInterface $channelStatisticService)
    {
        $this->channelStatisticService = $channelStatisticService;
    }

    public function TotalChannelVideosLikesNumber(Request $request, Response $response, $args)
    {
        if (!isset($args['channelId']) || empty($args['channelId'])) {
            $response->getBody()->write('Не передан id канала');
            return $response;
        }
        $channelId = (string) $args['channelId'];
        $limit = $args['limit'] ?? null;

        $videosLikesDislikes = $this->channelStatisticService->getTotalChannelVideosLikesNumber($channelId, $limit);

        $response->getBody()->write(json_encode($videosLikesDislikes, JSON_THROW_ON_ERROR, 512));
        return $response;
    }

    public function TopChannelsVideosLikesDislikesRating(Request $request, Response $response, $args)
    {
        $limit = $args['limit'] ?? null;

        $topChannels = $this->channelStatisticService->getTopChannelsWithBestLikesDislikeRation($limit);

        $response->getBody()->write(json_encode($topChannels, JSON_THROW_ON_ERROR, 512));
        return $response;
    }
}
