<?php


namespace App\Services\Youtube\Repositories;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class SearchYoutubeChannelRepository implements Interfaces\SearchYoutubeRepositoryInterface
{
    public array $channel_attributes;

    public string $channel_name;

    public string $channel_id;

    private Client $client;

    public function __construct(string $channel_id)
    {
        $this->channel_id = $channel_id;
        $this->channel_attributes = [];
        $this->client = new Client(['base_uri' => 'https://youtube.googleapis.com']);
    }

    public function search(): array
    {
        $this->getChannelData();
        $this->getChannelName();
        return $this->aggregateData();
    }

    private function getChannelData(string $next_page_token = null) {
        $response = $this->getVideos($next_page_token);
        $this->channel_attributes = array_merge($this->channel_attributes, $response['channel_attributes']);
        $next_page_token = $response['next_page_token'];
        if ($next_page_token) {
            return self::getChannelData($next_page_token);
        }
    }

    protected function getAttributes(array $videos): array
    {
        $video_ids = implode(',', array_map(function ($video) {
            return $video['id']['videoId'];
        }, $videos));
        $response = $this->client->get('/youtube/v3/videos', ['query' => [
            'part' => 'statistics, snippet',
            'id' => $video_ids,
            'key' => env('YOUTUBE_API_KEY'),
        ]]);
        $response = json_decode($response->getBody(), true);
        $videos = $response['items'];
        $result = [];
        foreach ($videos as $video) {
            $result[$video['snippet']['title']] = [
                'views' => $video['statistics']['viewCount'],
                'likes' => $video['statistics']['likeCount'],
                'dislikes' => $video['statistics']['dislikeCount']
            ];
        }
        return $result;
    }

    protected function getVideos(string $next_page_token = null): array
    {
        try {
            $response = $this->client->request('GET', '/youtube/v3/search',
                ['query' => [
                    'channelId' => $this->channel_id,
                    'maxResults' => 500,
                    'type' => 'video',
                    'pageToken' => $next_page_token,
                    'key' => env('YOUTUBE_API_KEY'),
                ]]);
            $response = json_decode($response->getBody(), true);
            return ['channel_attributes' => $this->getAttributes($response['items']),
                'next_page_token' => $response["nextPageToken"] ?? null];
        } catch (\GuzzleHttp\Exception\RequestException $ex) {
            Log::debug('error');
            Log::debug((string) $ex->getResponse()->getBody());
            throw $ex;
        } catch (GuzzleException $e) {
            Log::debug((string) $e->getResponse()->getBody());
        }
    }

    protected function getChannelName() {
        $response = $this->client->get('/youtube/v3/channels', ['query' => [
            'part' => 'snippet',
            'id' => $this->channel_id,
            'key' => env('YOUTUBE_API_KEY'),
        ]]);
        $response = json_decode($response->getBody(), true);
        $this->channel_name = $response['items'][0]['snippet']['title'];
    }

    protected function aggregateData(): array
    {
        $total_views = 0;
        $total_likes = 0;
        $total_dislikes = 0;
        foreach ($this->channel_attributes as $attribute) {
            $total_views += $attribute['views'];
            $total_likes += $attribute['likes'];
            $total_dislikes += $attribute['dislikes'];
        }
        return [
            'channel_id' => $this->channel_id,
            'name' => $this->channel_name,
            'likes' => $total_likes,
            'dislikes' => $total_dislikes,
            'views' => $total_views
        ];
    }
}
