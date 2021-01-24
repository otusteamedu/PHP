<?php


namespace App\Http\Controllers;


use App\Jobs\OrdersJob;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @OA\Post (
     *     path="/order/new",
     *     @OA\Response(
     *         response="200",
     *         description="Create new order",
     *         @OA\JsonContent(
     *          @OA\Property(property="status", type="string"),
     *           @OA\Property(
     *               property="order",
     *                  @OA\Property(property="id", type="integer"),
     *           )
     *       )
     *     ),
     * )
     */
    public function newOrder(): JsonResponse
    {
        $order = new Order();
        $order->status = "new";
        $order->save();
        $id = $order->id;
        $this->dispatch(new OrdersJob($id));
        return response()->json([
            "status" => "success",
            "order" => [
                "id" => $id,
            ],
        ]);
    }

    /**
     * @OA\Post (
     *     path="/order/checkStatus",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Order id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns order status",
     *         @OA\JsonContent(
     *          @OA\Property(property="status", type="string"),
     *           @OA\Property(
     *               property="order",
     *                  @OA\Property(property="id", type="integer"),
     *                  @OA\Property(property="status", type="string"),
     *           )
     *       )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="invalid order id",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Order #{id} not found",
     *         @OA\JsonContent()
     *     ),
     * )
     */
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
