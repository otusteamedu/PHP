<?php


namespace App\Http\Controllers;

use App\Order;
use App\OrderDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Order::all());
    }

    public function show(int $id): JsonResponse
    {
        $order = Order::find($id);
        $result = [
            'id' => $order->id,
            'processed' => $order->processed
        ];
        return response()->json($result);
    }

    public function create(Request $request): JsonResponse
    {
        $order = new Order;
        $order->product_name= $request->get('product_name');
        $order->quantity = $request->get('quantity');
        $order->total= $request->get('total');
        $order->save();
        event(new \App\Events\OrderCreated($order));
        return response()->json(['id' => $order->id]);
    }

    public function delete(int $id): JsonResponse
    {
        $order = Order::findOrFail($id);
        event(new \App\Events\OrderDeleted($order));
        return response()->json(['id' => $order->id]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $order = Order::findOrFail($id);
        $newOrder = new OrderDTO(
            $order->id,
            $request->get('product_name'),
            $request->get('quantity'),
            $request->get('total'),
            (bool) $request->get('processed')
        );
        event(new \App\Events\OrderUpdated($order, $newOrder));
        return response()->json(['id' => $order->id]);
    }
}
