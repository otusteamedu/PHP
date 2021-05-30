<?php


namespace App\Console\Commands;


use App\Amqp\Connection;
use App\Console\CommandContract;

class FormQueueConsumeCommand implements CommandContract
{

    public function __construct(array $arguments = [])
    {
    }

    public function handle()
    {
        $connection = Connection::create();
        $channel = $connection->channel();
        $channel->queue_declare('form_queue', false, true, false, false);
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
            echo ' [x] At ', (new \DateTime())->format('H:i:s'), "\n";
            sleep(substr_count($msg->body, '.'));
            $body = json_decode($msg->body, true);
            $time= (new \DateTime())->setTimestamp($body['time']);
            $message = "Hi {$body['name']}. We've got your request to make date from {$body['date_from']} to {$body['date_to']} at "
                . $time->format('Y.d.m H:i:s');
            mail($body['email'], 'Data request', $message, "From: Server");
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