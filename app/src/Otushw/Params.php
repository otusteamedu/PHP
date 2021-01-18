<?php


namespace Otushw;

use Exception;

class Params
{
    const PREFIX = 'request_params_';
    const REQUIRED_PARAM = 'type_request';
    const REQUIRED_PARAM_DATA_TYPE = [self::REQUIRED_PARAM => 'string'];

    private array $allParams;

    public function __construct()
    {
        $this->validateParam();
        $this->allParams = $this->getParams();
    }

    /**
     * @return
     */
    public function getParam(string $paramName)
    {
        if (!empty($this->allParams[$paramName])) {
            return $this->allParams[$paramName];
        }
    }

    /**
     * @return array
     */
    public function getAllParams(): array
    {
        return $this->allParams;
    }

    /**
     * @return array
     */
    private function getParams(): array
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return $data;
    }

    /**
     * @throws Exception
     */
    private function validateParam(): void
    {
        $rawParams = $this->checkJSON();
        $this->checkRequiredParam($rawParams);
        $typeRequest = $rawParams[self::REQUIRED_PARAM];
        $section = self::PREFIX . $typeRequest;
        if (empty($_ENV[$section])) {
            throw new AppException('Section "' . $section . '" does not exist.');
        }
        $this->checkParam($_ENV[$section], $rawParams);
    }

    private function checkJSON(): array
    {
        $raw = file_get_contents('php://input');
        if (empty($raw)) {
            throw new Exception('Input date is empty');
        }
        $rawParams = json_decode($raw, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new AppException(json_last_error_msg());
        }
        return $rawParams;
    }

    private function checkRequiredParam(array $rawParams): void
    {
        $this->checkParam(self::REQUIRED_PARAM_DATA_TYPE, $rawParams);
    }

    private function checkParam(array $params, array $rawParams): void
    {
        foreach ($params as $param => $dateType) {
            $function = $this->generateValidationFunc($dateType);
            if (!function_exists($function)) {
                throw new UserException('PHP has not function: ' . $function);
            }
            if (empty($rawParams[$param])) {
                throw new UserException('Required parameter "' . $param . '" is missing.');
            }
            if (!$function($rawParams[$param])) {
                throw new UserException('Wrong type for parameter: ' . $param);
            }
        }
    }

    /**
     * @param string $type
     *
     * @return string
     */
    private function generateValidationFunc(string $type): string
    {
        return 'is_' . $type;
    }


}