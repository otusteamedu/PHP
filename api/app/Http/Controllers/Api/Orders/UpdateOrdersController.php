<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Orders;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class UpdateOrdersController extends Controller
{
    public function __invoke(Request $request, int $orderId): JsonResponse
    {
        $this->validate($request, [
            'name' => ['bail', 'required', 'string'],
        ]);
        $order = Order::find($orderId);
        if (!$order) {
            abort(404);
        }
        $order->update($request->all());
        return response()->json($order);
    }
}
