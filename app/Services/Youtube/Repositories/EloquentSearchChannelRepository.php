<?php


namespace App\Services\Youtube\Repositories;


use App\Models\Channel;
use App\Models\Video;
use Illuminate\Support\Collection;

class EloquentSearchChannelRepository implements SearchChannelRepository
{

    public function search(string $q, int $limit, int $offset): Collection
    {
        $qb = Channel::withSum('videos', 'like_count')->withSum('videos', 'dislike_count');

        if ($q) {
            $qb->where('title', 'LIKE', "%{$q}%");
            $qb->orWhere('description', 'LIKE', "%{$q}%");
        }
        $qb->take($limit);
        $qb->skip($offset);
        return $qb->get();
    }

    public function getChannelById(int $id): Channel
    {
        return Channel::with('videos')->find($id);
    }
}
