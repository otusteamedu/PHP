<?php


namespace Otus\Processes;


use Otus\Exceptions\AppException;
use Otus\Validators\RequestValidator;

class EventProcessFactory
{
    public static function getProcess(): EventProcessInterface
    {
        $validator = new RequestValidator();

        switch ($_SERVER['REQUEST_METHOD']){
            case RequestValidator::POST_REQUEST:
                $validator->validatePost();
                return new EventCreator($validator->getValidatedData());
            case RequestValidator::GET_REQUEST:
                $validator->validateGet();
                return new EventSearcher($validator->getValidatedData());
            default:
                throw new AppException('Invalid request method');
        }
    }
}
