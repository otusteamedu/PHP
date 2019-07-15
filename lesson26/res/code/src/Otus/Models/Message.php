<?php

namespace Otus\Models;

/**
 * Class Message
 * @package Otus
 */
class Message extends BaseModel
{
    /**
     * @var string
     */
    protected static $tableName = 'message';

    /**
     * @var string
     */
    protected static $queueName = 'messages';

    /**
     * @var array
     */
    protected $fields = ['id', 'message', 'status', 'deleted', 'type'];

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $message;

    /**
     * @var int
     */
    public $status;

    /**
     * @var int
     */
    public $deleted;

    /**
     * @var string
     */
    public $type;

    const STATUS_NEW = 0;
    const STATUS_ACCEPTED = 2;
    const STATUS_REJECTED = 3;
    public static $statuses = [
        self::STATUS_NEW => 'Ожидает рассмотрения',
        self::STATUS_ACCEPTED => 'Принято',
        self::STATUS_REJECTED => 'Отклонено',
    ];

    const TYPE_COMMENT = 0;
    const TYPE_OFFER = 1;
    const TYPE_WARNING = 2;
    public static $types = [
        self::TYPE_COMMENT => 'Отзыв',
        self::TYPE_OFFER => 'Предложение',
        self::TYPE_WARNING => 'Предупреждение',
    ];

    /**
     * get queue name
     * @return string
     */
    public static function getQueueName()
    {
        return self::$queueName;
    }

    /**
     * @return string
     */
    public function getStringStatus()
    {
        return 'Message with id "' . $this->id . '" has status "' . self::$statuses[$this->status] . '".';
    }
}