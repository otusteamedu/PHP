<?php
require_once 'bootstrap/app.php';

use Src\services\weather\WeatherForecast;
use Src\services\weather\YandexWeatherService;
use Src\services\notification\TelegramNotificationService;

$weatherService = new YandexWeatherService();
$notificationService = new TelegramNotificationService();
$weatherForecast = new WeatherForecast($weatherService, $notificationService);
$weatherForecast->getWeather();