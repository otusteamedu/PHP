<?php


namespace Repetitor202\Domain\Services\Events;


use Repetitor202\Domain\DTO\EventSearchDTO;
use Repetitor202\Domain\DTO\EventStoreDTO;
use Repetitor202\Domain\Repositories\Events\EventsRedisRepository;
use Repetitor202\Domain\Repositories\Events\IEventsRepository;

class EventServise
{
    private IEventsRepository $repository;

    public function __construct()
    {
        $this->repository = new EventsRedisRepository();
    }

    public function search(array $params): void
    {
        $searchDto = new EventSearchDTO($params);

        $eventName = $this->repository->search($searchDto);

        if(is_null($eventName)) {
            $message = 'Events with required params are not found.';
        } else {
            $message = 'Event with required params and max priority is ' . $eventName . '.';
        }

        echo $message;
    }

    public function save(array $params): void
    {
        // TODO: validation

        $storeDto = new EventStoreDTO(
            time(),
            $params['priority'],
            $params['conditions'],
            $params['name']
        );

        $transaction = $this->repository->insert($storeDto);
        print_r($transaction);
    }

    public function clean(): void
    {
        $yesNo = $this->repository->clean() ? '' : 'not ';
        echo 'The info with event is ' . $yesNo . 'deleted!';
    }
}