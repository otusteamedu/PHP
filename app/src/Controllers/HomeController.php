<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()  : void
    {
        $this->content = $this->renderView('/pages/home');
        $this->title = 'Home page';

         $this->viewResponse();
    }

    public function pageNotFound() : void
    {
        $this->content = $this->renderView('/pages/404');
        $this->title = 'Page Not Found';

         $this->viewResponse();
    }

}