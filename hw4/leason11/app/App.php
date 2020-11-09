<?php

/**
 * Class App
 * Simple application for manipulation YouTube channel
 */
class App
{
    /**
     * @var \Google\Client
     */
    private $apiClient;
    /**
     * @var Google_Service_YouTube
     */
    private $youtube;
    /**
     * @var array
     */
    private $config;

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
        // создаем API client
        $this->apiClient = new Google\Client();

        if ( ! isset($config['appName'])) {
            new Exception('missing application name in config');
            exit(1);
        }
        $this->apiClient->setApplicationName($config['appName']);

        if ( ! isset($config['key'])) {
            new Exception('missing developer api key');
            exit(1);
        }
        $this->apiClient->setDeveloperKey($config['key']);

        // создаем сервис YouTube
        $this->youtube = new Google_Service_YouTube($this->apiClient);
        $this->config = $config;
    }


    public function run()
    {
        echo "Channels: \n";
        //$activites = new Google_Service_YouTube_Activity();
        //$activites->setId($this->config['favorite_channel_id']);
        $channels = $this->youtube->channels->listChannels('brandingSettings', ['channelId'=>$this->config['favorite_channel_id']]);
        print_r($channels);
    }
}