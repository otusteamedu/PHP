<?php


namespace App\Services\Event\Repositories\Eloquent;


use App\Models\Event;
use App\Services\Event\Repositories\ISearchEventRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EloquentSearchEventRepository
 * @package App\Services\Event\Repositories\Eloquent
 */
class EloquentSearchEventRepository implements ISearchEventRepository
{

    public function getEvents(): Collection
    {
        return Event::all();
    }

    public function searchEvents(array $conditions): Collection
    {
        // TODO: Implement searchEvents() method.
    }

    public function getEventByCondition(array $conditions): Event
    {
        $request = 'SELECT * FROM events WHERE ';
        $where = '';
        $orderBy = ' ORDER BY priority DESC LIMIT 1';
        foreach ($conditions as $param => $value) {
            $where .= empty($where) ? '' : ' OR ';
            $where .= 'conditions->"$.'.$param.'" = '.$value;
        }

        $result = (array)\DB::select($request.$where.$orderBy)[0] ?? [];
        $result['conditions'] = json_decode($result['conditions'], true);
        return new Event($result);
    }

}
