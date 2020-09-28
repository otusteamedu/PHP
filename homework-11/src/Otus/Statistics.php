<?php

namespace Otus;

use Elasticsearch\Client;

class Statistics
{
    private Client $client;

    public function __construct()
    {
        $this->client = ElasticClientFactory::make();
    }

    /**
     * @param  int  $limit
     *
     * @throws \Otus\Exceptions\InvalidDataFormatException
     * @return \Otus\ChannelCollection
     */
    public function get(int $limit): ChannelCollection
    {
        $result = $this->client->search([
            'index' => 'channels',
            'body'  => [
                'size' => $limit,
                'sort' => [
                    [
                        'ratio' => ['order' => 'asc'],
                    ],
                ],
            ],
        ]);

        return new ChannelCollection($result);
    }
}