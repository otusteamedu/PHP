<?php


namespace Src;


class CommandService
{
    private array $argv;

    public function __construct(array $argv)
    {
        $this->argv = $argv;
    }

    /**
     * @throws \ErrorException
     * @throws \Exception
     */
    public function run()
    {
        if (isset($this->argv[1]) && $this->argv[1] == 'publisher') {
            $publisher = new Publisher();
            $publisher->listen();
        }
        throw new \Exception('Service not found');
    }
}