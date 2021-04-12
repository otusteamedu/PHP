<?php

declare(strict_types=1);

namespace App\Command\Indexes;

use App\Command\CommandInterface;
use App\Config\Configuration;
use App\Console\Console;
use Elasticsearch\Client;

class CreateIndexesCommand implements CommandInterface
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
            $params = $this->getIndexStructure($indexName);

            if ($this->elasticsearchClient->indices()->exists(['index' => $indexName])) {
                Console::info("Индекс $indexName уже существует");
                continue;
            }

            $this->elasticsearchClient->indices()->create($params);

            Console::success("Индекс $indexName успешно создан");
        }
    }

    private function getIndexStructure(string $indexName): array
    {
        $path = $this->config->getParam('elasticsearch_path_to_structures');

        $json = file_get_contents("$path$indexName.json");

        return json_decode($json, true);
    }

}