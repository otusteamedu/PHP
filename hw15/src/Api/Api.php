<?php


namespace App\Api;


use App\Queue\Workers\ClientWorker;
use App\Queue\QueueBroker;

class Api
{

    public function run(QueueBroker $broker)
    {
        $dispatcher = new ClientWorker($broker);

        $result = [];
        //routing
        if ($this->isRouteRequest()) {

            $clientID = $this->getClientID();
            $content = $this->getRequestContent();
            $id = $dispatcher->registrateRequest($clientID, $content);
            $result['id'] = $id;
        }
        elseif ($this->isRouteGetStatus()) {

            $id = $this->getRequestID();
            $result['status'] = $dispatcher->getStatus($id);
        }

        $this->output($result);
    }

    private function isRouteRequest()
    {
        //some logic
        return false;
    }

    private function isRouteGetStatus()
    {
        //some logic
        return true;
    }

    private function getRequestContent()
    {
        return 'some_string';
    }

    private function getClientID()
    {
        return '1';
    }

    private function getRequestID()
    {
        //parse request ID
        return '1_1591879122';
    }

    /**
     * @param [] $result
     */
    private function output($result)
    {
        echo json_encode($result);
    }

}