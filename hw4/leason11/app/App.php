<?php

/**
 * Class App
 * Simple application for manipulation YouTube channel
 */

use app\src\Youtuber;
use app\src\ElasticStorage;

class App
{
    /**
     * @var array
     */
    private $config;
    private $client;
    private $storage;


    public function __construct($config = [])
    {
        if (empty($config)) {
            // читаем конфиг из файла
            $configFile = __DIR__ . '/../config/youtube.ini';
            if ( ! file_exists($configFile)) {
                throw new Exception('missing configuration file config/youtube.ini');
            }
            $config = parse_ini_file($configFile);
            if (empty($config)) {
                throw new Exception('missing API key');
            }
        }

        if ( ! isset($config['appName'])) {
            throw new Exception('missing application name in config');
        }

        if ( ! isset($config['key'])) {
            throw new Exception('missing developer api key');
        }
        $this->client = new Youtuber($config['key'], $config['appName']);
        $this->config = $config;

        $this->storage = new ElasticStorage();
        $this->storage->createIndex([
            'index' => $config['appName'],
            'body'  => [
                'number_of_replicas' => 0,
                'number_of_shards'   => 2,
            ],
        ]);
    }


    public function run()
    {
        echo "Channel info: \n";
        $chId = $this->config['favorite_channel_id'];

        $channels  = $this->client->getChannelInfo($chId);
        $data      = $this->client->getChannelVideos($chId);
        $videoInfo = $this->prerateVideoInfo($data);
        $this->storeData($channels, $videoInfo);
    }


    /**
     * Добавлемя информацию о лайках/дизлайках к видео
     *
     * @param $data
     *
     * @return array
     */
    private function prerateVideoInfo($data)
    {
        $videoInfo = [];
        foreach ($data['items'] as $item) {
            $videoId = $item['id']['videoId'];
            try {
                $data = $this->client->getVideoRating($videoId);
            } catch (Exception $e) {
                print_r(['error' => $e->getMessage()]);
            }
            $row = [
                'info' => $item['snippet'],
            ];
            if (isset($data)) {
                $row['raiting'] = $data;
            }
            $videoInfo[] = $row;
            unset($row);
        }

        return $videoInfo;
    }


    /**
     * Сохраняем информацию о канале в хранилище
     *
     * @param $channelInfo
     * @param $video
     */
    private function storeData($channelInfo, $video)
    {
        $this->storage->add([
            'index' => $this->config['appName'],
            'body'  => [
                'info'  => $channelInfo,
                'video' => $video,
            ],
        ]);
    }
}