<?php


namespace App\Http\Api;


use App\Models\Order;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;

class OrderController extends BaseController
{

    /**
     * @OA\Post (
     *     path="/api/orders/",
     *     summary="Create a new post",
     *     tags={"order"},
     *    @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"price"},
     *       @OA\Property(property="price", type="boolean", example="100000"),
     *    ),
     * ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="price", type="string", example="The price field is required")
     *        )
     *     )
     * )
     * )
     */
    public function add(Request $request, OrderService $service)
    {
        $data = $this->validate($request, [
            'price' => 'numeric|required'
        ]);
        return $service->create(new Order($data))->toArray();
    }

    /**
     * @OA\Get(
     * path="/api/orders/{id}",
     * summary="Retrieve the order",
     * description="Get order by id",
     * tags={"order"},
     * @OA\Parameter(
     *    description="ID of order",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="93a268d1-16e1-42fa-b445-fce2f0ba016e",
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *  ),
     * @OA\Response(
     *    response=404,
     *    description="Page not found",
     *  )
     * )
     */
    public function get($id)
    {
        return Order::findOrFail($id)->toArray();
    }
}