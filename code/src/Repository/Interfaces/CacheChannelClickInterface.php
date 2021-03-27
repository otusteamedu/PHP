<?php


namespace App\Repository\Interfaces;


interface CacheChannelClickInterface
{
    public function set(string $channelId): int;
    public function get(string $channelId): int;
    public function delete(string $channelId): void;
    public function deleteAll(): void;
}
