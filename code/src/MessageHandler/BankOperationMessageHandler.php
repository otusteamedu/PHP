<?php


namespace App\MessageHandler;


use App\Entity\User;
use App\Message\MessageInterface;
use App\Service\Mailer\MailerInterface;
use App\Message\BankOperationMessage;
use Doctrine\ORM\EntityManagerInterface;
use Slim\Views\PhpRenderer;

class BankOperationMessageHandler implements MessageHandlerInterface
{
    const MAIL_SUBJECT = 'Банковская выписка';
    const MAIL_TYPE = 'text/html';


    private EntityManagerInterface $entityManager;
    private MailerInterface $mailer;
    private PhpRenderer $renderer;


    /**
     * BankOperationMessageHandler constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Service\Mailer\MailerInterface $mailer
     * @param \Slim\Views\PhpRenderer $renderer
     */
    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer, PhpRenderer $renderer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }


    /** @throws \Throwable
     * @var BankOperationMessage $message
     */
    public function process(MessageInterface $message)
    {
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $message->getEmail()]);

        $dateStart = $message->getDateStart();
        $dateEnd = $message->getDateEnd();
        $body = $this->renderer->fetchTemplate('email/bank-operation.php', [
            'username' => $user->getUsername(),
            'dateStart' => $dateStart->format('d.m.Y'),
            'dateEnd' => $dateEnd->format('d.m.Y'),
            'operations' => $user->getBankOperations($dateStart, $dateEnd),
        ]);

        $this->mailer->sendEmail(
            $message->getEmail(),
            self::MAIL_SUBJECT,
            $body,
            self::MAIL_TYPE
        );

    }
}
