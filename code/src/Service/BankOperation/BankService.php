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
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(MessageServiceInterface $messageService, EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->messageService = $messageService;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }


    /**
     * Возвращает первую банковскую операцию совершенную пользователем.
     *
     * @param \App\Entity\User $user
     * @return \App\Entity\BankOperation|null
     */
    public function getUserFirstOperation(User $user): ?BankOperation
    {
        /** @var BankOperation $firstEntry */
        list ($firstEntry) = $this->entityManager->getRepository(BankOperation::class)
            ->findBy(['user' => $user], ['createdAt' => 'ASC'], 1);

        return $firstEntry;
    }

    /**
     * Создание сообщения и помещение его в очередь для последующей обработки.
     *
     * @param \App\Entity\User $user
     * @param \DateTime $dateStart
     * @param \DateTime $dateEnd
     * @return bool
     */
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
