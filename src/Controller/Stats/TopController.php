<?php declare(strict_types=1);

namespace Controller\Stats;

use Repository\Youtube\ChannelRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TopController
{
    public function getAction(Request $request): Response
    {
        $channelRepository = new ChannelRepository();
        $limit = (int)explode('/', $request->getPathInfo())[3];

        return new Response(json_encode($channelRepository->getTopChannels($limit)));
    }
}
