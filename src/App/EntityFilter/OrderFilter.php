<?php

namespace App\EntityFilter;

class OrderFilter extends CommonEntityFilter
{
    public const CLIENT = 'client_id';
    public const STATE = 'state';
    public const TYPE = 'type';

    private int $clientId = 0;
    private int $state = 0;
    private string $type = '';

    /**
     * @param array|null $assoc
     * @return array
     */
    public function fetchToAssoc(?array $assoc = null): array
    {
        return parent::fetchToAssoc(
            [
                self::CLIENT => $this->clientId ?? 0,
                self::STATE  => $this->state ?? 0,
                self::TYPE   => $this->type ?? '',
            ]
        );
    }

    /**
     * @param array $row
     * @return IEntityFilter
     */
    public static function buildFromAssoc(array $row): IEntityFilter
    {
        return (new self($row[self::ID] ?? 0))->setState($row[self::STATE] ?? 0)
                                              ->setClientId(
                                                  $row[self::CLIENT] ?? 0
                                              )
                                              ->setType($row[self::TYPE] ?? '');
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @param int $clientId
     * @return OrderFilter
     */
    public function setClientId(int $clientId): OrderFilter
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * @param int $state
     * @return OrderFilter
     */
    public function setState(int $state): OrderFilter
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return OrderFilter
     */
    public function setType(string $type): OrderFilter
    {
        $this->type = $type;
        return $this;
    }
}