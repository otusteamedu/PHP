<?php


namespace App\Model\Interfaces;


use DateTime;

interface ModelYoutubeInterface
{
    public function getId(): string;
    public function getTitle(): string;
    public function getDescription(): string;
    public function getPublishedAt(): DateTime;

    public function setId(string $id): void;
    public function setTitle(string $title): void;
    public function setDescription(string $description): void;
    public function setPublishedAt(DateTime $publishedAt): void;

    public function toArray(): array;
}
