<?php

declare(strict_types=1);

namespace App\Services;

use Google_Client;
use Google_Exception;
use RuntimeException;

class YouTubeAuth
{
    /**
     * @var Google_Client
     */
    protected $client;
    /**
     * @var string
     */
    protected $tokenPath;
    /**
     * @var string
     */
    protected $redirectUri;

    /**
     * @param string $configPath
     * @param array $scopes
     * @param string $tokenPath
     * @param string|null $redirectUri
     */
    public function __construct(string $configPath, array $scopes, string $tokenPath, string $redirectUri = null)
    {
        $this->client = new Google_Client();

        try {
            $this->client->setAuthConfig($configPath);
            $this->client->setScopes($scopes);
        } catch (Google_Exception $e) {
            throw new RuntimeException("Google client initialization error: {$e->getMessage()}", 0, $e);
        }

        $this->client->addScope($scopes);
        $this->tokenPath = $tokenPath;

        if ($redirectUri) {
            $this->client->setRedirectUri($redirectUri);
        }
    }

    /**
     * @return Google_Client
     */
    public function getClient(): Google_Client
    {
        return $this->client;
    }

    /**
     * @param string $redirectUri
     * @return YouTubeAuth
     */
    public function setRedirectUri(string $redirectUri): YouTubeAuth
    {
        $this->client->setRedirectUri($redirectUri);

        return $this;
    }

    /**
     * @param $redirect
     * @return string
     */
    public function createAuthUrl($redirect = null): string
    {
        if ($redirect) {
            $this->client->setRedirectUri($redirect);
        } elseif ($this->client->getRedirectUri() === null) {
            throw new RuntimeException('Redirect uri is missing.');
        }

        $this->client->setPrompt('consent');
        $this->client->setAccessType('offline');

        return $this->client->createAuthUrl();
    }

    /**
     * @return YouTubeAuth
     * @throws RuntimeException
     */
    public function initToken(): YouTubeAuth
    {
        if (file_exists($this->tokenPath)) {
            $token = file_get_contents($this->tokenPath);
            $token = json_decode($token, true);
            $this->client->setAccessToken($token);

            if ($this->client->isAccessTokenExpired()) {
                $this->client->refreshToken($this->client->getRefreshToken());
                $freshToken = $this->client->getAccessToken();
                file_put_contents($this->tokenPath, json_encode($freshToken));
            }
            return $this;
        } else {
            throw new RuntimeException('Token not found. Create a new one.');
        }
    }

    /**
     * @param $code
     */
    public function fetchToken($code): void
    {
        $token = $this->client->fetchAccessTokenWithAuthCode($code);

        if (array_key_exists('error', $token)) {
            throw new RuntimeException("Error while fetching access token, reason:");
        }

        file_put_contents($this->tokenPath, json_encode($token));
    }
}
