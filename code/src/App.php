<?php
declare(strict_types=1);

namespace Src;

use Exception;

class App
{
    private array $params;

    /**
     * @throws \Exception
     */
    public function __construct(array $queryParams)
    {
        $this->validateRequest($queryParams);
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

    /**
     * @throws \Exception
     */
    private function validateRequest(array $data)
    {
        if (empty($data['email'])) {
            throw new Exception('Email field if required', 400);
        }
    }
}