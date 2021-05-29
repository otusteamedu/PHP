<?php


namespace App\MessageHandler;


use App\Entity\User;
use App\Message\MessageInterface;
use App\Service\Mailer\MailerInterface;
use App\Message\BankOperationMessage;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Slim\Views\PhpRenderer;

class BankOperationMessageHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;
    private MailerInterface $mailer;
    private PhpRenderer $renderer;

    /**
     * BankOperationMessageHandler constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->entityManager = $container->get(EntityManagerInterface::class);
        $this->mailer = $container->get(MailerInterface::class);
        $this->renderer = $container->get(PhpRenderer::class);
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

        $this->mailer->sendEmail($message->getEmail(), 'Банковская выписка', $body, 'text/html');

    }
}
