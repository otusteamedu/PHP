<?php


namespace App\Services\Channels\Repositories\Interfaces;



use App\Models\Channel;
use Illuminate\Support\Collection;

interface SearchChannelRepositoryInterface
{
    public function search(string $q) : ?Channel;

    public function getTop() : ?array;
}
