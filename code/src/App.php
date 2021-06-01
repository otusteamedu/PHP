<?php
declare(strict_types = 1);

namespace Src;

class App
{
    private array $params;

    public function __construct(array $queryParams)
    {
        $this->params = $queryParams;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        $consumer = new Consumer();
        $consumer->send($this->params['email']);
    }
}