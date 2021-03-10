<?php


namespace Otushw\Queue;


interface QueueInterface
{
    public function connect(): void;
    public function disconnect(): void;
    public function publish(string $data): void;
    public function consume(): void;
}