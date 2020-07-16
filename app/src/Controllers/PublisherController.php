<?php

namespace App\Controllers;

use App\Components\Rabbit\Rabbit;
use App\Queue\QueueRequest;

class PublisherController
{
    public function registerQueueMessage($clientID, $message, Rabbit $rabbit)
    {
        $requestID = $clientID . '----' . time();
        $requestItem = QueueRequest::createByArray(['id' => $requestID, 'message' => $message]);
        $rabbit->pushRequest($requestItem);
        return $requestID;
    }

    public function getJobStatus($requestID, Rabbit $rabbit)
    {
        $queueResponse = $rabbit->popResponse($requestID);

        return $queueResponse->getStatus();
    }
}