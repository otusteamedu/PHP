<?php


namespace App\Api\Handlers;


use App\Queue\Workers\ClientWorker;

class Handler
{
    private $result = [];

    /**
     * @var ClientWorker
     */
    protected $clientWorker;

    public function __construct(ClientWorker $clientWorker = null)
    {
        $this->clientWorker = $clientWorker;
    }

    protected function buildResult()
    {
    }

    public function output()
    {
        try {

            $this->buildResult();
            $result = json_encode($this->result);

        } catch (\Exception $exception) {
            $result = [];
        }

        echo $result;
    }

    protected function appendResultItem($key, $value)
    {
        $this->result[$key] = $value;
        return $this;
    }

}
