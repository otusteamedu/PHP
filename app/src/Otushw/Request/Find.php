<?php


namespace Otushw\Request;

use Otushw\EventDTO;
use Otushw\UserRequestDTO;
use Otushw\Storage\StorageInterface;
use Otushw\View;


class Find implements Request
{
    CONST TYPE_REQUEST = 'get_item';

    private UserRequestDTO $userRequest;
    private EventDTO $result;

    public function __construct(UserRequestDTO $userRequest)
    {
        $this->userRequest = $userRequest;
    }

    /**
     * @param StorageInterface $storage
     *
     * @throws Exception
     */
    public function process(StorageInterface $storage): void
    {
        $this->result = $storage->find($this->userRequest);
        if (!$this->result) {
            throw new Exception('Could not find Event by given conditions.');
        }
    }

    public static function getTypeRequest(): string
    {
        return self::TYPE_REQUEST;
    }

    /**
     * @return string
     */
    public function showResult(): string
    {
        View::showSearchResult($this->result);
    }
}