<?php


namespace App\Http\Api;


use App\Models\Order;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class OrderController extends Controller
{
    public function add(Request $request, OrderService $service)
    {
        $data  = $this->validate($request, [
            'price' => 'numeric|required'
        ]);
        return $service->create(new Order($data))->toArray();
    }
    public function get($id){
        return Order::find($id);
    }
}