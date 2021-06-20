<?php


namespace App\Services\Order;


use App\Jobs\OrderJob;
use App\Models\Order;
use Illuminate\Support\Str;

class OrderService
{

    public function create(Order $order): Order
    {
        $order->id = Str::orderedUuid();
        $order->saveOrFail();
        dispatch(new OrderJob($order->refresh()))->onQueue('order');
        return $order;
    }

    public function close(Order $order): void
    {
        $order->status = Order::STATUS['CLOSED'];
        $order->save();
    }
}