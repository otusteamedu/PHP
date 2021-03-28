<?php


namespace App\Services\Channels;


use App\Models\Channel;
use App\Models\ChannelVideo;
use Google_Service_YouTube_Video;

class YoutubeChannelVideoService
{
    private $youtube;

    public function __construct(\Google_Service_YouTube $youTube)
    {
        $this->youtube = $youTube;
    }

    /**
     * @param Channel $channel
     * @throws VideoHasAnotherChannelId
     * @throws YoutubeChannelIdRequired
     */
    public function loadForChannel(Channel $channel)
    {
        $this->save($channel, $this->loadByIds($this->searchIdsByChannel($channel)));
    }

    /**
     * @param Channel $channel
     * @return int[]
     * @throws YoutubeChannelIdRequired
     */
    public function searchIdsByChannel(Channel $channel): array
    {
        $this->checkChannel($channel);
        $maxItems = 1;
        $videoIds = collect();
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
        return $videoIds->toArray();
    }

    /**
     * @param array $ids
     * @return Google_Service_YouTube_Video[]
     */
    public function loadByIds(array $ids): array
    {
        return $this->youtube->videos->listVideos('statistics, snippet', ['id' => implode(',', $ids)])->getItems();
    }

    /**
     * @param Channel $channel
     * @param Google_Service_YouTube_Video[] $videos
     * @throws VideoHasAnotherChannelId
     * @throws YoutubeChannelIdRequired
     */
    public function save(Channel $channel, array $videos): void
    {
        $this->checkChannel($channel);
        foreach ($videos as $item) {
            if ($item->getSnippet()->getChannelId() !== $channel->youtube_id) {
                throw new VideoHasAnotherChannelId();
            }
            ChannelVideo::query()->create([
                'channel_id' => $channel->getKey(),
                'youtube_id' => $item->getId(),
                'views'      => $item->getStatistics()->getViewCount() ?? 0,
                'likes'      => $item->getStatistics()->getLikeCount() ?? 0,
                'dislikes'   => $item->getStatistics()->getDislikeCount() ?? 0,
            ]);
        }
    }

    /**
     * @param Channel $channel
     * @throws YoutubeChannelIdRequired
     */
    private function checkChannel(Channel $channel)
    {
        if (empty($channel->youtube_id)) {
            throw new YoutubeChannelIdRequired('youtube_id is required');
        }
    }

}
