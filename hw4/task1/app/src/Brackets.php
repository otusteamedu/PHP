<?php
namespace Jekys;

class Brackets
{
    /**
    * @var string $code - HTTP response code
    */
    private $code = '400';

    /**
    * @var string $msg - Response message
    */
    private $msg = 'Unknown error';

    /**
    * @var string $postKey - key in the $_POST array
    */
    private $postKey = null;

    /**
    * Class object constructor
    *
    * Does all checks and sets $code and $msg for response
    *
    * @param string $postKey - where message with brackets is stored
    *
    * @return void
    */
    public function __construct(String $postKey)
    {
        $this->postKey = $postKey;

        $checkers = [
            'notEmptyValue'  => '"'.$postKey.'" param is empty',
            'checkContentLength' => "wrong content length",
            'isCorrect' => "brackets are closed incorrectly"
        ];

        $success = true;

        foreach ($checkers as $function => $msg) {
            if (!$this->{$function}()) {
                $this->msg = $msg;
                $success = false;

                break;
            }
        }

        if ($success) {
            $this->code = 200;
            $this->msg = 'Everything is OK =)';
        }
    }

    /**
    * Checks $_POST param emptyness
    *
    * @return boolean
    */
    private function notEmptyValue()
    {
        return !empty($_POST[$this->postKey]);
    }

    /**
    * Checks that content-length is correct
    *
    * @param boolean
    */
    private function checkContentLength()
    {
        return ($_SERVER['HTTP_CONTENT_LENGTH'] - strlen($this->postKey.'=')) == strlen($_POST[$this->postKey]);
    }

    /**
    * Checks that all brackets are close correct
    *
    * @param boolean
    */
    private function isCorrect()
    {
        $str = $_POST[$this->postKey];

        while (substr_count($str, '()')) {
            $str = str_replace('()', '', $str);
        }

        return strlen($str) == 0;
    }

    /**
    * Returns code and message for server response
    *
    * @return array
    */
    public function getResponse()
    {
        return [
            'code' => $this->code,
            'msg' => $this->msg
        ];
    }
}
