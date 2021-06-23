<?php

declare(strict_types=1);

namespace App\Service\Sender;

class Message
{
    private string $subject;
    private string $content;

    public function __construct(string $subject, string $content)
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}