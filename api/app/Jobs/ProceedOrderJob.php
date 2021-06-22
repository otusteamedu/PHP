<?php

namespace App\Jobs;

use App\Models\Order;

class ProceedOrderJob extends Job
{
    private Order $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->order->status = 2;
        $this->order->save();
    }
}
