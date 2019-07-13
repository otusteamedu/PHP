<?php

namespace crazydope\youtube;

interface VideoInterface extends ArrayDocumentInterface
{
    public function getId(): string;

    public function setId(string $id): VideoInterface;

    public function getChannelId(): string;

    public function setChannelId(string $channelId): VideoInterface;

    public function getTitle(): string;

    public function setTitle(string $title): VideoInterface;

    public function getLink(): string;

    public function setLink(string $link): VideoInterface;

    public function getLikeCount(): int;

    public function setLikeCount(int $likeCount): VideoInterface;

    public function getDislikeCount(): int;

    public function setDislikeCount(int $dislikeCount): VideoInterface;
}