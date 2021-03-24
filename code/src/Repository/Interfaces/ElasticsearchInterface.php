<?php


namespace App\Repository\Interfaces;


use App\Model\Interfaces\ModelElasticsearchInterface;

interface ElasticsearchInterface
{
    /**
     * @param ModelElasticsearchInterface $model
     * @param string $query
     * @param int $limit
     * @param int $offset
     * @return ModelElasticsearchInterface[]
     */
    public function search(
        ModelElasticsearchInterface $model,
        string $query,
        int $limit,
        int $offset
    ): array;

}
