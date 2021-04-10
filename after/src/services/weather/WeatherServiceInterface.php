<?php

namespace Src\services\weather;

interface WeatherServiceInterface
{
    public function getTemperature(): int;
}