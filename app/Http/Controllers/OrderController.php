<?php


namespace App\Http\Controllers;


use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function newOrder(): JsonResponse
    {
        $order = new Order();
        $order->status = "new";
        $order->save();
        $id = $order->id;

        return response()->json([
            "status" => "success",
            "order" => [
                "id" => $id,
            ],
        ]);
    }


    public function checkStatus(Request $request): JsonResponse
    {
        $id = (int)$request->input('id');
        if ($id < 1) {
            return response()->json([
                "status" => "error",
                "message" => "invalid order id",
            ], 400);
        }

        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                "status" => "error",
                "message" => "Order #{$id} not found",
                "order" => [
                    "id" => $id,
                ],
            ], 404);
        }

        return response()->json([
            "status" => "success",
            "order" => [
                "id" => $id,
                "status" => $order->status,
            ],
        ]);
    }

}
