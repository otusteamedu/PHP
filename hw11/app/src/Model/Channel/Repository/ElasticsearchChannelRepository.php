<?php

declare(strict_types=1);

namespace App\Model\Channel\Repository;

use App\Model\Channel\Entity\Channel;
use App\Model\Channel\Exception\ChannelNotFoundException;
use DomainException;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class ElasticsearchChannelRepository implements ChannelRepositoryInterface
{

    private const INDEX_NAME = 'channels';
    private Client $elasticsearchClient;

    public function __construct(Client $elasticsearchClient)
    {
        $this->elasticsearchClient = $elasticsearchClient;
    }

    public function get(int $limit, int $skip): array
    {
        $params = [
            'index' => self::INDEX_NAME,
            'size'  => $limit,
            'from'  => $skip,
        ];

        $response = $this->elasticsearchClient->search($params);

        return array_map(
            fn($hit) => $this->buildChannel($hit['_source']),
            $response['hits']['hits']
        );
    }

    public function getOne(string $id): Channel
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id'    => $id,
        ];

        try {
            $response = $this->elasticsearchClient->get($params);
        } catch (Missing404Exception $e) {
            throw new ChannelNotFoundException('Канал не найден');
        }

        return $this->buildChannel($response['_source']);
    }

    private function buildChannel(array $source): Channel
    {
        return new Channel($source['id'], $source['title']);
    }

    public function add(Channel $channel): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id'    => $channel->getId(),
            'body'  => $channel->toArray(),
        ];

        $response = $this->elasticsearchClient->index($params);

        if (empty($response['_shards']['successful'])) {
            throw new DomainException('Ошибка при добавлении канала');
        }
    }

    public function update(Channel $channel): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id'    => $channel->getId(),
            'body'  => $channel->toArray(),
        ];

        $response = $this->elasticsearchClient->index($params);

        if (empty($response['_shards']['successful'])) {
            throw new DomainException('Ошибка при изменении канала');
        }
    }

    public function delete(Channel $channel): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id'    => $channel->getId(),
        ];

        $response = $this->elasticsearchClient->delete($params);

        if (empty($response['_shards']['successful'])) {
            throw new DomainException('Ошибка при удалении канала');
        }
    }

    public function hasById(string $id): bool
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body'  => [
                'query' => [
                    'match' => [
                        'id' => $id,
                    ],
                ],
            ],
        ];

        $response = $this->elasticsearchClient->search($params);

        return !empty($response['hits']['total']['value']);
    }

}