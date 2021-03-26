<?php


namespace Otushw\ServerAPI;

use Gridonic\JsonResponse\ErrorJsonResponse;
use Gridonic\JsonResponse\SuccessJsonResponse;
use Otushw\Queue\QueueProducerInterface;
use Otushw\ServerAPI\Router\ControllerFactory;
use Otushw\ServerAPI\Router\RouterFactory;
use Otushw\Storage\OrderMapper;
use Psr\Http\Message\ServerRequestInterface;
use Otushw\AppInstanceAbstract;

class ServerAPI extends AppInstanceAbstract
{
    protected QueueProducerInterface $queueProducer;
    protected ServerRequestInterface $request;
    protected ControllerFactory $controllerFactory;


    public function __construct()
    {
//        try {

        parent::__construct();

        $request = Request::getInstance();
        $router = RouterFactory::create();
        $controllerFactory = $router->process($request);
        $request = $request->withAttribute('id', $controllerFactory->getID());

        $this->request = $request;

        $this->controllerFactory = $controllerFactory;



//        var_dump($_ENV['routes']);
////        $this->queueProducer = $this->queueFactory->createProducer();
//        // get HTTP-message
//        // get Router
//
////        $this->getRequest();
//////        $var = $this->request->getParsedBody(); // post
////          $method = $this->request->getMethod(); // post
////        print_r($method);
////        $json = $this->request->getBody()->getContents(); // post
////        print_r($json);
////        var_dump(json_decode($json, true));
//
//        $data = array(
//            'post' => array(
//                'id' => 1,
//                'title' => 'A blog post',
//            )
//        );
////        $message = 'The Blog post was successfully created.';
////        $title = 'Successfully created!';
//        $statusCode = 205;
//        $res = new ErrorJsonResponse($data, 'aaaaaaaaaa ');
//        }
//catch (\Exception $e) {
//        $res->send();
//}
    }

    public function run()
    {
        $controller = $this->controllerFactory->getController();
        $action = [$controller, $this->controllerFactory->getAction()];
        $action($this->request);
    }

}