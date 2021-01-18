<?php


namespace Otushw\Request;

use Otushw\Params;
use Otushw\EventDTO;
use Otushw\UserRequestDTO;
use Otushw\UserException;
use Otushw\AppException;


class RequestFactory
{
    const EXCLUDE_FILES = ['Request.php', 'RequestFactory.php', '.', '..'];
    const ALLOWED_TYPE_REQUEST = ['add', 'get_item', 'delete'];

    private Params $params;
    private string $typeRequest;

    public function __construct()
    {
        $this->params = new Params();
        $typeRequest = $this->params->getParam('type_request');

        $this->validateTypeRequest($typeRequest);
        $this->setTypeRequest($typeRequest);
    }

    public function create(): Request
    {
        $params = $this->params->getAllParams();
        switch ($this->typeRequest) {
            case Add::getTypeRequest():
                $event = new EventDTO(
                    time(),
                    $params['priority'],
                    $params['conditions'],
                    $params['event']
                );
                return new Add($event);
            case Find::getTypeRequest():
                $userRequest = new UserRequestDTO($params['conditions']);
                return new Find($userRequest);
            case Delete::getTypeRequest():
                return new Delete();
        }
    }

    private function validateTypeRequest(string $typeRequest): void
    {
        if (!in_array($typeRequest, self::ALLOWED_TYPE_REQUEST)) {
            throw new UserException('Does not allow Request.');
        }
    }

    private function setTypeRequest(string $typeRequest): void
    {
        $this->typeRequest = strtolower($typeRequest);
    }

}