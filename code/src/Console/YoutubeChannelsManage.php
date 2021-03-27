<?php


namespace App\Console;


use App\Model\Builders\YoutubeChannelBuilder;
use App\Model\Builders\YoutubeVideoBuilder;
use App\Services\ElasticsearchService;
use App\Services\YouTubeService;
use Elasticsearch\Client;
use Psr\Container\ContainerInterface;

class YoutubeChannelsManage extends Console
{
    private Client $client;
    private YouTubeService $youtubeService;
    private ElasticsearchService $elasticService;
    private YoutubeChannelBuilder $channelBuilder;
    private YoutubeVideoBuilder $videoBuilder;

    /**
     * YoutubeChannelsManage constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->youtubeService = $container->get(YouTubeService::class);
        $this->client = $container->get('elastic');

        $this->elasticService = new ElasticsearchService($this->client);
        $this->channelBuilder = new YoutubeChannelBuilder();
        $this->videoBuilder = new YoutubeVideoBuilder();
    }

    public function run()
    {
        $cancel = false;

        while (!$cancel) {
            echo 'Загрузить каналы (l), Инфо (i), Индексы (idx), Settings (s), выход (q): ';
            $answer = $this->readLine();

            switch ($answer) {
                case 'l':
                    echo 'Введите ключевые слова для поиска каналов: ';
                    $query = $this->readLine();
                    echo 'Loading...', PHP_EOL;
                    $this->loadData($query);
                    echo 'Загрузка завершена', PHP_EOL;
                    break;

                case 'idx':
                    $this->showIndices();
                    break;

                case 's':
                    $this->showSettings();
                    break;

                case 'i':
                    $this->showInfo();
                    break;

                default:
                    $cancel = true;
                    break;
            }
        }
    }

    private function showInfo(): void
    {
        echo 'Инфо', PHP_EOL;
        $data = $this->client->info();
        print_r($data);
    }

    private function showSettings(): void
    {
        echo 'Settings', PHP_EOL;
        $data = $this->client->indices()->getSettings();
        print_r($data);
    }

    private function showIndices(): void
    {
        echo 'Индексы', PHP_EOL;
        $stats = $this->client->indices()->stats();
        print_r($stats);
    }

    private function loadData($query): void
    {
        $result = $this->youtubeService->search($query, 25);
        $items = $result->getItems();

        foreach ($items as $item) {
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

        foreach ($items as $item) {
            $result = $this->youtubeService->findVideo($item->getId()->videoId);
            list($video) = $result->getItems();

            $model = $this->videoBuilder->buildFromGoogle($video);
            $this->elasticService->loadModel($model);
        }
    }
}
