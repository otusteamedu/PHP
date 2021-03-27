<?php


namespace App\Console;


use App\Model\Builders\YoutubeChannelBuilder;

use App\Model\Builders\YoutubeVideoBuilder;
use App\Model\EventModel;
use App\Repository\RedisEventRepository;
use App\Services\ElasticsearchService;
use App\Services\YouTubeService;
use DI\Container;
use DI\ContainerBuilder;
use Elasticsearch\Client;

class App extends Console
{
    const CONFIG_DIR = __DIR__ . '/../../config';

    private Container $container;
    private Client $client;
    private YouTubeService $youtubeService;
    private ElasticsearchService $elasticService;
    private YoutubeChannelBuilder $channelBuilder;
    private YoutubeVideoBuilder $videoBuilder;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(self::CONFIG_DIR . '/services.php');
        $this->container = $builder->build();
    }

    public function run()
    {
        $cancel = false;

        while(!$cancel) {
            echo 'Test redis (r), youtube channels (c),  выход (q): ';
            $answer = $this->readLine();

            switch($answer) {
                case 'r':
                    $redis = new RedisManage($this->container);
                    $redis->run();
                    break;
                case 'c':
                    $youtube = new YoutubeChannelsManage($this->container);
                    $youtube->run();
                    break;
                case 'q':
                default:
                    $cancel = true;
            }
        }
    }

}

