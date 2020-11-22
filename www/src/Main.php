<?php

use src\ExceptionEmptyString;
use src\ExceptionWrongBrackets;
use src\ExceptionWrongLength;

class Main
{

    const POST_PARAM = 'string';

    public function getPost(string $post): string
    {
        return $_POST[$post];
    }

    public function run()
    {
        try {
            $str = $this->getPost(self::POST_PARAM);
            if (empty($srt))
                throw new ExceptionEmptyString();

            if (!$this->testLength($str))
                throw new ExceptionWrongLength();

            $this->testCountBrackets($str);

            $this->sendOk();
        } catch (ExceptionEmptyString $e) {
            $this->sendBad($e->getMessage());
        } catch (ExceptionWrongLength $e) {
            $this->sendBad($e->getMessage());
        } catch (ExceptionWrongBrackets $e) {
            $this->sendBad($e->getMessage());
        }

    }

    public function testLength(string $str): bool
    {
        return $_SERVER['CONTENT_LENGTH'] != (mb_strlen($str) + mb_strlen(self::POST_PARAM));
    }

    public function sendOk()
    {
        header("HTTP/1.1 200 Test OK");
    }

    public function sendBad(string $errStr)
    {
        header("HTTP/1.1 400 $errStr");
    }

    /**
     * @param string $str
     * @throws ExceptionWrongBrackets
     */
    public function testCountBrackets(string $str)
    {
        $opened = 0;
        for ($i = 0; $i < mb_strlen($str); $i++) {
            $symbol = substr($str, $i, 1);
            if ($symbol != '(' && $symbol != ')')
                throw new ExceptionWrongBrackets('Wrong symbol');
            $symbol === '(' ? $opened++ : $opened--;
            if ($opened < 0)
                throw new ExceptionWrongBrackets('Wrong sequence');
        }
        if ($opened !== 0)
            throw new ExceptionWrongBrackets('Wrong sequence');
    }
}