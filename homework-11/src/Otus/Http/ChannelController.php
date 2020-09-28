<?php

namespace Otus\Http;

use Otus\Channel;
use Otus\GoogleService;

class ChannelController
{
    private GoogleService $service;

    private Channel $channel;

    public function __construct()
    {
        $this->service = new GoogleService();
        $this->channel = new Channel();
    }

    public function store(Request $request): ResponseContract
    {
        if (! $request->has('id')) {
            return new JsonResponse(Response::HTTP_BAD_REQUEST, 'Error');
        }

        $channelData = $this->service->getChannel($request->get('id'));
        $this->channel->save($channelData);

        return new JsonResponse(Response::HTTP_CREATED, $this->channel);
    }

    public function show(Request $request): ResponseContract
    {
        if (! $request->has('id')) {
            return new JsonResponse(Response::HTTP_BAD_REQUEST, 'Error');
        }

        $this->channel->get($request->get('id'));

        return new JsonResponse(Response::HTTP_OK, $this->channel);
    }

    public function delete(Request $request): ResponseContract
    {
        if (! $request->has('id')) {
            return new JsonResponse(Response::HTTP_BAD_REQUEST, 'Error');
        }

        if (! $this->channel->delete($request->get('id'))) {
            return new JsonResponse(Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(Response::HTTP_OK, 'OK');
    }
}
