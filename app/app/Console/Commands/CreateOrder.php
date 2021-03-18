<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Order;

class CreateOrder extends Command
{
    protected $signature = 'order:create';

    protected $description = 'Create an order';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $order = Order::inRandomOrder()->first();
        event(new \App\Events\OrderCreated($order));
        return 0;
    }
}
