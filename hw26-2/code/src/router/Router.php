<?php

namespace TimGa\hw26\router;

use TimGa\hw26\controller\RequestController;
use TimGa\hw26\controller\ResultController;
use TimGa\hw26\controller\SiteController;

class Router
{

    static function run()
    {
        if (strpos($_SERVER['REQUEST_URI'], 'send_request')) {
            (new RequestController())->createNewRequest();
            return true;
        }
        if (strpos($_SERVER['REQUEST_URI'], 'check_request')) {
            (new ResultController())->checkResult();
            return true;
        }
        (new SiteController())->index();
    }

}
