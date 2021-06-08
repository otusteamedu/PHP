<?php


namespace App\Utils\Command;


use App\Entity\User;
use App\Service\Security\SecurityInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUsersCommand extends Command
{
    const TEST_USERS = ['user1@mail.com', 'user2@mail.com'];

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
            ->setName('users:create')
            ->setDescription('Создает фейковых пользователей');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->entityManager
            ->getRepository(User::class)
            ->findBy(['email' => self::TEST_USERS]);

        if ($users) {
            echo 'Test users (' . implode(', ', self::TEST_USERS) . ') already exists', PHP_EOL;
            return Command::FAILURE;
        }


        foreach (self::TEST_USERS as $key => $email) {
            $i = $key + 1;

            $user = new User();
            $user->setEmail($email);
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
