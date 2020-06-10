<?php

namespace App;

use App\Domain\Task;
use Psr\Log\LoggerInterface;
use Redis;
use Spiral\Goridge\StreamRelay;
use Spiral\RoadRunner\Worker;
use Throwable;

class Workerman
{
    public static function handle(): void
    {
        $logger = App::get(LoggerInterface::class);
        $logger->debug('Worker: started');

        $redis = App::get(Redis::class);
        $worker = new Worker(new StreamRelay(STDIN, STDOUT));

        try {
            while ($payload = $worker->receive($context)) {
                $logger->debug('Worker: new task');
                try {
                    $payload = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
                    $redis->hSet($payload['id'], 'status', Task::STATUS_DONE);
                    $logger->debug('Worker: success');
                    $worker->send('ok');
                } catch (Throwable $e) {
                    $logger->debug('Worker: error');
                    $worker->error((string) $e);
                }
            }
        } catch (Throwable $e) {
            $worker->error((string) $e);
        }
        $logger->debug('Worker: stopped');
    }
}
