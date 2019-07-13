<?php

namespace crazydope\youtube;

class Channel implements ChannelInterface
{
    /**
     * @var string
     */
    protected $id = '';
    /**
     * @var string
     */
    protected $title = '';
    /**
     * @var string
     */
    protected $description = '';
    /**
     * @var string
     */
    protected $link = '';

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return ChannelInterface
     */
    public function setId(string $id): ChannelInterface
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ChannelInterface
     */
    public function setTitle(string $title): ChannelInterface
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return ChannelInterface
     */
    public function setDescription(string $description): ChannelInterface
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return ChannelInterface
     */
    public function setLink(string $link): ChannelInterface
    {
        $this->link = $link;
        return $this;
    }

    public function exchangeArray(array $data): void
    {
        $this->id = $data['_id'] ? (string) $data['_id'] : '';
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->link = $data['link'] ?? '';
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description'=> $this->description,
            'link' => $this->link,
        ];
    }
}