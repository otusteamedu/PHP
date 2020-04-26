<?php

namespace Bjlag\Entities;

use Bjlag\BaseModel;
use Bjlag\Http\Forms\ChannelCreateForm;

class ChannelEntity extends BaseModel
{
    public const TABLE = 'channel';

    public const FIELD_ID = 'id';
    public const FIELD_URL = 'url';
    public const FIELD_NAME = 'name';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_BANNER = 'banner';
    public const FIELD_COUNTRY = 'country';
    public const FIELD_REGISTRATION_DATA = 'registration_data';
    public const FIELD_NUMBER_VIEWS = 'number_views';
    public const FIELD_NUMBER_SUBSCRIBES = 'number_subscribes';
    public const FIELD_LINKS = 'links';

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
     * @param array|string $registrationData
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

    /**
     * @param \Bjlag\Http\Forms\ChannelCreateForm $form
     * @return static
     */
    public static function create(ChannelCreateForm $form): self
    {
        return (new ChannelEntity())
            ->setUrl($form->getUrl())
            ->setName($form->getName())
            ->setDescription($form->getDescription())
            ->setBanner($form->getBanner())
            ->setCountry($form->getCountry())
            ->setRegistrationData($form->getRegistrationData())
            ->setNumberViews($form->getNumberViews())
            ->setNumberSubscribes($form->getNumberSubscribes())
            ->setLinks($form->getLinks());
    }

    /**
     * @return mixed
     */
    public function save()
    {
        $data = [
            self::FIELD_URL => $this->getUrl(),
            self::FIELD_NAME => $this->getName(),
            self::FIELD_DESCRIPTION => $this->getDescription(),
            self::FIELD_BANNER => $this->getBanner(),
            self::FIELD_COUNTRY => $this->getCountry(),
            self::FIELD_REGISTRATION_DATA => $this->getRegistrationData(),
            self::FIELD_NUMBER_VIEWS => $this->getNumberViews(),
            self::FIELD_NUMBER_SUBSCRIBES => $this->getNumberSubscribes(),
            self::FIELD_LINKS => $this->getLinks(),
        ];

        if ($this->getId() === null) {
            return $this->db->add(self::TABLE, $data);
        } else {
            return $this->db->update(self::TABLE, [self::FIELD_ID => $this->getId()], $data);
        }
    }

    /**
     * @param array $where
     * @param \Bjlag\Http\Forms\ChannelCreateForm $data
     * @return mixed
     */
    public function update(array $where, ChannelCreateForm $data)
    {
        $updatedData = [
            self::FIELD_URL => $data->getUrl(),
            self::FIELD_NAME => $data->getName(),
            self::FIELD_DESCRIPTION => $data->getDescription(),
            self::FIELD_BANNER => $data->getBanner(),
            self::FIELD_COUNTRY => $data->getCountry(),
            self::FIELD_REGISTRATION_DATA => $data->getRegistrationData(),
            self::FIELD_NUMBER_VIEWS => $data->getNumberViews(),
            self::FIELD_NUMBER_SUBSCRIBES => $data->getNumberSubscribes(),
            self::FIELD_LINKS => $data->getLinks(),
        ];

        return $this->db->update(self::TABLE, $where, $updatedData);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return (bool) $this->db->delete(self::TABLE, [
            'id' => $this->getId()
        ]);
    }
}
