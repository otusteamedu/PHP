<?php


namespace App;


use App\Model\Builders\YoutubeChannelBuilder;

use App\Model\Builders\YoutubeVideoBuilder;
use App\Model\EventModel;
use App\Model\EventParam;
use App\Repository\RedisEventRepository;
use App\Services\ElasticsearchService;
use App\Services\RedisEventService;
use App\Services\YouTubeService;
use DI\Container;
use DI\ContainerBuilder;
use Elasticsearch\Client;

class AppConsole
{
    private Container $container;
    private Client $client;
    private YouTubeService $youtubeService;
    private ElasticsearchService $elasticService;
    private YoutubeChannelBuilder $channelBuilder;
    private YoutubeVideoBuilder $videoBuilder;

    /**
     * AppConsole constructor.
     */
    public function __construct()
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(__DIR__ . '/../config/services.php');
        $this->container = $builder->build();

        $this->youtubeService = $this->container->get(YouTubeService::class);
        $this->client = $this->container->get('elastic');

        $this->elasticService = new ElasticsearchService($this->client);
        $this->channelBuilder = new YoutubeChannelBuilder();
        $this->videoBuilder = new YoutubeVideoBuilder();
    }

    private function testRedis()
    {
        $repo = new RedisEventRepository($this->container);

        $repo->drop();

        for($i = 1; $i <= 5; $i++) {
            $model = new EventModel();
            $model->setEvent('event ' . $i);
            $model->setPriority(rand(1, 3) * 1000);

            $params1 = ['param1' => rand(1, 2)];
            $params2 = (rand(0, 1)) ? ['param2' => rand(1, 2)] : [];

            $model->setCondition(array_merge($params1, $params2));

            $repo->create($model);
        }

        $cancel = false;

        while(!$cancel) {
            echo 'get events(e), get by id(g), ' .
                'delete events(d), findByParams(f), выход (q): ';
            $answer = $this->readLine();

            switch ($answer) {
                case 'g':
                    echo 'Type id: ';
                    $id = $this->readLine();
                    echo PHP_EOL;
                    $m = $repo->findOne($id);
                    print_r($m->toArray());
                    break;

                case 'e':
                    $models = $repo->findAll();
                    foreach ($models as $model ) {
                        print_r($model->toArray());
                    }
                    break;


                case 'f':
                    echo 'Type param1: ';
                    $p1 = $this->readLine();
                    echo 'Type param2: ';
                    $p2 = $this->readLine();

                    $param1 = $p1 ? ['param1' => $p1] : [];
                    $param2 =  $p2 ? ['param2' => $p2] : [];
                    $params = array_merge($param1, $param2);

                    if (!$params) {
                        break;
                    }

                    $data = $repo->findByParams($params);
                    print_r($data);

                    break;


                case 'd':
                    $repo->drop();
                    break;

                default:
                    $cancel = true;
            }
        }

    }

    public function run()
    {
        $this->testRedis();
//
//        $cancel = false;
//
//        while(!$cancel) {
//            echo 'Загрузить каналы (l), выход (q): ';
//            $answer = $this->readLine();
//
//            switch($answer) {
//                case 'l':
//                    echo 'Введите ключевые слова для поиска каналов: ';
//                    $query = $this->readLine();
//                    echo 'Loading...', PHP_EOL;
//                    $this->loadData($query);
//                    echo 'Загрузка завершена', PHP_EOL;
//                    break;
//
//                default:
//                    $cancel = true;
//                    break;
//            }
//        }
    }

    private function loadData($query): void
    {
        $result = $this->youtubeService->search($query, 25);
        $items = $result->getItems();

        foreach($items as $item) {
            $snippet = $item->getSnippet();
            $channel = $this->channelBuilder->buildFromGoogle($snippet);
            $this->elasticService->loadModel($channel);

            $this->loadVideo($channel->getId());
        }
    }

    private function loadVideo($channelId): void
    {
        $result = $this->youtubeService->findChannelVideos($channelId, 100);
        $items = $result->getItems();

        foreach($items as $item) {
            $result = $this->youtubeService->findVideo($item->getId()->videoId);
            list($video) = $result->getItems();

            $model = $this->videoBuilder->buildFromGoogle($video);
            $this->elasticService->loadModel($model);
        }
    }

    private function readLine(): string
    {
        return rtrim(fgets(STDIN));
    }
}

