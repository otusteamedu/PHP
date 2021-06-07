<?php


namespace App\Http\Api;


use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class OrderController extends Controller
{
    public function add(Request $request)
    {
        $data  = $this->validate($request, [
            'total' => 'numeric|required'
        ]);
        var_dump($data);
    }
    public function get(){
        return ['todo' => 'Method will return order'];
    }
}