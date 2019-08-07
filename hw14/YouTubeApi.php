<?php
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new Exception(sprintf('Please run "composer require google/apiclient:~2.0" in "%s"', __DIR__));
}
require_once __DIR__ . '/vendor/autoload.php';

class YouTubeApi
{
    private $secretFile = __DIR__ . '/client_secret.json';
    private $client;
    private $service;


    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('API code samples');
        $this->client->setScopes([
            'https://www.googleapis.com/auth/youtube.readonly',
        ]);


        $this->client->setAuthConfig($this->secretFile);
        $this->client->setAccessType('offline');

        $authUrl = $this->client->createAuthUrl();
        printf("Open this link in your browser:\n%s\n", $authUrl);
        print('Enter verification code: ');
        $authCode = trim(fgets(STDIN));

        $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);
        $this->client->setAccessToken($accessToken);

        $this->service = new Google_Service_YouTube($this->client);


    }

    public function findChannel(string $IdChannel)
    {
        $response = $this->service->channels->listChannels('statistics,snippet', ['id' => $IdChannel]);
        $statistics = $response->getItems()[0]->getStatistics();
        $snippet = $response->getItems()[0]->getSnippet();

        return [ 'statistics' => $statistics, 'snippet' => $snippet];

    }

}