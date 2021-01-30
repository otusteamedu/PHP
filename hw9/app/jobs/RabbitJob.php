<?php

namespace app\jobs;

/**
 * Обработчик очереди
 */

use app\models\Job;
use yii\db\Exception;
use app\components\JobExecutor;

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
        // Сохраняем время, когда начали обработку задачи
        $model->work_at = date('Y-m-d H:i:s', time());
        $model->save();

        $executor = new JobExecutor();
        $executor->someWork();

        // Сохраняем время завершения обработки
        $model->done_at = date('Y-m-d H:i:s', time());
        $model->save();
    }
}
