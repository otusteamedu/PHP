<?php


namespace App\Services;


use App\Model\Event;
use App\Model\Interfaces\ModelEventInterface;
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

    /**
     * @param int $priority
     * @param array $params
     * @param string $event
     * @return ModelEventInterface
     */
    public function addEvent(int $priority, array $params, string $event): ModelEventInterface
    {
        if (!$priority || empty($params) || 0 === strlen($event)) {
            throw new EventServiceParamsException('Priority, Params, Event required!');
        }

        $model = new Event();
        $model->setPriority($priority);
        $model->setCondition($params);
        $model->setEvent($event);

        return $this->repository->create($model);
    }

    /**
     * @param array $params
     * @return ModelEventInterface
     * @throws EventServiceEventNotFoundException
     */
    public function getEvent(array $params): ModelEventInterface
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

    /**
     * @return ModelEventInterface[]
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @return bool
     */
    public function deleteEvents(): bool
    {
        return $this->repository->drop();
    }
}
