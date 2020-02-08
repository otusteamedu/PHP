<?php declare(strict_types=1);

namespace Controller\Stats;

use Repository\Youtube\ChannelRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SumController
{
    public function getAction(Request $request): Response
    {
        $channelRepository = new ChannelRepository();

        return new Response(json_encode($channelRepository->getSummaryStat()));
    }
}
