<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\Event\EventService;

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
        $event = $this->eventService->getEventByCondition($request->all());
        dd($event);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //dd($request->all());
        $id = $this->eventService->create($request->all());
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
    }

    public function seedredis()
    {
        $events = Event::All();
        $this->eventService->deleteAll();
        foreach ($events as $event) {
            $this->eventService->create($event->getAttributes());
        }

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
}
