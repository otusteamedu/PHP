<?php


namespace App\Services\Youtube\Repositories;


use App\Models\Video;
use Illuminate\Support\Collection;

class EloquentSearchVideoRepository implements SearchVideoRepository
{

    public function search(string $q, int $limit, int $offset): Collection
    {
        $qb = Video::query();
        if ($q) {
            $qb->where('title', 'LIKE', "%{$q}%");
            $qb->orWhere('description', 'LIKE', "%{$q}%");
        }
        $qb->take($limit);
        $qb->skip($offset);

        return $qb->get();
    }

    public function getChannelsVideoByYoutubeChannelId(string $youtubeChannelId): Collection
    {
        // TODO: Implement getChannelsVideoByYoutubeChannelId() method.
    }
}
