<?php


namespace App\Service\Mailer;


use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class EmailService implements EmailSenderInterface
{
    private Swift_Mailer $mailer;

    /**
     * EmailService constructor.
     */
    public function __construct(string $host, int $port, string $username, string $password)
    {
        $transport = (new Swift_SmtpTransport($host, $port))
            ->setUsername($username)
            ->setPassword($password);

        $this->mailer = new Swift_Mailer($transport);
    }


    public function sendEmail($to, $subject, $message): bool
    {
        $message = (new Swift_Message($subject))
            ->setFrom(['fast-food@company.com'])
            ->setTo([$to])
            ->setBody($message)
        ;

        return $this->mailer->send($message);
    }

}
