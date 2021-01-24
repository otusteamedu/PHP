<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrdersJob extends Job
{
    use InteractsWithQueue, Queueable, SerializesModels;
    protected int $id;

    /**
     * OrdersJob constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        sleep(15); // иммитация обработки
        $order = Order::find($this->id);
        $order->status = "accepted";
        $order->save();
    }
}
