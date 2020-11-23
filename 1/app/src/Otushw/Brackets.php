<?php

namespace Otushw;

use Exception;

class Brackets
{
    const LENGTH_PAIR_BRACKETS = 2;
    const CORRECT_BRACKETS = '()';

    protected $parameter;

    public function validation()
    {
        $msg = 'Validation';
        try {
            if (!isset($_POST['string'])) {
                throw new Exception('Parameter "string" is missing');
            }
            if (empty($_POST['string'])) {
                throw new Exception('Parameter "string" is empty');
            }
            if (!is_string($_POST['string'])) {
                throw new Exception('Parameter is not string');
            }

            $this->parameter = $_POST['string'];

            $this->checkBrackets();
            $code = 200;
            $msg .= ' passed';
        } catch (Exception $e) {
            $code = 404;
            $msg .= ' failed:' . $e->getMessage();
        }
        http_response_code($code);
        echo $msg;
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
