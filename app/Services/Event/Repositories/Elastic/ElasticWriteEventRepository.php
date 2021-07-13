<?php


namespace App\Services\Event\Repositories\Elastic;


use App\Models\Event;
use App\Services\Event\Repositories\IWriteEventRepository;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;

/**
 * Class ElasticWriteEventRepository
 * @package App\Services\Event\Repositories\Elastic
 */
class ElasticWriteEventRepository implements IWriteEventRepository
{
    /**
     * @var Client
     */
    private Client $elasticSearch;

    /**
     * @var Event
     */
    private Event $event;

    /**
     * ElasticWriteEventRepository constructor.
     * @param Client $elasticSearch
     */
    public function __construct(Client $elasticSearch)
    {
        $this->elasticSearch = $elasticSearch;
        $this->event = new Event();
    }

    public function create(array $data): int
    {
        try {
            $this->elasticSearch->index([
                'index' => $this->event->getElasticIndexName(),
                'type'  => $this->event->getElasticIndexType(),
                'id'    => $data['name'],
                'body'  => $data
            ]);
            return 1;
        } catch (Missing404Exception $ex) {
            echo $ex->getMessage();
        }
        return 0;
    }

    public function delete(string $name): bool
    {
        try {
            $delete = $this->elasticSearch->delete([
                'index' => $this->event->getElasticIndexName(),
                'type'  => $this->event->getElasticIndexType(),
                'id'    => $name,
            ]);
            return true;
        } catch (Missing404Exception $ex) {
            if ($ex->getCode() == 404) throw new \Exception("Event doesnt present", 0);
        }
    }

    public function deleteAll(): void
    {
        try {
            $this->elasticSearch->indices()->delete(['index' => $this->event->getElasticIndexName()]);
        } catch (Missing404Exception $ex) {

        }
    }

}
