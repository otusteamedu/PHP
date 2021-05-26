<?php


namespace App\Command;


use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakerUsersCommand extends AbstractFakeCommand
{
    protected static string $defaultName = 'fake:users';

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a fake users.')
            ->setHelp('This command allows you to create users...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            foreach (range(1, 10) as $_) {

                $user = new User();
                $user->setEmail($this->faker->email);
                $user->setPassword($this->faker->password);
                $user->setDiscount(rand(0, 50));
                $user->setFirstname($this->faker->firstName());
                $user->setLastname($this->faker->lastName);


                $this->em->persist($user);
            }

            $this->em->flush();
        } catch (\Exception $e) {
            echo $e->getMessage(), PHP_EOL;
            echo $e->getFile() . ':' . $e->getLine();
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

}
