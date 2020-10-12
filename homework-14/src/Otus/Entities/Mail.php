<?php

namespace Otus\Entities;

class Mail
{
    private string $id;

    private string $mailboxId;

    private string $receivedAt;

    private string $messageId;

    private string $subject;

    private ?string $fromName;

    private string $fromEmail;

    private ?string $senderName;

    private string $senderEmail;

    private string $plainText;

    private ?string $html;

    private string $toEmail;

    private ?string $ccEmail;

    private ?string $bccEmail;

    private string $replyToEmail;

    public function __construct(array $data)
    {
        $this->setId($data['id'])
             ->setMailboxId($data['mailbox_id'])
             ->setReceivedAt($data['received_at'])
             ->setMessageId($data['message_id'])
             ->setSubject($data['subject'])
             ->setFromName($data['from_name'] ?? null)
             ->setFromEmail($data['from_email'])
             ->setSenderName($data['sender_name'] ?? null)
             ->setSenderEmail($data['sender_email'])
             ->setPlainText($data['plain_text'])
             ->setHtml($data['html'] ?? null)
             ->setToEmail($data['to_email'])
             ->setCcEmail($data['cc_email'] ?? null)
             ->setBccEmail($data['bcc_email'] ?? null)
             ->setReplyToEmail($data['reply_to_email']);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getMailboxId(): string
    {
        return $this->mailboxId;
    }

    public function setMailboxId(string $mailboxId): self
    {
        $this->mailboxId = $mailboxId;

        return $this;
    }

    public function getReceivedAt(): string
    {
        return $this->receivedAt;
    }

    public function setReceivedAt(string $receivedAt): self
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function setMessageId(string $messageId): self
    {
        $this->messageId = $messageId;

        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    public function setFromName(?string $fromName): self
    {
        $this->fromName = $fromName;

        return $this;
    }

    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    public function setFromEmail(string $fromEmail): self
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    public function setSenderName(?string $senderName): self
    {
        $this->senderName = $senderName;

        return $this;
    }

    public function getSenderEmail(): string
    {
        return $this->senderEmail;
    }

    public function setSenderEmail(string $senderEmail): self
    {
        $this->senderEmail = $senderEmail;

        return $this;
    }

    public function getPlainText(): string
    {
        return $this->plainText;
    }

    public function setPlainText(string $plainText): self
    {
        $this->plainText = $plainText;

        return $this;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    public function setHtml(string $html): self
    {
        $this->html = $html;

        return $this;
    }

    public function getToEmail(): string
    {
        return $this->toEmail;
    }

    public function setToEmail(string $toEmail): self
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    public function getCcEmail(): string
    {
        return $this->ccEmail;
    }

    public function setCcEmail(string $ccEmail): self
    {
        $this->ccEmail = $ccEmail;

        return $this;
    }

    public function getBccEmail(): string
    {
        return $this->bccEmail;
    }

    public function setBccEmail(string $bccEmail): self
    {
        $this->bccEmail = $bccEmail;

        return $this;
    }

    public function getReplyToEmail(): string
    {
        return $this->replyToEmail;
    }

    public function setReplyToEmail(string $replyToEmail): self
    {
        $this->replyToEmail = $replyToEmail;

        return $this;
    }
}
