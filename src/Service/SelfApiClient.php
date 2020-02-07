<?php declare(strict_types=1);

namespace Service;

use Entity\Youtube\Channel;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class SelfApiClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://mysite.local'
        ]);
    }

    public function postChannel(Channel $channel): ResponseInterface
    {
        return $this->client->request('post', '/channels', [
            'json' => $channel->jsonSerialize()
        ]);
    }
}
