<?php

namespace App\Repositories;

use Elasticsearch\Client;
use App\Models\BaseModel;
use App\Clients\ElasticClient;

class AbstractElasticRepository implements CUDRepositoryInterface
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * AbstractElasticRepository constructor.
     */
    public function __construct()
    {
        $this->client = ElasticClient::getInstance();
    }

    /**
     * @param BaseModel $model
     */
    public function insert(BaseModel $model): void
    {
        $this->client->index([
            'index' => $model->getIndex(),
            'id' => $model->getId(),
            'body' => $model->toArray(),
        ]);
    }

    /**
     * @param BaseModel $model
     * @param array $updateData
     */
    public function update(BaseModel $model, array $updateData): void
    {
        $params = [
            'index' => $model->getIndex(),
            'id'    => $model->getId(),
            'body'  => [
                'doc' => $updateData
            ]
        ];

        $this->client->update($params);
    }

    /**
     * @param BaseModel $model
     */
    public function delete(BaseModel $model): void
    {
        $this->client->delete([
            'index' => $model->getIndex(),
            'id' => $model->getId(),
        ]);
    }
}
