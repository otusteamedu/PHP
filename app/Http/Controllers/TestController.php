<?php

namespace App\Http\Controllers;

use App\Model\TestModel;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $model = new TestModel();
        var_dump($model->test());
        die();
    }
}
