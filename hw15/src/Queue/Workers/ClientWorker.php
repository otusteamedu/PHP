<?php


namespace App\Queue\Workers;


use App\Queue\Items\RequestItem;

class ClientWorker extends Worker
{

    public function registrateRequest($clientID, $content)
    {
        $requestID = $clientID . '_' . time();
        $requestItem = RequestItem::createByArray(['id' => $requestID, 'content' => $content]);
        $this->broker->pushRequest($requestItem);
        return $requestID;
    }

    public function getStatus($requestID)
    {
        $resp = $this->broker->popResponse($requestID);
        if (!$resp)
            return null;

        return $resp->getStatus();
    }

}