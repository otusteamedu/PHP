<?php


namespace App\Services\Channels\Repositories;


use App\Models\Channel;

abstract class EloquentSearchChannelRepository implements Interfaces\SearchChannelRepositoryInterface
{
    public function search(string $q): ?Channel
    {
        return Channel::where('channel_id', 'LIKE', '%' . $q . '%')->first();
    }
}
