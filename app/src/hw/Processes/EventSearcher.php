<?php


namespace Otus\Processes;

use Otus\DTO\EventDTO;
use Otus\DTO\UserRequestDTO;
use Otus\Storage\StorageInterface;
use Otus\View;

class EventSearcher implements EventProcessInterface
{
    private UserRequestDTO $requestDTO;

    public function __construct(array $data)
    {
        $this->createUserRequestDTO($data);
    }

    public function process(StorageInterface $storage)
    {
        /** @var EventDTO $result */
        $result = $storage->find($this->requestDTO);
        View::showResult($result->toArray());
    }

    private function createUserRequestDTO(array $data)
    {
        $requestDTO = new UserRequestDTO();
        $requestDTO->setConditions($data['conditions']);

        $this->requestDTO = $requestDTO;
    }

}