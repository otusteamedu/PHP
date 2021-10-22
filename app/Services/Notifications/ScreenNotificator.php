<?php

namespace App\Services\Notifications;


use App\Services\Observer\INotificator;


class ScreenNotificator implements INotificator
{
    /**
     * @param $message
     */
    public function send($message): void
    {
        echo "<pre>$message</pre>";
    }
}