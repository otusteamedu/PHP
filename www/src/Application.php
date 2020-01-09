<?php

namespace Tirei01\Hw5;

class Application
{
    protected $post;
    protected $isError;

    public function __construct(?array $post = null)
    {
        $this->post = $post;
        $this->isError = true;
    }

    /**
     *
     */
    protected function validate() : void
    {
        $tmp = $this->post['string'];
        $tmp = preg_replace('/[^\(\)]/', '', $tmp);
        $length = strlen($tmp);
        if ($length % 2 === 0) {
            $i = 0;
            while (true) {
                $startLength = strlen($tmp);
                $tmp = str_replace('()', '', $tmp);
                $replaseLength = strlen($tmp);
                if (strlen($tmp) === 0) {
                    $this->isError = false;
                    break;
                } elseif ($replaseLength === $startLength) {
                    break;
                }
                $i++;
                if ($i > 10000) {
                    break;
                }
            }
        }
    }

    /**
     *
     */
    public function run(): void
    {
        $this->validate();
        if ($this->isError === true) {
            echo $this->sendError();
        } else {
            echo $this->sendSuccess();
        }
    }

    /**
     * @return string
     */
    public function sendError()
    {
        return $this->sendAnswer(400, '400 Bad Reuest', "Everything is bad " . $this->post['string']);
    }

    /**
     * @return string
     */
    public function sendSuccess()
    {
        return $this->sendAnswer(200, '200 OK', "Everything is Success " . $this->post['string']);
    }

    /**
     * @param int    $http_code
     * @param string $httpText
     * @param string $messate
     *
     * @return string
     */
    protected function sendAnswer($http_code = 200, $httpText = '200 OK', $messate = '')
    {
        \header($httpText, true, $http_code);
        return $messate;
    }
}