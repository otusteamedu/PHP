<?php

namespace Otus\Controllers;

use Otus\Basic\Request;
use Otus\Basic\Response;

/**
 * Class BaseController
 * @package Otus\Controllers
 */
class BaseController
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Response
     */
    private $response;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param $method
     */
    public function __call($method, $args)
    {
        $methods = get_class_methods(static::class);
        if (in_array($method . 'Action', $methods)) {
            $this->{$method . 'Action'}();
        } else {
            $this->response->setContent('Unknown method ' . $method);
            $this->response->setStatusCode(404);
            $this->response->send();
            exit();
        }
    }

    /**
     * Default index action
     */
    public function indexAction()
    {
        $response = new Response();
        $response->setContent('index page of ' . static::class);
        $response->send();
    }
}