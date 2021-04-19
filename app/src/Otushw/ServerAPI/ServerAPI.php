<?php


namespace Otushw\ServerAPI;

use Otushw\Queue\QueueProducerInterface;
use Otushw\ServerAPI\Exception\ServerAPIException;
use Otushw\ServerAPI\Router\ControllerFactory;
use Otushw\ServerAPI\Router\RouterFactory;
use Psr\Http\Message\ServerRequestInterface;
use Otushw\AppInstanceAbstract;
use Symfony\Component\HttpFoundation\JsonResponse;

class ServerAPI extends AppInstanceAbstract
{
    protected QueueProducerInterface $queueProducer;
    protected ServerRequestInterface $request;
    protected ControllerFactory $controllerFactory;

    public function __construct()
    {
        try {
            parent::__construct();
            $request = Request::getInstance();
            $router = RouterFactory::create();
            $controllerFactory = $router->process($request);
            $request = $request->withAttribute('id', $controllerFactory->getID());

            $this->request = $request;
            $this->controllerFactory = $controllerFactory;
        }
        catch (ServerAPIException $e) {
            $response = JsonResponse::create($e->getMessage(), 500);
            $response->send();
        }
    }

    public function run()
    {
        try {
            $queueProducer = $this->queueFactory->createProducer();
            $controller = $this->controllerFactory->getController($queueProducer);
            $action = [$controller, $this->controllerFactory->getAction()];
            $response = $action($this->request);
        }
        catch (ServerAPIException $e) {
            $response = JsonResponse::create($e->getMessage(), 500);
            $response->send();
        }
        $response->send();
    }

}