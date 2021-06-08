<?php
declare(strict_types=1);

namespace Src;

class App
{
    private array $params;

    private ?array $argv;

    /**
     * @throws \Exception
     */
    public function __construct(array $queryParams, ?array $argv)
    {
        $this->argv = $argv;
        $this->params = $queryParams;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        if (!empty($this->argv)) {
            $service = new CommandService($this->argv);
            $service->run();
        } else {
            RequestValidator::validate($this->params);
            $consumer = new Consumer();
            $consumer->send($this->params['email']);
        }
    }
}