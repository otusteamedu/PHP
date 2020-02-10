<?php declare(strict_types=1);

namespace Service\Config;

class YoutubeApiConfigIniProvider implements YoutubeConfigProviderInterface
{
    private string $configFilename;

    private array $apiConfig;

    public function __construct(string $configFilename)
    {
        $this->configFilename = $configFilename;
        $this->apiConfig = parse_ini_file($this->configFilename, true, INI_SCANNER_TYPED);
    }

    public function getApiKey(): string
    {
        return $this->apiConfig['youtube']['api_key'];
    }

    public function getApiBaseUrl(): string
    {
        return $this->apiConfig['youtube']['api_base_url'];
    }

    public function getSearchApiPath(): string
    {
        return $this->apiConfig['youtube']['api_path_search'];
    }

    public function getVideosApiPath(): string
    {
        return $this->apiConfig['youtube']['api_path_videos'];
    }
}
