<?php

namespace App\Repositories;

use stdClass;
use InvalidArgumentException;
use App\Clients\YoutubeClient;
use GuzzleHttp\Exception\GuzzleException;

class YoutubeVideoRepository extends AbstractYoutubeRepository implements FindManyByIdsRepositoryInterface
{
    private const REQUEST_METHOD_GET = 'GET';
    private const CHANNEL_PART = 'contentDetails,statistics,id';
    private const MAX_RESULTS = 50;

    /**
     * @var string|mixed
     */
    private string $apiVideoUrl;

    /**
     * YoutubeChannelRepository constructor.
     *
     * @param YoutubeClient $client
     */
    public function __construct(YoutubeClient $client)
    {
        parent::__construct($client);
        $this->apiVideoUrl = $_ENV['YOUTUBE_VIDEO_URL'];
    }

    /**
     * @param array $ids
     *
     * @return stdClass
     *
     * @throws GuzzleException
     */
    public function findManyByIds(array $ids): stdClass
    {
        if (!$ids && !$this->apiKey && !$this->apiVideoUrl)
            throw new InvalidArgumentException();

        $result = $this->client->request(self::REQUEST_METHOD_GET, $this->apiVideoUrl, [
            'query' => [
                'key' => $this->apiKey,
                'part' => self::CHANNEL_PART,
                'id' => implode(',', $ids),
                'maxResults' => self::MAX_RESULTS,
                'pageToken' => ''
            ]
        ]);

        return json_decode(json: $result->getBody()->getContents(), flags: JSON_THROW_ON_ERROR);
    }
}
