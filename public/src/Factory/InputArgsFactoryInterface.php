<?php

namespace Socket\Ruvik\Factory;

use Socket\Ruvik\DTO\InputArgs;

interface InputArgsFactoryInterface
{
    public const LONG_OPTION_ROUTE = 'route';
    public const LONG_OPTION_MESSAGE = 'message';

    public const SHORT_OPTION_ROUTE = 'r';
    public const SHORT_OPTION_MESSAGE = 'm';


    public const SHORT_OPTIONS = [
        self::SHORT_OPTION_ROUTE . ':',
        self::SHORT_OPTION_MESSAGE . ':',
    ];

    public const LONG_OPTIONS = [
        self::LONG_OPTION_ROUTE . ':',
        self::LONG_OPTION_MESSAGE . ':',
    ];

    public function create(array $args): InputArgs;
}