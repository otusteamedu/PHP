<?php


namespace Otushw\ServerQueue\Jobs;

use Otushw\Models\Order;

class JobUpdate extends Job
{
    private Order $order;

    public function __construct(Order $order)
    {
        parent::__construct();
        $this->order = $order;
    }

    public function work(): bool
    {
        return $this->mapper->update($this->order);
    }
}