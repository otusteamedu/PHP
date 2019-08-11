<?php


namespace nvggit\hw26\models;

/**
 * Class Task
 * @package nvggit\hw26\models
 *
 * @property string $correlation_id
 * @property int $status
 * @property string $type
 */
class Task
{
    public $correlation_id;
    public $status;
    public $type;

    const TYPE_FROG_HARD_WORK = 'frog_hard_work';
    const TYPE_FROG_HARD_WORK_STATUS = 'frog_hard_work_status';

    const STATUS_NEW = 1;
    const STATUS_PENDING = 2;
    const STATUS_COMPLETED = 3;

    public static $statuses = [
        self::STATUS_NEW => 'New',
        self::STATUS_PENDING => 'Pending',
        self::STATUS_COMPLETED => 'Completed',
    ];
}