<?php

namespace RedisApp;

use RedisApp\Controller;
use RedisApp\View;

class App
{
    private Controller $run;
    private View $view;

    public function __construct()
    {
        $this->run = new Controller();
        $this->view = new View();
    }

    public function run(): void
    {
        $this->run->run();
        $this->view->view();

        echo "<pre>";
        print_r($this->view->getEv1()); // event1
        echo PHP_EOL;
        echo PHP_EOL;
        print_r($this->view->getEv2()); // event3
        echo "</pre>";
    }
}
