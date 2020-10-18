<?php

class HttpResponse
{
    /**
     * Отправить ответ
     *
     * @param int    $code код ответа
     * @param string $msg  тело ответа
     */
    public function send($code, $msg)
    {
        if ($code == 200) {
            $codeMsg = 'OK';
        } else {
            $codeMsg = 'Bad Request';
        }
        header(sprintf('HTTP/1.1 %s %s', $code, $codeMsg));
        echo "$msg";
    }
}