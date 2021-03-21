<?php

namespace App\Services\Channels;

use App\Models\Channel;
use App\Services\Channels\Repositories\EloquentCreateChannelRepository;
use App\Services\Channels\Repositories\Interfaces\SearchChannelRepositoryInterface;
use Illuminate\Support\Collection;

class ChannelService
{
    private SearchChannelRepositoryInterface $search_channel_repository;

    private EloquentCreateChannelRepository $create_channel_repository;

    public function __construct(
        SearchChannelRepositoryInterface $search_channel_repository,
        EloquentCreateChannelRepository $create_channel_repository
    )
    {
        $this->search_channel_repository = $search_channel_repository;
        $this->create_channel_repository = $create_channel_repository;
    }

    public function search(string $q): ?Channel
    {
        return $this->search_channel_repository->search($q);
    }

    public function createAndGet(string $channel_id): ?Channel
    {
        return $this->create_channel_repository->createAndGet($channel_id);
    }

    public function getTop(): ?array
    {
        return $this->search_channel_repository->getTop();
    }
}
