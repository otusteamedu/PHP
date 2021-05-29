<?php


namespace App\Command;


use App\Entity\User;
use App\Service\Security\SecurityInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUsersCommand extends Command
{
    protected static string $defaultName = 'fake:users';

    private EntityManagerInterface $entityManager;
    private SecurityInterface $security;

    /**
     * CreateUsersCommand constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Service\Security\SecurityInterface $security
     */
    public function __construct(EntityManagerInterface $entityManager, SecurityInterface $security)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->security = $security;
    }


    protected function configure(): void
    {
        $this
            ->setDescription('Creates a fake users.')
            ->setHelp('This command allows you to create users...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        foreach (range(1 , 2) as $i) {
            $user = new User();
            $user->setEmail('user' . $i . '@mail.com');
            $user->setFirstname('User ' . $i);
            $user->setPassword(
                $this->security->cryptPassword('user' . $i)
            );

            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();

        echo 'Users created!', PHP_EOL;

        return Command::SUCCESS;
    }

}
