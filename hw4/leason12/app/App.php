<?php
/**
 * Пример работы с хранилищем
 *
 * @author Petr Ivanov (petr.yrs@gmail.com)
 */

use app\storage\RedisStorage;
use app\events\Events;

class App
{
    /**
     * @var RedisStorage
     */
    private $storage;
    /**
     * @var Events
     */
    private $events;


    public function __construct()
    {
        $this->storage = new RedisStorage();
        $this->events  = new Events();
    }


    public function run()
    {
        // заполнение случайными данными
        $this->randomFill();

        // очистить события
        $this->events->clear();

        // загрузить из хранилища
        $this->events->load($this->storage->fetchAll());

        $param = [
            'param1' => random_int(1, 3),
            'param2' => random_int(1, 3),
        ];
        // получить лучшее событие
        $best = $this->events->fetchBest($param);

        print_r([
            'Input param' => $param,
            'Best event'  => $best,
        ]);
    }


    /**
     * Генерирование случайных данных
     */
    private function randomFill()
    {
        $total = random_int(100, 1000);
        $i     = 0;
        while ($i < $total) {
            $priority = random_int(0, 10);
            $params   = [
                'param1' => random_int(1, 3),
                'param2' => random_int(1, 3),
            ];
            $this->events->add($priority, $params);

            $i++;
        }
        $this->storage->save($this->events);
    }
}