<?php


namespace Services\Dto;

/**
 * Class RoomDto
 *
 * содержит поля из таблицы 'room'
 *
 * @package Services\Dto
 */
class RoomDto extends AbstractDto
{
    public ?int $id;
    public ?string $name;
}
