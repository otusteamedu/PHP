<?php

namespace App\Action;

use App\Api\ActionInterface;
use App\Api\RequestInterface;
use Exception;

class Index implements ActionInterface
{

    /**
     * @param RequestInterface $request
     * @throws Exception
     */
    public function execute(RequestInterface $request): void
    {
        $view = __DIR__.'/../view/index.php';
        if (!is_file($view)) {
            throw new Exception('View is not found');
        }
        require $view;
    }
}