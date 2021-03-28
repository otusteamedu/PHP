<?php


namespace App\Services\Channels\Repositories;



use Illuminate\Support\Collection;

interface ChannelRepositoryInterface
{
    public function search(string $query = ''): Collection;
}
