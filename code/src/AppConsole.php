<?php


namespace App;


use App\Model\Builders\ChannelBuilder;

use App\Model\Builders\VideoBuilder;
use App\Services\ElasticsearchService;
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
    private ChannelBuilder $channelBuilder;
    private VideoBuilder $videoBuilder;

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
        $this->channelBuilder = new ChannelBuilder();
        $this->videoBuilder = new VideoBuilder();
    }

    public function run()
    {
        $cancel = false;

        while(!$cancel) {
            echo 'Загрузить каналы (l), выход (q): ';
            $answer = $this->readLine();

            switch($answer) {
                case 'l':
                    echo 'Введите ключевые слова для поиска каналов: ';
                    $query = $this->readLine();
                    echo 'Loading...', PHP_EOL;
                    $this->loadData($query);
                    echo 'Загрузка завершена', PHP_EOL;
                    break;

                default:
                    $cancel = true;
                    break;
            }
        }
    }

    private function loadData($query): void
    {
        $result = $this->youtubeService->search($query, 25);
        $items = $result->getItems();

        foreach($items as $item) {
            $snippet = $item->getSnippet();
            $channel = $this->channelBuilder->buildFromGoogleResult($snippet);
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

