<?php


namespace App\Controllers;


use App\Entities\Event;
use App\Repositories\Event\EventRepository;
use App\Services\ServiceContainer\AppServiceContainer;

class EventController extends BaseController
{
    private EventRepository $eventRepository;

    public function __construct()
    {
        $this->eventRepository = AppServiceContainer::getInstance()->resolve(EventRepository::class);
    }

    public function index() : string
    {
        $this->title = 'Events';

        $events = $this->eventRepository->getAll();
        $this->content = $this->renderView('pages.events.index', [
            'events' => $events,
        ]);

        return $this->viewResponse();
    }

    public function create() : string
    {
        $this->content = $this->renderView('pages.events.create');
        $this->title = 'Create Event';

        return $this->viewResponse();
    }

    public function store() : string
    {
        $request = $this->getRequest();
        $name = $request->get('name');
        $priority = $request->get('priority');
        $params = $request->get('params');

        $event = new Event();
        $event->setName($name);
        $event->setPriority($priority);
        $event->setParams(explode(',', $params));

        $this->eventRepository->save($event);

        return $this->redirect('events');
    }

    public function flush() : string
    {
        $this->eventRepository->flushAll();

        return $this->redirect('events');
    }

    public function search() : string
    {
        $this->content = $this->renderView('pages.events.search');
        $this->title = 'Search Event';

        return $this->viewResponse();
    }
}