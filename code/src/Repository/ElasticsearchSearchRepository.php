<?php


namespace App\Repository;


use App\Model\Interfaces\ModelElasticsearchInterface;
use App\Repository\Exceptions\ElasticsearchNotFoundException;
use App\Repository\Interfaces\ElasticsearchInterface;
use Elasticsearch\Client;
use Psr\Container\ContainerInterface;

class ElasticsearchSearchRepository implements ElasticsearchInterface
{
    private int $totalCount = 0;
    private Client $client;

    /**
     * ElasticsearchSearchSnippets constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->client = $container->get('elastic');
    }

    /**
     * @inheritDoc
     * @throws ElasticsearchNotFoundException
     */
    public function search(
        ModelElasticsearchInterface $model,
        string $query,
        int $limit,
        int $offset
    ): array
    {
        $result = $this->client->search([
            'index' => $model->getSearchIndex(),
            'body' => [
                'query' => [
                    'query_string' => [
                        'fields' => $model->getSearchFields(),
                        'query' => '*' . $query . '*',
                        'analyze_wildcard' => true,
                        'allow_leading_wildcard' => true,
                    ]
                ]
            ],
            'size' => $limit,
            'from' => $offset,
        ]);

        return $this->buildCollection($result, $model);
    }

    /**
     * @param array $items
     * @param ModelElasticsearchInterface $model
     * @return ModelElasticsearchInterface[]
     */
    private function buildCollection(array $items, ModelElasticsearchInterface $model): array
    {
        if (!$items) {
            throw new ElasticsearchNotFoundException('По вашему запросу ничего не найдено');
        }

        $this->totalCount = $items['hits']['total']['value'];
        $values = $items['hits']['hits'];
        $builder = $model->getBuilder();

        $models = [];

        foreach ($values as $item) {
            $model = $builder->buildFromElasticResult($item['_source']);
            array_push($models, $model);
        }

        return $models;
    }
}
