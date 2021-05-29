<?php


namespace App\Service\BankOperation;


use App\Entity\BankOperation;
use App\Entity\User;
use App\Message\BankOperationMessage;
use App\Service\Message\MessageServiceInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class BankService implements BankOperationInterface
{
    private MessageServiceInterface $messageService;
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    /**
     * BankService constructor.
     * @param \App\Service\Message\MessageServiceInterface $messageService
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(MessageServiceInterface $messageService, EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->messageService = $messageService;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }


    public function getUserFirstOperation(User $user): ?BankOperation
    {
        /** @var BankOperation $firstEntry */
        list ($firstEntry) = $this->entityManager->getRepository(BankOperation::class)
            ->findBy(['user' => $user], ['createdAt' => 'ASC'], 1);

        return $firstEntry;
    }

    public function getUserOperations(User $user, DateTime $dateStart, DateTime $dateEnd): bool
    {
        try {
            $bankStatement = new BankOperationMessage($user->getEmail(), $dateStart, $dateEnd);
            $this->messageService->push($bankStatement);

            return true;

        } catch (\Exception $e) {
            $error = $e->getMessage() . '(' . $e->getFile() . ': ' . $e->getLine() . ')';
            $this->logger->error($error);
            return false;
        }
    }
}
