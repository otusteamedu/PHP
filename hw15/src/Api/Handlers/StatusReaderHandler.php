<?php


namespace App\Api\Handlers;


use App\Queue\Workers\ClientWorker;

class StatusReaderHandler extends Handler
{
    public function __construct(ClientWorker $clientWorker = null)
    {
        parent::__construct($clientWorker);

        $id = $this->getRequestID();
        $status = $clientWorker->getStatus($id);
        $this->appendResultItem('status', $status);
    }

    private function getRequestID()
    {
        //parse request ID
        return '1_1591879122';
    }

}