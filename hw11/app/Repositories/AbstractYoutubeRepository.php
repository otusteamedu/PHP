<?php

namespace App\Repositories;

use App\Clients\YoutubeClient;
use GuzzleHttp\ClientInterface;

class AbstractYoutubeRepository implements ReadRepositoryInterface
{
    /**
     * @var string|mixed
     */
    protected string $apiKey;

    /**
     * @var ClientInterface
     */
    protected ClientInterface $client;

    /**
     * AbstractYoutubeRepository constructor.
     *
     * @param YoutubeClient $client
     */
    public function __construct(YoutubeClient $client)
    {
        $this->client = $client;
        $this->apiKey = $_ENV['YOUTUBE_API_KEY'];
    }
}
