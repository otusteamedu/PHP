<?php

namespace App\Controllers;

use App\Components\Rabbit\Rabbit;
use App\Queue\QueueResponse;

class ConsumerController
{
    public function handle(Rabbit $rabbit)
    {
        $requestQueue = $rabbit->popRequest();
        $queueMessage = [
            'id' => $requestQueue->getId(), 'status' =>mt_rand(1, 100),
        ];
        $responseItem = QueueResponse::createByArray($queueMessage);
        $rabbit->pushResponse($responseItem);
    }
}