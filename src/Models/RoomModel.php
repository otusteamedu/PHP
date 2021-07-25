<?php


namespace src\Models;


use Services\Dao\DataMapper\Room\Room;
use Services\Dto\RoomDto;

class RoomModel extends BaseModel
{
    /**
     * @param $id
     * @return Room
     */
    public function getById($id): Room
    {
        return $this->dataAccess->getRoom($id);
    }

    /**
     * @param RoomDto $data
     * @return Room
     */
    public function insert(RoomDto $data): Room
    {
        return $this->dataAccess->insertRoom($data);
    }

    /**
     * @param $room
     * @return bool
     */
    public function update($room): bool
    {
        return $this->dataAccess->updateRoom($room);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        return $this->dataAccess->deleteRoom($id);
    }

}
