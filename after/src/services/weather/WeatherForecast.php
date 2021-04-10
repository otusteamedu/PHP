<?php


namespace Src\services\weather;

use Src\services\notification\NotificationServiceInterface;

class WeatherForecast implements WeatherForecastInterface
{
    private WeatherServiceInterface $weatherService;

    private NotificationServiceInterface $notificationService;

    public function __construct(
        WeatherServiceInterface $weatherService,
        NotificationServiceInterface $notificationService
    )
    {
        $this->weatherService = $weatherService;
        $this->notificationService = $notificationService;
    }

    public function getWeather()
    {
        $temperature = $this->weatherService->getTemperature();
        $this->notificationService->sendTemperatureMessage($temperature);
    }
}