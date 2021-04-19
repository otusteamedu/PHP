<?php

namespace App\Repositories;

use JetBrains\PhpStorm\Pure;
use stdClass;
use InvalidArgumentException;
use App\Clients\YoutubeClient;
use \GuzzleHttp\Exception\GuzzleException;

class YoutubeSearchRepository extends AbstractYoutubeRepository implements FindByIdRepositoryInterface
{
    private const REQUEST_METHOD_GET = 'GET';
    private const CHANNEL_PART = 'id';
    private const TYPE = 'video';
    private const MAX_RESULTS = 50;

    /**
     * @var string|mixed
     */
    private string $apiSearchUrl;

    /**
     * YoutubeChannelRepository constructor.
     *
     * @param YoutubeClient $client
     */
    public function __construct(YoutubeClient $client)
    {
        parent::__construct($client);
        $this->apiSearchUrl = $_ENV['YOUTUBE_SEARCH_URL'];
    }

    /**
     * @param string $id
     *
     * @return stdClass
     *
     * @throws GuzzleException
     */
    public function findById(string $id): stdClass
    {
        if (!$id && !$this->apiKey && !$this->apiSearchUrl)
            throw new InvalidArgumentException();

        $result = $this->client->request(self::REQUEST_METHOD_GET, $this->apiSearchUrl, [
            'query' => [
                'key' => $this->apiKey,
                'part' => self::CHANNEL_PART,
                'channelId' => $id,
                'type' => self::TYPE,
                'maxResults' => self::MAX_RESULTS,
                'pageToken' => ''
            ]
        ]);

        return json_decode(json: $result->getBody()->getContents(), flags: JSON_THROW_ON_ERROR);
    }
}
