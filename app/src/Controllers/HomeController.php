<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()  : string
    {
        $this->content = $this->renderView('/pages/home');
        $this->title = 'Home page';

        $redis = new \Redis();

        $redis->connect('redis', 6379);

        return $this->viewResponse();
    }

    public function pageNotFound() : string
    {
        $this->content = $this->renderView('/pages/404');
        $this->title = 'Page Not Found';

        return $this->viewResponse();
    }

}