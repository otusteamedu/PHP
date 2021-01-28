<?php

namespace app\models;

use Yii;
use app\models\behaviors\QueueBehavior;

/**
 * This is the model class for table "job".
 *
 * @property int         $id
 * @property string      $add_at   Дата и время создания задачи
 * @property string|null $work_at  Дата и время начала выполнения задачи
 * @property string|null $done_at  Дата и время окончания выполнения задачи
 * @property string      $job_name Название задачи
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * Подключение поведений
     *
     * @return string[]
     */
    public function behaviors()
    {
        return [
            QueueBehavior::class,
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['add_at', 'work_at', 'done_at', 'job_name'], 'safe'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'add_at'   => 'Добавлена',
            'work_at'  => 'Начата',
            'done_at'  => 'Окончена',
            'job_name' => 'Название задачи',
        ];
    }
}
