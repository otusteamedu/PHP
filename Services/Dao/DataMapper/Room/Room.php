<?php


namespace Services\Dao\DataMapper\Room;


use Services\Dto\RoomDto;
use Services\Traits\HasObjectTools;

/**
 * Class Room
 *
 * Сущность для Кинозалов
 *
 * @package Services\Dao\DataMapper\Room
 */
class Room
{
    use HasObjectTools;

    private ?int $id = null;
    private ?string $name = null;

    /**
     * Room constructor.
     * @param RoomDto|null $room
     */
    public function __construct(RoomDto $room = null)
    {
        if (is_null($room)){
            return;
        }
        $this->id = $room->id;
        $this->name = $room->name;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Room
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Room
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Набор лейблов для свойств объекта
     *
     * @return string[]
     */
    public static function attributeLabels(): array
    {
        return [
            'id' => 'Код Кинозала',
            'name' => 'Наименование Кинозала',
        ];
    }

}
