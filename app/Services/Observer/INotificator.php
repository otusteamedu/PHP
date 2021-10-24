<?php

namespace App\Services\Observer;

interface INotificator
{
    public function send($message): void;
}