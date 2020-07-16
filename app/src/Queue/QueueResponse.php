<?php


namespace App\Queue;


class QueueResponse extends QueueObject
{

    private $requestID;
    private $status;

    protected function initByArray($data)
    {
        $this->requestID = $data['id'];
        $this->status = $data['status'];
        return true;
    }

    /**
     * @return mixed
     */
    public function getRequestID()
    {
        return $this->requestID;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function check($requestID)
    {
        return $this->getRequestID() == $requestID;
    }

    public function toArray()
    {
        return ['id' => $this->requestID, 'status' => $this->getStatus()];
    }
}