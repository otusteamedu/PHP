<?php declare(strict_types=1);

namespace Controller;

use Entity\Youtube\Channel;
use Repository\Youtube\ChannelRepository;
use Service\Database\MongoDatabase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChannelsController
{
    public function getAction(Request $request): Response
    {
        $channelRepository = new ChannelRepository(new MongoDatabase());
        $id = explode('/', $request->getPathInfo())[2];

        return new Response(json_encode($channelRepository->findOne($id)));
    }

    public function postAction(Request $request): Response
    {
        $channelRepository = new ChannelRepository(new MongoDatabase());

        $channel = new Channel();
        $channel->handleArray(json_decode($request->getContent(), true));
        $id = $channelRepository->saveOne($channel);

        return new Response(json_encode($channelRepository->findOne($id)));
    }

    public function deleteAction(Request $request): Response
    {
        $channelRepository = new ChannelRepository(new MongoDatabase());
        $id = explode('/', $request->getPathInfo())[2];

        return new Response(json_encode($channelRepository->deleteOne($id)));
    }
}
