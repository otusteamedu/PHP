<?php


namespace Otus\Processes;


use Otus\Exceptions\AppException;
use Otus\Validators\RequestValidator;

class EventProcessFactory
{
    public static function getProcess(array $data): EventProcessInterface
    {
        switch ($data['request_type']){
            case RequestValidator::ADD_REQUEST:
                return new EventCreator($data);
            case RequestValidator::SEARCH_REQUEST:
                return new EventSearcher($data);
            case RequestValidator::DELETE_REQUEST:
                return new EventDeleter();
            default:
                throw new AppException('Invalid request method');
        }
    }
}
