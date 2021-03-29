<?php


namespace App\Controller;

use App\Model\YoutubeChannel;
use App\Repository\ElasticsearchElasticRepository;
use App\Repository\Exceptions\ElasticsearchNotFoundException;
use App\Repository\Interfaces\CacheChannelClickInterface;
use App\Repository\Interfaces\ElasticsearchInterface;
use App\Repository\ElasticsearchSearchRepository;
use App\Services\ChannelStatisticsService;
use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class ChannelController extends AbstractController
{
    private ElasticsearchInterface $searchClient;
    private CacheChannelClickInterface $clickCache;

    /**
     * ChannelController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->searchClient = new ElasticsearchSearchRepository($container);
        $this->clickCache = $container->get('cache_click_client');
    }


    public function index(Request $request, Response $response): Response
    {
        $error = null;
        $result = [];
        $limit = 100;
        $offset = 0;

        $query = $request->getQueryParams()['q'] ?? '';
        $model = new YoutubeChannel();

        try {
            $result = $this->searchClient->search($model, $query, $limit, $offset);
        } catch (ElasticsearchNotFoundException | Exception $e) {
            $error = $e->getMessage();
        }

        return $this->render($response, 'channel/index.php', [
            'channels' => $result,
            'error' => $error,
            'q' => $query,
        ]);
    }


    public function show(Request $request, Response $response): Response
    {
        $error = null;
        $channel = null;
        $stats = null;
        $video = null;
        $clickCount = null;

        $id = $request->getAttribute('id');
        $model = new YoutubeChannel();
        $repository = new ElasticsearchElasticRepository($this->container);

        try {
            $channel = $repository->findOne($id, $model);
            $stats = $repository->getStatistics($id);
            $clickCount = $this->clickCache->set($channel->getId());
            $video = $repository->findVideoByChannelId($id);
        }catch (ElasticsearchNotFoundException $e) {
            $error = $e->getMessage();
        }

        return $this->render($response, 'channel/show.php', [
            'error' => null,
            'channel' => $channel,
            'stats' => $stats,
            'video' => $video,
            'clickCount' => $clickCount,
        ]);
    }

    public function top(Request $request, Response $response): Response
    {
        $error = null;
        $statisticsService = new ChannelStatisticsService($this->container);
        $channels = $statisticsService->topChannels(5);

        return $this->render($response, 'channel/top.php', [
            'error' => null,
            'channels' => $channels,
        ]);
    }
}
