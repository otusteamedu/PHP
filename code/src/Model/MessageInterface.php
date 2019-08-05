<?php

namespace crazydope\theater\Model;

interface MessageInterface extends ArrayDocumentInterface
{
    public const STATUS_IN_PROGRESS = 1;

    public const STATUS_PROCESSED = 2;

    public const STATUS_CANCELED = 3;

    public function setStatus(?int $status): MessageInterface;

    public function getStatus(): ?int;

    public function setType(?int $type): MessageInterface;

    public function getType(): ?int;

    public function setMessage(?string $message): MessageInterface;

    public function getMessage(): ?string;

    public function setId(?string $id): MessageInterface;

    public function getId(): ?string;

    public function setAnswer(?string $answer): MessageInterface;

    public function getAnswer(): ?string;
}