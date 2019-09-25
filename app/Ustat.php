<?php
namespace Youtubestat;

use Youtubestat\Model;

class Ustat
{
    // google API keys
    private $client_id = '';

    private $client_secret = '';

    private $refresh_token = '';

    //google API connect client
    protected $api_client;

    protected $maxResults = 5;

    protected $pages = 1;

    public function __construct(Array $params)
    {

        $required_keys = [
            'client_id',
            'client_secret',
            'refresh_token'
        ];

        if (empty($params)) {
            throw new \Exception('Reqired params is missing. You must provide next fields: ' . implode(', ', $required_keys));
        }

        $param_keys = array_keys($params);

        if (!empty($messing_keys = array_diff($required_keys, $param_keys))) {
            throw new \Exception('Reqired param or parameters is missing: ' . implode(', ', $messing_keys));
        }

        foreach ($required_keys as $key) {
            if (empty($params[$key])) {
                throw new \Exception('Reqired param "' . $key . '" is empty');
            }
            $this->$key = $params[$key];
        }

        $this->api_client = $this->connect();

    }

    public function setMaxResults($max)
    {
        if (!filter_var($max, FILTER_SANITIZE_NUMBER_INT)) {
            throw new \Exception('Max results must be integer number');
        }

        if ($max < 1) {
            $max = 1;
        }

        $this->maxResults = $max;
    }

    public function setPages($pages)
    {
        if (!filter_var($pages, FILTER_SANITIZE_NUMBER_INT)) {
            throw new \Exception('Pages must be integer number');
        }

        if ($pages < 1) {
            $pages = 1;
        }

        $this->pages = $pages;
    }



    private function connect()
    {
        require_once __DIR__ . '/../vendor/autoload.php';

        $client = new \Google_Client();
        $client->setApplicationName('API code samples');
        $client->setScopes([
            'https://www.googleapis.com/auth/youtube.readonly',
        ]);

        //how to get keys https://cloud.google.com/iam/docs/creating-managing-service-account-keys
        $client->setAuthConfig('client_secret_899632747294-df8fm6buohraml1gq9lj67anio1lsgqi.apps.googleusercontent.com.json');
        $client->setAccessType('offline');


        // Exchange authorization code for an access token.
        //$accessToken = '1/0ETQq8vdh4ilfOks8Z6GDBOf1Bdrc9vjFjOJUm2ddF3SOEoY4GPYr2jydUg99Acu';//this is refresh token
        //$client->fetchAccessTokenWithAuthCode($authCode);
        $client->fetchAccessTokenWithRefreshToken($this->refresh_token);

        return $client;
    }


    public function getTopVideos()
    {

        $type = 'videos';

        $params = [
            'part' => 'statistics,snippet',
            'queryParams' => [
                'chart' => 'mostPopular',
                'maxResults' => $this->maxResults
            ]
        ];

        $response = $this->makeRequest($type, $params);

        $items = [];
        $page = 1;
        if (!empty($response) && $response->count()) {
            while(!empty($current_items = $response->getItems())) {

                $items[] = $current_items;
                $nextPageToken = $response->getNextPageToken();
                if (empty($nextPageToken) || $page === $this->pages) {
                    break;
                }

                $params['queryParams']['pageToken'] = $nextPageToken;

                $response = $this->makeRequest($type, $params);

                $page++;

            }
        }

        /*$this->printDie($response->getItems());*/

        if (count($items)) {
            $items = array_merge(...$items);
        }


        return $items;

    }


    public function getAllVideos4Channel($channelId)
    {

        $type = 'search';

        $params = [
            'part' => 'snippet',
            'queryParams' => [
                'channelId' => $channelId,
                'maxResults' => $this->maxResults
            ]
        ];

        $response = $this->makeRequest($type, $params);

        $items = [];
        $page = 1;
        if (!empty($response) && $response->count()) {
            while(!empty($current_items = $response->getItems())) {

                $items[] = $current_items;
                $nextPageToken = $response->getNextPageToken();
                if (empty($nextPageToken) || $page === $this->pages) {
                    break;
                }

                $params['queryParams']['pageToken'] = $nextPageToken;

                $response = $this->makeRequest($type, $params);

                $page++;
            }
        }

        if (count($items)) {
            $items = array_merge(...$items);
        }


        return $items;

    }


    public function getVideoStatistics(Array $videoIds)
    {
        $type = 'videos';

        if (empty($videoIds)) {
            throw new \Exception('Video ids for statistic data can\'t be empty');
        }

        $params = [
            'part' => 'statistics',
            'queryParams' => [
                'id' => implode(',', $videoIds),
                'maxResults' => $this->maxResults
            ]
        ];
        $response = $this->makeRequest($type, $params);

        $items = [];
        $page = 1;
        if (!empty($response) && $response->count()) {
            while(!empty($current_items = $response->getItems())) {

                $items[] = $current_items;
                $nextPageToken = $response->getNextPageToken();
                if (empty($nextPageToken) || $page === $this->pages) {
                    break;
                }

                $params['queryParams']['pageToken'] = $nextPageToken;

                $response = $this->makeRequest($type, $params);

                $page++;
            }
        }

        if (count($items)) {
            $items = array_merge(...$items);
        }


        return $items;
    }


    public function makeRequest($type = 'videos', Array $params)
    {

        $requiredKeys = ['part', 'queryParams'];

        if (0 === count($params)) {
            $params = [
                'part' => 'statistics,snippet',
                'queryParams' => [
                    'chart' => 'mostPopular',
                    'maxResults' => $this->maxResults
                ]
            ];
        }

        if (!empty($messingKeys = array_diff($requiredKeys, array_keys($params)))) {
            throw new \Exception('Reqired param or parameters is missing: ' . implode(', ', $messingKeys));
        }

        $service = new \Google_Service_YouTube($this->api_client);

        switch ($type) {
            case 'videos':
                $response = $service->videos->listVideos($params['part'], $params['queryParams']);
                break;
            case 'search':
                $response = $service->search->listSearch($params['part'], $params['queryParams']);
                break;
        }

        return !empty($response) ? $response : null;

    }

    public function saveChannelData(Array $data)
    {

        if (empty($data)) {
            throw new \Exception('Data for collection is empty');
        }

        $model = new Model();

        return $model->addItem2Collection($data);

    }

    public function printDie($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;
    }

}