<?php


namespace src;


class ElasticIndex extends ElasticClient
{
    public function addToIndex(array $query)
    {
        $client = $this->createClient();
        return $response = $client->index($query);
    }

    public function getForIndex(array $query)
    {
        $client = $this->createClient();
        return $response = $client->get($query);

    }

    public function search(array $query)
    {
        $client = $this->createClient();
        return $response = $client->search($query);
    }

}