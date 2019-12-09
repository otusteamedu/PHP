<?php

namespace App\Http\Controllers;

use App\Contracts\Storage;
use App\Entities\Event;
use App\Http\Requests\Event\{CreateRequest, SearchRequest};
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    protected $storage;

    /**
     * @param Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * @param SearchRequest $request
     * @return Factory|View
     */
    public function search(SearchRequest $request)
    {
        $event = null;

        if ($conditions = $request->conditions()) {
            $event = $this->storage->find($conditions) ?? false;
        }

        return view('events.search', compact('event'));
    }

    /**
     * @param CreateRequest $request
     * @return RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $event = (new Event)
            ->setName($request->data()['name'])
            ->setPriority($request->data()['priority'])
            ->setConditions($request->data()['conditions']);

        $result = $this->storage->insert($event);

        $redirect = redirect()->route('home');

        if ($result === true) {
            return $redirect->with('success', 'Event saved.');
        } else {
            return $redirect->with('error', 'Error while saving event.');
        }
    }

    /**
     * @return RedirectResponse
     */
    public function clear()
    {
        $this->storage->clear();

        return redirect()->route('home')->with('success', 'All events cleared.');
    }
}
