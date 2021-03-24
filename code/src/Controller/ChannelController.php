<?php


namespace App\Controller;

use App\Repository\ElastisearchChannelStatistics;
use App\Repository\ElasticsearchChannels;
use App\Services\YouTubeService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class ChannelController extends AbstractController
{
    private ElasticsearchChannels $searchClient;
    private ElastisearchChannelStatistics $statsClient;

    /**
     * ChannelController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->searchClient = new ElasticsearchChannels($container);
        $this->statsClient = new ElastisearchChannelStatistics($container);
    }


    public function index(Request $request, Response $response): Response
    {
        $error = null;
        $result = [];
        $limit = 100;
        $offset = 0;

        $query = $request->getQueryParams()['q'] ?? '';

        try {
            $result = $this->searchClient->search($query, $limit, $offset);
        } catch (\Exception $e) {
            $error = $e;
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

        $id = $request->getAttribute('id');
        try {
            $channel = $this->searchClient->findOne($id);

            $stats = $this->statsClient->getStatistics($id);

        }catch (\Exception $e) {
            $error = $e;
        }

        return $this->render($response, 'channel/show.php', [
            'error' => null,
            'channel' => $channel,
            'stats' => $stats,
        ]);
    }

    public function top(Request $request, Response $response): Response
    {
        $error = null;

        $channels = $this->statsClient->topChannels(3);

        return $this->render($response, 'channel/top.php', [
            'error' => null,
            'channels' => $channels,
        ]);

    }

}
