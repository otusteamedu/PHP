<?php


namespace Otushw\Request;

use Otushw\EventDTO;
use Otushw\Storage\StorageInterface;
use Exception;
use Otushw\View;
use Otushw\UserException;
use Otushw\AppException;

class Add implements Request
{
    CONST TYPE_REQUEST = 'add';

    private EventDTO $event;
    private bool $result;

    public function __construct(EventDTO $event)
    {
        $this->event = $event;
    }

    /**
     * @param StorageInterface $storage
     *
     * @throws Exception
     */
    public function process(StorageInterface $storage): void
    {
        $this->result = $storage->set($this->event);
        if (!$this->result) {
            throw new AppException('Could not set Event in storage');
        }
    }

    /**
     * @return string
     */
    public static function getTypeRequest(): string
    {
        return self::TYPE_REQUEST;
    }

    /**
     * @return string
     */
    public function showResult(): void
    {
        View::showAdd($this->result);
    }


}
