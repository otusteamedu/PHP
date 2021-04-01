<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()  : string
    {
        $this->content = $this->renderView('/pages/home');
        $this->title = 'Home page';

        return $this->viewResponse();
    }

    public function pageNotFound() : string
    {
        $this->content = $this->renderView('/pages/404');
        $this->title = 'Page Not Found';

        return $this->viewResponse();
    }

}