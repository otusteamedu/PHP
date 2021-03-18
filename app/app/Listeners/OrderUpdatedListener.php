<?php


namespace App\Listeners;


use App\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class OrderUpdatedListener implements ShouldQueue
{

    public function __construct()
    {

    }

    public function handle($event)
    {
        $order = $event->order;
        $order->product_name = $event->newOrder->product_name;
        $order->quantity = $event->newOrder->quantity;
        $order->total = $event->newOrder->total;
        $order->processed = $event->newOrder->processed;
        $order->save();
        Log::info('Updated Order:' . json_encode($event));
    }
}
