<?php

declare(strict_types=1);

namespace App\Command\Indexes;

use App\Command\CommandInterface;
use App\Config\Configuration;
use App\Console\Console;
use Elasticsearch\Client;

class DeleteIndexesCommand implements CommandInterface
{

    private Client        $elasticsearchClient;
    private Configuration $config;

    public function __construct(Client $elasticsearchClient, Configuration $config)
    {
        $this->elasticsearchClient = $elasticsearchClient;
        $this->config = $config;
    }

    public function execute(): void
    {
        $indexNames = $this->config->getParam('elasticsearch_indexes');

        foreach ($indexNames as $indexName) {
            $params = ['index' => $indexName];

            if (!$this->elasticsearchClient->indices()->exists($params)) {
                Console::info("Индекс $indexName не существует");
                continue;
            }

            $this->elasticsearchClient->indices()->delete($params);

            Console::success("Индекс $indexName успешно удален");
        }
    }

}