<?php


namespace App\Repository\Interfaces;

use App\Model\Interfaces\ModelElasticsearchInterface;

interface ElasticRepositoryInterface
{
    /**
     * @param string $id
     * @param ModelElasticsearchInterface $model
     * @return ModelElasticsearchInterface
     */
    public function findOne(string $id, ModelElasticsearchInterface $model): ModelElasticsearchInterface;

    /**
     * @param ModelElasticsearchInterface $model
     * @return ModelElasticsearchInterface[]
     */
    public function findAll(ModelElasticsearchInterface $model): array;
}
