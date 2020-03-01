<?php

namespace Sergey\Otus\View;

class Error extends Html
{
    /**
     * @param string $message
     * @return mixed|void
     */
    protected function htmlBody($message)
    {
        echo '<div style="color:red">' . $message . '</div>';
    }

    /**
     * @param string $message
     */
    protected function init($message)
    {
        $this->headElements["<title> . $message . </title>"];
    }
}