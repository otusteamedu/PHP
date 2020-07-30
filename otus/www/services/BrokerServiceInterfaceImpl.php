<?php

namespace Services;

use Classes\Dto\PushDto;
use Classes\Queue\BrockerInterface;
use Classes\JsonHandler;

class BrokerServiceInterfaceImpl implements BrokerServiceInterface
{

    private $broker;

    public function __construct(BrockerInterface $brocker)
    {
        $this->broker = $brocker;
    }
    public function pushRequest(PushDto $pushDto): string
    {
        $requestId = $this->getRequestId($pushDto);
        $this->broker->pushRequest($this->preparePushData($pushDto, $requestId));

        return $requestId;
    }

    public function getRequestStatusById(string $id): string
    {
        return $this->broker->popResponse($id);
    }

    public function popRequest()
    {
        return $this->broker->popRequest();
    }

    public function pushResponse(string $response)
    {
        $this->broker->pushResponse($response);
    }

    private function getRequestId(PushDto $pushDto)
    {
        $date = new \DateTime();
        return md5($pushDto->id . $date->getTimestamp());
    }
    private function preparePushData(PushDto $pushDto, string $requestId)
    {
        $data = [
            'id' => $requestId,
            'clientId' => $pushDto->id,
            'message' => $pushDto->message
        ];

        return json_encode($data, JSON_THROW_ON_ERROR | true, 512);
    }

    public function handleRequest()
    {
        $queue = $this->popRequest();
        $data = JsonHandler::getFromJson($queue);
        $message = [
            'id' => $data['id'],
            'status' => 'taken'
        ];


        $this->pushResponse(JsonHandler::getJson($message));
    }
}
