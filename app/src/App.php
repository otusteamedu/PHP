<?php

namespace Otus;

use Otus\Exceptions\AppException;
use Otus\Message\Message;
use Otus\Queue\RabbitMQ\BasicRabbitQueue;
use Otus\Request\Request;
use Otus\Response\JsonResponse;
use Otus\Validators\RequestValidator;

class App
{
    /**
     * @throws AppException
     */
    public function run ()
    {
        $request = new Request();

        if (!$request->isPost()) {
            throw new AppException('unsupported request method');
        }

        (new RequestValidator($request->getData()))->validate();
        $this->addToQueue($request->getData());
    }

    public function addToQueue(array $data)
    {
        $rabbit = new BasicRabbitQueue();
        $rabbit->addToQueue(json_encode($data));
        Message::showMessage(JsonResponse::respond(['asd'=>'asd'],201));
    }
}