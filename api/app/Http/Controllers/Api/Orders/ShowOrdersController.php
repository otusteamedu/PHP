<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Orders;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class ShowOrdersController extends Controller
{
    public function __invoke(int $orderId): JsonResponse
    {
        $order = Order::find($orderId);
        if (!$order) {
            abort(404);
        }
        return response()->json($order);
    }
}
