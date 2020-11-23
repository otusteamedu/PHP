<?php


namespace Otus\Queue;


interface QueueContract
{
    public function push(string $queue, $data): void;

    public function pop(string $queue): MessageContract;
}