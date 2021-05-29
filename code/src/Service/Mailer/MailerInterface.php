<?php


namespace App\Service\Mailer;


interface MailerInterface
{
    public function sendEmail(string $to, string $subject, string $message, string $contentType = null): bool;
}
