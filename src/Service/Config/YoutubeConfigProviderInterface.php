<?php declare(strict_types=1);

namespace Service\Config;

interface YoutubeConfigProviderInterface
{
    public function getApiKey(): string;

    public function getApiBaseUrl(): string;

    public function getSearchApiPath(): string;

    public function getVideosApiPath(): string;
}
