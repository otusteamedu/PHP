<?php


namespace App\Service\Mailer;


use Slim\Views\PhpRenderer;
use Swift_Mailer;

class MailerService implements MailerInterface
{
    const BOT_MAIL = 'app-bot@mail.com';

    private Swift_Mailer $mailer;

    /**
     * MailerService constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }


    /**
     * Отправка письма.
     *
     * @param string $to
     * @param string $subject
     * @param string $message
     * @param string|null $contentType
     * @return bool
     */
    public function sendEmail(string $to, string $subject, string $message, string $contentType = null): bool
    {
        $message = (new \Swift_Message($subject))
            ->setFrom(self::BOT_MAIL)
            ->setTo([$to])
            ->setBody($message, $contentType);

        return $this->mailer->send($message);
    }
}
