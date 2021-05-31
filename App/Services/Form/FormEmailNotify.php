<?php


namespace App\Services\Form;


use PhpAmqpLib\Message\AMQPMessage;

class FormEmailNotify
{
    /**
     * @param \PhpAmqpLib\Message\AMQPMessage $message
     * @throws \JsonException
     */
    public static function send(AMQPMessage $message): void
    {
        $body = json_decode($message->body, true, 512, JSON_THROW_ON_ERROR);
        $time = (new \DateTime())->setTimestamp($body['time']);
        $mail = sprintf("Hi %s. We've got your request to make date from %s to %s at %s",
            $body['name'], $body['date_from'], $body['date_to'], $time->format('Y.d.m H:i:s'));
        mail($body['email'], 'Data request', $mail, "From: Server");
    }
}