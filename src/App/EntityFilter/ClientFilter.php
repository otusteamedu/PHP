<?php

namespace App\EntityFilter;

class ClientFilter extends CommonEntityFilter
{
    public const TYPE = 'type';

    protected string $type = '';

    /**
     * @param array|null $assoc
     * @return array
     */
    public function fetchToAssoc(?array $assoc = null): array
    {
        return parent::fetchToAssoc(
            [self::TYPE => $this->type]
        );
    }

    /**
     * @param array $row
     * @return ClientFilter
     */
    public static function buildFromAssoc(array $row): ClientFilter
    {
        return (new static($row[self::ID] ?? 0))->setType(
            $row[self::TYPE] ?? ''
        );
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
     * @return ClientFilter
     */
    public function setType(string $type): ClientFilter
    {
        $this->type = $type;
        return $this;
    }
}