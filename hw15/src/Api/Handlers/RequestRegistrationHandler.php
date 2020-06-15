<?php


namespace App\Api\Handlers;


use App\Queue\Workers\ClientWorker;

class RequestRegistrationHandler extends Handler
{

    protected function buildResult()
    {
        $clientID = $this->getClientID();
        $content = $this->getRequestContent();

        $id = $this->clientWorker->registrateRequest($clientID, $content);
        $this->appendResultItem('id', $id);
    }

    private function getClientID()
    {
        return '1';
    }

    private function getRequestContent()
    {
        return 'some_string';
    }

}