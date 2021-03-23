<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class StoreController
{

    public function index()
    {
        return view('store.index');
    }

    public function store(Request $request)
    {
        $data = $request->post('event');
        $event = $data['event_name'];
        $priority = $data['priority'];
        $conditions = $data['conditions'];
        $key = $this->getKet($conditions);
        Redis::zadd($key, $priority, $event);
        var_dump(Redis::zrevrange($key, 0, 5));
        die();
    }

    private function getKet(array $conditions)
    {
        if (!empty($conditions)) {
            $key = [];
            foreach ($conditions as $condition) {
                array_push($key, $condition['key'], $condition['value']);
            }
            return implode(':', $key);
        }
        return false;
    }
}
