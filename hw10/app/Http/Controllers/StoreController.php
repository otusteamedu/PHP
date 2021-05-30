<?php


namespace App\Http\Controllers;


use App\Services\Events\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class StoreController
{
    private EventService $event_service;

    public function __construct(EventService $event_service)
    {
        $this->event_service = $event_service;
    }

    public function index()
    {
        return view('store.index');
    }

    public function store(Request $request)
    {
        $data = $request->post('event');
        $result = $this->event_service->store($data);
        $this->setFlash($request, $result);

        return redirect('/');
    }

    public function get(Request $request)
    {
        $conditions = $request->get('conditions');
        if ($conditions) {
            $event = $this->event_service->getOne($conditions);
        }
        return view('store.get', ['event' => $event ?? '']);
    }

    public function flush()
    {
        $this->event_service->flush();
        return redirect('/');
    }

    private function setFlash(Request $request, int $result)
    {
        if ($result == 1) {
            $request->session()->flash('success', 'The event was store successfully.');
        } elseif ($result == 0) {
            $request->session()->flash('success', 'The event was update successfully.');
        } else {
            $request->session()->flash('failed', 'The event was not store.');
        }
    }
}
