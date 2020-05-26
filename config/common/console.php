<?php

use App\Console\Command\FixtureLoaderCommand;
use Doctrine\Migrations\Tools\Console\Command;
use Infrastructure\Container\Console\FixtureLoaderCommandFactory;

return [
    'dependencies' => [
        'factories' => [
            FixtureLoaderCommand::class => FixtureLoaderCommandFactory::class
        ],
    ],

    'config' => [
        'console' => [
            'commands' => [
                FixtureLoaderCommand::class,
                Command\DumpSchemaCommand::class,
                Command\ExecuteCommand::class,
                Command\GenerateCommand::class,
                Command\LatestCommand::class,
                Command\MigrateCommand::class,
                Command\RollupCommand::class,
                Command\StatusCommand::class,
                Command\VersionCommand::class,
                Command\UpToDateCommand::class,
            ]
        ]
    ],
];
