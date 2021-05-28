<?php

namespace App\Repositories;

use JetBrains\PhpStorm\Pure;
use stdClass;
use InvalidArgumentException;
use App\Clients\YoutubeClient;
use GuzzleHttp\Exception\GuzzleException;

class YoutubeChannelRepository extends AbstractYoutubeRepository implements FindByIdRepositoryInterface
{
    private const REQUEST_METHOD_GET = 'GET';
    private const CHANNEL_PART = 'id,snippet,statistics';

    /**
     * @var string|mixed
     */
    private string $apiChannelUrl;

    /**
     * YoutubeChannelRepository constructor.
     *
     * @param YoutubeClient $client
     */
    #[Pure] public function __construct(YoutubeClient $client)
    {
        parent::__construct($client);
        $this->apiChannelUrl = $_ENV['YOUTUBE_CHANNEL_URL'];
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
        if (!$id && !$this->apiKey && !$this->apiChannelUrl)
            throw new InvalidArgumentException();

        $result = $this->client->request(self::REQUEST_METHOD_GET, $this->apiChannelUrl, [
            'query' => [
                'key' => $this->apiKey,
                'part' => self::CHANNEL_PART,
                'id' => $id
            ]
        ]);

        return json_decode(json: $result->getBody()->getContents(), flags: JSON_THROW_ON_ERROR);
    }
}
