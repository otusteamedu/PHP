<?php


namespace Controller;

use Service\Database\PDOFactory;
use Service\DataMapper\ChannelMapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class ChannelController
{

    private ChannelMapper $channelMapper;

    public function __construct()
    {
        $pdoFactory = new PDOFactory();
        $this->channelMapper = new ChannelMapper($pdoFactory->getPostgresPDO());
    }

    public function add(Request $request): Response
    {
        $channel = $this->channelMapper->insert(json_decode($request->getContent(), true));
        return new Response(json_encode($channel->getId()));
    }

    public function find(Request $request): Response
    {
        $id = explode('/', $request->getPathInfo())[4];
        if (empty($id)) {
            return new Response(json_encode($this->channelMapper->findAll()));
        }
        $channel = $this->channelMapper->findById($id);
        if (!$channel) {
            throw new Exception('Channel not found.', Response::HTTP_NOT_FOUND);
        }
        return new Response(json_encode($channel));
    }


    public function delete(Request $request): Response
    {
        $id = explode('/', $request->getPathInfo())[4];
        $channel = $this->channelMapper->findById($id);
        if (!$channel) {
            throw new Exception('Channel not found.', Response::HTTP_NOT_FOUND);
        }
        return new Response(json_encode($this->channelMapper->delete($id)));
    }
}