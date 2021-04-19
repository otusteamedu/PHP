<?php


namespace App\Services\YouTube\Endpoints;


use App\Services\YouTube\Exceptions\YouTubeApiBadResponseException;
use Google_Client;
use Google_Service_YouTube;

abstract class BaseEndpoint
{
    protected Google_Service_YouTube $client;

    public function __construct()
    {
        $googleClient = new Google_Client();
        $googleClient->setApplicationName($_ENV['GOOGLE_APP_NAME']);
        $googleClient->setDeveloperKey($_ENV['GOOGLE_API_KEY']);

        $this->client = new Google_Service_YouTube($googleClient);
    }


    /**
     * @param mixed $response
     * @param string $expectedClass
     * @throws YouTubeApiBadResponseException
     */
    protected function throwBadResponseException($response, string $expectedClass): void
    {
        $typeResponse = gettype($response);
        $returnedObjectClass = null;
        if($typeResponse === 'object'){
            $returnedObjectClass = get_class($response);
        }

        throw new YouTubeApiBadResponseException(
            'Expected Response Instance of ' . $expectedClass . ', ' .
            ' got: ' . $returnedObjectClass ?? $typeResponse
        );
    }

    abstract public function execute(string $part, array $params);
}