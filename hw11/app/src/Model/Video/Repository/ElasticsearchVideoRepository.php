<?php

declare(strict_types=1);

namespace App\Model\Video\Repository;

use App\Model\Video\Entity\Video;
use App\Model\Video\Exception\VideoNotFoundException;
use DomainException;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class ElasticsearchVideoRepository implements VideoRepositoryInterface
{

    private const INDEX_NAME = 'videos';
    private Client $elasticsearchClient;

    public function __construct(Client $elasticsearchClient)
    {
        $this->elasticsearchClient = $elasticsearchClient;
    }

    public function get(string $channelId, int $limit, int $skip): array
    {
        $params = [
            'index' => self::INDEX_NAME,
            'size'  => $limit,
            'from'  => $skip,
            'body'  => [
                'query' => [
                    'match' => [
                        'channelId' => $channelId,
                    ],
                ],
            ],
        ];

        $response = $this->elasticsearchClient->search($params);

        return array_map(
            fn($hit) => $this->buildVideo($hit['_source']),
            $response['hits']['hits']
        );
    }

    public function getOne(string $id): Video
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id'    => $id,
        ];

        try {
            $response = $this->elasticsearchClient->get($params);
        } catch (Missing404Exception $e) {
            throw new VideoNotFoundException('Видео не найдено');
        }

        return $this->buildVideo($response['_source']);
    }

    private function buildVideo(array $data): Video
    {
        $video = new Video(
            $data['id'],
            $data['title'],
            $data['channelId']
        );

        $video->changeLikeCount($data['likeCount']);
        $video->changeDislikeCount($data['dislikeCount']);

        return $video;
    }

    public function add(Video $video): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id'    => $video->getId(),
            'body'  => $video->toArray(),
        ];

        $response = $this->elasticsearchClient->index($params);

        if (empty($response['_shards']['successful'])) {
            throw new DomainException('Ошибка при добавлении видео');
        }
    }

    public function update(Video $video): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id'    => $video->getId(),
            'body'  => $video->toArray(),
        ];

        $response = $this->elasticsearchClient->index($params);

        if (empty($response['_shards']['successful'])) {
            throw new DomainException('Ошибка при изменении видео');
        }
    }

    public function delete(Video $video): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'id'    => $video->getId(),
        ];

        $response = $this->elasticsearchClient->delete($params);

        if (empty($response['_shards']['successful'])) {
            throw new DomainException('Ошибка при удалении видео');
        }
    }

    public function deleteAllByChannel(string $channelId): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body'  => [
                'query' => [
                    'match' => [
                        'channelId' => $channelId,
                    ],
                ],
            ],
        ];

        $this->elasticsearchClient->deleteByQuery($params);
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