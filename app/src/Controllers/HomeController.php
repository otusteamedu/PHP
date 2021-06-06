<?php

namespace App\Controllers;

use App\Services\RabbitMQ\Example;

class HomeController extends BaseController
{
    public function index()  : string
    {
        $this->content = $this->renderView('/pages/home');
        $this->title = 'Home page';
        Example::init();

        return $this->viewResponse();
    }

    public function pageNotFound() : string
    {
        $this->content = $this->renderView('/pages/404');
        $this->title = 'Page Not Found';

        return $this->viewResponse();
    }

}