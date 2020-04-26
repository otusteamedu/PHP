<?php

namespace Bjlag\Http\Forms;

use Bjlag\Entities\ChannelEntity;
use Bjlag\Forms;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\UnprocessableEntityException;
use Psr\Http\Message\ServerRequestInterface;

class ChannelUpdateForm implements Forms
{
    private const FIELDS = [
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

    /** @var \Psr\Http\Message\ServerRequestInterface */
    private $request;

    /** @var array */
    private $body;

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

    /** @var array */
    private $filter;

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
        $this->body = $request->getParsedBody();
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
     * @return \Bjlag\Http\Forms\ChannelUpdateForm
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
     * @return \Bjlag\Http\Forms\ChannelUpdateForm
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
     * @return \Bjlag\Http\Forms\ChannelUpdateForm
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
     * @return \Bjlag\Http\Forms\ChannelUpdateForm
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
     * @return \Bjlag\Http\Forms\ChannelUpdateForm
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
     * @return \Bjlag\Http\Forms\ChannelUpdateForm
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
     * @return \Bjlag\Http\Forms\ChannelUpdateForm
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
     * @return \Bjlag\Http\Forms\ChannelUpdateForm
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
     * @return \Bjlag\Http\Forms\ChannelUpdateForm
     */
    public function setLinks(array $links): self
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilterId(): string
    {
        return $this->filter['id'];
    }

    /**
     * @return $this
     * @throws \League\Route\Http\Exception\BadRequestException
     * @throws \League\Route\Http\Exception\UnprocessableEntityException
     */
    public function fillAndValidate(): self
    {
        if (!isset($this->body['filter']['id']) || !isset($this->body['data'])) {
            throw new BadRequestException();
        }

        $this->filter = $this->body['filter'];

        foreach (self::FIELDS as $field) {
            if (!isset($this->body['data'][$field])) {
                throw new UnprocessableEntityException("Поле '{$field}' обязательно для заполнения.");
            }

            $setterName = strtr($field, ['_' => ' ']);
            $setterName = ucwords($setterName);
            $setterName = 'set' . strtr($setterName, [' ' => '']);

            $this->{$setterName}($this->body['data'][$field]);
        }

        return $this;
    }
}
