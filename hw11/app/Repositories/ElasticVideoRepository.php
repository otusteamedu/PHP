<?php

namespace App\Repositories;

class ElasticVideoRepository extends AbstractElasticRepository
{
    /**
     * @param array $models
     */
    public function insertMany(array $models): void
    {
        foreach ($models as $key => $model) {
            $params['index'] = $model->getIndex();
            $params['body'][] = [
                'index' => [
                    '_id' => $model->getId(),
                ]
            ];

            $params['body'][] = [
                'id' => $model->getId(),
                'channelId' => $model->getChannelId(),
                'body' => $model->toArray(),
            ];
        }

        $this->client->bulk($params);
    }
}
