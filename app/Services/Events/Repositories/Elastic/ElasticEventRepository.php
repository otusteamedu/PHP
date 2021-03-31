<?php


namespace App\Services\Events\Repositories\Elastic;


use App\Services\Events\EventService;
use App\Services\Events\Repositories\iEventRepository;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;

class ElasticEventRepository implements iEventRepository
{

    public const EVENT_INDEX = 'events';

    private $elastic;

    public function __construct(Client $client)
    {
        $this->elastic = $client;
    }

    public function add($data): void
    {
        $this->elastic->index([
            'index' => self::EVENT_INDEX,
            'type'  => self::EVENT_INDEX,
            'id'    => $data['name'],
            'body'  => $data,
        ]);
    }

    public function delete(string $name): void
    {
        try {
            $this->elastic->delete([
                'index' => self::EVENT_INDEX,
                'type'  => self::EVENT_INDEX,
                'id'    => $name,
            ]);
        } catch (Missing404Exception $e) {
            //just a stub
        }
    }

    public function clear(): void
    {
        try {
            $this->elastic->indices()->delete(['index' => self::EVENT_INDEX]);
        } catch (Missing404Exception $e) {
            //just a stub
        }
    }
}
