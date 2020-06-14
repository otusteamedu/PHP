<?php


namespace App\Api\Handlers;


use App\Queue\Workers\ClientWorker;

class Handler
{
    private $result = [];

    /**
     * @var ClientWorker
     */
    private $clientWorker;

    public function __construct(ClientWorker $clientWorker = null)
    {
        $this->clientWorker = $clientWorker;
    }

    public function output()
    {
        echo json_encode($this->result);
    }

    protected function appendResultItem($key, $value)
    {
        $this->result[$key] = $value;
        return $this;
    }

}
