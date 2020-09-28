<?php

namespace Helpers;

class ArraySort
{
    /**
     * Сортируем многомерный массив по значению вложенного массива
     * @param $array array многомерный массив который сортируем
     * @param $field string название поля вложенного массива по которому необходимо отсортировать
     * @return array отсортированный многомерный массив
     */
    public static function customMultiSort(array $array, string $field): array
    {
        $sortArr = [];
        foreach ($array as $key => $val) {
            $sortArr[$key] = $val[$field];
        }
        array_multisort($sortArr, SORT_DESC,  $array);
        return $array;
    }
}