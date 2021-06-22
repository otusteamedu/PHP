<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Orders;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class GetOrdersController extends Controller
{
    const MODELS_PER_PAGE = 10;
    const MAX_MODELS_PER_PAGE = 30;

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $limit = $request->get('limit', self::MODELS_PER_PAGE);
        $offset = $request->get('offset', 0);

        $this->validate($request, [
            'limit' => 'max:' . self::MAX_MODELS_PER_PAGE,
        ]);

        $qb = Order::query()->take($limit)->skip($offset)->orderBy('id', 'DESC');

        return response()->json($qb->get());
    }
}
