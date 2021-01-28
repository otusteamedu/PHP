<?php

namespace app\jobs;

/**
 * Обработчик очереди
 */

use app\models\Job;
use yii\db\Exception;

class RabbitJob extends \yii\base\BaseObject implements \yii\queue\JobInterface
{
    public $jobId;


    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        $model = Job::findOne($this->jobId);
        if (empty($model)) {
            throw new Exception(sprintf('Job [%s] not found', $this->jobId));
        }
        $model->work_at = date('Y-m-d H:i:s', time());
        $model->save();

        $sleepTime = random_int(2, 60);
        sleep($sleepTime); // имитация сложного процесса

        $model->done_at = date('Y-m-d H:i:s', time());
        $model->save();
    }
}
