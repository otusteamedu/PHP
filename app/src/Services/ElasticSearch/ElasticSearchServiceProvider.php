<?php


namespace App\Services\ElasticSearch;


class ElasticSearchServiceProvider
{
    public function boot(): void
    {
        $client = ElasticSearchClient::get();

        $config = json_decode(file_get_contents(__DIR__ . '/elasticSearchSchema.json'), true);

        foreach ($config as $indexParams){
            if(!isset($indexParams['index'])){
                continue;
            }

            if(false === $client->indices()->exists(['index' => $indexParams['index']])){
                $client->indices()->create($indexParams);
            }
        }
    }
}