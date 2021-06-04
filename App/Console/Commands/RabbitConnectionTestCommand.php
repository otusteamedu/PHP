<?php


namespace App\Console\Commands;


use App\Amqp\Connection;
use Illuminate\Console\Command;

class RabbitConnectionTestCommand extends Command
{
    protected $signature = 'rabbit:test';

    public function handle(){
        Connection::create();
        $this->info('Connection is ok');
    }
}