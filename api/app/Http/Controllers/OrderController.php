<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkStatus(Request $request)
    {
        $orderId = $request->get('order_id');
        $status = '';
        if ($orderId) {
            $order = $this->getOrderRequest(intval($orderId));
            if (!empty($order)) {
                $status = $order['status'];
            }
        }
        return view('orders.check_form', ['status' => $status]);
    }

    public function create()
    {
        return view('orders.create_form');
    }


    public function createOrder(Request $request)
    {
        $response = $this->createOrderRequest($request->all());
        return view('orders.check_form', ['orderId' => $response['id']]);
    }

    private function createOrderRequest(array $data)
    {

        $request = Request::create('/api/v1/orders', 'post', $data);
        return json_decode(app()->handle($request)->getContent(), true);
    }

    private function getOrderRequest(int $orderId)
    {
        $request = Request::create(\route('orders.show', ['orderId' => $orderId]));
        return json_decode(app()->handle($request)->getContent(), true);
    }
}
