<?php

namespace Src\services\weather;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class YandexWeatherService implements WeatherServiceInterface
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTemperature(): int
    {
        try {
            $response = $this->client->request('GET', $_ENV['yandex_api_uri'], [
                'query' => [
                    'lat' => $_ENV['lat'],
                    'lon' => $_ENV['lon'],
                    'lang' => 'ru_RU',
                    'limit' => $_ENV['yandex_api_days_limit']
                ],
                'headers' => [
                    'X-Yandex-API-Key' => $_ENV['yandex_api_key']
                ]
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
            return (int)$result['fact']['temp'];
        } catch (BadResponseException $e) {
            echo $e->getMessage();
        }
    }
}