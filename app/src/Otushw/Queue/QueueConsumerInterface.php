<?php


namespace Otushw\Queue;

interface QueueConsumerInterface
{
    public function consume(): void;
}