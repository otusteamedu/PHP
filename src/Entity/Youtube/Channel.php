<?php declare(strict_types=1);

namespace Entity\Youtube;

class Channel implements \JsonSerializable
{
    private string $title;

    private string $url;

    private array $videos = [];

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

    /**
     * @return Video[]
     */
    public function getVideos(): array
    {
        return $this->videos;
    }

    /**
     * @param Video[] $videos
     */
    public function setVideos(array $videos): void
    {
        $this->videos = $videos;
    }

    public function handleArray(array $channel): void
    {
        $this->setTitle($channel['title']);
        $this->setUrl($channel['url']);

        $videos = [];
        foreach ($channel['videos'] as $item) {
            $video = new Video();
            $video->handleArray($item);
            $videos[] = $video;
        }
        $this->setVideos($videos);
    }

    public function jsonSerialize()
    {
        $channel = [
            'title' => $this->getTitle(),
            'url' => $this->getUrl(),
        ];
        foreach ($this->getVideos() as $video) {
            $channel['videos'][] = $video->jsonSerialize();
        }

        return $channel;
    }
}
