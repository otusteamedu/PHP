<?php


namespace App\Services\Event\Repositories\Eloquent;


use App\Models\Event;
use App\Services\Event\Repositories\ISearchEventRepository;
use App\Services\Event\Traits\HasEventSearch;
use Illuminate\Support\Collection;

/**
 * Class EloquentSearchEventRepository
 * @package App\Services\Event\Repositories\Eloquent
 */
class EloquentSearchEventRepository implements ISearchEventRepository
{
    use HasEventSearch;

    public function getEvents(): Collection
    {
        return Event::all()->sortByDesc('priority');
    }

    public function searchEvents(array $conditions): Collection
    {
        // TODO: Implement searchEvents() method.
    }

    public function getEventByCondition(array $conditions): ?Event
    {
        $eventsList = $this->selectEventsByConditionsFromDB($conditions);
        $eventsWithConditionsArray = $this->getEventsWithConditions($eventsList);
        $checkedEvents = $this->getItemsSatisfiesConditions($eventsWithConditionsArray,$conditions);
        $event = array_filter($eventsList, function ($event) use ($checkedEvents) {
            return in_array($event->name, $checkedEvents);
        });
        $first_key = array_key_first($event);
        if (is_null($first_key)) {
            return null;
        }
        $result = (array)$event[$first_key];
        $result['conditions'] = json_decode($result['conditions'], true);
        return new Event($result);
    }

    /**
     * Выбирает строки из базы по условию совпадения в записи хотя бы одного условия из $conditions
     *
     * @param array $conditions
     * @return array
     */
    private function selectEventsByConditionsFromDB(array $conditions): array
    {
        $request = 'SELECT * FROM events WHERE ';
        $where = '';
        $orderBy = ' ORDER BY priority DESC';
        foreach ($conditions as $param => $value) {
            $where .= empty($where) ? '' : ' OR ';
            $where .= 'conditions->"$.'.$param.'" = '.$value;
        }
        return (array)\DB::select($request.$where.$orderBy);
    }

    /**
     * возвращает список событий в виде ключей массива и условий в виде массива значений
     * для каждого события
     *
     * @param $events
     * @return array
     */
    private function getEventsWithConditions($events):array
    {
        $resultEventsList = [];
        foreach ($events as $event) {
            $resultEventsList = array_merge(
                $resultEventsList,
                [$event->name => json_decode($event->conditions, true)]
            );
        }
        return  $resultEventsList;
    }

}
