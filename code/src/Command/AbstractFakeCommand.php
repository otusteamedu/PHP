<?php


namespace App\Command;


use Doctrine\ORM\EntityManager;
use Faker\Generator;
use Symfony\Component\Console\Command\Command;

abstract class AbstractFakeCommand extends Command
{
    protected EntityManager $em;
    protected Generator $faker;

    /**
     * DoctrineCommand constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param \Faker\Generator $faker
     */
    public function __construct(EntityManager $entityManager, Generator $faker)
    {
        parent::__construct();
        $this->em = $entityManager;
        $this->faker = $faker;
    }

}
