<?php

namespace App\Services\Event\Traits;

/**
 * Trait HasEventSearch
 * @package app\Services\Event\Repositories\Traits
 */
trait HasEventSearch
{
    /**
     * Возвращает ключи массива $items отфильтрованного массива по принципу
     * $items['ключ'=> array[
     *                  'параметр1'=>'Значение1'
     *                  'параметр2'=>'Значение2'
     *                ]
     *       ]
     * параметры и значения должны полностью находиться в массиве
     * $conditions [
     *                  'параметр1'=>'Значение1'
     *                  'параметр2'=>'Значение2'
     *                  'параметрN'=>'ЗначениеX'
     *             ]
     *
     * Принцип работы следующий: 'параметрN'=>'ЗначениеX' - назовем условием.
     * Фильтруем массив $items, по принципу, что количество условий в элементе 'ключ'
     * должно быть равно количеству условий в отфильтрованном массиве $conditions, где остались
     * только те условия, которые совпали с условиями у элемента 'ключ'
     *
     * @param array $items
     * @param array $conditions
     * @return int[]|string[]
     */
    private function getItemsSatisfiesConditions(array $items, array $conditions): Array
    {
        return array_keys(
            array_filter($items, function ($val) use ($conditions) {
                $checkedConditions = array_filter($conditions, function ($value, $param) use ($val) {
                    return isset($val[$param]) && $val[$param] == $value;
                }, ARRAY_FILTER_USE_BOTH);
                return count($checkedConditions) == count($val);
            }));
    }
}
