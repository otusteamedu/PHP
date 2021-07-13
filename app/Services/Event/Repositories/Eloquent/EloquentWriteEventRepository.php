<?php


namespace App\Services\Event\Repositories\Eloquent;


use App\Models\Event;
use App\Services\Event\Repositories\IWriteEventRepository;

/**
 * Class EloquentWriteEventRepository
 * @package App\Services\Event\Repositories\Eloquent
 */
class EloquentWriteEventRepository implements IWriteEventRepository
{
    public function create(array $data): int
    {
        return Event::create($data)->id;
    }

    public function delete(string $name): bool
    {
        //Такой механизм требуется, чтобы сработал Oserver для event на удаление.
        foreach (Event::where('name',$name)->get() as $event) {
            return $event->delete();
        }
        throw new \Exception("Event doesnt present", 0);
    }

    public function deleteAll(): void
    {
        Event::truncate();
    }

}
