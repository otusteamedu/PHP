<?php

namespace Src\services\notification;

interface NotificationServiceInterface
{
    public function sendTemperatureMessage(float $temperature);
}