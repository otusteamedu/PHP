<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\Event\EventService;
use Illuminate\Support\Collection;
use View;
use function PHPUnit\Framework\isNull;

class EventController extends Controller
{
    /**
     * Хендлер объекта по работе с репозиторием Event
     * @var EventService
     */
    private EventService $eventService;

    /**
     * EventController constructor.
     * @param EventService $eventService
     */
    public function __construct(
        EventService $eventService
    )
    {
        $this->eventService = $eventService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conditions = [];
        $search = $request->get('q', '');
        $parameters = preg_split("/[\s,]+/", $search);
        foreach ($parameters as $parameter) {
            $conditions += $this->getConditionFromString($parameter);
        }
        $event = $this->eventService->getEventByCondition($conditions);
        $events = !is_null($event)
            ? collect([0 => $event])
            : collect();

        view::share([
            'events' => $events,
            'search' => $search,
        ]);
        return view('events.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $parameters = $request->all();
        $parameters['conditions'] = $this->getParametersForConditionFromAllParametrs($parameters);
        $id = $this->eventService->create($parameters);
        echo "Событие с id="
            . $id
            . " успешно добавлено!";
    }

    public function delete($item)
    {
        try {
            $this->eventService->delete($item);
            echo "Событие "
                . $item
                . " успешно удалено!";
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function clear()
    {
        $this->eventService->deleteAll();
        echo "Data cleared successfully!";
    }

    public function seedredis()
    {
        echo "<pre>";
        echo "Starting seeder" . PHP_EOL;
        $events = Event::All();
        $this->eventService->deleteAll();
        foreach ($events as $event) {
            $this->eventService->create($event->toArray());
        }
        echo "It's done" . PHP_EOL;
    }

    public function showall()
    {
        $events = $this->eventService->getEvents();
        view::share([
            'events' => $events,
        ]);
        return view('events.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }

    /**
     * Возвращает массив параметров param(n) и значений.
     * типа ['param1'=>1,'param2'=>5]
     *
     * @param $params
     * @return array
     */
    private function getParametersForConditionFromAllParametrs(array $params): array
    {
        //Берем все ключи, которые начинаются на param
        $result = array_filter($params, function($key) {
            return str_starts_with($key, 'param');
        }, ARRAY_FILTER_USE_KEY);
        //Возвращается массив с преобразованными строковыми значениями в числовые
        return array_map('intval', $result);
    }

    private function getConditionFromString(string $param): array
    {
        $result = explode('=', $param);
        $condition = [];
        if (isset($result[0]) && isset($result[1])) {
            $condition = [
                $result[0] => $result[1]
            ];
        }
        return $condition;
    }
}
