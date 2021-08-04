<?php


namespace src\Controllers;


use Services\Dao\DataMapper\Room\Room;
use Services\Dto\RoomDto;

class RoomController extends BaseController
{
    public function run()
    {
        echo "<pre>";
        $id = $_GET['id'];
        $this->showRooms([$this->model->getById($id)]);
    }

    public function all()
    {
        echo "<pre>";
        $this->showRooms($this->model->get());
    }

    public function insert()
    {
        echo "<pre>";
        $data = new RoomDto(['name' => 'Зал из Инсерта']);
        $this->showRooms([$this->model->insert($data)->asArray()]);
    }

    public function update()
    {
        echo "<pre>";
        $id = $_GET['id'];
        $room = $this->model->getById($id);
        $room->setName($room->getName() . "-Updated");
        var_dump($this->model->update($room));
        $this->showRooms([$this->model->getById($id)->asArray()]);
    }

    public function delete()
    {
        echo "<pre>";
        $id = $_GET['id'];
        var_dump($this->model->delete($id));
    }

    private function showRooms(array $rooms): void
    {
        echo "<Table border='1px'>";
        echo "<caption>Таблица Кинозалов</caption>";
        echo "<tr>";
        foreach (Room::attributeLabels() as $label) {
            echo "<th>";
            echo $label;
            echo "</th>";
        }
        echo "</tr>";
        foreach ($rooms as $room) {
            echo "<tr>";
            foreach (Room::attributeLabels() as $key => $label) {
                echo "<td>";
                echo $room->{'get'.$key}();;
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</Table>";
    }

}
