<?php

declare(strict_types=1);

namespace App\Service\Sender\Mail;

use App\Service\Sender\RecipientInterface;

interface MailRecipientInterface extends RecipientInterface
{
    public function getEmail(): string;
}