<?php


namespace App\Services\Channels;


use App\Models\Channel;
use App\Models\ChannelVideo;
use Faker\Generator;
use Google_Service_YouTube_SearchResultSnippet;
use Illuminate\Container\Container;
use Illuminate\Support\Arr;

class YoutubeChannelVideoService
{
    private $youtube;

    public function __construct(\Google_Service_YouTube $youTube)
    {
        $this->youtube = $youTube;
    }

    public function loadForChannel(Channel $channel)
    {
        try {
            if ($channel->youtube_id === null) {
                return;
            }
            $maxItems = 10;
            $videoIds = collect([]);
            $pageToken = '';
            while ($videoIds->count() < $maxItems) {
                $response = $this->youtube->search->listSearch('id', [
                    'maxResults' => $maxItems,
                    'channelId'  => $channel->youtube_id,
                    'type'       => 'video',
                    'pageToken'  => $pageToken
                ]);
                $pageToken = $response->getNextPageToken();
                $items = collect($response->getItems())->pluck('id')->pluck('videoId');
                $collection = ChannelVideo::query()
                    ->whereIn('youtube_id', $items->toArray())
                    ->get(['id', 'youtube_id']);
                $videoIds->push(...$items->diff($collection->pluck('youtube_id')));
            }
            $response = $this->youtube->videos->listVideos('statistics', ['id' => $videoIds->implode(',')]);
            foreach ($response->getItems() as $item) {
                ChannelVideo::query()->create([
                    'channel_id' => $channel->getKey(),
                    'youtube_id' => $item->getId(),
                    'views'      => $item->getStatistics()->getViewCount(),
                    'likes'      => $item->getStatistics()->getLikeCount(),
                    'dislikes'   => $item->getStatistics()->getDislikeCount(),
                ]);
            }
        } catch (\Throwable $e) {
        }
    }
}
