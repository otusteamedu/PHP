<?php


namespace nvggit\hw26;


class QueueApi extends RestApi
{
    public $apiName = 'queue';

    public function viewAction()
    {

    }


    public function createAction()
    {
        $client = new RabbitClient('custom_queue');
        $this->response("Task added, corrID is {$client->addTask()}");
    }
}