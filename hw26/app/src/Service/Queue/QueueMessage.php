<?php

declare(strict_types=1);

namespace App\Service\Queue;

class QueueMessage
{
    /**
     * @var mixed
     */
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->data;
    }
}