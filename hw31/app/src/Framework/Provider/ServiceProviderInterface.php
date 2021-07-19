<?php

declare(strict_types=1);

namespace App\Framework\Provider;

interface ServiceProviderInterface
{
    public function register(): void;
}