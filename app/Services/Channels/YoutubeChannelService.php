<?php


namespace App\Services\Channels;


use App\Models\Channel;
use Faker\Generator;
use Google_Service_YouTube;
use Google_Service_YouTube_SearchResultSnippet;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

class YoutubeChannelService
{
    /**
     * @var Google_Service_YouTube
     */
    private $youtube;

    public function __construct(Google_Service_YouTube $youTube)
    {
        $this->youtube = $youTube;
    }


    /**
     * @param null $query
     * @return Google_Service_YouTube_SearchResultSnippet[]
     * @throws BindingResolutionException
     */
    public function searchNew($query = null): array
    {
        $maxItems = 5;
        $found = [];
        $pageToken = '';
        while (count($found) < $maxItems) {
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
            array_push($found, ...$items);
        }
        return $found;
    }

    /**
     * @param Google_Service_YouTube_SearchResultSnippet[] $searchResult
     * @throws YoutubeChannelIdRequired
     */
    public function saveNew(array $searchResult): void
    {
        foreach ($searchResult as $item) {
            if (empty($item->getChannelId())) {
                throw new YoutubeChannelIdRequired();
            }
            Channel::query()->create([
                'name'        => $item->getTitle(),
                'youtube_id'  => $item->getChannelId(),
                'description' => $item->getDescription(),
                'tags'        => []
            ]);
        }
    }
}
