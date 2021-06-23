<?php

declare(strict_types=1);

namespace App\Service\Sender\Mail;

use App\Framework\Config\Configuration;
use App\Service\Sender\Message;
use App\Service\Sender\RecipientInterface;
use App\Service\Sender\SenderInterface;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailSender implements SenderInterface
{
    private Configuration $config;

    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * @throws Exception
     */
    public function send(Message $message, RecipientInterface $recipient): void
    {
        $mail = new PHPMailer(true);

        $mail->CharSet = 'UTF-8';

        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;

        $mail->Host = $this->config->getParam('mail_host');
        $mail->Username = $this->config->getParam('mail_username');
        $mail->Password = $this->config->getParam('mail_password');
        $mail->Port = 465;

        $mail->setFrom($this->config->getParam('mail_from'));
        $mail->addAddress($recipient->getEmail());

        $mail->isHTML(true);
        $mail->Subject = $message->getSubject();
        $mail->Body = $message->getContent();

        $mail->send();
    }
}