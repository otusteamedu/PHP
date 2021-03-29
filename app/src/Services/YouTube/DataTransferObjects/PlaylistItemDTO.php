<?php


namespace App\Services\YouTube\DataTransferObjects;


class PlaylistItemDTO
{
    private string $id;
    private string $title = '';
    private string $description = '';
    private string $channelId = '';
    private string $playlistId = '';
    private string $videoId = '';

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
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
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * @param string $channelId
     */
    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }

    /**
     * @return string
     */
    public function getPlaylistId(): string
    {
        return $this->playlistId;
    }

    /**
     * @param string $playlistId
     */
    public function setPlaylistId(string $playlistId): void
    {
        $this->playlistId = $playlistId;
    }

    /**
     * @return string
     */
    public function getVideoId(): string
    {
        return $this->videoId;
    }

    /**
     * @param string $videoId
     */
    public function setVideoId(string $videoId): void
    {
        $this->videoId = $videoId;
    }


}