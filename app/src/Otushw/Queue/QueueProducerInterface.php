<?php


namespace Otushw\Queue;

interface QueueProducerInterface
{
    public function publish(string $data): void;
}