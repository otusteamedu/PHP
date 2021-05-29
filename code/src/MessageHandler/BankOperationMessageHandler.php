<?php


namespace App\MessageHandler;


use App\Entity\User;
use App\Message\MessageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class BankOperationMessageHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    /**
     * BankOperationMessageHandler constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->entityManager = $container->get(EntityManagerInterface::class);
    }


    public function process(MessageInterface $message)
    {
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $message->getEmail()]);

        /** @var \App\Entity\BankOperation $operation */
        foreach ($user->getBankOperations() as $operation) {
            echo $operation->getCreatedAt()->format('d.m.Y H:i:s') .
                ' sum: ' . $operation->getSum() . PHP_EOL;
        }

    }
}
