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

    protected function beforeSave()
    {
        if (!$this->id) {
            $this->id = uniqid('', true);
        }
    }

}