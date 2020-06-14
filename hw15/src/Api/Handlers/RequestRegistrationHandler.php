<?php


namespace App\Api\Handlers;


use App\Queue\Workers\ClientWorker;

class RequestRegistrationHandler extends Handler
{

    public function __construct(ClientWorker $clientWorker)
    {
        parent::__construct($clientWorker);

        $clientID = $this->getClientID();
        $content = $this->getRequestContent();

        $id = $clientWorker->registrateRequest($clientID, $content);
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