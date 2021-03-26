<?php


namespace Otushw\ServerQueue\Jobs;


use Otushw\DTOs\OrderDTO;
use Otushw\Models\Order;

class JobCreate extends Job
{
    private OrderDTO $orderRaw;

    public function __construct(OrderDTO $orderRaw)
    {
        parent::__construct();
        $this->orderRaw = $orderRaw;
    }

    public function work(): bool
    {
        $order = $this->mapper->insert($this->orderRaw);
        return  $order instanceof Order;
    }


}