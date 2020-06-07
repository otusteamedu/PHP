<?php

namespace App;

use App\Action\Index;
use App\Action\Validate;
use App\Api\ActionInterface;
use App\Api\ApplicationInterface;
use App\Api\RequestInterface;
use App\Model\SequenceValidator;
use Exception;

class Application implements ApplicationInterface
{
    private RequestInterface $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function run(): void
    {
        $response = new HttpResponse();
        try {
            $actionName = $this->request->getQuery('r', 'index');
            $action = $this->determineAction($actionName);
            $view = $action->execute($this->request, $response);
            $response->setBody($view->render());
        } catch (Exception $exception) {
            $message = 'Internal Server Error. '.$exception->getMessage();
            $response->setBody($message)->setHttpCode(500);
        }
        $response->send();
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