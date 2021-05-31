<?php


namespace App\Services\Form;


use PhpAmqpLib\Message\AMQPMessage;

class FormEmailNotify
{

    private AMQPMessage $message;

    public function __construct(AMQPMessage $message)
    {
        $this->message = $message;
    }

    /**
     * @throws \JsonException
     */
    public function send(): void
    {
        $data = json_decode($this->message->body, true, 512, JSON_THROW_ON_ERROR);
        $time = (new \DateTime())->setTimestamp($data['time']);
        $mail = sprintf("Hi %s. We've got your request to make date from %s to %s at %s",
            $data['name'], $data['date_from'], $data['date_to'], $time->format('Y.d.m H:i:s'));
        mail($data['email'], 'Data request', $mail, "From: Server");
    }


}