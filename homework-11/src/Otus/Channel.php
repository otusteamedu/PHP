<?php

namespace Otus;

use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class Channel
{
    private Client $client;

    public ?string $id;

    public ?string $title;

    public ?string $description;

    public int $likeCount = 0;

    public int $dislikeCount = 0;

    public float $ratio = 0;

    public function __construct()
    {
        $this->client = ElasticClientFactory::make();
    }

    public static function make(array $data): Channel
    {
        $instance = new self();

        $data = ChannelSanitizer::sanitize($data);

        return $instance->fill($data);
    }

    public function save(array $data): self
    {
        $data = ChannelSanitizer::sanitize($data);

        $this->client->index([
            'index' => 'channels',
            'id'    => $data['id'] ?? '',
            'body'  => $data,
        ]);

        return $this->fill($data);
    }

    public function fill(array $data): self
    {
        $this->id              = $data['id'];
        $this->title           = $data['title'];
        $this->description     = $data['description'];
        $this->likeCount       = $data['like_count'];
        $this->dislikeCount    = $data['dislike_count'];
        $this->ratio           = $data['ratio'];

        return $this;
    }

    public function get(string $id): self
    {
        $data = $this->client->getSource([
            'index' => 'channels',
            'id'    => $id,
        ]);

        return $this->fill($data);
    }

    public function delete(string $id): bool
    {
        try {
            $this->client->delete([
                'index' => 'channels',
                'id'    => $id,
            ]);
        } catch (Missing404Exception $exception) {
            return false;
        }

        return true;
    }
}