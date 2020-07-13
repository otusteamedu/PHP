<?php


namespace YoutubeApp;

use YoutubeApp\Controller;
use YoutubeApp\View;

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
        print_r($this->view->getTopChannel());
        echo PHP_EOL;
        echo PHP_EOL;
        print_r($this->view->getAllDataChannel());
        echo "</pre";
    }
}
