<?php


namespace App\Services\Channels\Repositories;


use App\Models\Channel;
use Illuminate\Support\Collection;

class EloquentChannelRepository implements ChannelRepositoryInterface
{
    public function search(string $query = ''): Collection
    {
        return Channel::query()
            ->where('description', 'like', "%{$query}%")
            ->where('name', 'like', "%{$query}%")
            ->where('url', 'like', "%{$query}%")
            ->get();
    }
}
