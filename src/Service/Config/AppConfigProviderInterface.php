<?php declare(strict_types=1);

namespace Service\Config;

interface AppConfigProviderInterface
{
    public function getAppBasePath(): string;
}
