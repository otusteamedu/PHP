<?php

namespace Bjlag\Entities\Dto;

use Bjlag\Dto;

class ChannelDto implements Dto
{
    /** @var string */
    private $id;

    /** @var string */
    private $url;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var string */
    private $banner;

    /** @var string */
    private $country;

    /** @var \DateTimeImmutable */
    private $registrationData;

    /** @var int */
    private $numberViews;

    /** @var int */
    private $numberSubscribes;

    /** @var array */
    private $links;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return ChannelDto
     */
    public function setId(string $id): ChannelDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return ChannelDto
     */
    public function setUrl(string $url): ChannelDto
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ChannelDto
     */
    public function setName(string $name): ChannelDto
    {
        $this->name = $name;
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
     * @return ChannelDto
     */
    public function setDescription(string $description): ChannelDto
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getBanner(): string
    {
        return $this->banner;
    }

    /**
     * @param string $banner
     * @return ChannelDto
     */
    public function setBanner(string $banner): ChannelDto
    {
        $this->banner = $banner;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return ChannelDto
     */
    public function setCountry(string $country): ChannelDto
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getRegistrationData(): \DateTimeImmutable
    {
        return $this->registrationData;
    }

    /**
     * @param string $registrationData
     * @return ChannelDto
     */
    public function setRegistrationData(string $registrationData): ChannelDto
    {
        try {
            $this->registrationData = new \DateTimeImmutable($registrationData);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Неверный формат даты.');
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getNumberViews(): int
    {
        return $this->numberViews;
    }

    /**
     * @param int $numberViews
     * @return ChannelDto
     */
    public function setNumberViews(int $numberViews): ChannelDto
    {
        $this->numberViews = $numberViews;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberSubscribes(): int
    {
        return $this->numberSubscribes;
    }

    /**
     * @param int $numberSubscribes
     * @return ChannelDto
     */
    public function setNumberSubscribes(int $numberSubscribes): ChannelDto
    {
        $this->numberSubscribes = $numberSubscribes;
        return $this;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param array $links
     * @return ChannelDto
     */
    public function setLinks(array $links): ChannelDto
    {
        $this->links = $links;
        return $this;
    }
}
