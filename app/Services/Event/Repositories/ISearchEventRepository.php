<?php


namespace App\Services\Event\Repositories;


use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ISearchEventRepository
 * @package App\Services\Event\Repositories
 */
interface ISearchEventRepository
{
    /**
     * Возвращает все события
     *
     * @return Collection
     */
    public function getEvents(): Collection;

    /**
     * @param array $conditions
     * @return Collection
     */
    public function searchEvents(array $conditions): Collection;

    /**
     * Возвращает событие по условию: параметры у события должны совпасть с пришедшими параметрами в $conditions
     * если таких событий несколько, то выбрать с наибольшим приоритетом 'priority', который есть у события
     * @param array $conditions
     * @return Event
     */
    public function getEventByCondition(array $conditions): Event;
}
