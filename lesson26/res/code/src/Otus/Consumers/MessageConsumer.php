<?php


namespace Otus\Consumers;


use Exception;
use Otus\Models\Message;
use Otus\Utils\Rabbit;

class MessageConsumer extends BasicConsumer
{

    protected $scriptName = 'messageConsumerScript';

    public function __construct()
    {
        parent::__construct();
        $this->queue = Message::getQueueName();
    }

    public function processMessage($msg)
    {
        $message = json_decode($msg->body);
        try {
            sleep(mt_rand(2, 20));
            $id = $message->id;
            $item = Message::findById($id);
            $item->status = mt_rand(Message::STATUS_ACCEPTED, Message::STATUS_REJECTED);
            $item->save();
        } catch (Exception $exc) {
            $message = (array)$message;
            if (array_key_exists('rebuild', $message)) {
                $message['rebuild'] = (int)$message['rebuild'] + 1;
            } else {
                $message['rebuild'] = 1;
            }
            $message = json_encode($message);
            //повторно отсылаем сообщение с фейлом
            Rabbit::sendMesage(Message::getQueueName(), $message);
        }
    }
}