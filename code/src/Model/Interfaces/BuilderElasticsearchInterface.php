<?php


namespace App\Model\Interfaces;


interface BuilderElasticsearchInterface
{
    public function buildFromElasticResult(array $data): ModelElasticsearchInterface;
}
