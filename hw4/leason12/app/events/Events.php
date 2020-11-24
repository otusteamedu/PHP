<?php

namespace app\events;

class Events implements IEvent
{
    private $data;


    /**
     * Добавить событие
     *
     * @param int   $priority   приоритет
     * @param array $conditions параметры
     */
    public function add(int $priority, array $conditions)
    {
        $this->data[] = [
            'prio'   => $priority,
            'params' => $conditions,
        ];
    }


    /**
     * Удалить все события
     */
    public function clear()
    {
        $this->data = [];
    }


    /**
     * Получение наиболее подходящего события с максимальным приоритетом
     *
     * @param array $params
     *
     * @return mixed
     */
    public function fetchBest(array $params)
    {
        // фильтруем по параметрам
        $buf = array_filter($this->data, function ($item) use ($params) {
            $buf = array_intersect_assoc($params, $item);

            return count($buf) === count($params);
        });
        // сортируем по возрастанию приоритета
        usort($buf, function ($a, $b) {
            if ($a['prio'] === $b['prio']) {
                return 0;
            }

            return ($a['prio'] < $b['prio']) ? -1 : 1;
        });

        return array_pop($buf); // возвращаемя последний элемент, имеющий максимальный приоритет
    }


    /**
     * Загрузка данных
     * @param $data
     */
    public function load($data) {
        $this->data = $data;
    }
}