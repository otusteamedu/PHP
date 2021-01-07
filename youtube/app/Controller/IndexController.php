<?php

namespace App\Controller;

use App\Core\BaseWebController;

class IndexController extends BaseWebController
{
    public function indexAction()
    {
        $test = $this->app()->getRequest()->getQuery('test');
        return $this->view('index', ['test' => $test]);
    }
}