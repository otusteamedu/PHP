<?php


namespace Service\Core;

use Service\Controllers\HomeController;

class Router
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getResponse() : Response
    {
        $controller = HomeController::class;

        $uri = $this->request->getServer()['REQUEST_URI'];

        switch ($uri){
            case '/validate':
                $action = 'validate';
                break;
            case '/success':
                $action = 'showSuccess';
                break;
            case '/error':
                $action = 'showError';
                break;
            default:
                $action = 'show';
                break;
        }

        return new Response($controller, $action);
    }
}