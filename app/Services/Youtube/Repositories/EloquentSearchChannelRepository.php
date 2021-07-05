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

    public function getAllChannelsData(): Collection
    {
        $qb = Channel::query()
            ->join('videos as videos', 'channels.id', '=', 'videos.channel_id', 'left outer')
            ->select([
                'channels.id',
                'channels.youtube_channel_id',
                'channels.title as channel_title',
                'channels.description as channel_description',
                'videos.id as video_id',
                'videos.youtube_video_id',
                'videos.published_at',
                'videos.title',
                'videos.description',
                'videos.view_count',
                'videos.like_count',
                'videos.dislike_count',
                'videos.favorite_count',
                'videos.comment_count',
                'videos.tags',

            ]);
        return $qb->get();
    }
}
