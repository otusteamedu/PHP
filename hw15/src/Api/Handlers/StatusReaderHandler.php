<?php


namespace App\Api\Handlers;


use App\Queue\Workers\ClientWorker;

class StatusReaderHandler extends Handler
{

    protected function buildResult()
    {
        $id = $this->getRequestID();
        $status = $this->clientWorker->getStatus($id);
        $this->appendResultItem('status', $status);
    }

    private function getRequestID()
    {
        //parse request ID
        return '1_1591879122';
    }

}