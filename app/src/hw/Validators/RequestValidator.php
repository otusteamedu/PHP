<?php

namespace Otus\Validators;

use Monolog\Logger;
use Otus\Exceptions\AppException;
use Rakit\Validation\Validator;

class RequestValidator
{
    const ADD_REQUEST = "add";
    const SEARCH_REQUEST = "search";
    const DELETE_REQUEST = "delete";

    private Validator $validator;
    private array $data;

    public function __construct()
    {
        $this->validator = new Validator();

        $json = file_get_contents('php://input');

        if (empty($json)) {
            throw new AppException('body is empty', Logger::ERROR);
        }

        $this->data = json_decode($json,true);
    }

    /**
     * @throws AppException
     */
    public function validate()
    {
        switch ($this->data['request_type']) {
            case self::SEARCH_REQUEST:
                $this->validateSearch();
                break;
            case self::ADD_REQUEST:
                $this->validateAdd();
                break;
            case self::DELETE_REQUEST:
                break;
            default:
                throw new AppException("Invalid request method", Logger::ERROR);
        }
    }

    private function validateSearch()
    {
        $validation = $this->validator->validate($this->data,[
           'conditions' => 'required|array'
        ]);

        if ($validation->fails()) {
            throw new AppException('Validation error, reason: ' . json_encode($validation->errors()->firstOfAll()), Logger::ERROR);
        }

        return true;
    }

    private function validateAdd()
    {
        $validation = $this->validator->validate($this->data, [
           'event' => 'required',
           'conditions' => 'required|array',
           'priority' => 'required|numeric'
        ]);

        if ($validation->fails()) {
            throw new AppException('Validation error, reason: ' . json_encode($validation->errors()->firstOfAll()), Logger::ERROR);
        }

        return true;
    }

    public function getValidatedData()
    {
        return $this->data;
    }
}
