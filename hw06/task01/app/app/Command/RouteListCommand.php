<?php
// app/Command/RouteListCommand.php

namespace App\Command;

use Slim\Interfaces\RouteCollectorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RouteListCommand extends Command
{

    /*
     * Имя вынесено в константу, чтобы было меньше ошибок при маппинге команд
     */
    const NAME = 'route:list';

    /**
     * @var RouteCollectorInterface
     */
    private $router;

    public function __construct(RouteCollectorInterface $router)
    {
        $this->router = $router;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName(self::NAME)
            ->setDescription('List of routes.')
            ->setHelp('List of routes.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Routes');
        $rows = [];
        $routes = $this->router->getRoutes();
        if (!$routes) {
            $io->text('Routes list is empty');
            return 0;
        }
        foreach ($routes as $route) {
            $rows[] = [
                'path' => $route->getPattern(),
                'methods' => implode(', ', $route->getMethods()),
                'name' => $route->getName(),
                'handler' => $route->getCallable(),
            ];
        }
        $io->table(
            ['Route', 'Methods', 'Name', 'Handler'],
            $rows
        );
        return 0;
    }
}