<?php

namespace Controllers;

use Contracts\YoutubeStorageInteface;
use Models\Task;
use \MongoDB\Client;

class YoutubeController implements YoutubeStorageInteface
{
    private $mongo;
    private $collection;

    public function __construct(Client $connection)
    {
        $this->mongo = $connection;
        $this->collection = $this->mongo->youtube->videos;
    }

    /*
     * ПОлучение всех видео всех каналов
     * @return array
     */
    public function all(): array
    {
        return $this->collection->find()->toArray();
    }

    /*
     * Получение всех видео определенного канала
     * @param string $id идентификатор канала YouTube
     * @return object
     */
    public function get($id)
    {
        return $this->collection->findOne(['_id' => $id ]);
    }

    /*
     * Запись / обновление данных по каналу
     * @param Task $task модель данных по каналу
     */
    public function store(Task $task)
    {

        $videoID = $task->getData();
        $video = self::get($videoID['_id']);

        if(!$video) {
            return $this->collection->insertOne($task->getData());
        } else {
            return self::update($task);
        }

    }

    /*
     * Обновление данных по каналу YoutubeController
     * @param Task $task модель данных по каналу
     */
    public function update(Task $task)
    {
        $videoID = $task->getData();

        return $this->collection->findOneAndUpdate(['_id' => $videoID['_id']], ['$set' => $task->getData()]);
    }


}