<?php

namespace Bjlag\Entities;

class ChannelEntity
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
     * @return \Bjlag\Entities\ChannelEntity
     */
    public function setId(string $id): self
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
     * @return \Bjlag\Entities\ChannelEntity
     */
    public function setUrl(string $url): self
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
     * @return \Bjlag\Entities\ChannelEntity
     */
    public function setName(string $name): self
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
     * @return \Bjlag\Entities\ChannelEntity
     */
    public function setDescription(string $description): self
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
     * @return \Bjlag\Entities\ChannelEntity
     */
    public function setBanner(string $banner): self
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
     * @return \Bjlag\Entities\ChannelEntity
     */
    public function setCountry(string $country): self
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
     * @return string
     */
    public function getRegistrationDataAsString(): string
    {
        return $this->registrationData->format('Y-m-d');
    }

    /**
     * @param array|string|object $registrationData
     * @return \Bjlag\Entities\ChannelEntity
     */
    public function setRegistrationData($registrationData): self
    {
        try {
            if (is_string($registrationData)) {
                $this->registrationData = new \DateTimeImmutable($registrationData);
            } elseif (is_array($registrationData)) {
                $this->registrationData = new \DateTimeImmutable($registrationData['date']);
            } elseif(is_object($registrationData)) {
                $this->registrationData = new \DateTimeImmutable($registrationData->{'date'});
            } else {
                throw new \InvalidArgumentException('Неверный формат даты.');
            }
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
     * @return \Bjlag\Entities\ChannelEntity
     */
    public function setNumberViews(int $numberViews): self
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
     * @return \Bjlag\Entities\ChannelEntity
     */
    public function setNumberSubscribes(int $numberSubscribes): self
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
     * @return \Bjlag\Entities\ChannelEntity
     */
    public function setLinks(array $links): self
    {
        $this->links = $links;
        return $this;
    }
}
