<?php

namespace Otushw;

use Exception;

class Brackets
{
    protected $parameter;

    const LENGTH_PAIR_BRACKETS = 2;
    const CORRECT_BRACKETS = '()';
    const PARAMETER_NAME = 'string';
    const HTTP_200 = 200;
    const HTTP_404 = 404;

    public function __construct()
    {
        try {
            if ($this->validationParameter()) {
                $this->parameter = $_POST[self::PARAMETER_NAME];

                $this->checkBrackets();
                $code = self::HTTP_200;
                $msgError = '';
            }
        } catch (Exception $e) {
            $code = self::HTTP_404;
            $msgError = $e->getMessage();
        }

        $this->response($code, $msgError);
    }

    protected function response($code, $msgError)
    {
        $msg = 'Validation';
        $msg_suffix = ' passed';
        if ($code == self::HTTP_404) {
            $msg_suffix = ' failed:' . $msgError;
        }
        http_response_code($code);
        echo $msg . $msg_suffix;
    }

    protected function validationParameter()
    {
        if (!isset($_POST[self::PARAMETER_NAME])) {
            throw new Exception('Parameter "string" is missing');
        }
        if (empty($_POST[self::PARAMETER_NAME])) {
            throw new Exception('Parameter "string" is empty');
        }
        if (!is_string($_POST[self::PARAMETER_NAME])) {
            throw new Exception('Parameter is not string');
        }
        return true;
    }

    protected function checkBrackets()
    {
        $numIteration = strlen($this->parameter) / self::LENGTH_PAIR_BRACKETS;
        if (!is_integer($numIteration)) {
            throw new Exception("Unpaired number of brackets");
        }
        $i = 0;
        $value = $this->parameter;
        while ($value != '') {
            $i++;
            $value = str_replace(self::CORRECT_BRACKETS, '', $value);
            if ($i > $numIteration) {
                throw new Exception("Sequence of brackets is broken");
            }
        }
    }
}
