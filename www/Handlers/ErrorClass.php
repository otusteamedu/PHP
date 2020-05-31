<?php

namespace Handlers\ErrorClass;

class ErrorClass {
    private $current;
    private $file;

    public function __construct (String $file) 
    {
        $this->file = $file;
        $this->make();
    }

    private function make ()
    {
        $this->current = file_get_contents($this->file, FILE_APPEND);
    }

    private function write (String $error)
    {
        $this->current .= $error . "\n";

        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/' . $this->file, $this->current);
    }
}
