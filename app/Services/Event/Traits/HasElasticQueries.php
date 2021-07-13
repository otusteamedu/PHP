<?php


namespace App\Services\Event\Traits;

/**
 * Trait HasElasticQueries
 * возвращает ряд запросов для Elasticsearch
 *
 * @package App\Services\Event\Traits
 */
trait HasElasticQueries
{
    /**
     * Возвращает запрос для поиска всех Событий в репозитории
     *
     * @return array[]
     */
    private function queryGetAllEvents(): array
    {
        return [
            'query_string' => [
                'fields' => [
                    'name',
                ],
                'query' => '*',
            ],
        ];
    }

    /**
     * Возвращает запрос для поиска событий по условиям в репозитории
     * @param array $conditions
     * @return array|\array[][]
     */
    private function queryGetEventsByConditions(array $conditions): array
    {
        $query = ['bool' => ['should' => []]];
        foreach ($conditions as $key => $value) {
            $query['bool']['should'][] = ['term' => ["conditions.$key" => $value]];
        }
        return $query;
    }
}
