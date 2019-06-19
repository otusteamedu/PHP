<?php

namespace Otus;

class YouTubeApi {

    protected $token;
    protected $baseUrl;
    private static $instance;
    private $path;

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function __construct() {
        $config = parse_ini_file(APP_DIR . '/config.ini', true);
        $this->token = $config['token'];
        $this->baseUrl = $config['baseUrl'];
    }

    public function getChannelInfoById(string $id, array $part = ['snippet','contentDetails', 'statistics'])
    {
        $this->path = 'channels?';
        $parameters = [
            'part'  => implode(',',$part),
            'id'    => $id,
            'key'   => $this->token,
        ];
        $url = $this->getUrlByParameters($parameters);
        $response = $this->makeRequest($url);
        if (isset($response->items)) {
            return $response->items[0];
        } else {
            return null;
        }
    }

    //https://www.googleapis.com/youtube/v3/
    //playlistItems?
    //part=snippet&
    //playlistId=$playList&
    //key=$key
    public function getPlaylistInfo(string $id, array $part = ['snippet'], string $pageToken = null, int $maxResults = 10)
    {
        $this->path = 'playlistItems?';
        $parameters = [
            'part'  => implode(',',$part),
            'playlistId'    => $id,
            'key'   => $this->token,
        ];
        if ($pageToken) {
            $parameters['pageToken'] = $pageToken;
        }
        if ($maxResults) {
            $parameters['maxResults'] = $maxResults;
        }
        $url = $this->getUrlByParameters($parameters);
        $response = $this->makeRequest($url);
        if (isset($response->error)) {
            throw new \Exception($response->error->code . ': ' . $response->error->message);
        } else {
            return $response;
        }
    }

    public function getVideosInfo(string $id, array $part = ['snippet', 'statistics'])
    {
        $this->path = 'videos?';
        $parameters = [
            'part'  => implode(',',$part),
            'id'    => $id,
            'key'   => $this->token,
        ];
        $parameters['maxResults'] = 20;

        $url = $this->getUrlByParameters($parameters);
        $response = $this->makeRequest($url);
        if (isset($response->error)) {
            throw new \Exception($response->error->code . ': ' . $response->error->message);
        } else if (isset($response->items)) {
            return $response->items;
        } else {
            return [];
        }
    }

    public function searchVideoByWorld($world, array $part = ['snippet'], int $limit = 50)
    {
        $this->path = 'search?';
        $parameters = [
            'part'  => implode(',',$part),
            'q'    => $world,
            'maxResults' => $limit,
            'key'   => $this->token,
        ];
        $parameters['maxResults'] = 20;

        $url = $this->getUrlByParameters($parameters);
        $response = $this->makeRequest($url);
        if (isset($response->error)) {
            throw new \Exception($response->error->code . ': ' . $response->error->message);
        } else if (isset($response->items)) {
            return $response->items;
        } else {
            return [];
        }
    }

    private function getUrlByParameters(array $parameters)
    {
        return $this->baseUrl . $this->path . http_build_query($parameters);
    }

    private function makeRequest($url)
    {
        return json_decode(file_get_contents($url));
    }
}