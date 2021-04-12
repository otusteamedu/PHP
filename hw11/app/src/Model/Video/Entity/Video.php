<?php

declare(strict_types=1);

namespace App\Model\Video\Entity;

use InvalidArgumentException;

class Video
{

    private string $id;
    private string $title;
    private string $channelId;
    private int    $likeCount;
    private int    $dislikeCount;

    public function __construct(string $id, string $title, string $channelId)
    {
        $this->assertIdIsNotEmpty($id);
        $this->assertTitleIsNotEmpty($title);
        $this->assertChannelIdIsNotEmpty($channelId);

        $this->id = $id;
        $this->title = $title;
        $this->channelId = $channelId;
    }

    private function assertIdIsNotEmpty(string $id): void
    {
        if (empty(trim($id))) {
            throw new InvalidArgumentException('Не указан id видео');
        }
    }

    private function assertTitleIsNotEmpty(string $title): void
    {
        if (empty(trim($title))) {
            throw new InvalidArgumentException('Не указано название видео');
        }
    }

    private function assertChannelIdIsNotEmpty(string $channelId): void
    {
        if (empty(trim($channelId))) {
            throw new InvalidArgumentException('Не указан id канала');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function changeTitle(string $title): void
    {
        $this->assertTitleIsNotEmpty($title);

        $this->title = $title;
    }

    public function changeLikeCount(int $likeCount): void
    {
        if ($likeCount < 0) {
            throw new InvalidArgumentException('Количество лайков не может быть меньше нуля');
        }

        $this->likeCount = $likeCount;
    }

    public function changeDislikeCount(int $dislikeCount): void
    {
        if ($dislikeCount < 0) {
            throw new InvalidArgumentException('Количество дизлайков не может быть меньше нуля');
        }

        $this->dislikeCount = $dislikeCount;
    }

    public function toArray(): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'channelId'    => $this->channelId,
            'likeCount'    => $this->likeCount,
            'dislikeCount' => $this->dislikeCount,
        ];
    }

}