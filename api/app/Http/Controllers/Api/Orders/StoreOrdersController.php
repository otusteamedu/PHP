<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Orders;

use App\Jobs\ProceedOrderJob;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class StoreOrdersController extends Controller
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => ['bail', 'required', 'string'],
        ]);
        $order = Order::create($request->all());
        $this->dispatch(new ProceedOrderJob($order));
        return response()->json($order);
    }
}
