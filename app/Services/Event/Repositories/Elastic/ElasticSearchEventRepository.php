<?php

namespace App\Services\Event\Repositories\Elastic;

use App\Models\Event;
use App\Services\Event\Repositories\ISearchEventRepository;
use App\Services\Event\Traits\HasElasticQueries;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class ElasticSearchEventRepository
 * @package App\Services\Event\Repositories\Elastic
 */
class ElasticSearchEventRepository implements ISearchEventRepository
{
    use HasElasticQueries;
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

    public function getEvents(): Collection
    {
        try {
            $items = $this->elasticSearch->search([
                'index' => $this->event->getElasticIndexName(),
                'type'  => $this->event->getElasticIndexType(),
                'body'  => ['query' => $this->queryGetAllEvents()],
                'size'  => 200,
            ]);
            return $this->buildCollection($items)
                ->sortByDesc('priority');
        } catch (Missing404Exception $ex) {
            return collect();
        }
    }

    public function searchEvents(array $conditions): Collection
    {
        try {
            $items = $this->elasticSearch->search([
                'index' => $this->event->getElasticIndexName(),
                'type'  => $this->event->getElasticIndexType(),
                'body'  => ['query' => $this->queryGetEventsByConditions($conditions)]
            ]);
            return collect(Arr::pluck($items['hits']['hits'], '_source'))
                ->sortByDesc('priority')->filter(static function ($event) use ($conditions) {
                    return collect($event['conditions'])->diffAssoc($conditions)->isEmpty();
                });
        } catch (Missing404Exception $ex) {
            return collect();
        }
    }

    public function getEventByCondition(array $conditions): ?Event
    {
        $event = $this->searchEvents($conditions)->first();
        return !is_null($event) ? new Event($event) : null ;
    }

    /**
     * Возвращает коллекцию из событий на основе $items
     *
     * @param array $items
     * @return Collection
     */
    private function buildCollection(array $items): Collection
    {
        $events = Arr::pluck($items['hits']['hits'], '_source');
        $eventsCollection = collect();
        foreach ($events as $event) {
            $eventsCollection->add(new Event($event));
        }
        return $eventsCollection;
    }
}
