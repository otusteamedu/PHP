<?php

namespace App\Command;

use App\Core\AbstractController;
use App\Model\ClientHandler;
use Socket\Raw\Factory as SocketFactory;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        $this->app()->logger()->writeln('Hello');
    }
}