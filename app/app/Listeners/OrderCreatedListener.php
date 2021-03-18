<?php


namespace App\Listeners;

use App\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class OrderCreatedListener implements ShouldQueue
{

    public function __construct()
    {

    }

    public function handle($event)
    {
        $order = $event->order;
        $order->setProcessed();
        $order->save();
        Log::info('Created Order:' . $event->order->id);
    }
}
