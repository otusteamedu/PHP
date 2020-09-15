<?php


namespace App;

use App\Client;

class App
{
    private SocketAppFactory $factory;
    private ?string $type;

    public function __construct(?string $type = null)
    {
        $this->type = $type;
        $this->factory = new SocketAppFactory();
    }

    public function run()
    {
        $this->factory->createInstance($this->type) ->run();
    }
}
