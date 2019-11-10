<?php

declare(strict_types=1);

namespace RowDataGateway\Entities;

use RowDataGateway\Gateways\GenreGateway;

/**
 * @property GenreGateway $gateway
 */
class Genre extends AbstractEntity
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $title;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return Genre
     */
    public function setTitle(string $title): Genre
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param GenreGateway $gateway
     * @param array $attrs
     */
    public function __construct(GenreGateway $gateway, array $attrs = [])
    {
        parent::__construct($gateway, $attrs);
    }

    /**
     * @return int
     */
    public function save(): int
    {
        if ($this->id !== null) {
            throw new \RuntimeException('Film already saved.');
        }

        $this->passAttributesToGateway();

        $this->id = $this->gateway->insert();

        return $this->id;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $this->passAttributesToGateway();

        return $this->gateway->update();
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $result = $this->gateway->delete();

        if ($result === true) {
            $this->id = null;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }

    private function passAttributesToGateway(): void
    {
        $this->gateway->title = $this->title;
    }
}
