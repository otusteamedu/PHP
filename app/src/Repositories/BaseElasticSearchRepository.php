<?php

namespace App\Repositories;

use App\Entities\BaseEntity;
use App\Services\ElasticSearch\ElasticSearchClient;
use Illuminate\Support\Collection;
use ElasticSearch\Client;

abstract class BaseElasticSearchRepository
{
    protected Client $elasticSearchClient;

    protected const INDEX = '';

    public function __construct()
    {
        $this->elasticSearchClient = ElasticSearchClient::get();
    }

    protected function getIndex() : string
    {
        return static::INDEX;
    }

    /**
     * @return Collection|BaseEntity[]
     */
    public function getAll(): Collection
    {
        $index = $this->elasticSearchClient->search([
            'index' => $this->getIndex(),
            'body' => ["query"=>[
                    "match_all"=>(object)[]
                ],
            ],
            'size' => 10000
        ]);

        $collection = collect();

        foreach($index['hits']['hits'] as $source){
            $collection->push($this->makeModelBySource($source['_source']));
        }

        return $collection;
    }

    /**
     * @param string $id
     * @return BaseEntity
     */
    public function getById(string $id): BaseEntity
    {
        $source = $this->elasticSearchClient->get([
            'index' => $this->getIndex(),
            'id' => $id
        ]);

        return $this->makeModelBySource($source['_source']);
    }

    /**
     * @param BaseEntity $entity
     * @return BaseEntity
     */
    public function save(BaseEntity $entity): BaseEntity
    {
        $this->elasticSearchClient->index([
            'index' => $this->getIndex(),
            'id' => $entity->getId(),
            'body' => $entity->toArray(),
        ]);

        return $entity;
    }

    abstract protected function makeModelBySource(array $source) : BaseEntity;
}