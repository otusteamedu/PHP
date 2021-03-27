<?php


namespace App\Services\Channels;


use App\Models\Channel;
use Faker\Generator;
use Google_Service_YouTube_SearchResultSnippet;
use Illuminate\Container\Container;
use Illuminate\Support\Arr;

class YoutubeChannelService
{
    /**
     * @var \Google_Service_YouTube
     */
    private $youtube;

    public function __construct(\Google_Service_YouTube $youTube)
    {
        $this->youtube = $youTube;
    }

    public function parseNew($query = null)
    {
        try {
            $maxItems = 5;
            $createdCount = 0;
            $pageToken = '';
            while ($createdCount < $maxItems) {
                $response = $this->youtube->search->listSearch('snippet', [
                    'maxResults' => $maxItems,
                    'q'          => $query ?? Container::getInstance()->make(Generator::class)->word(),
                    'type'       => 'channel',
                    'pageToken'  => $pageToken
                ]);
                $pageToken = $response->getNextPageToken();
                $items = collect(Arr::pluck($response->getItems(), 'snippet'));
                $collection = Channel::query()
                    ->whereIn('youtube_id', $items->pluck('channelId'))
                    ->get(['id', 'youtube_id']);
                $items = $items->whereNotIn('channelId', $collection->pluck('youtube_id'));
                foreach ($items as $item) {
                    /** @var Google_Service_YouTube_SearchResultSnippet $item */
                    Channel::query()->create([
                        'name'        => $item->getTitle(),
                        'youtube_id'  => $item->getChannelId(),
                        'description' => $item->getDescription(),
                        'tags'        => []
                    ]);
                    ++$createdCount;
                }

            }
        } catch (\Throwable $e) {
        }

    }
}
