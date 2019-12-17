<?php

declare(strict_types=1);

namespace Welcomer;

class WelcomeService
{
    private const WELCOME_MESSAGE_TEMPLATE = 'Hello %s, have a good day !';

    public function getWelcomeMessage(string $name): string
    {
        return sprintf(self::WELCOME_MESSAGE_TEMPLATE, $name);
    }
}
