<?php


namespace Repetitor202\Domain\Entities\Explorers\YouTube;


class ChannelEntity
{
    private string $id;
    private float $ratioLikeDislike;
    private string $title;

    public function __construct(
        string $id,
        float $ratioLikeDislike,
        string $title
    )
    {
        $this->id = $id;
        $this->ratioLikeDislike = $ratioLikeDislike;
        $this->title = $title;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getRatioLikeDislike(): float
    {
        return $this->ratioLikeDislike;
    }

    public function setRatioLikeDislike(float $ratioLikeDislike): void
    {
        $this->ratioLikeDislike = $ratioLikeDislike;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}