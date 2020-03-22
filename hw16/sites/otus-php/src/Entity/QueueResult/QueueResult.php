<?php

declare(strict_types=1);

namespace App\Entity\QueueResult;

use App\Entity\BaseEntity;

class QueueResult extends BaseEntity
{
    protected $clientId;

    protected $messageId;

    protected $queueName;

    protected $success;

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setClientId($id)
    {
        $this->clientId = $id;
    }

    public function getMessageId()
    {
        return $this->messageId;
    }

    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }

    public function getQueueName()
    {
        return $this->queueName;
    }

    public function setQueueName($queueName)
    {
        $this->queueName = $queueName;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function setSuccess($success)
    {
        $this->success = $success;
    }
}