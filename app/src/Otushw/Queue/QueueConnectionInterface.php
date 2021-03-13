<?php


namespace Otushw\Queue;

interface QueueConnectionInterface
{
    public function connect(): void;
    public function disconnect(): void;
}