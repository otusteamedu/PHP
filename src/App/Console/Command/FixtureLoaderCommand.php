<?php

namespace App\Console\Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixtureLoaderCommand extends Command
{
    /** @var \Doctrine\ORM\EntityManagerInterface */
    private $em;

    /** @var string */
    private $path;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @param string $path
     */
    public function __construct(EntityManagerInterface $em, string $path)
    {
        parent::__construct();

        $this->em = $em;
        $this->path = $path;
    }

    protected function configure()
    {
        $this
            ->setName('fixture:load')
            ->setDescription('Load fixture');
    }


    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<comment>Loading fixtures</comment>');

        $loader = new Loader();
        $loader->loadFromDirectory($this->path);

        $executor = new ORMExecutor($this->em, new ORMPurger());
        $executor->execute($loader->getFixtures());

        $output->writeln('<info>Done!</info>');

        return 0;
    }
}
