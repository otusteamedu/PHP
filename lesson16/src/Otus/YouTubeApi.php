<?php

namespace Otus;

use Exception;

/**
 * Class YouTubeApi
 * @package Otus
 */
class YouTubeApi
{

    /**
     * Youtube token
     * @var
     */
    protected $token;

    /**
     * Base api url
     * @var
     */
    protected $baseUrl;

    /**
     * instance of Api
     * @var
     */
    private static $instance;

    /**
     * Current path
     * @var
     */
    private $path;

    /**
     * Get instance of class
     * @return mixed
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * YouTubeApi constructor.
     */
    public function __construct()
    {
        $config = parse_ini_file(APP_DIR . '/config.ini', true);
        $this->token = $config['token'];
        $this->baseUrl = $config['baseUrl'];
    }

    /**
     * Get channel info
     * @param string $id
     * @param array $part
     * @return object|null
     * @throws Exception
     */
    public function getChannelInfoById(string $id, array $part = ['snippet', 'contentDetails', 'statistics'])
    {
        $this->path = 'channels?';
        $parameters = [
            'part' => implode(',', $part),
            'id' => $id,
            'key' => $this->token,
        ];
        $url = $this->getUrlByParameters($parameters);
        $response = $this->makeRequest($url);
        if (isset($response->error)) {
            throw new Exception($response->error->code . ': ' . $response->error->message);
        } else if (isset($response->items)) {
            return $response->items[0];
        } else {
            return null;
        }
    }

    /**
     * Get playlist items
     * @param string $id
     * @param array $part
     * @param string|null $pageToken
     * @param int $maxResults
     * @return object
     * @throws Exception
     */
    public function getPlaylistInfo(string $id, array $part = ['snippet'], string $pageToken = null, int $maxResults = 10)
    {
        $this->path = 'playlistItems?';
        $parameters = [
            'part' => implode(',', $part),
            'playlistId' => $id,
            'key' => $this->token,
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
            throw new Exception($response->error->code . ': ' . $response->error->message);
        } else {
            return $response;
        }
    }

    /**
     * Get video info by id
     * @param string $id
     * @param array $part
     * @return array
     * @throws Exception
     */
    public function getVideosInfo(string $id, array $part = ['snippet', 'statistics'])
    {
        $this->path = 'videos?';
        $parameters = [
            'part' => implode(',', $part),
            'id' => $id,
            'key' => $this->token,
        ];
        $parameters['maxResults'] = 20;

        $url = $this->getUrlByParameters($parameters);
        $response = $this->makeRequest($url);
        if (isset($response->error)) {
            throw new Exception($response->error->code . ': ' . $response->error->message);
        } else if (isset($response->items)) {
            return $response->items;
        } else {
            return [];
        }
    }

    /**
     * Get videos by keyWord
     * @param $word
     * @param array $part
     * @param int $limit
     * @return array
     * @throws Exception
     */
    public function searchVideoByWord($word, array $part = ['snippet'], int $limit = 50)
    {
        $this->path = 'search?';
        $parameters = [
            'part' => implode(',', $part),
            'q' => $word,
            'maxResults' => $limit,
            'key' => $this->token,
        ];
        $parameters['maxResults'] = 20;

        $url = $this->getUrlByParameters($parameters);
        $response = $this->makeRequest($url);
        if (isset($response->error)) {
            throw new Exception($response->error->code . ': ' . $response->error->message);
        } else if (isset($response->items)) {
            return $response->items;
        } else {
            return [];
        }
    }

    /**
     * Prepare URL
     * @param array $parameters
     * @return string
     */
    private function getUrlByParameters(array $parameters)
    {
        return $this->baseUrl . $this->path . http_build_query($parameters);
    }

    /**
     * Make request to google api
     * @param $url
     * @return mixed
     */
    private function makeRequest($url)
    {
        return json_decode(file_get_contents($url));
    }
}