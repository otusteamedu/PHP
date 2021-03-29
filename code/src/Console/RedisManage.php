<?php


namespace App\Console;


use App\Model\Event;
use App\Model\Interfaces\ModelEventInterface;
use App\Repository\RedisEventRepository;
use Psr\Container\ContainerInterface;
use Redis;

class RedisManage extends Console
{
    private RedisEventRepository $repository;

    /**
     * RedisManage constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->repository = new RedisEventRepository($container);
    }

    public function run(): void
    {
        $cancel = false;

        while (!$cancel) {
            echo 'Generate events(gen), Get all events(get), Get event by id(i), ' .
                'Delete events(d), findByParams(f), выход (q): ';
            $answer = $this->readLine();

            switch ($answer) {
                case 'gen':
                    $this->generateEvents();
                    break;

                case 'get':
                    $this->showEvents();
                    break;

                case 'i':
                    $this->showEvent();
                    break;

                case 'd':
                    $this->repository->drop();
                    break;
                case 'f':
                    $this->showByParams();
                    break;
                case 'q':
                default:
                    $cancel = true;
            }
        }
    }

    private function showByParams(): void
    {
        echo 'Type param1: ';
        $p1 = $this->readLine();
        echo 'Type param2: ';
        $p2 = $this->readLine();

        $param1 = $p1 ? ['param1' => $p1] : [];
        $param2 = $p2 ? ['param2' => $p2] : [];
        $params = array_merge($param1, $param2);

        if (!$params) {
            echo 'Not found', PHP_EOL;
            return;
        }

        $events = $this->repository->findByParams($params);
        $this->printEvents($events);

    }

    private function showEvents(): void
    {
        $events = $this->repository->findAll();
        $this->printEvents($events);
    }

    private function showEvent(): void
    {
        echo 'Type id: ';
        $id = $this->readLine();
        $event = $this->repository->findOne($id);
        $this->printEvents([$event]);
    }

    private function generateEvents(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $model = new Event();
            $model->setEvent('event ' . $i);
            $model->setPriority(rand(1, 3) * 1000);

            $params1 = ['param1' => rand(1, 2)];
            $params2 = (rand(0, 1)) ? ['param2' => rand(1, 2)] : [];

            $model->setCondition(array_merge($params1, $params2));

            $this->repository->create($model);
        }
    }

    private function printEvents(array $events): void
    {
        foreach ($events as $event) {
            print_r($event->toArray());
        }
    }
}
