<?php

namespace App;

use App\Action\Index;
use App\Action\Validate;
use App\Api\ActionInterface;
use App\Api\ApplicationInterface;
use App\Api\RequestInterface;
use App\Model\SequenceValidator;

class Application implements ApplicationInterface
{
    private RequestInterface $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function run(): void
    {
        $actionName = $this->request->getQuery('r', 'index');
        $action = $this->determineAction($actionName);
        $action->execute($this->request);
    }

    private function determineAction(string $actionName): ActionInterface
    {
        switch ($actionName) {
            case 'validate':
                return new Validate(new SequenceValidator());
            default:
                return new Index();
        }
    }
}