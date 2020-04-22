<?php


namespace Controller;


use Model\Channel;
use Service\ChannelStorage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChannelController
{

    private ChannelStorage $channelStorage;

    public function __construct()
    {
        $this->channelStorage = new ChannelStorage();
    }

    public function add(Request $request): Response
    {
        $channel = new Channel();
        $channel->handleArray(json_decode($request->getContent(), true));
        $id = $this->channelStorage->insertOne($channel);
        return new Response(json_encode($this->channelStorage->findOne($id)));
    }

    public function find(Request $request): Response
    {
        $id = explode('/', $request->getPathInfo())[4];
        return new Response(json_encode($this->channelStorage->findOne($id)));
    }

    public function channel(Request $request): Response
    {
        $channelId = explode('/', $request->getPathInfo())[4];
        return new Response(json_encode($this->channelStorage->find(['channelId' => $channelId])));
    }

    public function delete(Request $request): Response
    {
        $id = explode('/', $request->getPathInfo())[4];
        return new Response(json_encode($this->channelStorage->deleteOne($id)));
    }

    public function summary(Request $request): Response
    {
        $channelId = explode('/', $request->getPathInfo())[4];
        return new Response(json_encode($this->channelStorage->getSummary($channelId)));
    }

    public function top(Request $request): Response
    {
        $limit = explode('/', $request->getPathInfo())[4];
        return new Response(json_encode($this->channelStorage->getTopChannels($limit ?? 3)));
    }
}