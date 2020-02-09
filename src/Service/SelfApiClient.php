<?php declare(strict_types=1);

namespace Service;

use Entity\Youtube\Channel;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Service\Config\AppConfigProviderInterface;

class SelfApiClient
{
    private Client $client;

    private AppConfigProviderInterface $configProvider;

    public function __construct(AppConfigProviderInterface $configProvider)
    {
        $this->configProvider = $configProvider;
        $this->client = new Client([
            'base_uri' => $this->configProvider->getAppBasePath()
        ]);
    }

    public function postChannel(Channel $channel): ResponseInterface
    {
        return $this->client->request('post', '/channels', [
            'json' => $channel->jsonSerialize()
        ]);
    }
}
