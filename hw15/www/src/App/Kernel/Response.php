<?php

namespace App\Kernel;

class Response implements ResponseInterface
{
    protected $view = '';

    public function send()
    {
        echo $this->view;
    }

    /**
     * @param mixed $view
     */
    public function renderView($view): void
    {
        $this->view = $view;
    }
}