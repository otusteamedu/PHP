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
            $DS         = DIRECTORY_SEPARATOR;
            $configFile = __DIR__ . $DS . '..' . $DS . 'config' . $DS . 'youtube.ini';
            if ( ! file_exists($configFile)) {
                new Exception('missing configuration file config/youtube.ini');
                exit(1);
            }
            $config = parse_ini_file($configFile);
            if (empty($config)) {
                new Exception('missing API key');
                exit(1);
            }
        }

        if ( ! isset($config['appName'])) {
            new Exception('missing application name in config');
            exit(1);
        }

        if ( ! isset($config['key'])) {
            new Exception('missing developer api key');
            exit(1);
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
        try {
            $channels = $this->client->getChannelInfo($chId);
        } catch (Exception $e) {
            print_r(['error' => $e->getMessage()]);
            print_r(debug_backtrace());
        }

        $data      = $this->client->getChannelVideos($chId);
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

        $this->storage->add([
            'index' => $this->config['appName'],
            'body'  => [
                'info'  => $channels,
                'video' => $videoInfo,
            ],
        ]);
    }
}