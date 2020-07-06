<?php


namespace App;


use App\Controllers\MainController;

class App
{
    public function run()
    {
        return new MainController();
    }
}