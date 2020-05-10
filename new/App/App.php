<?php

class App {
    private Base $f3;

    public function __construct() {
        $this->f3 = Base::instance();
    }

    private function setRoutes() {
        $this->f3->route("GET /", "Main->index");
    }

    public function run() {
        $this->setRoutes();

        $this->f3->set("name", "Tataisneft");

        $this->f3->run();
    }
}