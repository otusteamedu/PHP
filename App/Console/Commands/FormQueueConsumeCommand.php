<?php


namespace App\Console\Commands;


use App\Amqp\Connection;
use App\Services\Form\FormEmailNotify;
use Illuminate\Console\Command;
use Illuminate\Container\Container;

class FormQueueConsumeCommand extends Command
{
    protected $signature = 'form:queue:consume';

    public function handle()
    {
        $connection = Connection::create();
        $channel = $connection->channel();
        $channel->queue_declare('form_queue', false, true, false, false);
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
            echo ' [x] At ', (new \DateTime())->format('H:i:s'), "\n";
            sleep(substr_count($msg->body, '.'));
            Container::getInstance()->make(FormEmailNotify::class, ['message' => $msg])->send();
            echo " [x] Done\n";
            $msg->ack();
        };
        $channel->basic_qos(null, 1, null);
        $channel->basic_consume('form_queue', '', false, false, false, false, $callback);
        while ($channel->is_open()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}