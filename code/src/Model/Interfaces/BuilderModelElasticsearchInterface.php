<?php


namespace App\Model\Interfaces;


interface BuilderModelElasticsearchInterface
{
    public function buildFromElasticResult(array $data): ModelElasticsearchInterface;
}
