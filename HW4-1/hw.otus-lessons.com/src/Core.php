<?php


namespace App;


class Core
{
    public $response = null;

    public ?Request $request = null;

    public array $config = [];

    public $dispatcher = null;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->config = Config::getConfig();
        $router = new Router($this);
        $this->dispatcher = $router;
        $this->dispatcher->dispatch();
    }

}