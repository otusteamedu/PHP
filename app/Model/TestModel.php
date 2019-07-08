<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
class TestModel
{
    public function test()
    {
        return DB::table("test")->get();
    }
}