<?php

declare(strict_types=1);

namespace App\Consumer;

use App\Framework\Console\ConsoleInterface;
use App\Model\BankAccount\Entity\AccountId;
use App\Model\BankAccount\Entity\BankAccount;
use App\Model\BankAccount\Repository\BankAccountRepositoryInterface;
use App\ReadModel\BankAccount\AccountStatementFetcher;
use App\Service\Queue\ConsumerInterface;
use App\Service\Queue\QueueMessage;
use App\Service\Sender\Mail\MailRecipient;
use App\Service\Sender\Mail\MailRecipientInterface;
use App\Service\Sender\Message;
use App\Service\Sender\SenderInterface;
use DateTimeImmutable;
use Exception;

class GenerateAccountStatementConsumer implements ConsumerInterface
{
    private BankAccountRepositoryInterface $bankAccountRepository;
    private AccountStatementFetcher        $accountStatementFetcher;
    private ConsoleInterface               $console;
    private SenderInterface                $sender;

    public function __construct(
        BankAccountRepositoryInterface $bankAccountRepository,
        AccountStatementFetcher $accountStatementFetcher,
        ConsoleInterface $console,
        SenderInterface $sender
    ) {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->accountStatementFetcher = $accountStatementFetcher;
        $this->console = $console;
        $this->sender = $sender;
    }

    /**
     * @throws Exception
     */
    public function consume(QueueMessage $message): void
    {
        $msg = json_decode($message->getBody(), false);

        $msg->accountId = new AccountId($msg->accountId);
        $msg->startDate = new DateTimeImmutable($msg->startDate);
        $msg->endDate = new DateTimeImmutable($msg->endDate);

        $accountStatement = $this->accountStatementFetcher->getByDateRange(
            $msg->accountId,
            $msg->startDate,
            $msg->endDate
        );

        $bankAccount = $this->bankAccountRepository->getOne($msg->accountId);

        $this->sender->send(
            $this->buildMessage($accountStatement),
            $this->buildRecipient($bankAccount)
        );

        $this->console->success(
            'Выписка успешно сгенерирована за период с ' . $msg->startDate->format('d.m.Y') . ' до ' . $msg->endDate->format('d.m.Y')
        );
    }

    private function buildMessage(array $accountStatement): Message
    {
        return new Message('Выписка по банковскому счету', print_r($accountStatement, true));
    }

    private function buildRecipient(BankAccount $bankAccount): MailRecipientInterface
    {
        return new MailRecipient($bankAccount->getEmail()->getValue());
    }
}