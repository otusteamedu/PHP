<?php
/**
 * Поведение для постановки в очередь
 */
namespace app\models\behaviors;

use yii\base\Behavior;
use app\jobs\RabbitJob;

class QueueBehavior extends Behavior
{
    public function afterSave(){
        // Создание задачи
        Yii::$app->queue->push(new RabbitJob(['jobId' => $this->owner->id]));
    }
}