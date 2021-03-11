<?php


namespace controllers;


class TestPost
{
    public function run()
    {
        $returnCode = 200;
        $str = $_POST['str'] ?? "";
        if (empty($str)) {
            $returnCode = 400;
        } else {
            if (!$this->checkString($str)) {
                $returnCode = 400;
            }
        }
        $msg = ($returnCode == 200) ? "Все хорошо!" : "Все плохо!";
        throw new \Exception($msg, $returnCode);
    }

    private function checkString($str):bool
    {
        $len = iconv_strlen($str, 'UTF-8');
        $i = 0;
        $open = 0;
        while ($i < $len) {
            if ($str[$i] === '(') {
                $open++;
            } else if ($str[$i] === ')') {
                $open--;
                if ($open < 0) {
                    return false;
                }
            }
            $i++;
        }
        return ($open === 0);
    }
}