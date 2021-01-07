<?php

namespace App\Command;

use App\Core\AbstractController;
use Elasticsearch\ClientBuilder;

class TestController extends AbstractController
{
    public function indexAction()
    {
        $client = ClientBuilder::create()->setHosts([
            'es01'
        ])->build();
        $response = $client->index([
            'index' => 'my_index',
            'id'    => 'my_id',
            'body'  => ['testField' => 'abc']
        ]);
        print_r($response);
    }
}