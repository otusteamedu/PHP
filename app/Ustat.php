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

    protected $maxResults = 50;

    protected $pages = 1;

    public function __construct(Array $params)
    {

        $required_keys = [
            'client_id',
            'client_secret',
            'refresh_token'
        ];

        if (empty($params)) {
            throw new \Exception('Required params is missing. You must provide next fields: ' . implode(', ', $required_keys));
        }

        $param_keys = array_keys($params);

        if (!empty($messing_keys = array_diff($required_keys, $param_keys))) {
            throw new \Exception('Required param or parameters is missing: ' . implode(', ', $messing_keys));
        }

        foreach ($required_keys as $key) {
            if (empty($params[$key])) {
                throw new \Exception('Required param "' . $key . '" is empty');
            }
            $this->$key = $params[$key];
        }

        $this->api_client = $this->connect();

    }

    /**
     * Set max result that we will receive in response from youtube
     * @param $max
     * @throws \Exception
     */
    public function setMaxResults($max)
    {
        if (!filter_var($max, FILTER_SANITIZE_NUMBER_INT)) {
            throw new \Exception('Max results must be integer number');
        }

        if ($max < 1) {
            $max = 1;
        }
        if($max > 50) {
            $max = 50;
        }

        $this->maxResults = $max;
    }

    /**
     * Set how much pages we will check in response what we receive before. In 1 page maximum can be 50 results
     * @param $pages
     * @throws \Exception
     */
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


    /**
     * Connect to youtube api, use refresh token
     * @return \Google_Client
     */
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

    /**
     * Get video list from top chart
     * @return array
     */
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

        if (count($items)) {
            $items = array_merge(...$items);
        }

        return $items;

    }

    /**
     * Get all data from mongodb
     * @return \MongoDB\Driver\Cursor
     */
    public function getAllData()
    {
        $model = new Model();

        return $model->getAllData();
    }


    /**
     * get all videos for given channel id
     * @param $channelId
     * @return array
     */
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

    /**
     * make request to youtube api and get statistics for video ids which we get from previous steps [all channel videos]
     * @param array $videoIds
     * @return array
     * @throws \Exception
     */
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

    /**
     * Make request to youtube api
     * @param string $type
     * @param array $params
     * @return \Google_Service_YouTube_SearchListResponse|\Google_Service_YouTube_VideoListResponse|null
     * @throws \Exception
     */
    public function makeRequest(string $type = 'videos', Array $params)
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

    /**
     * Save data to mongodb
     * @param array $data
     * @return int
     * @throws \Exception
     */
    public function saveChannelData(Array $data)
    {

        if (empty($data)) {
            throw new \Exception('Data for collection is empty');
        }

        $model = new Model();

        return $model->addItem2Collection($data);

    }


    /**
     * Return statistics for channel by name
     * @param string $channelName
     * @return array|\Traversable
     */
    public function getChannelStatByName(string $channelName)
    {

        $model = new Model();
        $result = $model->getAllData(['channelTitle' => $channelName]);
        if (!empty($data = iterator_to_array($result))) {
            $channelId = $data[0]['channelId'];
            return $this->getChannelStatById($channelId);
        }

        return [];

    }

    /**
     * Return statistics for channel by id
     * @param string $channelId
     * @return \Traversable
     */
    public function getChannelStatById(string $channelId)
    {
        $model = new Model();

        return $model->getChannelStat($channelId);
    }

    /**
     * Return statistics for all channel
     * @return array
     */
    public function getTopChannels()
    {

        $model = new Model();

        return $model->getTopLikeDislikeChannels();

    }

    /**
     * Just for debug
     * @param $data
     */
    public function printVarDie($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;
    }

    public function printVar($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

}