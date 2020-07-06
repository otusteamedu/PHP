<?php


namespace App;


use App\Controllers\YoutubeController;

class App
{
    public function run()
    {
        return new YoutubeController();
    }
}