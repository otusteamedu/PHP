<?php

namespace Bjlag\Http\Forms;

use Bjlag\Entities\ChannelEntity;
use Bjlag\BaseForm;

class ChannelForm extends BaseForm
{
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
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
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
     * @return \Bjlag\Http\Forms\ChannelForm
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
     * @return \Bjlag\Http\Forms\ChannelForm
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
     * @return \Bjlag\Http\Forms\ChannelForm
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
     * @return \Bjlag\Http\Forms\ChannelForm
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
     * @return \Bjlag\Http\Forms\ChannelForm
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
     * @param string $registrationData
     * @return \Bjlag\Http\Forms\ChannelForm
     */
    public function setRegistrationData(string $registrationData): self
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
     * @return \Bjlag\Http\Forms\ChannelForm
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
     * @return \Bjlag\Http\Forms\ChannelForm
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
     * @return \Bjlag\Http\Forms\ChannelForm
     */
    public function setLinks(array $links): self
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return array
     */
    protected function getFields(): array
    {
        return [
            ChannelEntity::FIELD_URL,
            ChannelEntity::FIELD_NAME,
            ChannelEntity::FIELD_DESCRIPTION,
            ChannelEntity::FIELD_BANNER,
            ChannelEntity::FIELD_COUNTRY,
            ChannelEntity::FIELD_REGISTRATION_DATA,
            ChannelEntity::FIELD_NUMBER_VIEWS,
            ChannelEntity::FIELD_NUMBER_SUBSCRIBES,
            ChannelEntity::FIELD_LINKS,
        ];
    }
}
