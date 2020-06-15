<?php


namespace App\Queue\Workers;


use App\Queue\Items\RequestItem;
use App\Queue\Items\ResponseItem;

class ServerWorker extends Worker
{

    public function run()
    {
        $item = $this->broker->popRequest();
        if (!$item)
            return;

        $this->processRequest($item);
    }

    private function processRequest(RequestItem $requestItem)
    {
        $data = [
            'id' => $requestItem->getId(), 'status' => 1
        ];
        $responseItem = ResponseItem::createByArray($data);
        $this->broker->pushResponse($responseItem);
    }

}