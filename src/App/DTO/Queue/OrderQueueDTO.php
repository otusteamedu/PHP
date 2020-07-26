<?php

namespace Ozycast\App\DTO\Queue;

class OrderQueueDTO extends QueueDTO
{
    private $controller = "order";
    private $action = "process";
    private int $order_id;

    public function __construct($order_id)
    {
        $params["order_id"] = $order_id;

        parent::__construct(
            $this->controller,
            $this->action,
            $params
        );
    }
}