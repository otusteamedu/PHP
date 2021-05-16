<?php


namespace App\Services\Channels\Repositories\Interfaces;


interface WriteChannelInterface
{
    public function createAndGet(string $channel_id);
}
