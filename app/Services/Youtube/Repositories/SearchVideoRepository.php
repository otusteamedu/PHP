<?php


namespace App\Services\Youtube\Repositories;


use App\Models\Video;
use Illuminate\Support\Collection;

interface SearchVideoRepository
{
    public function search(string $q, int $limit, int $offset): Collection;
    public function getChannelsVideoByYoutubeChannelId(string $youtubeChannelId): Collection;
}
