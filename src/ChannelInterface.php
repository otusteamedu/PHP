<?php

namespace crazydope\youtube;

interface ChannelInterface extends ArrayDocumentInterface
{
    public function getId(): string;

    public function getTitle(): string;

    public function getDescription(): string;

    public function getLink(): string;

    public function setId(string $id): ChannelInterface;

    public function setTitle(string $title): ChannelInterface;

    public function setDescription(string $description): ChannelInterface;

    public function setLink(string $link): ChannelInterface;
}