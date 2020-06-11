<?php


namespace App\Queue;


use App\Queue\Items\RequestItem;
use App\Queue\Items\ResponseItem;

interface QueueBroker
{

    public function pushRequest(RequestItem $requestItem);
    public function pushResponse(ResponseItem $responseItem);

    /**
     * return request and remove request item from queue
     * @return RequestItem|null
     */
    public function popRequest();

    /**
     * return response item and remove it from queue
     * @param mixed $requestID
     * @return ResponseItem|null
     */
    public function popResponse($requestID);

}