<?php


namespace Otushw\Request;

use Otushw\Storage\StorageInterface;
use Otushw\View;

class Delete implements Request
{
    CONST TYPE_REQUEST = 'delete';

    private bool $result;

    /**
     * @param StorageInterface $storage
     */
    public function process(StorageInterface $storage): void
    {
        $this->result = $storage->delete();
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
    public function showResult()
    {
        View::ShowStatusDelete($this->result);
    }
}