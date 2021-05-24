<?php

declare(strict_types=1);

namespace App\Command\Product;

use App\Command\CommandInterface;
use App\Console\ConsoleInterface;
use App\Model\Product\UseCase\Cook\CookProductCommand;
use App\Model\Product\UseCase\Cook\CookProductHandler;
use App\Service\Hydrator\HydratorInterface;

class CookCommand implements CommandInterface
{
    private ConsoleInterface   $console;
    private HydratorInterface  $hydrator;
    private CookProductHandler $cookProductHandler;

    public function __construct(
        ConsoleInterface $console,
        HydratorInterface $hydrator,
        CookProductHandler $cookProductHandler
    ) {
        $this->console = $console;
        $this->hydrator = $hydrator;
        $this->cookProductHandler = $cookProductHandler;
    }

    public function execute(): void
    {
        $data = $this->console->getArgument(2)->toArray();

        /* @var CookProductCommand $command */
        $command = $this->hydrator->hydrate(CookProductCommand::class, $data);

        $this->cookProductHandler->handle($command);
    }
}