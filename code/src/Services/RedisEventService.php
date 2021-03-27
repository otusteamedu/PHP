<?php


namespace App\Services;


use App\Model\EventModel;
use App\Model\Interfaces\EventInterface;
use App\Repository\RedisEventRepository;
use App\Services\Exceptions\EventServiceEventNotFoundException;
use App\Services\Exceptions\EventServiceParamsException;
use Psr\Container\ContainerInterface;

class RedisEventService implements Interfaces\EventServiceInterface
{
    private RedisEventRepository $repository;

    /**
     * RedisEventService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->repository = new RedisEventRepository($container);
    }


    public function addEvent(int $priority, array $params, string $event): EventInterface
    {
        if (!$priority || empty($params) || 0 === strlen($event)) {
            throw new EventServiceParamsException('Priority, Params, Event required!');
        }

        $model = new EventModel();
        $model->setPriority($priority);
        $model->setCondition($params);
        $model->setEvent($event);

        return $this->repository->create($model);
    }

    public function getEvent(array $params): EventInterface
    {
        $params = $params['params'];

        if (!isset($params['param1']) || !isset($params['param2'])) {
            throw new EventServiceParamsException('Params required');
        }
        $event = $this->repository->findMaxPriorityByParams($params);
        if (!$event) {
            throw new EventServiceEventNotFoundException('Event not found');
        }

        return $event;
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function deleteEvents(): bool
    {
        return $this->repository->drop();
    }
}
