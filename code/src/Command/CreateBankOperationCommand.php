<?php


namespace App\Command;


use App\Entity\BankOperation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateBankOperationCommand extends \Symfony\Component\Console\Command\Command
{

    protected static string $defaultName = 'fake:bank-operations';

    private EntityManagerInterface $entityManager;

    /**
     * CreateUsersCommand constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }


    protected function configure(): void
    {
        $this
            ->setDescription('Creates a fake bank operations.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->entityManager
            ->getRepository(User::class)
            ->findAll();

        for ($i = 30; $i >= 0; $i--) {

            for ($j = 0; $j < 24; $j++) {

                $date = new \DateTime('now');
                $date->setTime($j, rand(0, 59), rand(0, 59));
                $interval = new \DateInterval('P' . $i . 'D');
                $date->sub($interval);

                /** @var User $user */
                foreach ($users as $user) {
                    if (rand(0, 1)) {
                        $bankOperation = new BankOperation();

                        $sum = rand(100, 10000) * (rand(0, 1) ? 1 : -1);
                        $bankOperation
                            ->setUser($user)
                            ->setSum($sum)
                            ->setCreatedAt($date);

                        $this->entityManager->persist($bankOperation);
                    }
                }
            }
        }

        $this->entityManager->flush();

        echo 'Operations created!', PHP_EOL;

        return Command::SUCCESS;
    }

}
