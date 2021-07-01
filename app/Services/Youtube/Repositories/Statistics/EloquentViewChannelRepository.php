<?php


namespace App\Services\Youtube\Repositories\Statistics;


use App\Models\Video;
use App\Services\Youtube\ChannelService;
use App\Services\Youtube\VideoService;
use Illuminate\Support\Collection;

class EloquentViewChannelRepository implements ViewChannelRepository
{

    public function getViewsCount(int $channelId): int
    {
        return Video::where('channel_id', $channelId)->sum('view_count');
    }

    public function getCommentsCount(int $channelId): int
    {
        return Video::where('channel_id', $channelId)->sum('comment_count');
    }

    public function getLikesCount(int $channelId): int
    {
        return Video::where('channel_id', $channelId)->sum('like_count');
    }

    public function getDislikesCount(int $channelId): int
    {
        return Video::where('channel_id', $channelId)->sum('dislike_count');
    }

    public function getTopChannels(int $number): Collection
    {
        $query = "
                select c.id,
                       c.title,
                       c.description,
                       sum(like_count) as videos_sum_like_count,
                       sum(dislike_count) as videos_sum_dislike_count,
                       sum(view_count) as view_count,
                       sum(comment_count) as comment_count,
                       (sum(like_count)/sum(dislike_count)) as ratio from channels c
                left join videos v on c.id = v.channel_id
                group by c.id
                order by ratio desc
                limit ?
        ";
        return collect(\DB::select($query, [$number]));
    }
}
