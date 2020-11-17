<?php

namespace App\Controllers\Api;

use App\Services\RabbitMQ;
use App\Views\ApiJsonView;
use Exception;
use JsonException;
use PhpAmqpLib\Message\AMQPMessage;

class QueueApiController extends ApiController
{
    public string $apiName = 'queue';
    protected ApiJsonView $ApiJsonView;

    protected string $wrongResponse = 'You need to use POST method with body to add message to the queue';

    //соотносит метод запроса и действие в контроллере
    protected array $actionConfig = [
        'POST' => 'sendToQueueAction',
        'DEFAULT' => 'wrongAction'
    ];


    public function __construct()
    {
        parent::__construct();
        $this->ApiJsonView = new ApiJsonView();
    }

    /**
     * @throws JsonException
     */
    protected function wrongAction(): void
    {
        $this->ApiJsonView->response($this->wrongResponse, 405);
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    protected function sendToQueueAction(): void
    {
        $channel = RabbitMQ::getAMQPChannel();
        $channel->queue_declare('post_body_queue', false, false, false, false);

        $msg = new AMQPMessage($this->formData);
        $channel->basic_publish($msg, '', 'post_body_queue');

        RabbitMQ::closeChannelAndConnection();

        $this->ApiJsonView->response('Body send to RabbitMQ', 200);
    }
}