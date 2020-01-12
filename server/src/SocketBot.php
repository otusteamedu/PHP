<?php

namespace App;

class SocketBot
{
    public function sayReplyTo($message) : string
    {
        $message = str_replace(['!', '.', '?'], '', $message);
        $message = strtolower($message);

        $reply = 'Я не понимаю! Скажите что-то другое!';

        if ($message === 'привет') {
            $reply = 'И Вам здравствуйте!';
        }

        return $reply;
    }
}