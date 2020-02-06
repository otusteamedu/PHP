<?php declare(strict_types=1);

namespace Entity\Youtube;

class Video implements \JsonSerializable
{
    private string $title;

    private string $url;

    private int $likes = 0;

    private int $dislikes = 0;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getLikes(): int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }

    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    public function setDislikes(int $dislikes): void
    {
        $this->dislikes = $dislikes;
    }

    public function handleArray(array $video): void
    {
        $this->setTitle($video['title']);
        $this->setUrl($video['url']);
        $this->setLikes($video['likes'] ?? 0);
        $this->setDislikes($video['dislikes'] ?? 0);
    }

    public function jsonSerialize()
    {
        return [
            'title' => $this->getTitle(),
            'url' => $this->getUrl(),
            'likes' => $this->getLikes(),
            'dislikes' => $this->getDislikes(),
        ];
    }
}
