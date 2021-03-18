<?php


namespace App\Listeners;


use App\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class OrderDeletedListener implements ShouldQueue
{

    public function __construct()
    {

    }

    public function handle($event)
    {
        $order = $event->order;
        $order->delete();
        Log::info('Deleted Order:' . json_encode($event));
    }
}
