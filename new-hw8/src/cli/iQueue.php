<?php


namespace AYakovlev\cli;


interface iQueue
{
    public static function getConnection();
    public function sendMessageToQueue(string $data, string $template): void;
    public function getMessageFromQueue();
}