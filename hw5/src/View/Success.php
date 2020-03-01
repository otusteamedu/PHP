<?php

namespace Sergey\Otus\View;

class Success extends Html
{
    /**
     * @param string $message
     * @return mixed|void
     */
    protected function htmlBody($message)
    {
        echo '<div style="color:green">' . $message . '</div>';
    }

    /**
     * @param string $message
     */
    protected function init($message)
    {
        $this->headElements["<title> . $message . </title>"];
    }
}