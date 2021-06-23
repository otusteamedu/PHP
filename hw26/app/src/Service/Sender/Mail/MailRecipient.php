<?php

declare(strict_types=1);

namespace App\Service\Sender\Mail;

class MailRecipient implements MailRecipientInterface
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}