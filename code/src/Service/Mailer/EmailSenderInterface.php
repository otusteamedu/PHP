<?php


namespace App\Service\Mailer;


interface EmailSenderInterface
{
    public function sendEmail(string $to, string $subject, string $message): bool;
}
