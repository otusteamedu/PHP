<?php


namespace src;


class ElasticIndex extends ElasticClient
{
    public function addToIndex(array $query): void
    {
        $client = $this->createClient();
        $params = [
            'index' => 'youtube',
            'id' => 1,
            'body' => [
                'channel_name' => $query['channel_name'],
                'channel_subscribe' => $query['channel_subscribe'],
                'video_name' => $query['video_name'],
                'video_data' => $query['video_data'],
                'video_description' => $query['video_description'],
                'video_view' => $query['video_view'],
                'video_like' => $query['video_like'],
                'video_dislike' => $query['video_dislike']
            ]
        ];
        $client->index($params);
    }

    public function getFromIndex(int $query): array
    {
        $client = $this->createClient();
        $params = [
            'index' => 'youtube',
            'type' => 'youtube',
            'id' => $query,
        ];
        return $client->get($params);

    }

    public function updateInIndex(array $query): void
    {
        $client = $this->createClient();
        $param = [
            'index' => 'youtube',
            'id' => $query['id'],
            'body' => [
                'channel_name' => $query['channel_name'],
                'channel_subscribe' => $query['channel_subscribe'],
                'video_name' => $query['video_name'],
                'video_data' => $query['video_data'],
                'video_description' => $query['video_description'],
                'video_view' => $query['video_view'],
                'video_like' => $query['video_like'],
                'video_dislike' => $query['video_dislike']
            ]
        ];
        $client->updateByQuery($param);
    }

    public function deleteFromIndex(int $query): void
    {
        $client = $this->createClient();
        $param = [
            'index' => 'youtube',
            'id' => $query
        ];
        $client->deleteByQuery($param);
    }

    public function search(string $query): array
    {
        $client = $this->createClient();
        $params = [
            'index' => 'youtube',
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => [
                            'channel_name^5',
                            'video_name^4',
                            'video_data',
                            'video_description^2'
                        ]
                    ]
                ]
            ]
        ];
        return $response = $client->search($params);
    }

}