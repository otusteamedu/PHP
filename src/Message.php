<?php


namespace App;


class Message
{
    const MESSAGES = [
        'Привет!',
        'Это уже было',
        'Сам такой',
        'Я бы тоже поехал',
        'Не уверен, не обгоняй',
        'Ты так считаешь?',
        'Зачем оно мне',
        'Как знать',
    ];

    public function getMessage(): string
    {
        $max = count(self::MESSAGES) - 1;

        return self::MESSAGES[rand(0, $max)];
    }

}
