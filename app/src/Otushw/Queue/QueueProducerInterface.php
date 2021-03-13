<?php


namespace Otushw\Queue;

interface QueueProducerInterface extends QueueInstance
{
    public function publish(string $data): void;
}