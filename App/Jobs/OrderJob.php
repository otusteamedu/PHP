<?php


namespace App\Jobs;


use App\Models\Order;
use App\Services\Order\OrderService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle(OrderService $service)
    {
        $service->close($this->order);
    }
}
