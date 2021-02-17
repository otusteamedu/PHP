<?php


namespace Otus\Validators;


use Monolog\Logger;
use Otus\Exceptions\AppException;
use Rakit\Validation\Validator;

class RequestValidator
{
    const GET_REQUEST = "GET";
    const POST_REQUEST = "POST";

    private string $requestType;
    private Validator $validator;
    private array $data;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->requestType = $_SERVER['REQUEST_METHOD'];

        $json = file_get_contents('php://input');

        $this->data = json_decode($json,true);
    }

    /**
     * @throws AppException
     */
    public function validate()
    {
        switch ($this->requestType) {
            case RequestValidator::GET_REQUEST:
                $this->validateGet();
                break;
            case RequestValidator::POST_REQUEST:
                $this->validatePost();
                break;
            default:
                throw new AppException("Invalid request method", Logger::ERROR);
        }
    }

    /**
     * @return bool
     * @throws AppException
     */
    public function validateGet()
    {
        $validation = $this->validator->validate($this->data,[
           'conditions' => 'required|array'
        ]);

        if ($validation->fails()) {
            throw new AppException('Validation error, reason: ' . json_encode($validation->errors()->firstOfAll()), Logger::ERROR);
        }

        return true;
    }

    /**
     * @return bool
     * @throws AppException
     */
    public function validatePost()
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
